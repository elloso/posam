<?php 

class profile extends Admin_Controller 
{
	public function __construct()
	{
		parent::__construct();

		$this->not_logged_in();

		$this->data['page_title'] = 'Profile';
		
	}

	 
	//--> It redirects to the manage profile page
	//    As well as the profile data is also been passed to display on the view page
	
	public function index()
	{

		if(!in_array('viewProfile', $this->permission)) {
			redirect('dashboard', 'refresh');
		}

		$profile_data = $this->model_profile->getProfileData();
		$this->data['profile_data'] = $profile_data;

		$this->render_template('profile/index', $this->data);
	}	

	
	//--> If the validation is not true (not valid), then it redirects to the create page.
	//    If the validation for each input is true then it inserts the data into the database 
	//    and it sends the operation message into the session flashdata and display on the manage profile page
	
	public function create()
	{

		if(!in_array('createProfile', $this->permission)) {
			redirect('dashboard', 'refresh');
		}

		$this->form_validation->set_rules('profile_name', 'Name', 'required');
		$this->form_validation->set_error_delimiters('<p class="alert alert-warning">','</p>');

        if ($this->form_validation->run() == TRUE) {
            // true case
            $permission = serialize($this->input->post('permission'));
            
        	$data = array(
        		'profile_name' => $this->input->post('profile_name'),
        		'permission' => $permission
        	);

        	$create = $this->model_profile->create($data);

        	if($create == true) {
        		$msg_error = 'Successfully created'; 
        		$this->session->set_flashdata('success', $msg_error);
        		redirect('profile/', 'refresh');
        	}
        	else {
        		$msg_error = 'Error occurred'; 
                $this->session->set_flashdata('errors', $msg_error);
        		redirect('profile/create', 'refresh');
        	}
        }
        else {
            // false case
            $this->render_template('profile/create', $this->data);
        }	
	}

	
	//--> If the validation is not true (not valid), then it redirects to the edit profile page 
	//    If the validation is true (valid) then it updates the data into the database 
	//    and it sends the operation message into the session flashdata and display on the manage profile page
	
	public function edit($id = null)
	{

		if(!in_array('updateProfile', $this->permission)) {
			redirect('dashboard', 'refresh');
		}

		if($id) {

			$this->form_validation->set_rules('profile_name', 'Name', 'required');
			$this->form_validation->set_error_delimiters('<p class="alert alert-warning">','</p>');

			if ($this->form_validation->run() == TRUE) {
	            // true case
	            $permission = serialize($this->input->post('permission'));
	            
	        	$data = array(
	        		'profile_name' => $this->input->post('profile_name'),
	        		'permission' => $permission
	        	);

	        	$update = $this->model_profile->edit($data, $id);
	        	
	        	if($update == true) {
	        		$msg_error = 'Successfully updated'; 
        		    $this->session->set_flashdata('success', $msg_error);
	        		redirect('profile/', 'refresh');
	        	}
	        	else {
	        		$msg_error = 'Error occurred'; 
                    $this->session->set_flashdata('errors', $msg_error);
	        		redirect('profile/edit/'.$id, 'refresh');
	        	}
	        }
	        else {
	            // false case
	            $profile_data = $this->model_profile->getProfileData($id);
				$this->data['profile_data'] = $profile_data;
				$this->render_template('profile/edit', $this->data);	
	        }	
		}
	}

	
	//--> It removes the removes information from the database 
	//    and it sends the operation message into the session flashdata and display on the manage profile page
	
	public function delete($id)
	{

		if(!in_array('deleteProfile', $this->permission)) {
			redirect('dashboard', 'refresh');
		}

		if($id) {
			if($this->input->post('confirm')) {

				$check = $this->model_profile->existInUserProfile($id);
				if($check == true) {
					$msg_error = 'Profile exists in the user'; 
        	    	$this->session->set_flashdata('error', $msg_error);					
	        		redirect('profile/', 'refresh');
				}
				else {
					$delete = $this->model_profile->delete($id);
					if($delete == true) {
						$msg_error = 'Successfully deleted'; 
		        		$this->session->set_flashdata('success', $msg_error);
		        		redirect('profile/', 'refresh');
		        	}
		        	else {
		        		$msg_error = 'Error occurred'; 
                        $this->session->set_flashdata('error', $msg_error);
		        		redirect('profile/delete/'.$id, 'refresh');
		        	}
				}	
			}	
			else {
				$this->data['id'] = $id;
				$this->render_template('profile/delete', $this->data);
			}	
		}
	}


}