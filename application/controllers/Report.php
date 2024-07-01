<?php  

defined('BASEPATH') OR exit('No direct script access allowed');

class Report extends Admin_Controller 
{	
	public function __construct()
	{
		parent::__construct();

		$this->not_logged_in();

		$this->data['page_title'] = 'Reports';
	}

	 

	public function index()
	{

		if(!in_array('viewReport', $this->permission)) {redirect('dashboard', 'refresh');}

        //--> The report uses flashdata session variable.  Flashdata are temporary variables
        //    that will be used only one time.  

	    $this->session->set_flashdata('printdoc', 'no'); 

		if($this->input->post('report') == 'REP01') {
			if($this->input->post('format') == 'PDF') {
				$this->session->set_flashdata('printREP01', 'yes');
				$this->session->set_flashdata('printdoc', 'yes');				
			} else {				
				redirect('report/listREP01');
			}       
		}

		else if($this->input->post('report') == 'REP02') {			
			$this->session->set_userdata('availability', $this->input->post('availability'));
			if($this->input->post('format') == 'PDF') {
				$this->session->set_flashdata('printREP02', 'yes');
				$this->session->set_flashdata('printdoc', 'yes');				
			} else {				
				redirect('report/listREP02');
			}	
		}

		else if($this->input->post('report') == 'REP03') {
			$this->session->set_userdata('area', $this->input->post('area'));
			$this->session->set_userdata('municipality', $this->input->post('municipality'));
			$this->session->set_userdata('date_from', $this->input->post('date_from'));
			$this->session->set_userdata('date_to', $this->input->post('date_to'));
			if($this->input->post('format') == 'PDF') {
				$this->session->set_flashdata('printREP03', 'yes');
				$this->session->set_flashdata('printdoc', 'yes');				
			} else {				
				redirect('report/listREP03');
			}	
		}

		else if($this->input->post('report') == 'REP04') {	
		    $this->session->set_userdata('customer_type', $this->input->post('customer_type'));		  
			if($this->input->post('format') == 'PDF') {
				$this->session->set_flashdata('printREP04', 'yes');
				$this->session->set_flashdata('printdoc', 'yes');				
			} else {				
				redirect('report/listREP04');
			}	
		}

		else if($this->input->post('report') == 'REP05') {
		    $this->session->set_userdata('employee_type', $this->input->post('employee_type'));	 			  
			if($this->input->post('format') == 'PDF') {
				$this->session->set_flashdata('printREP05', 'yes');
				$this->session->set_flashdata('printdoc', 'yes');				
			} else {				
				redirect('report/listREP05');
			}	
		}

		else if($this->input->post('report') == 'REP06') {		
			$this->session->set_userdata('area', $this->input->post('area'));	
			$this->session->set_userdata('customer', $this->input->post('customer'));		
			$this->session->set_userdata('date_from', $this->input->post('date_from'));
			$this->session->set_userdata('date_to', $this->input->post('date_to'));
			if($this->input->post('format') == 'PDF') {
				$this->session->set_flashdata('printREP06', 'yes');
				$this->session->set_flashdata('printdoc', 'yes');				
			} else {				
				redirect('report/listREP06');
			}	
		}

		else if($this->input->post('report') == 'REP07') {	
			$this->session->set_userdata('area', $this->input->post('area'));
			$this->session->set_userdata('municipality', $this->input->post('municipality'));
			$this->session->set_userdata('customer', $this->input->post('customer'));		
			$this->session->set_userdata('date_from', $this->input->post('date_from'));
			$this->session->set_userdata('date_to', $this->input->post('date_to'));
			if($this->input->post('format') == 'PDF') {
				$this->session->set_flashdata('printREP07', 'yes');
				$this->session->set_flashdata('printdoc', 'yes');				
			} else {				
				redirect('report/listREP07');
			}	
		}

		else if($this->input->post('report') == 'REP08') {	
			$this->session->set_userdata('area', $this->input->post('area'));
			$this->session->set_userdata('date_from', $this->input->post('date_from'));
			$this->session->set_userdata('date_to', $this->input->post('date_to'));
			$this->session->set_flashdata('printREP08', 'yes');
			$this->session->set_flashdata('printdoc', 'yes');
		}

		else if($this->input->post('report') == 'REP09') {	
			$this->session->set_userdata('area', $this->input->post('area'));	
			$this->session->set_userdata('customer', $this->input->post('customer'));		
			$this->session->set_userdata('date_from', $this->input->post('date_from'));
			$this->session->set_userdata('date_to', $this->input->post('date_to'));
			if($this->input->post('format') == 'PDF') {
				$this->session->set_flashdata('printREP09', 'yes');
				$this->session->set_flashdata('printdoc', 'yes');				
			} else {				
				redirect('report/listREP09');
			}	
		}

		else if($this->input->post('report') == 'REP10') {	
		    if ($this->input->post('customer') =='all')
		       {$msg_error = 'You must choose a customer for this report'; 
                $this->session->set_flashdata('warning', $msg_error); 
                             
               }
            else {  		
				$this->session->set_userdata('customer', $this->input->post('customer'));						
				$this->session->set_userdata('date_from', $this->input->post('date_from'));
				$this->session->set_userdata('date_to', $this->input->post('date_to'));
				$this->session->set_flashdata('printREP10', 'yes');
				$this->session->set_flashdata('printdoc', 'yes');
				} 		
		}

		else if($this->input->post('report') == 'REP11') {
			if($this->input->post('format') == 'PDF') {
				$this->session->set_flashdata('printREP11', 'yes');
				$this->session->set_flashdata('printdoc', 'yes');				
			} else {				
				redirect('report/listREP11');
			}       
		}

		else if($this->input->post('report') == 'REP12') {
			$this->session->set_userdata('employee', $this->input->post('employee'));
			$this->session->set_userdata('date_from', $this->input->post('date_from'));
			$this->session->set_userdata('date_to', $this->input->post('date_to'));
			if($this->input->post('format') == 'PDF') {
				$this->session->set_flashdata('printREP12', 'yes');
				$this->session->set_flashdata('printdoc', 'yes');				
			} else {				
				redirect('report/listREP12');
			}	
		}


		else if($this->input->post('report') == 'REP13') {
			$this->session->set_userdata('date_from', $this->input->post('date_from'));
			$this->session->set_userdata('date_to', $this->input->post('date_to'));
			if($this->input->post('format') == 'PDF') {
				$this->session->set_flashdata('printREP13', 'yes');
				$this->session->set_flashdata('printdoc', 'yes');				
			} else {				
				redirect('report/listREP13');
			}	
		}


		else if($this->input->post('report') == 'REP14') {
			if($this->input->post('format') == 'PDF') {
				$this->session->set_flashdata('printREP14', 'yes');
				$this->session->set_flashdata('printdoc', 'yes');				
			} else {				
				redirect('report/listREP14');
			}       
		}


		else if($this->input->post('report') == 'REP15') {
			if($this->input->post('format') == 'PDF') {
				$this->session->set_userdata('supplier', $this->input->post('supplier'));
				$this->session->set_userdata('date_from', $this->input->post('date_from'));
				$this->session->set_userdata('date_to', $this->input->post('date_to'));
				$this->session->set_flashdata('printREP15', 'yes');
				$this->session->set_flashdata('printdoc', 'yes');				
			} else {				
				redirect('report/listREP15');
			}       
		}


	    $this->data['availability'] = $this->model_availability->getActiveAvailability();	    	
		$this->data['location'] = $this->model_location->getActiveLocation();
		$this->data['area'] = $this->model_area->getActiveArea();
		$this->data['municipality'] = $this->model_municipality->getActiveMunicipality();
		$this->data['customer'] = $this->model_customer->getActiveCustomer();
		$this->data['customer_type'] = $this->model_customer_type->getActiveCustomerType();		
		$this->data['employee'] = $this->model_employee->getActiveEmployee();
		$this->data['employee_type'] = $this->model_employee_type->getActiveEmployeeType();	
		$this->data['supplier'] = $this->model_supplier->getActiveSupplier();		
		
		$this->data['report'] = $this->model_report->getReportList('all'); 

		$this->render_template('report/index', $this->data);
	}


//-----------------------------------------------------------------------------------------------------
//--                                                                                                 --
//--                                 REPORT on LIST FORMAT                                           --
//--                                                                                                 --
//-----------------------------------------------------------------------------------------------------

//--> Manage Report in the format of datatable to have the facilities to transfer to Excel, pdf  etc..

