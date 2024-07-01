<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Maintenance extends Admin_Controller 
{
	public function __construct()
	{
		parent::__construct();

		$this->not_logged_in();

		$this->data['page_title'] = 'Maintenance';

	}


	public function index()
	{
		if(!in_array('viewMaintenance', $this->permission)) {
			redirect('dashboard', 'refresh');
		}

		$this->render_template('maintenance/index', $this->data);	
	}


	//--> It retrieve the specific maintenance information via a maintenance id
	//    and returns the data in json format

	public function fetchMaintenanceDataById($id) 
	{
		if($id) {
			$data = $this->model_maintenance->getMaintenanceData($id);
			echo json_encode($data);
		}
	}


	//--> It Fetches the maintenance data from the maintenance table 

    public function fetchMaintenanceAsset($id)
    {
        $result = array('data' => array());

        $data = $this->model_maintenance->getMaintenanceAsset($id);   

        foreach ($data as $key => $value) {

        	$maintenance_type_data = $this->model_maintenance_type->getMaintenanceTypeData($value['maintenance_type_fk']);  
        	$maintenance_name = $value['maintenance_name'];

            $buttons = '';

            if(in_array('updateMaintenance', $this->permission)) {
               $buttons .= '<button type="button" class="btn btn-default" onclick="editMaintenance('.$value['maintenance_id'].')" data-toggle="modal" data-target="#editModalMaintenance"><i class="fa fa-pencil"></i></button>';
               $maintenance_name='  <a data-target="#editModalMaintenance" onclick="editMaintenance('.$value['maintenance_id'].')" data-toggle="modal" href="#editModalMaintenance">'.$value['maintenance_name'].'</a>';
			}	

   
            if(in_array('deleteMaintenance', $this->permission)) { 
                $buttons .= ' <button type="button" class="btn btn-default" onclick="removeMaintenance('.$value['maintenance_id'].')" data-toggle="modal" data-target="#removeModalMaintenance"><i class="fa fa-trash"></i></button>';
            }
  
            $result['data'][$key] = array(              
                $maintenance_name,       
				$value['maintenance_date'],
				$value['cost'],
				$maintenance_type_data['maintenance_type_name'],                
                $buttons
            );

        } // /foreach

        echo json_encode($result);
    }

	

	//--> If the validation is not true (not valid), then it provides the validation error on the json format
    //    If the validation for each input is valid then it inserts the data into the database and 
    //    returns the appropriate message in the json format.

	public function create()
	{
		if(!in_array('createMaintenance', $this->permission)) {redirect('dashboard', 'refresh');}

		$response = array();

		$this->form_validation->set_rules('maintenance_name', 'Name', 'trim|required');
		$this->form_validation->set_rules('maintenance_type', 'Maintenance Type', 'trim|required');
		$this->form_validation->set_rules('cost', 'Cost', 'trim|required');		
		$this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');

        if ($this->form_validation->run() == TRUE) {
        	$data = array(
        		'asset_fk' => $this->session->asset_id, 
        		'maintenance_type_fk' => $this->input->post('maintenance_type'),				       		
        		'maintenance_name' => $this->input->post('maintenance_name'),        		
        		'maintenance_date' => (($this->input->post('maintenance_date') != FALSE) ? $this->input->post('maintenance_date') : NULL), 
        		'cost' => $this->input->post('cost'),   
				'description' => (($this->input->post('description_maintenance') != FALSE) ? $this->input->post('description_maintenance') : NULL), 
				'remark' => (($this->input->post('remark_maintenance') != FALSE) ? $this->input->post('remark_maintenance') : NULL), 
				'updated_by' => $this->session->userdata('user_id'),
        	);

        	$create = $this->model_maintenance->create($data);

        	if($create == true) 
        		{$response['success'] = true;
        		$response['messages'] = 'Successfully created';}
        	else 
        		{$response['success'] = false;
        		$response['messages'] = 'Error in the database while creating the information';}			
        	
        }
        else {
        	$response['success'] = false;
        	foreach ($_POST as $key => $value) {
        		$response['messages'][$key] = form_error($key);
        	}
        }

        echo json_encode($response);
	}
              

	//--> If the validation is not true (not valid), then it provides the validation error on the json format
    //    If the validation for each input is valid then it updates the data into the database and 
    //    returns an appropriate message in the json format.

	public function update($maintenance_id)
	{
		if(!in_array('updateMaintenance', $this->permission)) {redirect('dashboard', 'refresh');}

		$response = array();

		if($maintenance_id) {

			$this->form_validation->set_rules('edit_maintenance_name', 'Name', 'trim|required');
			$this->form_validation->set_rules('edit_maintenance_type', 'Maintenance Type', 'trim|required');
			$this->form_validation->set_rules('edit_cost', 'Cost', 'trim|required');
			$this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');

	        if ($this->form_validation->run() == TRUE) {
	        	
				$data = array(
	        		'maintenance_type_fk' => $this->input->post('edit_maintenance_type'),
	        		'maintenance_name' => $this->input->post('edit_maintenance_name'),
	        		'maintenance_date' => (($this->input->post('edit_maintenance_date') != FALSE) ? $this->input->post('edit_maintenance_date') : NULL), 
	        		'cost' => $this->input->post('edit_cost'),
					'description' => (($this->input->post('edit_description_maintenance') != FALSE) ? $this->input->post('edit_description_maintenance') : NULL), 
					'remark' => (($this->input->post('edit_remark_maintenance') != FALSE) ? $this->input->post('edit_remark_maintenance') : NULL), 	
					'updated_by' => $this->session->userdata('user_id'),					
				);

		        $update = $this->model_maintenance->update($data, $maintenance_id);	
	        	
	        	if($update == true) 
	        		{$response['success'] = true;
	        		$response['messages'] = 'Successfully updated';}
	        	else 
	        		{$response['success'] = false;
	        		$response['messages'] = 'Error in the database while updating the information';}			
	        	}  //end form validation is true
	        else   //form validation is false
	        	{$response['successa'] = false;
	        	foreach ($_POST as $key => $value) {$response['messages'][$key] = form_error($key);}
	            }
		}  //else no id
		else {
			$response['successb'] = false;
    		$response['messages'] = 'Error please refresh the page again';
		}

		echo json_encode($response);
	}




	public function remove()
	{
		if(!in_array('deleteMaintenance', $this->permission)) {
			redirect('dashboard', 'refresh');
		}
		
		$maintenance_id = $this->input->post('maintenance_id');

		$response = '';
		$response = array();
		
		if($maintenance_id) {			
			$delete = $this->model_maintenance->remove($maintenance_id);
			if($delete == true) {
				$response['success'] = true;
				$response['messages'] = 'Successfully deleted';}
			else {
				$response['success'] = false;
				$response['messages'] = 'Error in the database while deleting the information';
			}
		}
		else {
			$response['success'] = false;
			$response['messages'] = 'Refresh the page again';
		}

		echo json_encode($response);
	}


}