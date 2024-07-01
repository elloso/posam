<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Organization extends Admin_Controller 
{
	public function __construct()
	{
		parent::__construct();

		$this->not_logged_in();

		$this->data['page_title'] = 'Organization';

		$this->load->model('model_organization');
	}

    /* 
    * It redirects to the organization page and displays all the organization information
    * It also updates the organization information into the database if the 
    * validation for each input field is successfully valid
    */
	public function index()
	{  
        if(!in_array('updateOrganization', $this->permission)) {
            redirect('dashboard', 'refresh');
        }
        
		$this->form_validation->set_rules('organization_name', 'Organization name', 'trim|required');
		$this->form_validation->set_rules('address', 'Address', 'trim|required');
		$this->form_validation->set_rules('message', 'Message', 'trim|required');
	
	
        if ($this->form_validation->run() == TRUE) {
            // true case

        	$data = array(
        		'organization_name' => $this->input->post('organization_name'),
        		'address' => $this->input->post('address'),
        		'phone' => $this->input->post('phone'),
        		'country' => $this->input->post('country'),
        		'logo_visible' => $this->input->post('logo_visible'),	
        		'message' => $this->input->post('message'),
                'currency' => $this->input->post('currency')
        	);



        	$update = $this->model_organization->update($data, 1);
        	if($update == true) {
        		//$this->session->set_flashdata('success', 'Successfully updated');
        		redirect('organization/', 'refresh');
        	}
        	else {
        		$this->session->set_flashdata('errors', 'Error occurred!!');
        		redirect('organization/index', 'refresh');
        	}
        }
        else {

            // false case
            
            
            $this->data['currency_symbols'] = $this->currency();
        	$this->data['organization_data'] = $this->model_organization->getOrganizationData(1);
			$this->render_template('organization/index', $this->data);			
        }	

		
	}

}