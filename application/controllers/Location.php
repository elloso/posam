<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Location extends Admin_Controller 
{
	public function __construct()
	{
		parent::__construct();

		$this->not_logged_in();

		$this->data['page_title'] = 'Location';

	}


	//--> Redirects to the manage location page

	public function index()
	{

		if(!in_array('viewLocation', $this->permission)) {
			redirect('dashboard', 'refresh');
		}

		$this->render_template('location/index', $this->data);	
	}	

	
	//--> It checks if it gets the location id and retrieves
	//    the location information from the location model and 
	//    returns the data into json format. 
	//    This function is invoked from the view page.
	
	public function fetchLocationDataById($location_id) 
	{
		if($location_id) {
			$data = $this->model_location->getLocationData($location_id);
			echo json_encode($data);
		}

		return false;
	}


	//-->  For creation of drop-down list 

	public function fetchActiveLocation() 
	{
		$data = $this->model_location->getActiveLocation();
		echo json_encode($data);

	}

	
	//--> Fetches the location value from the location table 
	//    This function is called from the datatable ajax function
	
	public function fetchLocationData()
	{
		$result = array('data' => array());

		$data = $this->model_location->getLocationData(); 

		foreach ($data as $key => $value) {

			$buttons = '';

			$location_name = $value['location_name'];

			if(in_array('updateLocation', $this->permission)) {
				$buttons .= '<button type="button" class="btn btn-default" onclick="editFunc('.$value['location_id'].')" data-toggle="modal" data-target="#editModal"><i class="fa fa-pencil"></i></button>';
				$location_name='  <a data-target="#editModal" onclick="editFunc('.$value['location_id'].')" data-toggle="modal" href="#editModal">'.$value['location_name'].'</a>';
			}

			if(in_array('deleteLocation', $this->permission)) {
				$buttons .= ' <button type="button" class="btn btn-default" onclick="removeFunc('.$value['location_id'].')" data-toggle="modal" data-target="#removeModal"><i class="fa fa-trash"></i></button>';
			}
				

			$active = ($value['active'] == 1) ? '<span class="label label-success">'.'Active'.'</span>' : '<span class="label label-warning">'.'Inactive'.'</span>';

			$result['data'][$key] = array(
				$location_name,
				$value['location_code'],
				$active,
				$buttons
			);
		} // /foreach

		echo json_encode($result);
	}

	
	//--> It checks the location form validation 
	//    and if the validation is true (valid) then it inserts the data into the database 
	//    and returns the json format operation messages
	
	public function create()
	{
		if(!in_array('createLocation', $this->permission)) {
			redirect('dashboard', 'refresh');
		}

		$response = array();

		$this->form_validation->set_rules('location_name', 'Name', 'trim|required');
		$this->form_validation->set_rules('location_code', 'Code', 'trim|required');
		$this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');

        if ($this->form_validation->run() == TRUE) {
        	$data = array(
        		'location_code' => $this->input->post('location_code'),
        		'location_name' => $this->input->post('location_name'),
        		'active' => $this->input->post('active'),	
        	);

        	$create = $this->model_location->create($data);
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

	
	//--> It checks the location form validation 
	//    and if the validation is true (valid) then it updates the data into the database 
	//    and returns the json format operation messages
	
	public function update($location_id)
	{

		if(!in_array('updateLocation', $this->permission)) {
			redirect('dashboard', 'refresh');
		}

		$response = '';
		$response = array();

		if($location_id) {
			$this->form_validation->set_rules('edit_location_name', $this->lang->line('Name'), 'trim|required');
			$this->form_validation->set_rules('edit_location_code', 'Code', 'trim|required');
			$this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');

	        if ($this->form_validation->run() == TRUE) {
	        	$data = array(
	        		'location_code' => $this->input->post('edit_location_code'),
	        		'location_name' => $this->input->post('edit_location_name'),
	        		'active' => $this->input->post('edit_active'),	
	        	);

	        	$update = $this->model_location->update($data, $location_id);
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

	
	//--> It removes the location information from the database 
	//    and returns the json format operation messages
	
	public function remove()
	{
		if(!in_array('deleteLocation', $this->permission)) {
			redirect('dashboard', 'refresh');}
		
		$location_id = $this->input->post('location_id');

        $response = '';
		$response = array();

		if($location_id) {
			//---> Validate if the information is used in another table
			$total_used = $this->model_location->checkIntegrity($location_id);
			//---> If no table has this information, we can delete
            if ($total_used == 0) {        
				$delete = $this->model_location->remove($location_id);
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