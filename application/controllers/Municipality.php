<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Municipality extends Admin_Controller 
{
	public function __construct()
	{
		parent::__construct();

		$this->not_logged_in();

		$this->data['page_title'] = 'Municipality';

	}


	//--> Redirects to the manage municipality page

	public function index()
	{

		if(!in_array('viewMunicipality', $this->permission)) {
			redirect('dashboard', 'refresh');
		}

		$this->render_template('municipality/index', $this->data);	
	}	

	
	//--> It checks if it gets the municipality id and retrieves
	//    the municipality information from the municipality model and 
	//    returns the data into json format. 
	//    This function is invoked from the view page.
	
	public function fetchMunicipalityDataById($municipality_id) 
	{
		if($municipality_id) {
			$data = $this->model_municipality->getMunicipalityData($municipality_id);
			echo json_encode($data);
		}

		return false;
	}

	
	//--> Fetches the municipality value from the municipality table 
	//    This function is called from the datatable ajax function
	
	public function fetchMunicipalityData()
	{
		$result = array('data' => array());

		$data = $this->model_municipality->getMunicipalityData(); 

		foreach ($data as $key => $value) {

			$buttons = '';
			$municipality_name = $value['municipality_name'];

			if(in_array('updateMunicipality', $this->permission)) {
				$buttons .= '<button type="button" class="btn btn-default" onclick="editFunc('.$value['municipality_id'].')" data-toggle="modal" data-target="#editModal"><i class="fa fa-pencil"></i></button>';
				$municipality_name='  <a data-target="#editModal" onclick="editFunc('.$value['municipality_id'].')" data-toggle="modal" href="#editModal">'.$value['municipality_name'].'</a>';
			}

			if(in_array('deleteMunicipality', $this->permission)) {
				$buttons .= ' <button type="button" class="btn btn-default" onclick="removeFunc('.$value['municipality_id'].')" data-toggle="modal" data-target="#removeModal"><i class="fa fa-trash"></i></button>';
			}
				

			$active = ($value['active'] == 1) ? '<span class="label label-success">'.'Active'.'</span>' : '<span class="label label-warning">'.'Inactive'.'</span>';

			$result['data'][$key] = array(
				$municipality_name,
				$active,
				$buttons
			);
		} // /foreach

		echo json_encode($result);
	}

	
	//--> It checks the municipality form validation 
	//    and if the validation is true (valid) then it inserts the data into the database 
	//    and returns the json format operation messages
	
	public function create()
	{
		if(!in_array('createMunicipality', $this->permission)) {
			redirect('dashboard', 'refresh');
		}

		$response = array();

		$this->form_validation->set_rules('municipality_name', 'Name', 'trim|required');
		$this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');

        if ($this->form_validation->run() == TRUE) {
        	$data = array(
        		'municipality_name' => $this->input->post('municipality_name'),
        		'active' => $this->input->post('active'),	
        	);

        	$create = $this->model_municipality->create($data);
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

	
	//--> It checks the municipality form validation 
	//    and if the validation is true (valid) then it updates the data into the database 
	//    and returns the json format operation messages
	
	public function update($municipality_id)
	{

		if(!in_array('updateMunicipality', $this->permission)) {
			redirect('dashboard', 'refresh');
		}

		$response = '';
		$response = array();

		if($municipality_id) {
			$this->form_validation->set_rules('edit_municipality_name', 'Name', 'trim|required');
			$this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');

	        if ($this->form_validation->run() == TRUE) {
	        	$data = array(
	        		'municipality_name' => $this->input->post('edit_municipality_name'),
	        		'active' => $this->input->post('edit_active'),	
	        	);

	        	$update = $this->model_municipality->update($data, $municipality_id);
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

	
	//--> It removes the municipality information from the database 
	//    and returns the json format operation messages
	
	public function remove()
	{
		if(!in_array('deleteMunicipality', $this->permission)) {
			redirect('dashboard', 'refresh');}
		
		$municipality_id = $this->input->post('municipality_id');

        $response = '';
		$response = array();

		if($municipality_id) {
			//---> Validate if the information is used in another table
			$total_used = $this->model_municipality->checkIntegrity($municipality_id);
			//---> If no table has this information, we can delete
            if ($total_used == 0) {        
				$delete = $this->model_municipality->remove($municipality_id);
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