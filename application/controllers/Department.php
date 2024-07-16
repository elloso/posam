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

	
	//--> It checks if it gets the department id and retrieves
	//    the department information from the department model and 
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
		$data = $this->model_department->getActiveDepartment();
		echo json_encode($data);

	}

	
	//--> Fetches the department value from the department table 
	//    This function is called from the datatable ajax function
	
	public function fetchDepartmentData()
	{
		$result = array('data' => array());

		$data = $this->model_department->getDepartmentData(); 

		foreach ($data as $key => $value) {

			$buttons = '';

			$department_name = $value['department_name'];

			if(in_array('updateDepartment', $this->permission)) {
				$buttons .= '<button type="button" class="btn btn-default" onclick="editFunc('.$value['department_id'].')" data-toggle="modal" data-target="#editModal"><i class="fa fa-pencil"></i></button>';
				$department_name='  <a data-target="#editModal" onclick="editFunc('.$value['department_id'].')" data-toggle="modal" href="#editModal">'.$value['department_name'].'</a>';
			}

			if(in_array('deleteDepartment', $this->permission)) {
				$buttons .= ' <button type="button" class="btn btn-default" onclick="removeFunc('.$value['department_id'].')" data-toggle="modal" data-target="#removeModal"><i class="fa fa-trash"></i></button>';
			}
				

			$active = ($value['active'] == 1) ? '<span class="label label-success">'.'Active'.'</span>' : '<span class="label label-warning">'.'Inactive'.'</span>';

			$result['data'][$key] = array(
				$department_name,
				$value['department_code'],
				$active,
				$buttons
			);
		} // /foreach

		echo json_encode($result);
	}

	
	//--> It checks the department form validation 
	//    and if the validation is true (valid) then it inserts the data into the database 
	//    and returns the json format operation messages
	
	public function create()
	{
		if(!in_array('createDepartment', $this->permission)) {
			redirect('dashboard', 'refresh');
		}

		$response = array();

		$this->form_validation->set_rules('department_name', 'Name', 'trim|required');
		$this->form_validation->set_rules('department_code', 'Code', 'trim|required');
		$this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');

        if ($this->form_validation->run() == TRUE) {
        	$data = array(
        		'department_code' => $this->input->post('department_code'),
        		'department_name' => $this->input->post('department_name'),
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

	
	//--> It checks the department form validation 
	//    and if the validation is true (valid) then it updates the data into the database 
	//    and returns the json format operation messages
	
	public function update($department_id)
	{

		if(!in_array('updateDepartment', $this->permission)) {
			redirect('dashboard', 'refresh');
		}

		$response = '';
		$response = array();

		if($department_id) {
			$this->form_validation->set_rules('edit_department_name', $this->lang->line('Name'), 'trim|required');
			$this->form_validation->set_rules('edit_department_code', 'Code', 'trim|required');
			$this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');

	        if ($this->form_validation->run() == TRUE) {
	        	$data = array(
	        		'department_code' => $this->input->post('edit_department_code'),
	        		'department_name' => $this->input->post('edit_department_name'),
	        		'active' => $this->input->post('edit_active'),	
	        	);

	        	$update = $this->model_department->update($data, $department_id);
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

	
	//--> It removes the department information from the database 
	//    and returns the json format operation messages
	
	public function remove()
	{
		if(!in_array('deleteDepartment', $this->permission)) {
			redirect('dashboard', 'refresh');}
		
		$department_id = $this->input->post('department_id');

        $response = '';
		$response = array();

		if($department_id) {
			//---> Validate if the information is used in another table
			$total_used = $this->model_department->checkIntegrity($department_id);
			//---> If no table has this information, we can delete
            if ($total_used == 0) {        
				$delete = $this->model_department->remove($department_id);
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