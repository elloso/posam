<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Availability extends Admin_Controller 
{
	public function __construct()
	{
		parent::__construct();

		$this->not_logged_in();

		$this->data['page_title'] = 'Availability';

	}


	//--> Redirects to the manage availability page

	public function index()
	{

		if(!in_array('viewAvailability', $this->permission)) {
			redirect('dashboard', 'refresh');
		}

		$this->render_template('availability/index', $this->data);	
	}	

	
	//--> It checks if it gets the availability id and retrieves
	//    the availability information from the availability model and 
	//    returns the data into json format. 
	//    This function is invoked from the view page.
	
	public function fetchAvailabilityDataById($availability_id) 
	{
		if($availability_id) {
			$data = $this->model_availability->getAvailabilityData($availability_id);
			echo json_encode($data);
		}

		return false;
	}

	
	//--> Fetches the availability value from the availability table 
	//    This function is called from the datatable ajax function
	
	public function fetchAvailabilityData()
	{
		$result = array('data' => array());

		$data = $this->model_availability->getAvailabilityData(); 

		foreach ($data as $key => $value) {

			$buttons = '';

			$availability_name = $value['availability_name'];

			if(in_array('updateAvailability', $this->permission)) {
				$buttons .= '<button type="button" class="btn btn-default" onclick="editFunc('.$value['availability_id'].')" data-toggle="modal" data-target="#editModal"><i class="fa fa-pencil"></i></button>';
				$availability_name='  <a data-target="#editModal" onclick="editFunc('.$value['availability_id'].')" data-toggle="modal" href="#editModal">'.$value['availability_name'].'</a>';
			}

			if(in_array('deleteAvailability', $this->permission)) {
				$buttons .= ' <button type="button" class="btn btn-default" onclick="removeFunc('.$value['availability_id'].')" data-toggle="modal" data-target="#removeModal"><i class="fa fa-trash"></i></button>';
			}
				

			$active = ($value['active'] == 1) ? '<span class="label label-success">'.'Active'.'</span>' : '<span class="label label-warning">'.'Inactive'.'</span>';

			$result['data'][$key] = array(
				$availability_name,
				$active,
				$buttons
			);
		} // /foreach

		echo json_encode($result);
	}

	
	//--> It checks the availability form validation 
	//    and if the validation is true (valid) then it inserts the data into the database 
	//    and returns the json format operation messages
	
	public function create()
	{
		if(!in_array('createAvailability', $this->permission)) {
			redirect('dashboard', 'refresh');
		}

		$response = array();

		$this->form_validation->set_rules('availability_name', 'Name', 'trim|required');
		$this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');

        if ($this->form_validation->run() == TRUE) {
        	$data = array(
        		'availability_name' => $this->input->post('availability_name'),
        		'active' => $this->input->post('active'),	
        	);

        	$create = $this->model_availability->create($data);
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

	
	//--> It checks the availability form validation 
	//    and if the validation is true (valid) then it updates the data into the database 
	//    and returns the json format operation messages
	
	public function update($availability_id)
	{

		if(!in_array('updateAvailability', $this->permission)) {
			redirect('dashboard', 'refresh');
		}

		$response = '';
		$response = array();

		if($availability_id) {
			$this->form_validation->set_rules('edit_availability_name', $this->lang->line('Name'), 'trim|required');
			$this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');

	        if ($this->form_validation->run() == TRUE) {
	        	$data = array(
	        		'availability_name' => $this->input->post('edit_availability_name'),
	        		'active' => $this->input->post('edit_active'),	
	        	);

	        	$update = $this->model_availability->update($data, $availability_id);
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

	
	//--> It removes the availability information from the database 
	//    and returns the json format operation messages
	
	public function remove()
	{
		if(!in_array('deleteAvailability', $this->permission)) {
			redirect('dashboard', 'refresh');}
		
		$availability_id = $this->input->post('availability_id');

        $response = '';
		$response = array();

		if($availability_id) {
			//---> Validate if the information is used in another table
			$total_used = $this->model_availability->checkIntegrity($availability_id);
			//---> If no table has this information, we can delete
            if ($total_used == 0) {        
				$delete = $this->model_availability->remove($availability_id);
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