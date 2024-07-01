<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class User extends Admin_Controller 
{
	public function __construct()
	{
		parent::__construct();

		$this->not_logged_in();

		$this->data['page_title'] = 'User';
        
	}

	public function index()
	{
        if(!in_array('viewUser', $this->permission)) {redirect('dashboard', 'refresh');}

		$this->render_template('user/index', $this->data);	
	}



    public function fetchUserDataById($user_id) 
    {
        if($user_id) {
            $data = $this->model_user->getUserData($user_id);
            echo json_encode($data);
        }

        return false;
    }


	public function fetchUserData()
	{
		$result = array('data' => array());

		$data = $this->model_user->getUserData();

		foreach ($data as $key => $value) {

			$profile_data = $this->model_profile->getProfileData($value['profile_fk']);

			$buttons = '';

			if(in_array('updateUser', $this->permission)) {
                $buttons .= '<a href="'.base_url('user/update/'.$value['user_id']).'" class="btn btn-default"><i class="fa fa-pencil"></i></a>';
            }

            
            if(in_array('deleteUser', $this->permission)) {                
     
                    $buttons .= ' <button type="button" class="btn btn-default" onclick="removeFunc('.$value['user_id'].')" data-toggle="modal" data-target="#removeModal"><i class="fa fa-trash"></i></button>';
            }

            // It's not possible to delete or update the superadamin - password is Catalyste2024
            if ($value['username'] == 'superadmin') {$buttons = '';}

			$result['data'][$key] = array(			
				$value['username'],
				$value['email'],
				$value['user_name'],
				$value['phone'],
				$profile_data['profile_name'],
				$buttons
			);
		} // /foreach

		echo json_encode($result);
	}	


	public function create()
	{
		if(!in_array('createUser', $this->permission)) {redirect('dashboard', 'refresh');}

		$this->form_validation->set_rules('username', 'Username', 'trim|required|min_length[5]|max_length[12]|is_unique[user.username]');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|is_unique[user.email]');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[6]');
        $this->form_validation->set_rules('cpassword', 'Confirm Password', 'trim|required|matches[password]');
        $this->form_validation->set_rules('user_name', 'Name', 'trim|required');
        $this->form_validation->set_error_delimiters('<p class="alert alert-warning">','</p>');


        if ($this->form_validation->run() == TRUE) {    
            
            $user_id = $this->model_user->create();
            
            if($user_id) {
                $this->session->set_flashdata('success', 'Successfully created');
                redirect('user/', 'refresh');
            }
            else {
                $this->session->set_flashdata('errors', 'Error occurred!!');
                redirect('user/', 'refresh');
            }

        }
        else {
            // false case        	       	
			$this->data['profile'] = $this->model_profile->getProfileData();    	

            $this->render_template('user/create', $this->data);
        }	
	}

    

	public function update($user_id)
	{      
        if(!in_array('updateUser', $this->permission)) {redirect('dashboard', 'refresh');}

        if(!$user_id) {redirect('dashboard', 'refresh');}

        if(!empty($this->input->post('password'))) {
          $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[6]');    
          $this->form_validation->set_rules('cpassword', 'Confirm Password', 'trim|required|matches[password]');}

        $this->form_validation->set_rules('username','Username', 'trim|required|min_length[5]|max_length[12]');
        $this->form_validation->set_rules('email', 'Email', 'trim|required');
        $this->form_validation->set_rules('user_name', 'Name', 'trim|required');         

        $this->form_validation->set_error_delimiters('<p class="alert alert-warning">','</p>');

        if ($this->form_validation->run() == TRUE) {
            $password = $this->model_user->password_hash($this->input->post('password'));

            $data = array(
                'active' => $this->input->post('active'),               
                'username' => (($this->input->post('username') != FALSE) ? $this->input->post('username') : NULL), 
                'email' => (($this->input->post('email') != FALSE) ? $this->input->post('email') : NULL),           
                'phone' => $this->input->post('phone'),
                'user_name' => $this->input->post('user_name'),
                'remark' => (($this->input->post('remark') != FALSE) ? $this->input->post('remark') : NULL),  
                'password' => $password,
                'profile_fk' => (($this->input->post('profile') != FALSE) ? $this->input->post('profile') : NULL),   
                'updated_by' => $this->session->userdata('user_id'),
            );
            $update = $this->model_user->update($user_id, $data);
            
            if($update == true) {
                $this->session->set_flashdata('success', 'Successfully updated');
                redirect('user/', 'refresh');
            }
            else {
                $this->session->set_flashdata('errors', 'Error occurred!!');
                redirect('user/', 'refresh');
            }
        }
        else {
            
     
            $this->data['profile'] = $this->model_profile->getProfileData();   

            $result = array();
            $user_data = $this->model_user->getUserData($user_id);
            
            $this->data['user_data'] = $user_data;
            $this->render_template('user/edit', $this->data); 

        }   
	}


	public function remove()
	{
        if(!in_array('deleteUser', $this->permission)) {redirect('dashboard', 'refresh');}
        
        $user_id = $this->input->post('user_id');

        $response = array();

        if($user_id) {
            $delete = $this->model_user->remove($user_id);
            if($delete == true) {
                $response['success'] = true;
                $response['messages'] = "Successfully removed"; 
            }
            else {
                $response['success'] = false;
                $response['messages'] = "Error in the database while removing the user information";
            }
        }
        else {
            $response['success'] = false;
            $response['messages'] = "Refresh the page again!!";
        }

        echo json_encode($response);
	}



