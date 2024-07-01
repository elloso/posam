<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Delivery extends Admin_Controller 
{
	public function __construct()
	{
		parent::__construct();

		$this->not_logged_in();

		$this->data['page_title'] = 'Delivery';
		$this->log_module = 'Delivery';

	}



	public function index()
	{
		if(!in_array('viewDelivery', $this->permission)) {redirect('dashboard', 'refresh');}

		$this->data['supplier'] = $this->model_supplier->getActiveSupplier();    

		$this->data['page_title'] = 'Manage Delivery';

		//  Unset the variable session supplier id that might be used
		//  when we create a delivery directly from the supplier edit page	
		$this->session->unset_userdata('supplier_id');

		$this->render_template('delivery/index', $this->data);		
	}


	public function fetchDeliveryDataByDate()
	{
		$result = array('data' => array());

		$date_from = $this->input->get('date_from') ?? NULL;
        $date_to = $this->input->get('date_to') ?? NULL;
        $supplier = $this->input->get('supplier') ?? NULL;


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

        //--> Criteria RESOURCE
        if ($supplier == 'all') {
        	$supplier_from = "0";
			$supplier_to = "999";
        }
        else {
			$supplier_from = $supplier;
			$supplier_to = $supplier;
		}

		$data = $this->model_delivery->getDeliveryDataByDate($date_from, $date_to, $supplier_from, $supplier_to);

		foreach ($data as $key => $value) {

			$delivery_no = $value['delivery_no'];

			$buttons = '';

			if(in_array('updateDelivery', $this->permission)) {
				$buttons .= ' <a href="'.base_url('delivery/update/'.$value['delivery_id']).'" class="btn btn-default"><i class="fa fa-pencil"></i></a>';
				$delivery_no = '<a href="'.base_url('delivery/update/'.$value['delivery_id']).'">'.$value['delivery_no'].'</a>';
				
			}

			if(in_array('deleteDelivery', $this->permission)) {
				$buttons .= ' <button type="button" class="btn btn-default" onclick="removeFunc('.$value['delivery_id'].')" data-toggle="modal" data-target="#removeModal"><i class="fa fa-trash"></i></button>';
			}


			if(in_array('viewDelivery', $this->permission)) {
				$buttons .= '<a href="'.base_url('report_delivery/report_delivery/'.$value['delivery_id']).'" target="_blank" class="btn btn-default"><i class="fa fa-print"></i></a>'; 
			}
			

			$result['data'][$key] = array(

				$delivery_no,
				$value['supplier_name'],
				$value['delivery_date'],	
				$value['production_date'],				
				$value['expiry_date'],			
				$value['batch_no'],
				$value['lot_no'],
				$value['reference_no'],
				$buttons
			);
		} // /foreach

		echo json_encode($result);
	}



	public function fetchDeliveryDataBySupplier($supplier_id)
	{
		
		$result = array('data' => array());

        $date_from = $this->input->get('date_from') ?? NULL;
        $date_to = $this->input->get('date_to') ?? NULL;

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

		$data = $this->model_delivery->getDeliveryDataBySupplier($supplier_id, $date_from, $date_to);

		foreach ($data as $key => $value) {

			$delivery_no = $value['delivery_no'];

			$buttons = '';

			if(in_array('updateDelivery', $this->permission)) {
				$buttons .= ' <a href="'.base_url('delivery/update/'.$value['delivery_id']).'" class="btn btn-default"><i class="fa fa-pencil"></i></a>';
				$delivery_no = '<a href="'.base_url('delivery/update/'.$value['delivery_id']).'">'.$value['delivery_no'].'</a>';
			}


			if(in_array('viewDelivery', $this->permission)) {
				$buttons .= '<a href="'.base_url('report_delivery/report_delivery/'.$value['delivery_id']).'" target="_blank" class="btn btn-default"><i class="fa fa-print"></i></a>'; 
			}			

			$result['data'][$key] = array(
				$delivery_no,
				$value['delivery_date'],		
				$value['production_date'],	
				$value['expiry_date'],
				$value['batch_no'],
				$value['lot_no'],
				$value['reference_no'],
				$buttons
			);
		} // /foreach

		echo json_encode($result);
	}




	public function create()
	{
		if(!in_array('createDelivery', $this->permission)) {redirect('dashboard', 'refresh');}

		$this->data['page_title'] = 'Add Delivery';

		$this->form_validation->set_rules('supplier', 'Supplier', 'trim|required');
		$this->form_validation->set_rules('delivery_date', 'Delivery Date', 'trim|required');	
		$this->form_validation->set_rules('item[]', 'Item name', 'trim|required');			
	
        if ($this->form_validation->run() == TRUE) {           	

    		$data = array(
	    		'delivery_no' => $this->input->post('delivery_no'),
	    		'supplier_fk' => $this->input->post('supplier'),	
       			'delivery_date' => $this->input->post('delivery_date'),	
       			'disposition' => $this->input->post('disposition'),
       			'production_date' => $this->input->post('production_date'),
       			'expiry_date' => $this->input->post('expiry_date'),
       			'batch_no' => $this->input->post('batch_no'),
       			'lot_no' => $this->input->post('lot_no'),   
       			'reference_no' => $this->input->post('reference_no'),  		
	    		'updated_by' => $this->session->userdata('user_id'),
	    	);     	
        	
        	$delivery_id = $this->model_delivery->create($data);
        	
        	if($delivery_id) { 		
        		 //--> Log Action
                $this->model_log->create(array(
                    'delivery_fk' => $delivery_id,
                    'subject_fk' => $delivery_id,      
                    'action' => 'Create',
                    'attributes' => serialize($data),
                    'module' => $this->log_module,
                    'remark' => 'Create Delivery ' . $delivery_id,
                    'updated_by' => $this->session->user_id, 
                ));

        		redirect('delivery/update/'.$delivery_id, 'refresh');
        	}
        	else {
        		$this->session->set_flashdata('errors', 'Error occurred!!');
        		redirect('delivery/create/', 'refresh');
        	}
        }
        else {
            // false case
      	

        	$generate_no = $this->model_delivery->generateDeliveryNo();
        	$this->data['generate_no'] = $generate_no;     
        	
            $this->data['supplier'] = $this->model_supplier->getActiveSupplier();
        	$this->data['item'] = $this->model_item->getItemLocationData();   
        	$this->data['item_location'] = $this->model_supplier->getActiveSupplier();     	

            $this->render_template('delivery/create', $this->data);            
            
        }	
	}



	public function getItemLocationData()
	{
		$item = $this->model_item->getItemLocationData();
		echo json_encode($item);
	}


	public function update($delivery_id)
	{
		if(!in_array('updateDelivery', $this->permission)) {redirect('dashboard', 'refresh');}

		$this->data['page_title'] = 'Update Delivery';

		//--> Get the old data before updating
        $old_data = $this->model_delivery->getDeliveryData($delivery_id);

        $this->form_validation->set_rules('supplier', 'Supplier', 'trim|required');	
        $this->form_validation->set_rules('delivery_date', 'Delivery Date', 'trim|required');	
		$this->form_validation->set_rules('item[]', 'Item name', 'trim|required');
		
	
        if ($this->form_validation->run() == TRUE) {
        	
            $data = array(
	    		'supplier_fk' => $this->input->post('supplier'),	
       			'delivery_date' => $this->input->post('delivery_date'),	
       			'disposition' => $this->input->post('disposition'),
       			'production_date' => $this->input->post('production_date'),
       			'expiry_date' => $this->input->post('expiry_date'),
       			'batch_no' => $this->input->post('batch_no'),
       			'lot_no' => $this->input->post('lot_no'),   
       			'reference_no' => $this->input->post('reference_no'),  		
	    		'updated_by' => $this->session->userdata('user_id'),
	    	);       	
        	
        	$update = $this->model_delivery->update($delivery_id, $data);
        	
        	if($update == true) {        		
        		//--> Log Action
                $this->model_log->create(array(
                    'delivery_fk' => $delivery_id,
                    'subject_fk' => $delivery_id,      
                    'action' => 'Update',
                    'attributes' => serialize(array('old' => $old_data,'new' => $data)),
                    'module' => $this->log_module,
                    'remark' => 'Update Delivery ' . $delivery_id,
                    'updated_by' => $this->session->user_id, 
                ));
        		redirect('delivery/update/'.$delivery_id, 'refresh');
        	}
        	else {
        		$this->session->set_flashdata('errors', 'Error occurred!!');
        		redirect('delivery/update/'.$delivery_id, 'refresh');
        	}
        }
        else {
        	$result = array();
        	$delivery_data = $this->model_delivery->getDeliveryData($delivery_id);

    		$result['delivery'] = $delivery_data;
    		$movement = $this->model_delivery->getMovementData($delivery_data['delivery_id']);

    		foreach($movement as $k => $v) {
    			$result['movement'][] = $v;
    		}

    		$this->data['delivery_data'] = $result;

        	$this->data['item'] = $this->model_item->getItemLocationData();   
        	$this->data['supplier'] = $this->model_supplier->getActiveSupplier(); 
        	$this->data['item_location'] = $this->model_supplier->getActiveSupplier();   	

            $this->render_template('delivery/edit', $this->data);
        }
	}



	public function remove()
	{
        if(!in_array('deleteDelivery', $this->permission)) {redirect('dashboard', 'refresh');}
        
        $delivery_id = $this->input->post('delivery_id');

        $response = array();

        if ($delivery_id) {
            
                //--> Get the old data before deleting
                $old_data = $this->model_delivery->getDeliveryData($delivery_id);
                $delete = $this->model_delivery->remove($delivery_id);
                if($delete == true) {
                    $response['success'] = true;
                    $response['messages'] = 'Successfully deleted';
                    //--> Log Action
                    $this->model_log->create(array(
                        'delivery_fk' => $delivery_id,
                        'subject_fk' => $delivery_id,      
                        'action' => 'Delete',
                        'attributes' => serialize($old_data),
                        'module' => $this->log_module,
                        'remark' => 'Delete Delivery ' . $delivery_id,
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

    public function timeline($delivery_id)
    {
        if(!in_array('viewDelivery', $this->permission)) {redirect('dashboard', 'refresh');}

        $timeline_data = $this->model_log->timeline_delivery($delivery_id); 
        $this->data['timeline_data'] = $timeline_data;
        $this->render_template('timeline', $this->data);
    }

	

}