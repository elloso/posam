<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Payment extends Admin_Controller 
{
	public function __construct()
	{
		parent::__construct();

		$this->not_logged_in();

		$this->data['page_title'] = 'Payment';
		$this->data['active_tab'] = $this->input->get('tab') ?? 'payment';

	}


	public function index()
	{
		if(!in_array('viewPayment', $this->permission)) {
			redirect('dashboard', 'refresh');
		}

		$this->render_template('payment/index', $this->data);	
	}


	//--> It retrieve the specific payment information via a payment id
	//    and returns the data in json format

	public function fetchPaymentDataById($payment_id) 
	{
		if($payment_id) {
			$data = $this->model_payment->getPaymentData($payment_id);
			echo json_encode($data);
		}

		return false;
	}




	//--> It Fetches the payment data from the payment table 

    public function fetchPaymentCustomer($customer_id)
    {
        $result = array('data' => array());

        $date_from = $this->input->get('date_from_payment') ?? NULL;
        $date_to = $this->input->get('date_to_payment') ?? NULL;

        if ($date_from == null) {
            $date_from = "'1900-01-01'";
        } else {
            $date_from = "'" . $date_from . "'";
        }
        if ($date_to == null) {
            $date_to = "'2500-01-01'";
        } else {
            $date_to = "'" . $date_to . "'";
        }

        $data = $this->model_payment->getPayment($customer_id, $date_from, $date_to);   

        foreach ($data as $key => $value) {

            $buttons = '';
   
            if(in_array('deletePayment', $this->permission)) { 
                $buttons .= ' <button type="button" class="btn btn-default" onclick="removePayment('.$value['payment_id'].')" data-toggle="modal" data-target="#removeModalPayment"><i class="fa fa-trash"></i></button>';
            }

            $payment_type = ($value['payment_type'] == 1) ? '<span class="label label-success">'.'Payment'.'</span>' : '<span class="label label-warning">'.'Credit'.'</span>';
  
            $result['data'][$key] = array( 
				$value['payment_date'], 
				$value['amount_paid'], 
				$payment_type,
				$value['payment_remark'],  
				$value['order_no'], 
				$value['updated_by'],  
				$value['updated_date'],   				
                $buttons
            );

        } // /foreach

        echo json_encode($result);
    }

	

	//--> If the validation is not true (not valid), then it provides the validation error on the json format
    //    If the validation for each input is valid then it inserts the data into the database and 
    //    returns the appropriate message in the json format.

	public function create()
	{
		if(!in_array('createPayment', $this->permission)) {redirect('dashboard', 'refresh');}

		$response = array();

		$this->form_validation->set_rules('payment_date', 'Date', 'trim|required');
		$this->form_validation->set_rules('amount_paid', 'Amount Paid', 'trim|required');		
		$this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');

        if ($this->form_validation->run() == TRUE) {
        	$data = array(
        		'customer_fk' => $this->session->customer_id, 
        		'order_fk' => $this->input->post('payment_order'),	    		
        		'payment_date' => $this->input->post('payment_date'),	 
        		'amount_paid' => $this->input->post('amount_paid'),   
				'payment_remark' => (($this->input->post('payment_remark') != FALSE) ? $this->input->post('payment_remark') : NULL), 
				'payment_type' => $this->input->post('payment_type'),
				'updated_by' => $this->session->userdata('user_id'),
        	);

        	$create = $this->model_payment->create($data);

        	if($create == true) 
        		{// now decrease or increase the balance
        		$old_balance = $this->model_customer->getCustomerData($this->session->customer_id);
        		$new_balance = $old_balance['balance'] - $this->input->post('amount_paid');        		
    			$update_balance = array('balance' => $new_balance);
    			$this->model_customer->updateBalance($update_balance, $this->session->customer_id);
        		$response['success'] = true;
        		$response['messages'] = 'Successfully created';}
        	else 
        		{$response['success'] = false;
        		$response['messages'] = 'Error in the database while creating the information';}			
        	
        }
        else {
        	$response['success'] = false;
        	foreach ($_POST as $key => $value) {
        		$response['messages'][$key] = form_error($key);
        	}
        }

        echo json_encode($response);
	}
              


	public function remove()
	{
		if(!in_array('deletePayment', $this->permission)) {
			redirect('dashboard', 'refresh');
		}
		
		$payment_id = $this->input->post('payment_id');

		$response = '';
		$response = array();
		
		if($payment_id) {	
			// now increaae the balance
        		$old_balance = $this->model_customer->getCustomerData($this->session->customer_id);
        		$amount = $this->model_payment->getPaymentData($payment_id);
    		    $new_balance = $old_balance['balance'] + $amount['amount_paid'];
    			$update_balance = array('balance' => $new_balance);
    			$this->model_customer->updateBalance($update_balance, $this->session->customer_id);
    			$delete = $this->model_payment->remove($payment_id);			

			if($delete == true) {
				$response['success'] = true;
				$response['messages'] = 'Successfully deleted';}
			else {
				$response['success'] = false;
				$response['messages'] = 'Error in the database while deleting the information';
			}
		}
		else {
			$response['success'] = false;
			$response['messages'] = 'Refresh the page again';
		}

		echo json_encode($response);
	}


}