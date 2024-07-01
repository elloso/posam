<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Category extends Admin_Controller 
{
	public function __construct()
	{
		parent::__construct();

		$this->not_logged_in();

		$this->data['page_title'] = 'Category';

	}


	//--> Redirects to the manage category page

	public function index()
	{

		if(!in_array('viewCategory', $this->permission)) {
			redirect('dashboard', 'refresh');
		}

		$this->render_template('category/index', $this->data);	
	}	

	
	//--> It checks if it gets the category id and retrieves
	//    the category information from the category model and 
	//    returns the data into json format. 
	//    This function is invoked from the view page.
	
	public function fetchCategoryDataById($category_id) 
	{
		if($category_id) {
			$data = $this->model_category->getCategoryData($category_id);
			echo json_encode($data);
		}

		return false;
	}

	
	//--> Fetches the category value from the category table 
	//    This function is called from the datatable ajax function
	
	public function fetchCategoryData()
	{
		$result = array('data' => array());

		$data = $this->model_category->getCategoryData(); 

		foreach ($data as $key => $value) {

			$buttons = '';
			$category_name = $value['category_name'];

			if(in_array('updateCategory', $this->permission)) {
				$buttons .= '<button type="button" class="btn btn-default" onclick="editFunc('.$value['category_id'].')" data-toggle="modal" data-target="#editModal"><i class="fa fa-pencil"></i></button>';
				$category_name='  <a data-target="#editModal" onclick="editFunc('.$value['category_id'].')" data-toggle="modal" href="#editModal">'.$value['category_name'].'</a>';
			}

			if(in_array('deleteCategory', $this->permission)) {
				$buttons .= ' <button type="button" class="btn btn-default" onclick="removeFunc('.$value['category_id'].')" data-toggle="modal" data-target="#removeModal"><i class="fa fa-trash"></i></button>';
			}
				

			$active = ($value['active'] == 1) ? '<span class="label label-success">'.'Active'.'</span>' : '<span class="label label-warning">'.'Inactive'.'</span>';


			$result['data'][$key] = array(
				$category_name,
				$active,
				$buttons
			);
		} // /foreach

		echo json_encode($result);
	}

	
	//--> It checks the category form validation 
	//    and if the validation is true (valid) then it inserts the data into the database 
	//    and returns the json format operation messages
	
	public function create()
	{
		if(!in_array('createCategory', $this->permission)) {
			redirect('dashboard', 'refresh');
		}

		$response = array();

		$this->form_validation->set_rules('category_name', 'Name', 'trim|required');
		$this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');

        if ($this->form_validation->run() == TRUE) {
        	$data = array(
        		'category_name' => $this->input->post('category_name'),
        		'active' => $this->input->post('active'),	
        	);

        	$create = $this->model_category->create($data);
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

	
	//--> It checks the category form validation 
	//    and if the validation is true (valid) then it updates the data into the database 
	//    and returns the json format operation messages
	
	public function update($category_id)
	{

		if(!in_array('updateCategory', $this->permission)) {
			redirect('dashboard', 'refresh');
		}

		$response = '';
		$response = array();

		if($category_id) {
			$this->form_validation->set_rules('edit_category_name', 'Name', 'trim|required');
			$this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');

	        if ($this->form_validation->run() == TRUE) {
	        	$data = array(
	        		'category_name' => $this->input->post('edit_category_name'),
	        		'active' => $this->input->post('edit_active'),	
	        	);

	        	$update = $this->model_category->update($data, $category_id);
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

	
	//--> It removes the category information from the database 
	//    and returns the json format operation messages
	
	public function remove()
	{
		if(!in_array('deleteCategory', $this->permission)) {
			redirect('dashboard', 'refresh');}
		
		$category_id = $this->input->post('category_id');

        $response = '';
		$response = array();

		if($category_id) {
			//---> Validate if the information is used in another table
			$total_used = $this->model_category->checkIntegrity($category_id);
			//---> If no table has this information, we can delete
            if ($total_used == 0) {        
				$delete = $this->model_category->remove($category_id);
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