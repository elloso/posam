<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Customer extends Admin_Controller
{
	public function __construct()
	{
		parent::__construct();

		$this->not_logged_in();

		$this->data['page_title'] = 'Customer';
        $this->data['active_tab'] = $this->input->get('tab') ?? 'customer';
        $this->log_module = 'Customer';
        
	}

	public function index()
	{
        if(!in_array('viewCustomer', $this->permission)) {redirect('dashboard', 'refresh');}

		$this->render_template('customer/index', $this->data);	
	}


    //-->  For creation of drop-down list 

    public function fetchActiveCustomer() 
    {
        $data = $this->model_customer->getActiveCustomer();
        echo json_encode($data);

    }


    public function fetchCustomerDataById($customer_id) 
    {
        if($customer_id) {
            $data = $this->model_customer->getCustomerData($customer_id);
            echo json_encode($data);
        }

        return false;
    }


	public function fetchCustomerData()
	{
		$result = array('data' => array());

		$data = $this->model_customer->getCustomerData();

		foreach ($data as $key => $value) {

            $customer_name = $value['customer_name'];

            $buttons = '';

            if(in_array('updateCustomer', $this->permission)) {
    			$buttons .= '<a href="'.base_url('customer/update/'.$value['customer_id']).'" class="btn btn-default"><i class="fa fa-pencil"></i></a>';
                $customer_name = '<a href="'.base_url('customer/update/'.$value['customer_id']).'">'.$value['customer_name'].'</a>';
                $buttons .= '<a href="'.base_url('customer/timeline/'.$value['customer_id']).'" class="btn btn-default"><i class="fa fa-clock-o"></i></a>';
            }

            if(in_array('deleteCustomer', $this->permission)) { 
    			$buttons .= ' <button type="button" class="btn btn-default" onclick="removeFunc('.$value['customer_id'].')" data-toggle="modal" data-target="#removeModal"><i class="fa fa-trash"></i></button>';
            }

            if(in_array('viewCustomer', $this->permission)) {
                $buttons .= '<a href="'.base_url('report_customer/report_customer/'.$value['customer_id']).'" target="_blank" class="btn btn-default"><i class="fa fa-print"></i></a>';} 

            $order_today = ($value['order_today'] > 0) ? '<span class="label label-success">'.'Yes'.'</span>' : '<span class="label label-warning">'.'No'.'</span>'; 

            $active = ($value['active'] == 1) ? '' : '<span class="label label-warning">'.'Inactive'.'</span>';   
			

			$result['data'][$key] = array(
                $customer_name,
                $value['customer_code'],
                $value['customer_type_name'],
                $value['area_name'],
                $value['municipality_name'], 			
				$value['phone'],
                $order_today,         
                $value['balance'], 
                $active,   
				$buttons
			);
            
            // This will create directory for all customer
            // If the directory already exists, it won't be created
            $path = "./upload/customers/".$value['customer_id'];
            if(!is_dir($path))  {mkdir($path,0755,TRUE);}
		} // /foreach



		echo json_encode($result);
	}	


	public function create()
	{
		if(!in_array('createCustomer', $this->permission)) {redirect('dashboard', 'refresh');}

		$this->form_validation->set_rules('customer_name', 'Customer name', 'trim|required');
        $this->form_validation->set_rules('area', 'Area', 'trim|required');
        $this->form_validation->set_rules('customer_type', 'Customer Type', 'trim|required');
        $this->form_validation->set_error_delimiters('<p class="alert alert-warning">','</p>');


        if ($this->form_validation->run() == TRUE) {   

            $data = array(
            'active' => $this->input->post('active'),
            'balance' => $this->input->post('balance'),
            'area_fk' => (($this->input->post('area') != FALSE) ? $this->input->post('area') : NULL),
            'customer_type_fk' => (($this->input->post('customer_type') != FALSE) ? $this->input->post('customer_type') : NULL),
            'municipality_fk' => (($this->input->post('municipality') != FALSE) ? $this->input->post('municipality') : NULL),  
            'address' => (($this->input->post('address') != FALSE) ? $this->input->post('address') : NULL),
            'customer_code' => (($this->input->post('customer_code') != FALSE) ? $this->input->post('customer_code') : NULL),
            'phone' => (($this->input->post('phone') != FALSE) ? $this->input->post('phone') : NULL),
            'email' => (($this->input->post('email') != FALSE) ? $this->input->post('email') : NULL),
            'customer_name' => $this->input->post('customer_name'),
            'remark' => (($this->input->post('remark') != FALSE) ? $this->input->post('remark') : NULL), 
            'tin' => (($this->input->post('tin') != FALSE) ? $this->input->post('tin') : NULL),           
            'updated_by' => $this->session->userdata('user_id'),
            ); 
            
            $customer_id = $this->model_customer->create($data);

            if($customer_id) {
                $this->session->set_flashdata('success', 'Successfully created');
                //The create return the customer_id created if it's successful
                //--> Log Action
                $this->model_log->create(array(
                    'customer_fk' => $customer_id,
                    'subject_fk' => $customer_id,      
                    'action' => 'Create',
                    'attributes' => serialize($data),
                    'module' => $this->log_module,
                    'remark' => 'Create Customer ' . $customer_id,
                    'updated_by' => $this->session->user_id, 
                ));
                //---> Create the directory for deposit of documents-->
                $path = "./upload/customers/".$customer_id;
                //---> Create the folder if it does not exists
                if(!is_dir($path))  {mkdir($path,0755,TRUE);}     
                redirect('customer/update/'.$customer_id, 'refresh');
            }
            else {
                $this->session->set_flashdata('errors', 'Error occurred!!');
                redirect('customer/', 'refresh');
            }

        }
        else {
            // false case        	
			$this->data['municipality'] = $this->model_municipality->getActiveMunicipality();  
            $this->data['area'] = $this->model_area->getActiveArea();     
            $this->data['customer_type'] = $this->model_customer_type->getActiveCustomerType(); 

            $generate_code = $this->model_customer->generateCustomerCode();
            $this->data['generate_code'] = $generate_code;             	

            $this->render_template('customer/create', $this->data);
        }	
	}

    

	public function update($customer_id)
	{      
        if(!in_array('updateCustomer', $this->permission)) {redirect('dashboard', 'refresh');}

        if(!$customer_id) {redirect('dashboard', 'refresh');}

        //--> Get the old data before updating
        $old_data = $this->model_customer->getCustomerData($customer_id);

        $this->form_validation->set_rules('customer_name', 'Customer name', 'trim|required');
        $this->form_validation->set_rules('area', 'Area', 'trim|required');
        $this->form_validation->set_rules('customer_type', 'Customer Type', 'trim|required');
        $this->form_validation->set_error_delimiters('<p class="alert alert-warning">','</p>');

        if ($this->form_validation->run() == TRUE) {
            $data = array(
                'active' => $this->input->post('active'),
                'balance' => $this->input->post('balance'),
                'area_fk' => (($this->input->post('area') != FALSE) ? $this->input->post('area') : NULL),
                'customer_type_fk' => (($this->input->post('customer_type') != FALSE) ? $this->input->post('customer_type') : NULL),
                'municipality_fk' => (($this->input->post('municipality') != FALSE) ? $this->input->post('municipality') : NULL),  
                'address' => (($this->input->post('address') != FALSE) ? $this->input->post('address') : NULL),
                'customer_code' => (($this->input->post('customer_code') != FALSE) ? $this->input->post('customer_code') : NULL),
                'phone' => (($this->input->post('phone') != FALSE) ? $this->input->post('phone') : NULL),
                'email' => (($this->input->post('email') != FALSE) ? $this->input->post('email') : NULL),
                'customer_name' => $this->input->post('customer_name'),
                'remark' => (($this->input->post('remark') != FALSE) ? $this->input->post('remark') : NULL),
                'tin' => (($this->input->post('tin') != FALSE) ? $this->input->post('tin') : NULL),             
                'updated_by' => $this->session->userdata('user_id'),
                );

            $update = $this->model_customer->update($customer_id, $data);
            
            if($update == true) {
                //--> Log Action
                $this->model_log->create(array(
                    'customer_fk' => $customer_id,
                    'subject_fk' => $customer_id,      
                    'action' => 'Update',
                    'attributes' => serialize(array('old' => $old_data,'new' => $data)),
                    'module' => $this->log_module,
                    'remark' => 'Update Customer ' . $customer_id,
                    'updated_by' => $this->session->user_id, 
                ));
                $this->session->set_flashdata('success', 'Successfully updated');
                redirect('customer/update/'.$customer_id, 'refresh');
            }
            else {
                $this->session->set_flashdata('errors', 'Error occurred!!');
                redirect('customer/', 'refresh');
            }
        }
        else {
            
     
            $this->data['municipality'] = $this->model_municipality->getActiveMunicipality(); 
            $this->data['area'] = $this->model_area->getActiveArea();    
            $this->data['customer_type'] = $this->model_customer_type->getActiveCustomerType();              

            $customer_data = $this->model_customer->getCustomerData($customer_id);
            $this->data['customer_data'] = $customer_data;

            $this->render_template('customer/edit', $this->data); 
        }   
	}


	public function remove()
	{
        if(!in_array('deleteCustomer', $this->permission)) {redirect('dashboard', 'refresh');}
        
        $customer_id = $this->input->post('customer_id');

        $response = array();

        if ($customer_id) {
            //---> Validate if the information is used in other tables
            $total_rows = $this->model_customer->checkIntegrity($customer_id);
            //---> If no table have this information, we can delete
            if ($total_rows == 0) {  
                //Delete the directory of the documents
                 $path = "./upload/customers/".$customer_id;
                 rmdir($path);
                //--> Get the old data before deleting
                $old_data = $this->model_customer->getCustomerData($customer_id);
                $delete = $this->model_customer->remove($customer_id);
                if($delete == true) {
                    $response['success'] = true;
                    $response['messages'] = 'Successfully deleted';
                    //--> Log Action
                    $this->model_log->create(array(
                        'customer_fk' => $customer_id,
                        'subject_fk' => $customer_id,      
                        'action' => 'Delete',
                        'attributes' => serialize($old_data),
                        'module' => $this->log_module,
                        'remark' => 'Delete Customer ' . $customer_id,
                        'updated_by' => $this->session->user_id, 
                    ));
                } else {
                    $response['success'] = false;
                    $response['messages'] = 'Error in the database while deleting the information';}
            } else {
            //---> There is at least one data related
            $response['success'] = false;
            $response['messages'] = 'At least one data is related.  You cannot delete.';}

        }
        else {
            $response['success'] = false;
            $response['messages'] = 'Refresh the page again';}

        echo json_encode($response);
            
    }


    //--> Redirects to the timeline

    public function timeline($customer_id)
    {
        if(!in_array('viewCustomer', $this->permission)) {redirect('dashboard', 'refresh');}

        $timeline_data = $this->model_log->timeline_customer($customer_id); 
        $this->data['timeline_data'] = $timeline_data;
        $this->render_template('timeline', $this->data);
    }



//------------------------------------- ORDERS ---------------------------------------

    
    //-->  For creation of drop-down list 

    public function fetchCustomerOrder($customer_id) 
    {
        $data = $this->model_customer->getCustomerOrder($customer_id); 
        echo json_encode($data);
    }

    

    //-->  Fetches the orders of the customer
    
    public function fetchOrderData($customer_id)
    {
        $result = array('data' => array());

        $date_from = $this->input->get('date_from_order') ?? NULL;
        $date_to = $this->input->get('date_to_order') ?? NULL;

        if ($date_from == null) {
            $date_from = "'1900-01-01'";
        } else {
            $date_from = "'" . $date_from . "'";
        }
        if ($date_to == null) {
            $date_to = "'2500-01-01'";
        } else {
            $date_to = "'" . $date_to . "'";
        }

        $data = $this->model_customer->getCustomerOrderByDate($customer_id, $date_from, $date_to); 

        foreach ($data as $key => $value) {

            $buttons = '';

            $order_no = $value['order_no'];

            if(in_array('updateOrder', $this->permission)) {
                $buttons .= ' <a href="'.base_url('order/update/'.$value['order_id']).'" class="btn btn-default"><i class="fa fa-pencil"></i></a>';
                $order_no = '<a href="'.base_url('order/update/'.$value['order_id']).'">'.$value['order_no'].'</a>';
            }

            if(in_array('deleteOrder', $this->permission)) {
                $buttons .= ' <button type="button" class="btn btn-default" onclick="removeOrder('.$value['order_id'].')" data-toggle="modal" data-target="#removeModalOrder"><i class="fa fa-trash"></i></button>';
            }


            if(in_array('viewOrder', $this->permission)) {
                $buttons .= '<a href="'.base_url('report_order_slip/report_order_slip/'.$value['order_id']).'" target="_blank" class="btn btn-default"><i class="fa fa-print"></i></a>'; 
            }
    
            $result['data'][$key] = array( 
                $order_no,
                $value['order_date'],
                $value['delivery_date'],
                $value['order_total'],
                $value['updated_by'],  
                $value['updated_date'],    
                $buttons
            );
        } // /foreach

        echo json_encode($result);
    }
    


//-------------------------------------  DOCUMENT -----------------------------------------------

    
    //--> It Fetches the document data from the document table 
    //    this function is called from the datatable ajax function
    
    public function fetchCustomerDocument()
    {
        $result = array('data' => array());

        $customer_id = $this->input->post('document_customer_id');

        $data = $this->model_customer->getCustomerDocument($customer_id);  

        foreach ($data as $key => $value) {

            $link = base_url('upload/customers/'.$customer_id.'/'.$value['doc_name']);
            $doc_link = '<a href="'.$link.'" target="_blank" >'.($value['doc_name']).'</a>';

            $buttons = '';

            if(in_array('viewDocument', $this->permission)) {
                $buttons .= '<a href="'.$link.'" target="_blank" class="btn btn-default"><i class="fa fa-search"></i></a>';
            }

            if(in_array('deleteDocument', $this->permission)) { 
                $buttons .= ' <button type="button" class="btn btn-default" onclick="removeDocument('.$value['document_id'].')" data-toggle="modal" data-target="#removeDocumentModal"><i class="fa fa-trash"></i></button>';   
            }           
  
            $result['data'][$key] = array(
                $doc_link,
                $value['doc_size'],
                $buttons
            );
        } // /foreach

        echo json_encode($result);
    }



    //-->  This function is invoked from another function to upload the documents into the customers folder
    //     of the customer

    public function uploadDocument()
    {

        if(!in_array('updateDocument', $this->permission)) {redirect('dashboard', 'refresh');}

        $directory = $this->session->directory;
        $config['upload_path'] = './'.$directory;
        $config['allowed_types'] = 'gif|jpg|png|pdf|xls|xlsx|docx|doc|pptx';
        $config['max_size'] = '6000';        

        $this->load->library('upload', $config);

        if ( ! $this->upload->do_upload('customer_document')) {
            $msg_error ='This type of document is not allowed or the document is too large.'; 
            $this->session->set_flashdata('warning', $msg_error);
            redirect('customer/update/'.$this->session->customer_id, 'refresh');
            }
        else
            {
            //---> Create the document in the table document
           
            $doc_link = $directory.$this->upload->data('file_name');

            $data = array(
                'customer_fk' => $this->session->customer_id, 
                'doc_size' => $this->upload->data('file_size'),
                'doc_type' => $this->upload->data('file_type'),
                'doc_name' => $this->upload->data('file_name'),
                'updated_by' => $this->session->user_id,                 
            );

            $create = $this->model_customer->createDocument($data);
            
            if($create == true) {
                //--->  Upload the document
                $data = array('upload_data' => $this->upload->data());
                redirect('customer/update/'.$this->session->customer_id."?tab=document", 'refresh');}
            else {
                $msg_error = 'Error occurred'; 
                $this->session->set_flashdata('error', $msg_error);
                redirect('customer/', 'refresh');}
        }
    } 



    public function removeDocument()
    {
        if(!in_array('deleteDocument', $this->permission)) {redirect('dashboard', 'refresh');}
        
        $document_id = $this->input->post('document_id');
        $response = array();

        if($document_id) {
            //--> Get the link of the document for deleting the document on the directory
            $document_data = $this->model_customer->getDocument($document_id);
            $doc_link = '/upload/customers/'.$document_data['customer_fk'].'/'.$document_data['doc_name'];
            unlink(FCPATH . $doc_link);
            //--> Delete the document in the document table
            $delete = $this->model_customer->removeDocument($document_id);
            if($delete == true) {
                $response['success'] = true;
                $response['messages'] = 'Successfully deleted'; 
            }
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