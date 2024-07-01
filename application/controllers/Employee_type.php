<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Employee_type extends Admin_Controller 
{
	public function __construct()
	{
		parent::__construct();

		$this->not_logged_in();
		$this->data['page_title'] = 'Employee Type';
	}


	//-->  Redirects to the manage employee_type page

	public function index()
	{

		if(!in_array('viewEmployeeType', $this->permission)) {
			redirect('dashboard', 'refresh');
		}

		$this->render_template('employee_type/index', $this->data);	
	}	


	//-->  For creation of drop-down list 

	public function fetchActiveEmployeeType() 
	{
		$data = $this->model_employee_type->getActiveEmployeeType();
		echo json_encode($data);

	}

	//--> It checks if it gets the employee_type id and retreives
	//    the employee_type information from the employee_type model and 
	//    returns the data into json format. 
	//    This function is invoked from the view page.

	public function fetchEmployeeTypeDataById($employee_type_id) 
	{
		if($employee_type_id) {
			$data = $this->model_employee_type->getEmployeeTypeData($employee_type_id);
			echo json_encode($data);
		}

		return false;
	}


	//-->  Fetches the employee_type value from the employee_type table 
	// this function is called from the datatable ajax function
	
	public function fetchEmployeeTypeData()
	{
		$result = array('data' => array());

		$data = $this->model_employee_type->getEmployeeTypeData(); 

		foreach ($data as $key => $value) {

			$buttons = '';

			$employee_type_name = $value['employee_type_name'];

			if(in_array('updateEmployeeType', $this->permission)) {
				$buttons .= '<button type="button" class="btn btn-default" onclick="editFunc('.$value['employee_type_id'].')" data-toggle="modal" data-target="#editModal"><i class="fa fa-pencil"></i></button>';
				$employee_type_name='  <a data-target="#editModal" onclick="editFunc('.$value['employee_type_id'].')" data-toggle="modal" href="#editModal">'.$value['employee_type_name'].'</a>';
			}

			if(in_array('deleteEmployeeType', $this->permission)) {
				$buttons .= ' <button type="button" class="btn btn-default" onclick="removeFunc('.$value['employee_type_id'].')" data-toggle="modal" data-target="#removeModal"><i class="fa fa-trash"></i></button>';
			}
				

			$active = ($value['active'] == 1) ? '<span class="label label-success">'.'Active'.'</span>' : '<span class="label label-warning">'.'Inactive'.'</span>';

			$result['data'][$key] = array(
				$employee_type_name,
				$value['employee_type_code'],
				$active,
				$buttons
			);
		} // /foreach

		echo json_encode($result);
	}


	//---> Checks the employee_type form validation 
	//     and if the validation is successfully then it inserts the data into the database 
	//     and returns the json format operation messages

	public function create()
	{
		if(!in_array('createEmployeeType', $this->permission)) {
			redirect('dashboard', 'refresh');
		}

		$response = array();

		$this->form_validation->set_rules('employee_type_name', 'Name', 'trim|required');
		$this->form_validation->set_rules('employee_type_code', 'Code', 'trim|required');
		$this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');

        if ($this->form_validation->run() == TRUE) {
        	$data = array(
        		'employee_type_code' => $this->input->post('employee_type_code'),
        		'employee_type_name' => $this->input->post('employee_type_name'),
        		'active' => $this->input->post('active'),	
        	);

        	$create = $this->model_employee_type->create($data);
        	if($create == true) {
        		$response['success'] = true;
        		$response['messages'] = 'Successfully created';
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


	//-->  Checks the employee_type form validation 
	//     and if the validation is successfully then it updates the data into the database 
	//     and returns the json format operation messages

	public function update($employee_type_id)
	{

		if(!in_array('updateEmployeeType', $this->permission)) {
			redirect('dashboard', 'refresh');
		}

		$response = array();

		if($employee_type_id) {
			$this->form_validation->set_rules('edit_employee_type_name', 'Name', 'trim|required');
			$this->form_validation->set_rules('edit_employee_type_code', 'Code', 'trim|required');
			$this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');

	        if ($this->form_validation->run() == TRUE) {
	        	$data = array(
	        		'employee_type_code' => $this->input->post('edit_employee_type_code'),
	        		'employee_type_name' => $this->input->post('edit_employee_type_name'),
	        		'active' => $this->input->post('edit_active'),	
	        	);

	        	$update = $this->model_employee_type->update($data, $employee_type_id);
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


	//-->  Removes the employee_type information from the database 
	//     and returns the json format operation messages

	public function remove()
	{
		if(!in_array('deleteEmployeeType', $this->permission)) {
			redirect('dashboard', 'refresh');
		}
		
		$employee_type_id = $this->input->post('employee_type_id');

		$response = '';
		$response = array();

		if($employee_type_id) {
			//---> Validate if the information is used in other table
			$total_used = $this->model_employee_type->checkIntegrity($employee_type_id);
			//---> If not used, we can delete
            if ($total_used == 0) {        
				$delete = $this->model_employee_type->remove($employee_type_id);
				if($delete == true) {
					$response['success'] = true;
					$response['messages'] = 'Successfully deleted';}
				else {
					$response['success'] = false;
					$response['messages'] = 'Error in the database while deleting the information';}
				}

			else {
				//---> There is at least one table having this information
				$response['success'] = false;
				$response['messages'] = 'At least one employee uses this information.  You cannot delete.';}

		}
		else {
			$response['success'] = false;
			$response['messages'] = 'Refresh the page again';}

		echo json_encode($response);
	}

}