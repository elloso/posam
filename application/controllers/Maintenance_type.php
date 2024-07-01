<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Maintenance_type extends Admin_Controller 
{
	public function __construct()
	{
		parent::__construct();

		$this->not_logged_in();
		$this->data['page_title'] = 'Maintenance Type';
	}


	//-->  Redirects to the manage maintenance_type page

	public function index()
	{

		if(!in_array('viewMaintenanceType', $this->permission)) {
			redirect('dashboard', 'refresh');
		}

		$this->render_template('maintenance_type/index', $this->data);	
	}	


	//-->  For creation of drop-down list 

	public function fetchActiveMaintenanceType() 
	{
		$data = $this->model_maintenance_type->getActiveMaintenanceType();
		echo json_encode($data);

	}

	//--> It checks if it gets the maintenance_type id and retreives
	//    the maintenance_type information from the maintenance_type model and 
	//    returns the data into json format. 
	//    This function is invoked from the view page.

	public function fetchMaintenanceTypeDataById($maintenance_type_id) 
	{
		if($maintenance_type_id) {
			$data = $this->model_maintenance_type->getMaintenanceTypeData($maintenance_type_id);
			echo json_encode($data);
		}

		return false;
	}


	//-->  Fetches the maintenance_type value from the maintenance_type table 
	// this function is called from the datatable ajax function
	
	public function fetchMaintenanceTypeData()
	{
		$result = array('data' => array());

		$data = $this->model_maintenance_type->getMaintenanceTypeData(); 

		foreach ($data as $key => $value) {

			$buttons = '';

			$maintenance_type_name = $value['maintenance_type_name'];

			if(in_array('updateMaintenanceType', $this->permission)) {
				$buttons .= '<button type="button" class="btn btn-default" onclick="editFunc('.$value['maintenance_type_id'].')" data-toggle="modal" data-target="#editModal"><i class="fa fa-pencil"></i></button>';
				$maintenance_type_name='  <a data-target="#editModal" onclick="editFunc('.$value['maintenance_type_id'].')" data-toggle="modal" href="#editModal">'.$value['maintenance_type_name'].'</a>';
			}

			if(in_array('deleteMaintenanceType', $this->permission)) {
				$buttons .= ' <button type="button" class="btn btn-default" onclick="removeFunc('.$value['maintenance_type_id'].')" data-toggle="modal" data-target="#removeModal"><i class="fa fa-trash"></i></button>';
			}
				

			$active = ($value['active'] == 1) ? '<span class="label label-success">'.'Active'.'</span>' : '<span class="label label-warning">'.'Inactive'.'</span>';

			$result['data'][$key] = array(
				$maintenance_type_name,
				$value['maintenance_type_code'],
				$active,
				$buttons
			);
		} // /foreach

		echo json_encode($result);
	}


	//---> Checks the maintenance_type form validation 
	//     and if the validation is successfully then it inserts the data into the database 
	//     and returns the json format operation messages

	public function create()
	{
		if(!in_array('createMaintenanceType', $this->permission)) {
			redirect('dashboard', 'refresh');
		}

		$response = array();

		$this->form_validation->set_rules('maintenance_type_name', 'Name', 'trim|required');
		$this->form_validation->set_rules('maintenance_type_code', 'Code', 'trim|required');
		$this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');

        if ($this->form_validation->run() == TRUE) {
        	$data = array(
        		'maintenance_type_code' => $this->input->post('maintenance_type_code'),
        		'maintenance_type_name' => $this->input->post('maintenance_type_name'),
        		'active' => $this->input->post('active'),	
        	);

        	$create = $this->model_maintenance_type->create($data);
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


	//-->  Checks the maintenance_type form validation 
	//     and if the validation is successfully then it updates the data into the database 
	//     and returns the json format operation messages

	public function update($maintenance_type_id)
	{

		if(!in_array('updateMaintenanceType', $this->permission)) {
			redirect('dashboard', 'refresh');
		}

		$response = array();

		if($maintenance_type_id) {
			$this->form_validation->set_rules('edit_maintenance_type_name', 'Name', 'trim|required');
			$this->form_validation->set_rules('edit_maintenance_type_code', 'Code', 'trim|required');
			$this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');

	        if ($this->form_validation->run() == TRUE) {
	        	$data = array(
	        		'maintenance_type_code' => $this->input->post('edit_maintenance_type_code'),
	        		'maintenance_type_name' => $this->input->post('edit_maintenance_type_name'),
	        		'active' => $this->input->post('edit_active'),	
	        	);

	        	$update = $this->model_maintenance_type->update($data, $maintenance_type_id);
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


	//-->  Removes the maintenance_type information from the database 
	//     and returns the json format operation messages

	public function remove()
	{
		if(!in_array('deleteMaintenanceType', $this->permission)) {
			redirect('dashboard', 'refresh');
		}
		
		$maintenance_type_id = $this->input->post('maintenance_type_id');

		$response = '';
		$response = array();

		if($maintenance_type_id) {
			//---> Validate if the information is used in other table
			$total_used = $this->model_maintenance_type->checkIntegrity($maintenance_type_id);
			//---> If not used, we can delete
            if ($total_used == 0) {        
				$delete = $this->model_maintenance_type->remove($maintenance_type_id);
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