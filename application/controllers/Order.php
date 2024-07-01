<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Order extends Admin_Controller 
{
	public function __construct()
	{
		parent::__construct();

		$this->not_logged_in();

		$this->data['page_title'] = 'Order';
		$this->log_module = 'Order';

	}



	public function index()
	{
		if(!in_array('viewOrder', $this->permission)) {redirect('dashboard', 'refresh');}

		$this->data['area'] = $this->model_area->getActiveArea();    

		$this->data['page_title'] = 'Manage Order';

		//  Unset the variable session customer id that might be used
		//  when we create an order directly from the customer edit page	
		$this->session->unset_userdata('customer_id');	

		$this->render_template('order/index', $this->data);		
	}


	public function fetchOrderDataByDate()
	{
		$result = array('data' => array());

		$date_from = $this->input->get('date_from') ?? NULL;
        $date_to = $this->input->get('date_to') ?? NULL;
        $area = $this->input->get('area') ?? NULL;


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

        //--> Criteria area
        if ($area == 'all') {
        	$area_from = "0";
			$area_to = "999";
        }
        else {
			$area_from = $area;
			$area_to = $area;
		}

		$data = $this->model_order->getOrderDataByDate($date_from, $date_to, $area_from, $area_to);

		foreach ($data as $key => $value) {
			
			$order_no = $value['order_no'];

			$buttons = '';

			if(in_array('updateOrder', $this->permission)) {
				$buttons .= ' <a href="'.base_url('order/update/'.$value['order_id']).'" class="btn btn-default"><i class="fa fa-pencil"></i></a>';
				$order_no = '<a href="'.base_url('order/update/'.$value['order_id']).'">'.$value['order_no'].'</a>';
				$buttons .= '<a href="'.base_url('order/timeline/'.$value['order_id']).'" class="btn btn-default"><i class="fa fa-clock-o"></i></a>';
			}

			if(in_array('deleteOrder', $this->permission)) {
				$buttons .= ' <button type="button" class="btn btn-default" onclick="removeFunc('.$value['order_id'].')" data-toggle="modal" data-target="#removeModal"><i class="fa fa-trash"></i></button>';
			}


			if(in_array('viewOrder', $this->permission)) {
				$buttons .= '<a href="'.base_url('report_order_slip/report_order_slip/'.$value['order_id']).'" target="_blank" class="btn btn-default"><i class="fa fa-print"></i></a>'; 
			}

			

			$result['data'][$key] = array(
				$order_no,
				$value['customer_name'],
				$value['area_name'],
				$value['order_date'],
				$value['sales_invoice_no'],
				$value['order_total'],
				$value['updated_by'],
				$value['updated_date'],
				$buttons
			);
		} // /foreach

		echo json_encode($result);
	}




	public function create()
	{
		if(!in_array('createOrder', $this->permission)) {redirect('dashboard', 'refresh');}

		$this->data['page_title'] = 'Add Order';

		$this->form_validation->set_rules('customer', 'Customer', 'trim|required');
		$this->form_validation->set_rules('order_date', 'Order Date', 'trim|required');	
		$this->form_validation->set_rules('item[]', 'Item name', 'trim|required');			
	
        if ($this->form_validation->run() == TRUE) {           	

    		$data = array(
	    		'order_no' => $this->input->post('order_no'),
	    		'customer_fk' => $this->input->post('customer'),	
	    		'employee_fk' => $this->input->post('employee'), 
	    		'delivery_date' => $this->input->post('delivery_date'),   		
	    		'order_date' => $this->input->post('order_date'),	    		
	    		'order_total' => $this->input->post('order_total'),
	    		'sales_invoice_no' => $this->input->post('sales_invoice_no'),
	    		'delivery_receipt_no' => $this->input->post('delivery_receipt_no'),
	    		'purchase_order_no' => $this->input->post('purchase_order_no'),
	    		'updated_by' => $this->session->userdata('user_id'),
	    	);     	
        	
        	$order_id = $this->model_order->create($data);
        	
        	if($order_id) {   
        	    //--> Update the balance of the customer
        		$old_balance = $this->model_customer->getCustomerData($this->input->post('customer'));
        		$new_balance = $old_balance['balance'] + $this->input->post('order_total');
    			$update_balance = array('balance' => $new_balance);
    			$this->model_customer->updateBalance($update_balance, $this->input->post('customer'));     		
        		 //--> Log Action
                $this->model_log->create(array(
                    'order_fk' => $order_id,
                    'subject_fk' => $order_id,      
                    'action' => 'Create',
                    'attributes' => serialize($data),
                    'module' => $this->log_module,
                    'remark' => 'Create Order ' . $order_id,
                    'updated_by' => $this->session->user_id, 
                ));
        		redirect('order/update/'.$order_id, 'refresh');
        	}
        	else {
        		$this->session->set_flashdata('errors', 'Error occurred!!');
        		redirect('order/create/', 'refresh');
        	}
        }
        else {
            // false case
        	$organization = $this->model_organization->getOrganizationData(1);
        	$this->data['organization_data'] = $organization;        	

         	$generate_no = $this->model_order->generateOrderNo();
           	$this->data['generate_no'] = $generate_no; 
           	          	
            $this->data['customer'] = $this->model_customer->getActiveCustomer();
        	$this->data['item'] = $this->model_item->getItemLocationData();   
        	$this->data['employee'] = $this->model_employee->getActiveEmployee();     	

            $this->render_template('order/create', $this->data);
        }	
	}



	public function getItemPrice()
	{
		$item_location_id = $this->input->post('item_location_id');
		if($item_location_id) {
			$item_data = $this->model_order->getItemPrice($item_location_id);
			echo json_encode($item_data);
		}
	}


	public function getItemLocationData()
	{
		$item = $this->model_item->getItemLocationData();
		echo json_encode($item);
	}


	public function update($order_id)
	{
		if(!in_array('updateOrder', $this->permission)) {redirect('dashboard', 'refresh');}

		$this->data['page_title'] = 'Update Order';

		//--> Get the old data before updating
        $old_data = $this->model_order->getOrderData($order_id);

        $this->form_validation->set_rules('customer', 'Customer', 'trim|required');	
        $this->form_validation->set_rules('order_date', 'Order Date', 'trim|required');	
		$this->form_validation->set_rules('item[]', 'Item name', 'trim|required');
		
	
        if ($this->form_validation->run() == TRUE) { 

        	//--> Remove from the balance of the customer in case that the amount changed
        	$old_balance = $this->model_customer->getCustomerData($this->input->post('customer'));
        	$new_balance = $old_balance['balance'] - $this->input->post('order_total_value');
        	$update_balance = array('balance' => $new_balance);
    		$this->model_customer->updateBalance($update_balance, $this->input->post('customer'));

            $data = array(
	    		'order_date' => $this->input->post('order_date'),
	    		'employee_fk' => $this->input->post('employee'), 
	    		'sales_invoice_no' => $this->input->post('sales_invoice_no'),
	    		'delivery_receipt_no' => $this->input->post('delivery_receipt_no'),
	    		'purchase_order_no' => $this->input->post('purchase_order_no'),
	    		'delivery_date' => $this->input->post('delivery_date'), 
	    		'order_total' => $this->input->post('order_total'),	    		    		
	    		'updated_by' => $this->session->userdata('user_id')
	    	);       	
        	
        	$update = $this->model_order->update($order_id, $data);
        	
        	if($update == true) {
        		//--> Update the balance of the customer
        		$old_balance = $this->model_customer->getCustomerData($this->input->post('customer'));
        		$new_balance = $old_balance['balance'] + $this->input->post('order_total');        		
    			$update_balance = array('balance' => $new_balance);
    			$this->model_customer->updateBalance($update_balance, $this->input->post('customer'));
        		//--> Log Action
                $this->model_log->create(array(
                    'order_fk' => $order_id,
                    'subject_fk' => $order_id,      
                    'action' => 'Update',
                    'attributes' => serialize(array('old' => $old_data,'new' => $data)),
                    'module' => $this->log_module,
                    'remark' => 'Update Order ' . $order_id,
                    'updated_by' => $this->session->user_id, 
                ));
        		redirect('order/update/'.$order_id, 'refresh');
        	}
        	else {
        		$this->session->set_flashdata('errors', 'Error occurred!!');
        		redirect('order/update/'.$order_id, 'refresh');
        	}
        }
        else {
            // false case
        	$organization = $this->model_organization->getOrganizationData(1);
        	$this->data['organization_data'] = $organization;        	

        	$result = array();
        	$order_data = $this->model_order->getOrderData($order_id);

    		$result['order'] = $order_data;
    		$movement = $this->model_order->getMovementData($order_data['order_id']);

    		foreach($movement as $k => $v) {
    			$result['movement'][] = $v;
    		}

    		$this->data['order_data'] = $result;

        	$this->data['item'] = $this->model_item->getItemLocationData();   
        	$this->data['customer'] = $this->model_customer->getActiveCustomer(); 
        	$this->data['employee'] = $this->model_employee->getActiveEmployee();   	

            $this->render_template('order/edit', $this->data);
        }
	}



	public function remove()
	{
        if(!in_array('deleteOrder', $this->permission)) {redirect('dashboard', 'refresh');}
        
        $order_id = $this->input->post('order_id');

        $response = array();

        if ($order_id) {
            
                //--> Get the old data before deleting
                $old_data = $this->model_order->getOrderData($order_id);
                $delete = $this->model_order->remove($order_id);
                if($delete == true) {
                    $response['success'] = true;
                    $response['messages'] = 'Successfully deleted';
                    //--> Log Action
                    $this->model_log->create(array(
                        'order_fk' => $order_id,
                        'subject_fk' => $order_id,      
                        'action' => 'Delete',
                        'attributes' => serialize($old_data),
                        'module' => $this->log_module,
                        'remark' => 'Delete Order ' . $order_id,
                        'updated_by' => $this->session->user_id, 
                    ));
                } else {
                    $response['success'] = false;
                    $response['messages'] = 'Error in the database while deleting the information';}
            

        }
        else {
            $response['success'] = false;
            $response['messages'] = 'Refresh the page again';}

        echo json_encode($response);
            
    }


    //--> Redirects to the timeline

    public function timeline($order_id)
    {
        if(!in_array('viewOrder', $this->permission)) {redirect('dashboard', 'refresh');}

        $timeline_data = $this->model_log->timeline_order($order_id); 
        $this->data['timeline_data'] = $timeline_data;
        $this->render_template('timeline', $this->data);
    }

	

}