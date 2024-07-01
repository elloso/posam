<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Department extends Admin_Controller 
{
	public function __construct()
	{
		parent::__construct();

		$this->not_logged_in();

		$this->data['page_title'] = 'Department';

	}


	//--> Redirects to the manage department page

	public function index()
	{
		// var_dump($this->permission);
		// exit; 

		if(!in_array('viewDepartment', $this->permission)) {
			redirect('dashboard', 'refresh');
		}

		$this->render_template('department/index', $this->data);	
	}	

	
	//--> It checks if it gets the position id and retrieves
	//    the position information from the position model and 
	//    returns the data into json format. 
	//    This function is invoked from the view page.
	
	public function fetchDepartmentDataById($department_id) 
	{
		if($department_id) {
			$data = $this->model_department->getDepartmentData($department_id);
			echo json_encode($data);
		}

		return false;
	}


	//-->  For creation of drop-down list 

	public function fetchActiveDepartment() 
	{
		$data = $this->model_department->getActivePosition();
		echo json_encode($data);

	}

	
	//--> Fetches the position value from the position table 
	//    This function is called from the datatable ajax function
	
	public function fetchDepartmentData()
	{
		$result = array('data' => array());

		$data = $this->model_department->getDepartmentData(); 

		foreach ($data as $key => $value) {

			$buttons = '';

			$position_name = $value['position_name'];

			if(in_array('updatePosition', $this->permission)) {
				$buttons .= '<button type="button" class="btn btn-default" onclick="editFunc('.$value['position_id'].')" data-toggle="modal" data-target="#editModal"><i class="fa fa-pencil"></i></button>';
				$position_name='  <a data-target="#editModal" onclick="editFunc('.$value['position_id'].')" data-toggle="modal" href="#editModal">'.$value['position_name'].'</a>';
			}

			if(in_array('deletePosition', $this->permission)) {
				$buttons .= ' <button type="button" class="btn btn-default" onclick="removeFunc('.$value['position_id'].')" data-toggle="modal" data-target="#removeModal"><i class="fa fa-trash"></i></button>';
			}
				

			$active = ($value['active'] == 1) ? '<span class="label label-success">'.'Active'.'</span>' : '<span class="label label-warning">'.'Inactive'.'</span>';

			$result['data'][$key] = array(
				$position_name,
				$value['position_code'],
				$active,
				$buttons
			);
		} // /foreach

		echo json_encode($result);
	}

	
	//--> It checks the position form validation 
	//    and if the validation is true (valid) then it inserts the data into the database 
	//    and returns the json format operation messages
	
	public function create()
	{
		if(!in_array('createPosition', $this->permission)) {
			redirect('dashboard', 'refresh');
		}

		$response = array();

		$this->form_validation->set_rules('position_name', 'Name', 'trim|required');
		$this->form_validation->set_rules('position_code', 'Code', 'trim|required');
		$this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');

        if ($this->form_validation->run() == TRUE) {
        	$data = array(
        		'position_code' => $this->input->post('position_code'),
        		'position_name' => $this->input->post('position_name'),
        		'active' => $this->input->post('active'),	
        	);

        	$create = $this->model_department->create($data);
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

	
	//--> It checks the position form validation 
	//    and if the validation is true (valid) then it updates the data into the database 
	//    and returns the json format operation messages
	
	public function update($position_id)
	{

		if(!in_array('updatePosition', $this->permission)) {
			redirect('dashboard', 'refresh');
		}

		$response = '';
		$response = array();

		if($position_id) {
			$this->form_validation->set_rules('edit_position_name', $this->lang->line('Name'), 'trim|required');
			$this->form_validation->set_rules('edit_position_code', 'Code', 'trim|required');
			$this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');

	        if ($this->form_validation->run() == TRUE) {
	        	$data = array(
	        		'position_code' => $this->input->post('edit_position_code'),
	        		'position_name' => $this->input->post('edit_position_name'),
	        		'active' => $this->input->post('edit_active'),	
	        	);

	        	$update = $this->model_department->update($data, $position_id);
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

	
	//--> It removes the position information from the database 
	//    and returns the json format operation messages
	
	public function remove()
	{
		if(!in_array('deletePosition', $this->permission)) {
			redirect('dashboard', 'refresh');}
		
		$position_id = $this->input->post('position_id');

        $response = '';
		$response = array();

		if($position_id) {
			//---> Validate if the information is used in another table
			$total_used = $this->model_department->checkIntegrity($position_id);
			//---> If no table has this information, we can delete
            if ($total_used == 0) {        
				$delete = $this->model_department->remove($position_id);
				if($delete == true) {
					$response['success'] = true;
					$response['messages'] = 'Successfully deleted';}
				else {
					$response['success'] = false;
					$response['messages'] ='Error in the database while deleting the information';}
				}

			else {
				//---> There is at least one license having this information
				$response['success'] = false;
				$response['messages'] = 'At least one item uses this information.  You cannot delete.';}

		}
		else {
			$response['success'] = false;
			$response['messages'] = 'Refresh the page again';}

		echo json_encode($response);
	}

}