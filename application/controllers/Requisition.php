<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Requisition extends Admin_Controller 
{
	public function __construct()
	{
		parent::__construct();

		$this->not_logged_in();

		$this->data['page_title'] = 'Requisition';
		$this->log_module = 'Requisition';

	}



	public function index()
	{
		if(!in_array('viewRequisition', $this->permission)) {redirect('dashboard', 'refresh');}

		$this->data['employee_requested'] = $this->model_employee->getActiveEmployee();    

		$this->data['page_title'] = 'Manage Requisition';

		//  Unset the variable session employee id that might be used
		//  when we create a requisition directly from the employee edit page	
		$this->session->unset_userdata('employee_id');

		$this->render_template('requisition/index', $this->data);		
	}


	public function fetchRequisitionDataByDate()
	{
		$result = array('data' => array());

		$date_from = $this->input->get('date_from') ?? NULL;
        $date_to = $this->input->get('date_to') ?? NULL;
        $employee_requested = $this->input->get('employee_requested') ?? NULL;


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
        if ($employee_requested == 'all') {
        	$employee_from = "0";
			$employee_to = "999";
        }
        else {
			$employee_from = $employee_requested;
			$employee_to = $employee_requested;
		}

		$data = $this->model_requisition->getRequisitionDataByDate($date_from, $date_to, $employee_from, $employee_to);

		foreach ($data as $key => $value) {

			$requisition_no = $value['requisition_no'];

			$buttons = '';

			if(in_array('updateRequisition', $this->permission)) {
				$buttons .= ' <a href="'.base_url('requisition/update/'.$value['requisition_id']).'" class="btn btn-default"><i class="fa fa-pencil"></i></a>';
				$requisition_no = '<a href="'.base_url('requisition/update/'.$value['requisition_id']).'">'.$value['requisition_no'].'</a>';
				
			}

			if(in_array('deleteRequisition', $this->permission)) {
				$buttons .= ' <button type="button" class="btn btn-default" onclick="removeFunc('.$value['requisition_id'].')" data-toggle="modal" data-target="#removeModal"><i class="fa fa-trash"></i></button>';
			}


			if(in_array('viewRequisition', $this->permission)) {
				$buttons .= '<a href="'.base_url('report_requisition/report_requisition/'.$value['requisition_id']).'" target="_blank" class="btn btn-default"><i class="fa fa-print"></i></a>'; 
			}

			

			$result['data'][$key] = array(
				$requisition_no,
				$value['requisition_date'],	
				$value['employee_requested_name'],				
				$value['employee_approved_name'],			
				$value['updated_by'],
				$value['updated_date'],
				$buttons
			);
		} // /foreach

		echo json_encode($result);
	}



	public function fetchRequisitionDataByEmployee($employee_id)
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

		$data = $this->model_requisition->getRequisitionDataByEmployee($employee_id, $date_from, $date_to);

		foreach ($data as $key => $value) {

			$requisition_no = $value['requisition_no'];

			$buttons = '';

			if(in_array('updateRequisition', $this->permission)) {
				$buttons .= ' <a href="'.base_url('requisition/update/'.$value['requisition_id']).'" class="btn btn-default"><i class="fa fa-pencil"></i></a>';
				$requisition_no = '<a href="'.base_url('requisition/update/'.$value['requisition_id']).'">'.$value['requisition_no'].'</a>';
			}


			if(in_array('viewRequisition', $this->permission)) {
				$buttons .= '<a href="'.base_url('report_requisition/report_requisition/'.$value['requisition_id']).'" target="_blank" class="btn btn-default"><i class="fa fa-print"></i></a>'; 
			}

			

			$result['data'][$key] = array(
				$requisition_no,
				$value['requisition_date'],		
				$value['employee_approved_name'],	
				$value['updated_by'],
				$value['updated_date'],
				$buttons
			);
		} // /foreach

		echo json_encode($result);
	}




	public function create()
	{
		if(!in_array('createRequisition', $this->permission)) {redirect('dashboard', 'refresh');}

		$this->data['page_title'] = 'Add Requisition';

		$this->form_validation->set_rules('employee_requested', 'Requested By', 'trim|required');
		$this->form_validation->set_rules('requisition_date', 'Requisition Date', 'trim|required');	
		$this->form_validation->set_rules('item[]', 'Item name', 'trim|required');			
	
        if ($this->form_validation->run() == TRUE) {           	

    		$data = array(
	    		'requisition_no' => $this->input->post('requisition_no'),
	    		'employee_requested_fk' => $this->input->post('employee_requested'),	
	    		'employee_approved_fk' => $this->input->post('employee_approved'), 
       			'requisition_date' => $this->input->post('requisition_date'),	    		
	    		'updated_by' => $this->session->userdata('user_id'),
	    	);     	
        	
        	$requisition_id = $this->model_requisition->create($data);
        	
        	if($requisition_id) { 		
        		 //--> Log Action
                $this->model_log->create(array(
                    'requisition_fk' => $requisition_id,
                    'subject_fk' => $requisition_id,      
                    'action' => 'Create',
                    'attributes' => serialize($data),
                    'module' => $this->log_module,
                    'remark' => 'Create Requisition ' . $requisition_id,
                    'updated_by' => $this->session->user_id, 
                ));
        		redirect('requisition/update/'.$requisition_id, 'refresh');
        	}
        	else {
        		$this->session->set_flashdata('errors', 'Error occurred!!');
        		redirect('requisition/create/', 'refresh');
        	}
        }
        else {
            // false case
      	

        	$generate_no = $this->model_requisition->generateRequisitionNo();
        	$this->data['generate_no'] = $generate_no;     
        	
            $this->data['employee_requested'] = $this->model_employee->getActiveEmployee();
        	$this->data['item'] = $this->model_item->getItemLocationData();   
        	$this->data['employee_approved'] = $this->model_employee->getActiveEmployee();     	

            $this->render_template('requisition/create', $this->data);

            
        }	
	}


	public function getItemLocationData()
	{
		$item = $this->model_item->getItemLocationData();
		echo json_encode($item);
	}


	public function getItemData()
	{
		$item_location_id = $this->input->post('item_location_id');
		if($item_location_id) {
			$item_data = $this->model_requisition->getItemData($item_location_id);
			echo json_encode($item_data);
		}
	}



	public function update($requisition_id)
	{
		if(!in_array('updateRequisition', $this->permission)) {redirect('dashboard', 'refresh');}

		$this->data['page_title'] = 'Update Requisition';

		//--> Get the old data before updating
        $old_data = $this->model_requisition->getRequisitionData($requisition_id);

        $this->form_validation->set_rules('employee_requested', 'Requested By', 'trim|required');	
        $this->form_validation->set_rules('requisition_date', 'Requisition Date', 'trim|required');	
		$this->form_validation->set_rules('item[]', 'Item name', 'trim|required');
		
	
        if ($this->form_validation->run() == TRUE) {
        	
            $data = array(
	    		'requisition_date' => $this->input->post('requisition_date'),
	    		'employee_requested_fk' => $this->input->post('employee_requested'), 
	    		'employee_approved_fk' => $this->input->post('employee_approved'),	    		    		    		
	    		'updated_by' => $this->session->userdata('user_id')
	    	);       	
        	
        	$update = $this->model_requisition->update($requisition_id, $data);
        	
        	if($update == true) {        		
        		//--> Log Action
                $this->model_log->create(array(
                    'requisition_fk' => $requisition_id,
                    'subject_fk' => $requisition_id,      
                    'action' => 'Update',
                    'attributes' => serialize(array('old' => $old_data,'new' => $data)),
                    'module' => $this->log_module,
                    'remark' => 'Update Requisition ' . $requisition_id,
                    'updated_by' => $this->session->user_id, 
                ));
        		redirect('requisition/update/'.$requisition_id, 'refresh');
        	}
        	else {
        		$this->session->set_flashdata('errors', 'Error occurred!!');
        		redirect('requisition/update/'.$requisition_id, 'refresh');
        	}
        }
        else {
        	$result = array();
        	$requisition_data = $this->model_requisition->getRequisitionData($requisition_id);

    		$result['requisition'] = $requisition_data;
    		$movement = $this->model_requisition->getMovementData($requisition_data['requisition_id']);

    		foreach($movement as $k => $v) {
    			$result['movement'][] = $v;
    		}

    		$this->data['requisition_data'] = $result;

        	$this->data['item'] = $this->model_item->getItemLocationData();   
        	$this->data['employee_requested'] = $this->model_employee->getActiveEmployee(); 
        	$this->data['employee_approved'] = $this->model_employee->getActiveEmployee();   	

            $this->render_template('requisition/edit', $this->data);
        }
	}



	public function remove()
	{
        if(!in_array('deleteRequisition', $this->permission)) {redirect('dashboard', 'refresh');}
        
        $requisition_id = $this->input->post('requisition_id');

        $response = array();

        if ($requisition_id) {
            
                //--> Get the old data before deleting
                $old_data = $this->model_requisition->getRequisitionData($requisition_id);
                $delete = $this->model_requisition->remove($requisition_id);
                if($delete == true) {
                    $response['success'] = true;
                    $response['messages'] = 'Successfully deleted';
                    //--> Log Action
                    $this->model_log->create(array(
                        'requisition_fk' => $requisition_id,
                        'subject_fk' => $requisition_id,      
                        'action' => 'Delete',
                        'attributes' => serialize($old_data),
                        'module' => $this->log_module,
                        'remark' => 'Delete Requisition ' . $requisition_id,
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

    public function timeline($requisition_id)
    {
        if(!in_array('viewRequisition', $this->permission)) {redirect('dashboard', 'refresh');}

        $timeline_data = $this->model_log->timeline_requisition($requisition_id); 
        $this->data['timeline_data'] = $timeline_data;
        $this->render_template('timeline', $this->data);
    }

	

}