//------------------------------------ My account ----------------------------------------------------->


   //--> If the validation is not true (not valid), then it provides the validation error on the json format
   //    If the validation for each input is valid then it updates the data into the database and 
   //    returns an appropriate message in the json format.

    public function my_account()
    {
    if(!in_array('viewUser', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $user_id = $this->session->user_id;

        if($user_id) {
            $this->form_validation->set_rules('username', 'Username', 'trim|required|min_length[5]|max_length[12]');
            $this->form_validation->set_rules('email', 'Email', 'trim|required');
            $this->form_validation->set_rules('user_name', 'Name', 'trim|required');
            $this->form_validation->set_error_delimiters('<p class="alert alert-warning">','</p>');

            if ($this->form_validation->run() == TRUE) {
                // true case
                if(empty($this->input->post('password')) && empty($this->input->post('cpassword'))) {
                    $data = array(
                        'username' => $this->input->post('username'),
                        'email' => $this->input->post('email'),
                        'user_name' => $this->input->post('user_name'),
                        'phone' => $this->input->post('phone'),
                        'active' => $this->input->post('active'),
                    );

                    $update = $this->model_user->update($user_id, $data);
                    if($update == true) {
                        $msg_error = 'Successfully updated'; 
                        $this->session->set_flashdata('success', $msg_error);
                        redirect('user/my_account', 'refresh');
                    }
                    else {
                        $msg_error = 'Error occurred'; 
                        $this->session->set_flashdata('error', $msg_error);
                        redirect('user/my_account', 'refresh');
                    }
                }
                else {
                    $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[6]');
                    $this->form_validation->set_rules('cpassword', 'Confirm Password', 'trim|required|matches[password]');

                    if($this->form_validation->run() == TRUE) {

                        $password = $this->model_user->password_hash($this->input->post('password'));

                        $data = array(
                            'username' => $this->input->post('username'),
                            'password' => $password,
                            'email' => $this->input->post('email'),
                            'user_name' => $this->input->post('user_name'),
                            'phone' => $this->input->post('phone'),
                            'active' => $this->input->post('active'),
                        );

                        $update = $this->model_user->update($user_id, $data);
                        if($update == true) {
                            $msg_error = 'Successfully updated'; 
                            $this->session->set_flashdata('success', $msg_error);
                            redirect('user/my_account', 'refresh');
                        }
                        else {
                            $msg_error = 'Error occurred'; 
                            $this->session->set_flashdata('error', $msg_error);
                            redirect('user/my_account', 'refresh');
                        }
                    }
                    else {
                        // false case
                        $account_data = $this->model_user->getUserData($user_id);
                        $profile = $this->model_user->getUserProfile($user_id);

                        $this->data['account_data'] = $account_data;
                        $this->data['account_profile'] = $profile;

                        $profile_data = $this->model_profile->getProfileData();
                        $this->data['profile_data'] = $profile_data;

                        $this->render_template('user/my_account', $this->data); 
                    }   

                }
            }
            else {
                // false case
                $account_data = $this->model_user->getUserData($user_id);
                $profile = $this->model_user->getUserProfile($user_id);

                $this->data['account_data'] = $account_data;
                $this->data['account_profile'] = $profile;

                $profile_data = $this->model_profile->getProfileData();
                $this->data['profile_data'] = $profile_data;

                $this->render_template('user/my_account', $this->data); 
            }       
    }
}

 

}