	//--> REPORT 01

	public function listREP01()
	{
		$this->data['report'] = $this->model_report->getReportTitle('REP01');
		$this->render_template('report/listREP01', $this->data);	
	}

	public function fetchREP01()
	{
		$result = array('data' => array());

		$data = $this->model_report->get_REP01('list');

		foreach ($data as $key => $value) {

			$result['data'][$key] = array(	
				$value['item_code'],				
				$value['item_name'],
				$value['brand'],
				$value['category_name'],
				$value['unit_name'],
				$value['ordering_point'],
				$value['safety_stock'],
				$value['price_date'],
				$value['item_price'],
				$value['quantity'],
				$value['total']
			);
		} // /foreach

		echo json_encode($result);
	}


	//--> REPORT 02

	public function listREP02()
	{
		$this->data['report'] = $this->model_report->getReportTitle('REP02');
		$this->render_template('report/listREP02', $this->data);	
	}

	public function fetchREP02()
	{
		$result = array('data' => array());

		$data = $this->model_report->get_REP02('list');

		foreach ($data as $key => $value) {

			$result['data'][$key] = array(	
				$value['asset_code'],				
				$value['asset_name'],
				$value['asset_type_name'],
				$value['brand'],
				$value['location_name'],
				$value['serial_number'],
				$value['asset_value'],
				$value['asset_quantity'],
				($value['asset_quantity'] * $value['asset_value']).'.00'
			);
		} // /foreach

		echo json_encode($result);
	}


