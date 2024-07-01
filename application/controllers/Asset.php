<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Asset extends Admin_Controller
{
	public function __construct()
	{
		parent::__construct();

		$this->not_logged_in();

		$this->data['page_title'] = 'Asset';
        $this->data['active_tab'] = $this->input->get('tab') ?? 'asset';
        $this->log_module = 'Asset';
        
	}

	public function index()
	{
        if(!in_array('viewAsset', $this->permission)) {redirect('dashboard', 'refresh');}

		$this->render_template('asset/index', $this->data);	
	}



    public function fetchAssetDataById($asset_id) 
    {
        if($asset_id) {
            $data = $this->model_asset->getAssetData($asset_id);
            echo json_encode($data);
        }

        return false;
    }


	public function fetchAssetData()
	{
		$result = array('data' => array());

		$data = $this->model_asset->getAssetData();

		foreach ($data as $key => $value) {

            $asset_name = $value['asset_name'];

            $buttons = '';

            if(in_array('updateAsset', $this->permission)) {
    			$buttons .= '<a href="'.base_url('asset/update/'.$value['asset_id']).'" class="btn btn-default"><i class="fa fa-pencil"></i></a>';
                $asset_name = '<a href="'.base_url('asset/update/'.$value['asset_id']).'">'.$value['asset_name'].'</a>';
                $buttons .= '<a href="'.base_url('asset/timeline/'.$value['asset_id']).'" class="btn btn-default"><i class="fa fa-clock-o"></i></a>';
            }

            if(in_array('deleteAsset', $this->permission)) { 
    			$buttons .= ' <button type="button" class="btn btn-default" onclick="removeFunc('.$value['asset_id'].')" data-toggle="modal" data-target="#removeModal"><i class="fa fa-trash"></i></button>';
            }

            if(in_array('viewAsset', $this->permission)) {
                $buttons .= '<a href="'.base_url('report_asset/report_asset/'.$value['asset_id']).'" target="_blank" class="btn btn-default"><i class="fa fa-print"></i></a>';} 
            

			$result['data'][$key] = array(
                $asset_name,
                $value['asset_code'],
                $value['description'], 			
				$value['asset_value'],
                $value['asset_quantity'],                
				$buttons
			);
            // For conversion only, to delete after conversion
            // This will create directory for all asset
            $path = "./upload/assets/".$value['asset_id'];
            if(!is_dir($path))  {mkdir($path,0755,TRUE);}
		} // /foreach

		echo json_encode($result);
	}	


	public function create()
	{
		if(!in_array('createAsset', $this->permission)) {redirect('dashboard', 'refresh');}

		$this->form_validation->set_rules('asset_name', 'Asset name', 'trim|required');
		$this->form_validation->set_rules('asset_value', 'Value', 'trim|required');
        $this->form_validation->set_error_delimiters('<p class="alert alert-warning">','</p>');


        if ($this->form_validation->run() == TRUE) { 

            $data = array(  
            'availability_fk' => (($this->input->post('availability') != FALSE) ? $this->input->post('availability') : NULL), 
            'location_fk' => $this->input->post('location'),'location_fk' => (($this->input->post('location') != FALSE) ? $this->input->post('location') : NULL),  
            'asset_type_fk' => (($this->input->post('asset_type') != FALSE) ? $this->input->post('asset_type') : NULL), 
            'acquisition_date' => (($this->input->post('acquisition_date') != FALSE) ? $this->input->post('acquisition_date') : NULL),
            'brand' => (($this->input->post('brand') != FALSE) ? $this->input->post('brand') : NULL),           
            'description' => (($this->input->post('description') != FALSE) ? $this->input->post('description') : NULL),         
            'asset_value' => $this->input->post('asset_value'),
            'expiration_date' => (($this->input->post('expiration_date') != FALSE) ? $this->input->post('expiration_date') : NULL),
            'asset_code' => (($this->input->post('asset_code') != FALSE) ? $this->input->post('asset_code') : NULL), 
            'serial_number' => (($this->input->post('serial_number') != FALSE) ? $this->input->post('serial_number') : NULL),        
            'asset_name' => $this->input->post('asset_name'),
            'remark' => (($this->input->post('remark') != FALSE) ? $this->input->post('remark') : NULL), 
            'asset_quantity' => (($this->input->post('asset_quantity') != FALSE) ? $this->input->post('asset_quantity') : NULL),                 
            'updated_by' => $this->session->userdata('user_id'),
            );

            $asset_id = $this->model_asset->create($data);

            if($asset_id == false) {
                $msg_error = 'Error occurred'; 
                $this->session->set_flashdata('error', $msg_error);
                redirect('asset/create', 'refresh');}
            else {
                //The create return the id created if it's successful
                //--> Log Action
                $this->model_log->create(array(
                    'asset_fk' => $asset_id,
                    'subject_fk' => $asset_id,      
                    'action' => 'Create',
                    'attributes' => serialize($data),
                    'module' => $this->log_module,
                    'remark' => 'Create Asset ' . $asset_id,
                    'updated_by' => $this->session->user_id, 
                ));   
                //---> Create the directory for deposit of documents-->
                $path = "./upload/assets/".$asset_id;
                //---> Create the folder if it does not exists
                if(!is_dir($path))  {mkdir($path,0755,TRUE);}                 
                redirect('asset/update/'.$asset_id, 'refresh');}
        }

        else {
            // false case        	
			$this->data['category'] = $this->model_category->getActiveCategory();  
            $this->data['availability'] = $this->model_availability->getActiveAvailability(); 
            $this->data['location'] = $this->model_location->getActiveLocation();  
            $this->data['asset_type'] = $this->model_asset_type->getActiveAssetType();        

            $this->render_template('asset/create', $this->data);
        }	
	}

    

	public function update($asset_id)
	{      
        if(!in_array('updateAsset', $this->permission)) {redirect('dashboard', 'refresh');}

        if(!$asset_id) {redirect('dashboard', 'refresh');}

        //--> Get the old data before updating
        $old_data = $this->model_asset->getAssetData($asset_id);

        $this->form_validation->set_rules('asset_name', 'Asset name', 'trim|required');
        $this->form_validation->set_rules('asset_value', 'Value', 'trim|required');
        $this->form_validation->set_error_delimiters('<p class="alert alert-warning">','</p>');

        if ($this->form_validation->run() == TRUE) {
            $data = array(
                'availability_fk' => $this->input->post('availability'),'availability_fk' => (($this->input->post('availability') != FALSE) ? $this->input->post('availability') : NULL),
                'location_fk' => $this->input->post('location'),'location_fk' => (($this->input->post('location') != FALSE) ? $this->input->post('location') : NULL),
                'asset_type_fk' => $this->input->post('asset_type'),'asset_type_fk' => (($this->input->post('asset_type') != FALSE) ? $this->input->post('asset_type') : NULL),             
                'asset_code' => (($this->input->post('asset_code') != FALSE) ? $this->input->post('asset_code') : NULL), 
                'acquisition_date' => (($this->input->post('acquisition_date') != FALSE) ? $this->input->post('acquisition_date') : NULL),
                'brand' => (($this->input->post('brand') != FALSE) ? $this->input->post('brand') : NULL),
                'description' => (($this->input->post('description') != FALSE) ? $this->input->post('description') : NULL),         
                'asset_value' => $this->input->post('asset_value'),
                'serial_number' => (($this->input->post('serial_number') != FALSE) ? $this->input->post('serial_number') : NULL),
                'expiration_date' => (($this->input->post('expiration_date') != FALSE) ? $this->input->post('expiration_date') : NULL),
                'asset_quantity' => (($this->input->post('asset_quantity') != FALSE) ? $this->input->post('asset_quantity') : NULL),
                'asset_code' => (($this->input->post('asset_code') != FALSE) ? $this->input->post('asset_code') : NULL), 
                'asset_name' => $this->input->post('asset_name'),
                'remark' => (($this->input->post('remark') != FALSE) ? $this->input->post('remark') : NULL),            
                'updated_by' => $this->session->userdata('user_id'),
            );
            $update = $this->model_asset->update($asset_id, $data);
            
            if($update == true) {
                $this->session->set_flashdata('success', 'Successfully updated');
                //--> Log Action
                $this->model_log->create(array(
                    'asset_fk' => $asset_id,
                    'subject_fk' => $asset_id,      
                    'action' => 'Update',
                    'attributes' => serialize(array('old' => $old_data,'new' => $data)),
                    'module' => $this->log_module,
                    'remark' => 'Update Asset ' . $asset_id,
                    'updated_by' => $this->session->user_id, 
                ));
                redirect('asset/update/'.$this->session->asset_id, 'refresh');
            }
            else {
                $this->session->set_flashdata('errors', 'Error occurred!!');
                redirect('asset/', 'refresh');
            }
        }
        else {
            
     
            $this->data['category'] = $this->model_category->getActiveCategory(); 
            $this->data['availability'] = $this->model_availability->getActiveAvailability(); 
            $this->data['location'] = $this->model_location->getActiveLocation();  
            $this->data['asset_type'] = $this->model_asset_type->getActiveAssetType();              

            $asset_data = $this->model_asset->getAssetData($asset_id);
            $this->data['asset_data'] = $asset_data;

            $this->render_template('asset/edit', $this->data); 
        }   
	}


public function remove()
{
    if(!in_array('deleteAsset', $this->permission)) {redirect('dashboard', 'refresh');}
    
    $asset_id = $this->input->post('asset_id');

    $response = array();

    if($asset_id) {
        //---> Validate if the information is used in another table
        //$total_used = $this->model_asset->checkIntegrity($asset_id);
        $total_used = 0;
        //---> If no table has this information, we can delete
        if ($total_used == 0) {   
            //--> Get the old data before deleting
            $old_data = $this->model_asset->getAssetData($asset_id);     
            $delete = $this->model_asset->remove($asset_id);
            if($delete == true) {
                $response['success'] = true;
                $response['messages'] = 'Successfully deleted';
                //--> Log Action
                $this->model_log->create(array(
                    'asset_fk' => $asset_id,
                    'subject_fk' => $asset_id,      
                    'action' => 'Delete',
                    'attributes' => serialize($old_data),
                    'module' => $this->log_module,
                    'remark' => 'Delete Asset ' . $asset_id,
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

    public function timeline($asset_id)
    {
        if(!in_array('viewAsset', $this->permission)) {redirect('dashboard', 'refresh');}

        $timeline_data = $this->model_log->timeline_asset($asset_id); 
        $this->data['timeline_data'] = $timeline_data;
        $this->render_template('timeline', $this->data);
    }


 


//----------------------------------------------------------- Maintenance ------------------------------------------------------------------>


    public function fetchMaintenanceData($asset_id) 
    {

        $result = array('data' => array());

        $data = $this->model_maintenance->getMaintenance($asset_id);

        foreach ($data as $key => $value) {

            $buttons = '';

            if(in_array('deleteMaintenance', $this->permission)) { 
                $buttons .= ' <button type="button" class="btn btn-default" onclick="removeFunc('.$value['maintenance_id'].')" data-toggle="modal" data-target="#removeModal"><i class="fa fa-trash"></i></button>';
            }
            $result['data'][$key] = array(
                $value['maintenance_date'],
                $value['maintenance_name'],
                $value['remark'],
                $value['status_name'],
                $value['type_maintenance'],
                $buttons,
            );
        } 

        echo json_encode($result);
    }   


   




//-------------------------------------   DOCUMENT ------------------------------------------------------

    
    //--> It Fetches the document data from the document table 
    //    this function is called from the datatable ajax function
    
    public function fetchAssetDocument()
    {
        $result = array('data' => array());

        $asset_id = $this->input->post('document_asset_id');

        $data = $this->model_asset->getAssetDocument($asset_id);  

        foreach ($data as $key => $value) {

            $link = base_url('upload/assets/'.$asset_id.'/'.$value['doc_name']);
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



    //-->  This function is invoked from another function to upload the documents into the assets folder
    //     of the asset

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

        if ( ! $this->upload->do_upload('asset_document')) {
            $msg_error ='This type of document is not allowed or the document is too large.'; 
            $this->session->set_flashdata('warning', $msg_error);
            redirect('asset/update/'.$this->session->asset_id, 'refresh');
            }
        else
            {
            //---> Create the document in the table document
           
            $doc_link = $directory.$this->upload->data('file_name');

            $data = array(
                'asset_fk' => $this->session->asset_id, 
                'doc_size' => $this->upload->data('file_size'),
                'doc_type' => $this->upload->data('file_type'),
                'doc_name' => $this->upload->data('file_name'),
                'updated_by' => $this->session->user_id,                 
            );

            $create = $this->model_asset->createDocument($data);
            
            if($create == true) {
                //--->  Upload the document
                $data = array('upload_data' => $this->upload->data());
                redirect('asset/update/'.$this->session->asset_id."?tab=document", 'refresh');}
            else {
                $msg_error = 'Error occurred'; 
                $this->session->set_flashdata('error', $msg_error);
                redirect('asset/', 'refresh');}
        }
    } 



    public function removeDocument()
    {
        if(!in_array('deleteDocument', $this->permission)) {redirect('dashboard', 'refresh');}
        
        $document_id = $this->input->post('document_id');
        $response = array();

        if($document_id) {
            //--> Get the link of the document for deleting the document on the directory
            $document_data = $this->model_asset->getDocument($document_id);
            $doc_link = '/upload/assets/'.$document_data['asset_fk'].'/'.$document_data['doc_name'];
            unlink(FCPATH . $doc_link);
            //--> Delete the document in the document table
            $delete = $this->model_asset->removeDocument($document_id);
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