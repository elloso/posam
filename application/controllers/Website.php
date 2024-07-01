<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Website extends Admin_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->data['page_title'] = $this->lang->line('Website');
	}



	public function index($offset = 0){
       
        $this->load->view('website/index', $this->data);

        }


    public function about() {

        $this->load->view('website/about', $this->data);
    }   

   

    public function contact() {

        $this->load->view('website/contact', $this->data);
    }


}