	//--> REPORT 03

	public function listREP03()
	{
		$this->data['report'] = $this->model_report->getReportTitle('REP03');
		$this->render_template('report/listREP03', $this->data);	
	}

	public function fetchREP03()
	{
		$result = array('data' => array());

		$data = $this->model_report->get_REP03('list');

		foreach ($data as $key => $value) {

			$result['data'][$key] = array(	
				$value['order_no'],				
				$value['customer_name'],
				$value['phone'],
				$value['area_name'],
				$value['municipality_name'],
				$value['order_date'],
				$value['employee_name'],
				$value['sales_invoice_no'],
				$value['order_total']
				
			);
		} // /foreach

		echo json_encode($result);
	}



	//--> REPORT 04

	public function listREP04()
	{
		$this->data['report'] = $this->model_report->getReportTitle('REP04');
		$this->render_template('report/listREP04', $this->data);	
	}

	public function fetchREP04()
	{
		$result = array('data' => array());

		$data = $this->model_report->get_REP04('list');

		foreach ($data as $key => $value) {

			$result['data'][$key] = array(
				$value['customer_name'],							
				$value['customer_type_name'],
				$value['tin'],	
				$value['area_name'],
				$value['municipality_name'],
				$value['phone'],
				$value['email'],
				$value['balance']
			);
		} // /foreach

		echo json_encode($result);
	}



	//--> REPORT 05

	public function listREP05()
	{
		$this->data['report'] = $this->model_report->getReportTitle('REP05');
		$this->render_template('report/listREP05', $this->data);	
	}

	public function fetchREP05()
	{
		$result = array('data' => array());

		$data = $this->model_report->get_REP05('list');

		foreach ($data as $key => $value) {

			$result['data'][$key] = array(	

				$value['employee_name'],	
				$value['employee_code'],				
				$value['employee_type_name'],
				$value['employee_status_name'],
				$value['position_name'],
				$value['tin'],
				$value['municipality_name'],
				$value['phone'],
				$value['email']
			);
		} // /foreach

		echo json_encode($result);
	}


	
	//--> REPORT 06

