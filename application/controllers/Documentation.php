<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Documentation extends Admin_Controller  {

	public function __construct()
	{
		parent::__construct();
		$this->data['page_title'] = 'Documentation';
	}


	public function user_guide()
	{
		$this->render_template('documentation/user_guide',$this->data);
	}


	public function presentation()
	{
		$this->render_template('documentation/presentation',$this->data);
	}


	public function training()
	{
		$this->render_template('documentation/training',$this->data);
	}


	public function db_schema()
	{
		$this->render_template('documentation/db_schema',$this->data);
	}
}


