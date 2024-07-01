<?php 

class Dashboard extends Admin_Controller 
{
	public function __construct()
	{
		parent::__construct();

		$this->not_logged_in();

		$this->data['page_title'] = 'Dashboard';
		
	}

	 

	public function index()
	{

		 if($this->input->post('order_date')) 
		 	{$order_date = $this->input->post('order_date');} 
		 else { $order_date = date("Y-m-d");}

		//---> Keep the date selected in a session variable 
		
		$this->session->unset_userdata('order_date'); 

        if(empty($this->session->userdata('order_date'))) {
           $data = array('order_date' => $order_date);
           $this->session->set_userdata($data);
        }

		$this->data['total_item'] = $this->model_item->CountTotalItem();		
		$this->data['total_asset'] = $this->model_asset->countTotalAsset();
		$this->data['total_order'] = $this->model_order->countTotalOrder();
		$this->data['total_customer'] = $this->model_customer->countTotalCustomer();
		$this->data['total_employee'] = $this->model_employee->countTotalEmployee();
		$this->data['total_order_day'] = $this->model_order->countTotalOrderDay($order_date);

		$this->render_template('dashboard', $this->data);
		
	}


    
    public function fetchTotalByIngredient()
    {
        $result = array('data' => array());		

        $data = $this->model_order->countTotalByIngredient($this->session->order_date);

        foreach ($data as $key => $value) {

            $result['data'][$key] = array(
                $value['ingredient_name'], 
                $value['total_order'],                                
                round($value['total_ingredient'],4)
            );
        } // /foreach

        echo json_encode($result);

    }   

}