	public function listREP06()
	{
		$this->data['report'] = $this->model_report->getReportTitle('REP06');
		$this->render_template('report/listREP06', $this->data);	
	}

	public function fetchREP06()
	{
		$result = array('data' => array());

		$data = $this->model_report->get_REP06('list');

		foreach ($data as $key => $value) {

			//--> Generate the list of the items
				$list_item = '';
				$item = $this->model_report->getReportOrderItem($value['order_id']);
				foreach ($item as $it):
						$list_item = $list_item.'<strong>'.$it->quantity.'</strong>'.' '.$it->item_name.'&nbsp;&nbsp;&nbsp;&nbsp;';
				endforeach;	

			$result['data'][$key] = array(
				$value['area_name'],
				$value['municipality_name'],	
				$value['customer_name'],			
				$value['phone'],
				$value['order_no'],
				$list_item
			);
		} // /foreach

		echo json_encode($result);
	}



	//--> REPORT 07

	public function listREP07()
	{
		$this->data['report'] = $this->model_report->getReportTitle('REP07');
		$this->render_template('report/listREP07', $this->data);	
	}

	public function fetchREP07()
	{
		$result = array('data' => array());

		$data = $this->model_report->get_REP07('list');

		foreach ($data as $key => $value) {

			//--> Generate the list of the items
				$list_item = '';
				$item = $this->model_report->getReportOrderItem($value['order_id']);
				foreach ($item as $it):
						$list_item = $list_item.'<strong>'.$it->quantity.'</strong>'.' '.$it->item_name.'&nbsp;&nbsp;&nbsp;&nbsp;';
				endforeach;	

 			$result['data'][$key] = array(
				$value['area_name'],
				$value['municipality_name'],
				$value['customer_name'],	
				$value['order_no'],
				$list_item,
				$value['order_total'],
				$value['previous_balance'],
				$value['balance']
			);
		} // /foreach

		echo json_encode($result);
	}
	

	//--> REPORT 09

	public function listREP09()
	{
		$this->data['report'] = $this->model_report->getReportTitle('REP09');
		$this->render_template('report/listREP09', $this->data);	
	}

	public function fetchREP09()
	{
		$result = array('data' => array());

		$data = $this->model_report->get_REP09('list');

		foreach ($data as $key => $value) {

			$result['data'][$key] = array(	
				$value['area_name'],
				$value['municipality_name'],
				$value['customer_name'],
				$value['phone'],
				$value['order_no'],
				$value['order_total'],
				$value['payment_type'],
				$value['sales_invoice_no'],
				$value['payment_date'],
				$value['amount_paid'],
			);
		} // /foreach

		echo json_encode($result);
	}



	public function listREP11()
	{
		$this->data['report'] = $this->model_report->getReportTitle('REP11');
		$this->render_template('report/listREP11', $this->data);	
	}

	public function fetchREP11()
	{
		$result = array('data' => array());

		$data = $this->model_report->get_REP11('list');

		foreach ($data as $key => $value) {

			$result['data'][$key] = array(	
				$value['item_code'],				
				$value['item_name'],
				$value['category_name'],
				$value['unit_name'],				
				$value['price_date'],
				$value['item_price'],
				$value['quantity'],
				$value['ordering_point'],
				$value['safety_stock']
			);
		} // /foreach

		echo json_encode($result);
	}


	public function listREP12()
	{
		$this->data['report'] = $this->model_report->getReportTitle('REP12');
		$this->render_template('report/listREP12', $this->data);	
	}

	public function fetchREP12()
	{
		$result = array('data' => array());

		$data = $this->model_report->get_REP12('list');

		foreach ($data as $key => $value) {

			$result['data'][$key] = array(	
				$value['requisition_no'],				
				$value['requisition_date'],
				$value['employee_requested_name'],
				$value['employee_approved_name'],				
			);
		} // /foreach

		echo json_encode($result);
	}


