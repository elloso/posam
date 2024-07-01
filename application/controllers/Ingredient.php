<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Ingredient extends Admin_Controller 
{
	public function __construct()
	{
		parent::__construct();

		$this->not_logged_in();

		$this->data['page_title'] = 'Ingredient';

	}


	//--> Redirects to the manage ingredient page

	public function index()
	{

		if(!in_array('viewIngredient', $this->permission)) {
			redirect('dashboard', 'refresh');
		}

		$this->render_template('ingredient/index', $this->data);	
	}	


	//-->  For creation of drop-down list 

	public function fetchActiveIngredient() 
	{
		$data = $this->model_ingredient->getActiveIngredient();
		echo json_encode($data);

	}

	
	//--> It checks if it gets the ingredient id and retrieves
	//    the ingredient information from the ingredient model and 
	//    returns the data into json format. 
	//    This function is invoked from the view page.
	
	public function fetchIngredientDataById($ingredient_id) 
	{
		if($ingredient_id) {
			$data = $this->model_ingredient->getIngredientData($ingredient_id);
			echo json_encode($data);
		}

		return false;
	}

	
	//--> Fetches the ingredient value from the ingredient table 
	//    This function is called from the datatable ajax function
	
	public function fetchIngredientData()
	{
		$result = array('data' => array());

		$data = $this->model_ingredient->getIngredientData(); 

		foreach ($data as $key => $value) {

			$buttons = '';

			$ingredient_name = $value['ingredient_name'];

			if(in_array('updateIngredient', $this->permission)) {
				$buttons .= '<button type="button" class="btn btn-default" onclick="editFunc('.$value['ingredient_id'].')" data-toggle="modal" data-target="#editModal"><i class="fa fa-pencil"></i></button>';
				$ingredient_name='  <a data-target="#editModal" onclick="editFunc('.$value['ingredient_id'].')" data-toggle="modal" href="#editModal">'.$value['ingredient_name'].'</a>';
			}

			if(in_array('deleteIngredient', $this->permission)) {
				$buttons .= ' <button type="button" class="btn btn-default" onclick="removeFunc('.$value['ingredient_id'].')" data-toggle="modal" data-target="#removeModal"><i class="fa fa-trash"></i></button>';
			}
				

			$active = ($value['active'] == 1) ? '<span class="label label-success">'.'Active'.'</span>' : '<span class="label label-warning">'.'Inactive'.'</span>';

			$result['data'][$key] = array(
				$ingredient_name,				
				$value['formula'],
				$value['formula_unit'],
				$active,
				$buttons
			);
		} // /foreach

		echo json_encode($result);
	}

	
	//--> It checks the ingredient form validation 
	//    and if the validation is true (valid) then it inserts the data into the database 
	//    and returns the json format operation messages
	
	public function create()
	{
		if(!in_array('createIngredient', $this->permission)) {
			redirect('dashboard', 'refresh');
		}

		$response = array();

		$this->form_validation->set_rules('ingredient_name', 'Name', 'trim|required');
		$this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');

        if ($this->form_validation->run() == TRUE) {
        	$data = array(
        		'ingredient_name' => $this->input->post('ingredient_name'),
        		'formula' => $this->input->post('formula'),
        		'formula_unit' => $this->input->post('formula_unit'),
        		'active' => $this->input->post('active'),	
        	);

        	$create = $this->model_ingredient->create($data);
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

	
	//--> It checks the ingredient form validation 
	//    and if the validation is true (valid) then it updates the data into the database 
	//    and returns the json format operation messages
	
	public function update($ingredient_id)
	{

		if(!in_array('updateIngredient', $this->permission)) {
			redirect('dashboard', 'refresh');
		}

		$response = '';
		$response = array();

		if($ingredient_id) {
			$this->form_validation->set_rules('edit_ingredient_name', $this->lang->line('Name'), 'trim|required');
			$this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');

	        if ($this->form_validation->run() == TRUE) {
	        	$data = array(
	        		'ingredient_name' => $this->input->post('edit_ingredient_name'),
	        		'formula' => $this->input->post('edit_formula'),
	        		'formula_unit' => $this->input->post('edit_formula_unit'),
	        		'active' => $this->input->post('edit_active'),	
	        	);

	        	$update = $this->model_ingredient->update($data, $ingredient_id);
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

	
	//--> It removes the ingredient information from the database 
	//    and returns the json format operation messages
	
	public function remove()
	{
		if(!in_array('deleteIngredient', $this->permission)) {
			redirect('dashboard', 'refresh');}
		
		$ingredient_id = $this->input->post('ingredient_id');

        $response = '';
		$response = array();

		if($ingredient_id) {
			//---> Validate if the information is used in another table
			$total_used = $this->model_ingredient->checkIntegrity($ingredient_id);
			//---> If no table has this information, we can delete
            if ($total_used == 0) {        
				$delete = $this->model_ingredient->remove($ingredient_id);
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