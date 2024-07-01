<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Employee_status extends Admin_Controller 
{
	public function __construct()
	{
		parent::__construct();

		$this->not_logged_in();
		$this->data['page_title'] = 'Employee Status';
	}


	//-->  Redirects to the manage employee_status page

	public function index()
	{

		if(!in_array('viewEmployeeStatus', $this->permission)) {
			redirect('dashboard', 'refresh');
		}

		$this->render_template('employee_status/index', $this->data);	
	}	


	//-->  For creation of drop-down list 

	public function fetchActiveEmployeeStatus() 
	{
		$data = $this->model_employee_status->getActiveEmployeeStatus();
		echo json_encode($data);

	}

	//--> It checks if it gets the employee_status id and retreives
	//    the employee_status information from the employee_status model and 
	//    returns the data into json format. 
	//    This function is invoked from the view page.

	public function fetchEmployeeStatusDataById($employee_status_id) 
	{
		if($employee_status_id) {
			$data = $this->model_employee_status->getEmployeeStatusData($employee_status_id);
			echo json_encode($data);
		}

		return false;
	}


	//-->  Fetches the employee_status value from the employee_status table 
	// this function is called from the datatable ajax function
	
	public function fetchEmployeeStatusData()
	{
		$result = array('data' => array());

		$data = $this->model_employee_status->getEmployeeStatusData(); 

		foreach ($data as $key => $value) {

			$buttons = '';

			$employee_status_name = $value['employee_status_name'];

			if(in_array('updateEmployeeStatus', $this->permission)) {
				$buttons .= '<button type="button" class="btn btn-default" onclick="editFunc('.$value['employee_status_id'].')" data-toggle="modal" data-target="#editModal"><i class="fa fa-pencil"></i></button>';
				$employee_status_name='  <a data-target="#editModal" onclick="editFunc('.$value['employee_status_id'].')" data-toggle="modal" href="#editModal">'.$value['employee_status_name'].'</a>';
			}

			if(in_array('deleteEmployeeStatus', $this->permission)) {
				$buttons .= ' <button type="button" class="btn btn-default" onclick="removeFunc('.$value['employee_status_id'].')" data-toggle="modal" data-target="#removeModal"><i class="fa fa-trash"></i></button>';
			}
				

			$active = ($value['active'] == 1) ? '<span class="label label-success">'.'Active'.'</span>' : '<span class="label label-warning">'.'Inactive'.'</span>';

			$result['data'][$key] = array(
				$employee_status_name,
				$value['employee_status_code'],
				$active,
				$buttons
			);
		} // /foreach

		echo json_encode($result);
	}


	//---> Checks the employee_status form validation 
	//     and if the validation is successfully then it inserts the data into the database 
	//     and returns the json format operation messages

	public function create()
	{
		if(!in_array('createEmployeeStatus', $this->permission)) {
			redirect('dashboard', 'refresh');
		}

		$response = array();

		$this->form_validation->set_rules('employee_status_name', 'Name', 'trim|required');
		$this->form_validation->set_rules('employee_status_code', 'Code', 'trim|required');
		$this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');

        if ($this->form_validation->run() == TRUE) {
        	$data = array(
        		'employee_status_code' => $this->input->post('employee_status_code'),
        		'employee_status_name' => $this->input->post('employee_status_name'),
        		'active' => $this->input->post('active'),	
        	);

        	$create = $this->model_employee_status->create($data);
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


	//-->  Checks the employee_status form validation 
	//     and if the validation is successfully then it updates the data into the database 
	//     and returns the json format operation messages

	public function update($employee_status_id)
	{

		if(!in_array('updateEmployeeStatus', $this->permission)) {
			redirect('dashboard', 'refresh');
		}

		$response = array();

		if($employee_status_id) {
			$this->form_validation->set_rules('edit_employee_status_name', 'Name', 'trim|required');
			$this->form_validation->set_rules('edit_employee_status_code', 'Code', 'trim|required');
			$this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');

	        if ($this->form_validation->run() == TRUE) {
	        	$data = array(
	        		'employee_status_code' => $this->input->post('edit_employee_status_code'),
	        		'employee_status_name' => $this->input->post('edit_employee_status_name'),
	        		'active' => $this->input->post('edit_active'),	
	        	);

	        	$update = $this->model_employee_status->update($data, $employee_status_id);
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


	//-->  Removes the employee_status information from the database 
	//     and returns the json format operation messages

	public function remove()
	{
		if(!in_array('deleteEmployeeStatus', $this->permission)) {
			redirect('dashboard', 'refresh');
		}
		
		$employee_status_id = $this->input->post('employee_status_id');

		$response = '';
		$response = array();

		if($employee_status_id) {
			//---> Validate if the information is used in other table
			$total_used = $this->model_employee_status->checkIntegrity($employee_status_id);
			//---> If not used, we can delete
            if ($total_used == 0) {        
				$delete = $this->model_employee_status->remove($employee_status_id);
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
				$response['messages'] = 'At least one maintenance uses this information.  You cannot delete.';}

		}
		else {
			$response['success'] = false;
			$response['messages'] = 'Refresh the page again';}

		echo json_encode($response);
	}

}