	public function listREP13()
	{
		$this->data['report'] = $this->model_report->getReportTitle('REP13');
		$this->render_template('report/listREP13', $this->data);	
	}

	public function fetchREP13()
	{
		$result = array('data' => array());

		$data = $this->model_report->get_REP13('list');

		foreach ($data as $key => $value) {

			$result['data'][$key] = array(	
				$value['order_date'],				
				$value['number_of_order'],
				$value['average_amount'],
				$value['total_amount'],				
			);
		} // /foreach

		echo json_encode($result);
	}


	//--> REPORT 14

	public function listREP14()
	{
		$this->data['report'] = $this->model_report->getReportTitle('REP14');
		$this->render_template('report/listREP14', $this->data);	
	}

	public function fetchREP14()
	{
		$result = array('data' => array());

		$data = $this->model_report->get_REP14('list');

		foreach ($data as $key => $value) {

			$result['data'][$key] = array(
				$value['supplier_name'],							
				$value['tin'],
				$value['contact'],	
				$value['phone'],
				$value['mobile'],
				$value['email'],
				$value['website']
			);
		} // /foreach

		echo json_encode($result);
	}



	//--> REPORT 15

	public function listREP15()
	{
		$this->data['report'] = $this->model_report->getReportTitle('REP15');
		$this->render_template('report/listREP15', $this->data);	
	}

	public function fetchREP15()
	{
		$result = array('data' => array());

		$data = $this->model_report->get_REP15('list');

		foreach ($data as $key => $value) {

			$result['data'][$key] = array(
				$value['delivery_no'],
				$value['supplier_name'],							
				$value['delivery_date'],
				$value['production_date'],	
				$value['expiry_date'],
				$value['batch_no'],
				$value['lot_no'],
				$value['reference_no'],
				$value['list_item']
			);
		} // /foreach

		echo json_encode($result);
	}





//-----------------------------------------------------------------------------------------------------
//--                                                                                                 --
//--                                 UPDATE OF THE REPORT TITLE BY USER                              --
//--                                                                                                 --
//-----------------------------------------------------------------------------------------------------


    public function fetchReportById($report_id) 
	{
		if($report_id) {
			$data = $this->model_report->getReport($report_id);
			echo json_encode($data);
		}
	}


	//--> Manage Report for updating the titles

	public function title()
	{
		if(!in_array('updateReport', $this->permission)) {redirect('dashboard', 'refresh');}

		$this->render_template('report/title', $this->data);	
	}


	//--> It retrieves all the report data from the database 
	//    This function is called from the datatable ajax function
	//    The data is return based on the json format.

	public function fetchReport()
	{
		$result = array('data' => array());

		$data = $this->model_report->getReport();

		foreach ($data as $key => $value) {

			$buttons = '';

			if(in_array('updateReport', $this->permission)) {
				$buttons .= '<button type="button" class="btn btn-default" onclick="editFunc('.$value['report_id'].')" data-toggle="modal" data-target="#editModal"><i class="fa fa-pencil"></i></button>';
			 	$report_code='  <a data-target="#editModal" onclick="editFunc('.$value['report_id'].')" data-toggle="modal" href="#editModal">'.$value['report_code'].'</a>';
			}	

			$result['data'][$key] = array(	
				$report_code,
			    $value['report_title'],				
				$value['report_desc'],
				$buttons
			);
		} // /foreach

		echo json_encode($result);
	}



	public function update($report_id)
	{
		if(!in_array('updateReport', $this->permission)) {redirect('dashboard', 'refresh');}

		$response = array();

		if($report_id) {
			$this->form_validation->set_rules('report_title', 'Title', 'trim|required');
			$this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');

	        if ($this->form_validation->run() == TRUE) {
	        	$data = array(
	        		'report_title' => $this->input->post('report_title'),
	        		'report_desc' => $this->input->post('report_desc'),	
	        	);

	        	$update = $this->model_report->update($data, $report_id);
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



}