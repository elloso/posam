<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Area extends Admin_Controller 
{
	public function __construct()
	{
		parent::__construct();

		$this->not_logged_in();

		$this->data['page_title'] = 'Area';

	}


	//--> Redirects to the manage area page

	public function index()
	{

		if(!in_array('viewArea', $this->permission)) {redirect('dashboard', 'refresh');}

		$this->render_template('area/index', $this->data);	
	}	

	
	//--> It checks if it gets the area id and retrieves
	//    the area information from the area model and 
	//    returns the data into json format. 
	//    This function is invoked from the view page.
	
	public function fetchAreaDataById($area_id) 
	{
		if($area_id) {
			$data = $this->model_area->getAreaData($area_id);
			echo json_encode($data);
		}

		return false;
	}

	
	//--> Fetches the area value from the area table 
	//    This function is called from the datatable ajax function
	
	public function fetchAreaData()
	{
		$result = array('data' => array());

		$data = $this->model_area->getAreaData(); 

		foreach ($data as $key => $value) {

			$buttons = '';
			$area_name = $value['area_name'];

			if(in_array('updateArea', $this->permission)) {
				$buttons .= '<button type="button" class="btn btn-default" onclick="editFunc('.$value['area_id'].')" data-toggle="modal" data-target="#editModal"><i class="fa fa-pencil"></i></button>';
				$area_name='  <a data-target="#editModal" onclick="editFunc('.$value['area_id'].')" data-toggle="modal" href="#editModal">'.$value['area_name'].'</a>';
			}

			if(in_array('deleteArea', $this->permission)) {
				$buttons .= ' <button type="button" class="btn btn-default" onclick="removeFunc('.$value['area_id'].')" data-toggle="modal" data-target="#removeModal"><i class="fa fa-trash"></i></button>';
			}
				

			$active = ($value['active'] == 1) ? '<span class="label label-success">'.'Active'.'</span>' : '<span class="label label-warning">'.'Inactive'.'</span>';

			$result['data'][$key] = array(
				$area_name,
				$active,
				$buttons
			);
		} // /foreach

		echo json_encode($result);
	}

	
	//--> It checks the area form validation 
	//    and if the validation is true (valid) then it inserts the data into the database 
	//    and returns the json format operation messages
	
	public function create()
	{
		if(!in_array('createArea', $this->permission)) {
			redirect('dashboard', 'refresh');
		}

		$response = array();

		$this->form_validation->set_rules('area_name', 'Name', 'trim|required');
		$this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');

        if ($this->form_validation->run() == TRUE) {
        	$data = array(
        		'area_name' => $this->input->post('area_name'),
        		'active' => $this->input->post('active'),	
        	);

        	$create = $this->model_area->create($data);
        	if($create == true) {
        		$response['success'] = true;
        		$response['messages'] ='Successfully created';
        	}
        	else {
        		$response['error'] = false;
        		$response['messages'] = 'Error in the database while creating the information';			
        	}
        }
        else {
        	$response['error'] = false;
        	foreach ($_POST as $key => $value) {
        		$response['messages'][$key] = form_error($key);
        	}
        }

        echo json_encode($response);
	}

	
	//--> It checks the area form validation 
	//    and if the validation is true (valid) then it updates the data into the database 
	//    and returns the json format operation messages
	
	public function update($area_id)
	{

		if(!in_array('updateArea', $this->permission)) {
			redirect('dashboard', 'refresh');
		}

		$response = '';
		$response = array();

		if($area_id) {
			$this->form_validation->set_rules('edit_area_name', 'Name', 'trim|required');
			$this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');

	        if ($this->form_validation->run() == TRUE) {
	        	$data = array(
	        		'area_name' => $this->input->post('edit_area_name'),
	        		'active' => $this->input->post('edit_active'),	
	        	);

	        	$update = $this->model_area->update($data, $area_id);
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

	
	//--> It removes the area information from the database 
	//    and returns the json format operation messages
	
	public function remove()
	{
		if(!in_array('deleteArea', $this->permission)) {
			redirect('dashboard', 'refresh');}
		
		$area_id = $this->input->post('area_id');

        $response = '';
		$response = array();

		if($area_id) {
			//---> Validate if the information is used in another table
			$total_used = $this->model_area->checkIntegrity($area_id);
			//---> If no table has this information, we can delete
            if ($total_used == 0) {        
				$delete = $this->model_area->remove($area_id);
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