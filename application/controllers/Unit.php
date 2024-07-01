<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Unit extends Admin_Controller 
{
	public function __construct()
	{
		parent::__construct();

		$this->not_logged_in();

		$this->data['page_title'] = 'Unit';

	}


	//--> Redirects to the manage unit page

	public function index()
	{

		if(!in_array('viewUnit', $this->permission)) {
			redirect('dashboard', 'refresh');
		}

		$this->render_template('unit/index', $this->data);	
	}	

	
	//--> It checks if it gets the unit id and retrieves
	//    the unit information from the unit model and 
	//    returns the data into json format. 
	//    This function is invoked from the view page.
	
	public function fetchUnitDataById($unit_id) 
	{
		if($unit_id) {
			$data = $this->model_unit->getUnitData($unit_id);
			echo json_encode($data);
		}

		return false;
	}

	
	//--> Fetches the unit value from the unit table 
	//    This function is called from the datatable ajax function
	
	public function fetchUnitData()
	{
		$result = array('data' => array());

		$data = $this->model_unit->getUnitData(); 

		foreach ($data as $key => $value) {

			$buttons = '';

			$unit_name = $value['unit_name'];

			if(in_array('updateUnit', $this->permission)) {
				$buttons .= '<button type="button" class="btn btn-default" onclick="editFunc('.$value['unit_id'].')" data-toggle="modal" data-target="#editModal"><i class="fa fa-pencil"></i></button>';
				$unit_name='  <a data-target="#editModal" onclick="editFunc('.$value['unit_id'].')" data-toggle="modal" href="#editModal">'.$value['unit_name'].'</a>';
			}

			if(in_array('deleteUnit', $this->permission)) {
				$buttons .= ' <button type="button" class="btn btn-default" onclick="removeFunc('.$value['unit_id'].')" data-toggle="modal" data-target="#removeModal"><i class="fa fa-trash"></i></button>';
			}
				

			$active = ($value['active'] == 1) ? '<span class="label label-success">'.'Active'.'</span>' : '<span class="label label-warning">'.'Inactive'.'</span>';

			$result['data'][$key] = array(
				$unit_name,
				$active,
				$buttons
			);
		} // /foreach

		echo json_encode($result);
	}

	
	//--> It checks the unit form validation 
	//    and if the validation is true (valid) then it inserts the data into the database 
	//    and returns the json format operation messages
	
	public function create()
	{
		if(!in_array('createUnit', $this->permission)) {
			redirect('dashboard', 'refresh');
		}

		$response = array();

		$this->form_validation->set_rules('unit_name', 'Name', 'trim|required');
		$this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');

        if ($this->form_validation->run() == TRUE) {
        	$data = array(
        		'unit_name' => $this->input->post('unit_name'),
        		'active' => $this->input->post('active'),	
        	);

        	$create = $this->model_unit->create($data);
        	if($create == true) {
        		$response['success'] = true;
        		$response['messages'] ='Successfully created';
        	}
        	else {
        		$response['success'] = false;
        		$response['messages'] = 'Error in the database while creating the information';			
        	}
        }
        else {
        	$response['success'] = false;
        	foreach ($_POST as $key => $value) {
        		$response['messages'][$key] = form_error($key);
        	}
        }

        echo json_encode($response);
	}

	
	//--> It checks the unit form validation 
	//    and if the validation is true (valid) then it updates the data into the database 
	//    and returns the json format operation messages
	
	public function update($unit_id)
	{

		if(!in_array('updateUnit', $this->permission)) {
			redirect('dashboard', 'refresh');
		}

		$response = '';
		$response = array();

		if($unit_id) {
			$this->form_validation->set_rules('edit_unit_name', $this->lang->line('Name'), 'trim|required');
			$this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');

	        if ($this->form_validation->run() == TRUE) {
	        	$data = array(
	        		'unit_name' => $this->input->post('edit_unit_name'),
	        		'active' => $this->input->post('edit_active'),	
	        	);

	        	$update = $this->model_unit->update($data, $unit_id);
	        	if($update == true) {
	        		$response['success'] = true;
	        		$response['messages'] = 'Successfully updated';
	        	}
	        	else {
	        		$response['success'] = false;
	        		$response['messages'] = 'Error in the database while updating the information';			
	        	}
	        }
	        else {
	        	$response['success'] = false;
	        	foreach ($_POST as $key => $value) {
	        		$response['messages'][$key] = form_error($key);
	        	}
	        }
		}
		else {
			$response['success'] = false;
    		$response['messages'] = 'Error please refresh the page again';
		}

		echo json_encode($response);
	}

	
	//--> It removes the unit information from the database 
	//    and returns the json format operation messages
	
	public function remove()
	{
		if(!in_array('deleteUnit', $this->permission)) {
			redirect('dashboard', 'refresh');}
		
		$unit_id = $this->input->post('unit_id');

        $response = '';
		$response = array();

		if($unit_id) {
			//---> Validate if the information is used in another table
			$total_used = $this->model_unit->checkIntegrity($unit_id);
			//---> If no table has this information, we can delete
            if ($total_used == 0) {        
				$delete = $this->model_unit->remove($unit_id);
				if($delete == true) {
					$response['success'] = true;
					$response['messages'] = 'Successfully deleted';}
				else {
					$response['success'] = false;
					$response['messages'] ='Error in the database while deleting the information';}
				}

			else {
				//---> There is at least one item or asset having this information
				$response['success'] = false;
				$response['messages'] = 'At least one item or asset uses this information.  You cannot delete.';}

		}
		else {
			$response['success'] = false;
			$response['messages'] = 'Refresh the page again';}

		echo json_encode($response);
	}

}