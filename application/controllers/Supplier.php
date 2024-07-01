<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Supplier extends Admin_Controller 
{
	public function __construct()
	{
		parent::__construct();

		$this->not_logged_in();

		$this->data['page_title'] = 'Supplier';
    	$this->data['active_tab'] = $this->input->get('tab') ?? 'supplier';
    	$this->log_module = 'Supplier';

	}


	//--> Redirects to the manage supplier page

	public function index()
	{

		if(!in_array('viewSupplier', $this->permission)) {
			redirect('dashboard', 'refresh');
		}

		$this->render_template('supplier/index', $this->data);	
	}	

	
	//--> It checks if it gets the supplier id and retrieves
	//    the supplier information from the supplier model and 
	//    returns the data into json format. 
	//    This function is invoked from the view page.
	
	public function fetchSupplierDataById($supplier_id) 
	{
		if($supplier_id) {
			$data = $this->model_supplier->getSupplierData($supplier_id);
			echo json_encode($data);
		}

		return false;
	}


	//-->  For creation of drop-down list 

	public function fetchActiveSupplier() 
	{
		$data = $this->model_supplier->getActiveSupplier();
		echo json_encode($data);

	}

	
	//--> Fetches the supplier value from the supplier table 
	//    This function is called from the datatable ajax function
	
	public function fetchSupplierData()
	{
		$result = array('data' => array());

		$data = $this->model_supplier->getSupplierData(); 

		foreach ($data as $key => $value) {

			$buttons = '';

			$supplier_name = $value['supplier_name'];

			if(in_array('updateSupplier', $this->permission)) {
			$buttons .= '<a href="'.base_url('supplier/update/'.$value['supplier_id']).'" class="btn btn-default"><i class="fa fa-pencil"></i></a>';
            $supplier_name = '<a href="'.base_url('supplier/update/'.$value['supplier_id']).'">'.$value['supplier_name'].'</a>';
            $buttons .= '<a href="'.base_url('supplier/timeline/'.$value['supplier_id']).'" class="btn btn-default"><i class="fa fa-clock-o"></i></a>';
	        }

	        if(in_array('deleteSupplier', $this->permission)) { 
				$buttons .= ' <button type="button" class="btn btn-default" onclick="removeFunc('.$value['supplier_id'].')" data-toggle="modal" data-target="#removeModal"><i class="fa fa-trash"></i></button>';
	        }

	        if(in_array('viewSupplier', $this->permission)) {
	            $buttons .= '<a href="'.base_url('report_supplier/report_supplier/'.$value['supplier_id']).'" target="_blank" class="btn btn-default"><i class="fa fa-print"></i></a>';} 

			$active = ($value['active'] == 1) ? '' : '<span class="label label-warning">'.'Inactive'.'</span>';

			$result['data'][$key] = array(
				$supplier_name,
				$value['tin'],
				$value['address'],
				$value['contact'],
				$value['phone'],
				$value['email'],
				$value['website'],
				$active,
				$buttons
			);
		} // /foreach

		echo json_encode($result);
	}


	
	public function fetchSupplierItem($supplier_id)
	{
		$result = array('data' => array());

		$data = $this->model_supplier->getSupplierItem($supplier_id); 

		foreach ($data as $key => $value) {

			$buttons = '';

			$item_name = $value['item_name'];

			if(in_array('viewItem', $this->permission)) {
			$buttons .= '<a href="'.base_url('item/update/'.$value['item_id']).'" class="btn btn-default"><i class="fa fa-pencil"></i></a>';
            $item_name = '<a href="'.base_url('item/update/'.$value['item_id']).'">'.$value['item_name'].'</a>';
           
	        }

	        
			$result['data'][$key] = array(
				$item_name,
				$value['item_code'],
				$value['category_name'],
				$value['unit_name'],
				$value['item_price'],
				$buttons
			);
		} // /foreach

		echo json_encode($result);
	}


	
	//--> It checks the supplier form validation 
	//    and if the validation is true (valid) then it inserts the data into the database 
	//    and returns the json format operation messages
	
	public function create()
	{
		if(!in_array('createSupplier', $this->permission)) {
			redirect('dashboard', 'refresh');
		}

		$response = array();

		$this->form_validation->set_rules('supplier_name', 'Name', 'trim|required');
		$this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');

        if ($this->form_validation->run() == TRUE) {
        	$data = array(
        		'supplier_name' => $this->input->post('supplier_name'),
        		'address' => $this->input->post('address'),	
        		'contact' => $this->input->post('contact'),	
        		'phone' => $this->input->post('phone'),	
        		'email' => $this->input->post('email'),
        		'mobile' => $this->input->post('mobile'),		
        		'tin' => $this->input->post('tin'),	
        		'website' => $this->input->post('website'),
        		'remark' => $this->input->post('remark'),	
        		'active' => $this->input->post('active'),	
        	);

        $supplier_id = $this->model_supplier->create($data);

        if($supplier_id == false) {
            $msg_error = 'Error occurred'; 
            $this->session->set_flashdata('error', $msg_error);
            redirect('supplier/create', 'refresh');}
        else {
            //---> Create the directory for deposit of documents-->
            $path = "./upload/suppliers/".$supplier_id;
            //---> Create the folder if it does not exists
            if(!is_dir($path))  {mkdir($path,0755,TRUE);}  
            //--> Log Action
            $this->model_log->create(array(
                'supplier_fk' => $supplier_id,
                'subject_fk' => $supplier_id,      
                'action' => 'Create',
                'attributes' => serialize($data),
                'module' => $this->log_module,
                'remark' => 'Create Supplier ' . $supplier_id,
                'updated_by' => $this->session->user_id, 
            ));               
            redirect('supplier/update/'.$supplier_id, 'refresh');
            }
          }

        else {
        // false case   	

        $this->render_template('supplier/create', $this->data);
    }

	}

	
	//--> It checks the supplier form validation 
	//    and if the validation is true (valid) then it updates the data into the database 
	//    and returns the json format operation messages
	
	public function update($supplier_id)
	{

	if(!in_array('updateSupplier', $this->permission)) {redirect('dashboard', 'refresh');}

    if(!$supplier_id) {redirect('dashboard', 'refresh');}

    //--> Get the old data before updating
    $old_data = $this->model_supplier->getSupplierData($supplier_id);

    $this->form_validation->set_rules('supplier_name', 'Name', 'trim|required');
    $this->form_validation->set_error_delimiters('<p class="alert alert-warning">','</p>');

    if ($this->form_validation->run() == TRUE) {
	        	$data = array(	        		
	        	'supplier_name' => $this->input->post('supplier_name'),
        		'address' => $this->input->post('address'),	
        		'contact' => $this->input->post('contact'),	
        		'phone' => $this->input->post('phone'),	
        		'email' => $this->input->post('email'),
        		'mobile' => $this->input->post('mobile'),		
        		'tin' => $this->input->post('tin'),	
        		'website' => $this->input->post('website'),
        		'remark' => $this->input->post('remark'),	
        		'active' => $this->input->post('active'),	
	        	);

	    $update = $this->model_supplier->update($supplier_id, $data);
        
        if($update == true) {
            //--> Log Action
            $this->model_log->create(array(
                'supplier_fk' => $supplier_id,
                'subject_fk' => $supplier_id,      
                'action' => 'Update',
                'attributes' => serialize(array('old' => $old_data,'new' => $data)),
                'module' => $this->log_module,
                'remark' => 'Update Supplier ' . $supplier_id,
                'updated_by' => $this->session->user_id, 
            ));
            $this->session->set_flashdata('success', 'Successfully updated');

            redirect('supplier/update/'.$supplier_id, 'refresh');
        }
        else {
            $this->session->set_flashdata('errors', 'Error occurred!!');
            redirect('supplier/', 'refresh');
        }
    }
    else {

    	$supplier_data = $this->model_supplier->getSupplierData($supplier_id);
        $this->data['supplier_data'] = $supplier_data;

        $this->render_template('supplier/edit', $this->data); 
    }   
}

	
public function remove()
{
    if(!in_array('deleteSupplier', $this->permission)) {redirect('dashboard', 'refresh');}
    
    $supplier_id = $this->input->post('supplier_id');

    $response = array();

    if($supplier_id) {
            //---> Validate if the information is used in another table
            $total_used = $this->model_supplier->checkIntegrity($supplier_id);
            //---> If no table has this information, we can delete
            if ($total_used == 0) {   
                //--> Get the old data before deleting
                $old_data = $this->model_supplier->getSupplierData($supplier_id);     
                $delete = $this->model_supplier->remove($supplier_id);
                if($delete == true) {
                    $response['success'] = true;
                    $response['messages'] = 'Successfully deleted';
                    //--> Log Action
                    $this->model_log->create(array(
                        'supplier_fk' => $supplier_id,
                        'subject_fk' => $supplier_id,      
                        'action' => 'Delete',
                        'attributes' => serialize($old_data),
                        'module' => $this->log_module,
                        'remark' => 'Delete Supplier ' . $supplier_id,
                        'updated_by' => $this->session->user_id, 
                    ));
                }
                else {
                    $response['success'] = false;
                    $response['messages'] ='Error in the database while deleting the information';}
                }

            else {
                //---> There is at least one license having this information
                $response['success'] = false;
                $response['messages'] = 'At least one order uses this information.  You cannot delete.';}

        }
        else {
            $response['success'] = false;
            $response['messages'] = 'Refresh the page again';}

        echo json_encode($response);
    }




	 //--> Redirects to the timeline

    public function timeline($supplier_id)
    {
        if(!in_array('viewSupplier', $this->permission)) {redirect('dashboard', 'refresh');}

        $timeline_data = $this->model_log->timeline_supplier($supplier_id); 
        $this->data['timeline_data'] = $timeline_data;
        $this->render_template('timeline', $this->data);
    }



	//-------------------------------------   DOCUMENT ------------------------------------------------------

    
    //--> It Fetches the document data from the document table 
    //    this function is called from the datatable ajax function
    
    public function fetchSupplierDocument()
    {
        $result = array('data' => array());

        $supplier_id = $this->input->post('document_supplier_id');

        $data = $this->model_supplier->getSupplierDocument($supplier_id);  

        foreach ($data as $key => $value) {

            $link = base_url('upload/suppliers/'.$supplier_id.'/'.$value['doc_name']);
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



    //-->  This function is invoked from another function to upload the documents into the suppliers folder
    //     of the supplier

    public function uploadDocument()
    {

        if(!in_array('updateDocument', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $directory = $this->session->directory;
        $config['upload_path'] = './'.$directory;
        $config['allowed_types'] = 'gif|jpg|png|pdf|xls|xlsx|docx|doc|pptx';
        $config['max_size'] = '6000';        

        $this->load->library('upload', $config);

        if ( ! $this->upload->do_upload('supplier_document')) {
            $msg_error ='This type of document is not allowed or the document is too large.'; 
            $this->session->set_flashdata('warning', $msg_error);
            redirect('supplier/update/'.$this->session->supplier_id, 'refresh');
            }
        else
            {
            //---> Create the document in the table document
           
            $doc_link = $directory.$this->upload->data('file_name');

            $data = array(
                'supplier_fk' => $this->session->supplier_id, 
                'doc_size' => $this->upload->data('file_size'),
                'doc_type' => $this->upload->data('file_type'),
                'doc_name' => $this->upload->data('file_name'),
                'updated_by' => $this->session->user_id,                 
            );

            $create = $this->model_supplier->createDocument($data);
            
            if($create == true) {
                //--->  Upload the document
                $data = array('upload_data' => $this->upload->data());
                redirect('supplier/update/'.$this->session->supplier_id."?tab=document", 'refresh');}
            else {
                $msg_error = 'Error occurred'; 
                $this->session->set_flashdata('error', $msg_error);
                redirect('supplier/', 'refresh');}
        }
    } 



    public function removeDocument()
    {
        if(!in_array('deleteDocument', $this->permission)) {redirect('dashboard', 'refresh');}
        
        $document_id = $this->input->post('document_id');
        $response = array();

        if($document_id) {
           //--> Get the link of the document for deleting the document on the directory
            $document_data = $this->model_supplier->getDocument($document_id);
            $doc_link = '/upload/suppliers/'.$document_data['supplier_fk'].'/'.$document_data['doc_name'];
            unlink(FCPATH . $doc_link);
            //--> Delete the document in the document table
            $delete = $this->model_supplier->removeDocument($document_id);
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