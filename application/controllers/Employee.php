<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Employee extends Admin_Controller
{
public function __construct()
{
	parent::__construct();

	$this->not_logged_in();

	$this->data['page_title'] = 'Employee';
    $this->data['active_tab'] = $this->input->get('tab') ?? 'employee';
    $this->log_module = 'Employee';
    
}

public function index()
{
    if(!in_array('viewEmployee', $this->permission)) {redirect('dashboard', 'refresh');}

	$this->render_template('employee/index', $this->data);	
}


//-->  For creation of drop-down list 

public function fetchActiveEmployee() 
{
    $data = $this->model_employee->getActiveEmployee();
    echo json_encode($data);

}


public function fetchEmployeeDataById($employee_id) 
{
    if($employee_id) {
        $data = $this->model_employee->getEmployeeData($employee_id);
        echo json_encode($data);
    }

    return false;
}


public function fetchEmployeeData()
{
	$result = array('data' => array());

	$data = $this->model_employee->getEmployeeData();

	foreach ($data as $key => $value) {

        $employee_name = $value['employee_name'];

        $buttons = '';

        if(in_array('updateEmployee', $this->permission)) {
			$buttons .= '<a href="'.base_url('employee/update/'.$value['employee_id']).'" class="btn btn-default"><i class="fa fa-pencil"></i></a>';
            $employee_name = '<a href="'.base_url('employee/update/'.$value['employee_id']).'">'.$value['employee_name'].'</a>';
            $buttons .= '<a href="'.base_url('employee/timeline/'.$value['employee_id']).'" class="btn btn-default"><i class="fa fa-clock-o"></i></a>';
        }

        if(in_array('deleteEmployee', $this->permission)) { 
			$buttons .= ' <button type="button" class="btn btn-default" onclick="removeFunc('.$value['employee_id'].')" data-toggle="modal" data-target="#removeModal"><i class="fa fa-trash"></i></button>';
        }

        if(in_array('viewEmployee', $this->permission)) {
            $buttons .= '<a href="'.base_url('report_employee/report_employee/'.$value['employee_id']).'" target="_blank" class="btn btn-default"><i class="fa fa-print"></i></a>';} 

        $active = ($value['active'] == 1) ? '' : '<span class="label label-warning">'.'Inactive'.'</span>';    
		

		$result['data'][$key] = array(
            $employee_name,
            $value['employee_code'],
            $value['employee_type_name'],
            $value['area_name'],
            $value['municipality_name'], 			
			$value['phone'],
            $value['email'],
            $active,                
			$buttons
		);
        // For conversion only, to delete after conversion
        // This will create directory for all customer
        $path = "./upload/employees/".$value['employee_id'];
        if(!is_dir($path))  {mkdir($path,0755,TRUE);}
	} // /foreach

	echo json_encode($result);
}	


public function create()
{
    if(!in_array('createEmployee', $this->permission)) {redirect('dashboard', 'refresh');}

    $this->form_validation->set_rules('first_name', 'First Name', 'trim|required');
    $this->form_validation->set_rules('last_name', 'Last name', 'trim|required');
    $this->form_validation->set_error_delimiters('<p class="alert alert-warning">','</p>');


    if ($this->form_validation->run() == TRUE) {   

        $data = array(
        'active' => $this->input->post('active'),
        'area_fk' => (($this->input->post('area') != FALSE) ? $this->input->post('area') : NULL),
        'employee_type_fk' => (($this->input->post('employee_type') != FALSE) ? $this->input->post('employee_type') : NULL),
        'employee_status_fk' => (($this->input->post('employee_status') != FALSE) ? $this->input->post('employee_status') : NULL),
        'municipality_fk' => (($this->input->post('municipality') != FALSE) ? $this->input->post('municipality') : NULL),    
        'position_fk' => (($this->input->post('position') != FALSE) ? $this->input->post('position') : NULL),  
        'department_fk' => (($this->input->post('department') != FALSE) ? $this->input->post('department') : NULL),  
        'address' => (($this->input->post('address') != FALSE) ? $this->input->post('address') : NULL),
        'birthday' => (($this->input->post('birthday') != FALSE) ? $this->input->post('birthday') : NULL),
        'email' => (($this->input->post('email') != FALSE) ? $this->input->post('email') : NULL),
        'first_name' => (($this->input->post('first_name') != FALSE) ? $this->input->post('first_name') : NULL),
        'last_name' => (($this->input->post('last_name') != FALSE) ? $this->input->post('last_name') : NULL),
        'employee_code' => (($this->input->post('employee_code') != FALSE) ? $this->input->post('employee_code') : NULL),
        'employment_date' => (($this->input->post('employment_date') != FALSE) ? $this->input->post('employment_date') : NULL),
        'gender' => (($this->input->post('gender') != FALSE) ? $this->input->post('gender') : NULL),
        'pag_ibig' => (($this->input->post('pag_ibig') != FALSE) ? $this->input->post('pag_ibig') : NULL),
        'phil_health' => (($this->input->post('phil_health') != FALSE) ? $this->input->post('phil_health') : NULL),    
        'phone' => (($this->input->post('phone') != FALSE) ? $this->input->post('phone') : NULL),
        'remark' => (($this->input->post('remark') != FALSE) ? $this->input->post('remark') : NULL),          
        'sss' => (($this->input->post('sss') != FALSE) ? $this->input->post('sss') : NULL),
        'tin' => (($this->input->post('tin') != FALSE) ? $this->input->post('tin') : NULL),     
        'updated_by' => $this->session->userdata('user_id'),
        ); 
        
        $employee_id = $this->model_employee->create($data);

        if($employee_id == false) {
            $msg_error = 'Error occurred'; 
            $this->session->set_flashdata('error', $msg_error);
            redirect('employee/create', 'refresh');}
        else {
            //---> Create the directory for deposit of documents-->
            $path = "./upload/employees/".$employee_id;
            //---> Create the folder if it does not exists
            if(!is_dir($path))  {mkdir($path,0755,TRUE);}  
            //--> Log Action
            $this->model_log->create(array(
                'employee_fk' => $employee_id,
                'subject_fk' => $employee_id,      
                'action' => 'Create',
                'attributes' => serialize($data),
                'module' => $this->log_module,
                'remark' => 'Create Employee ' . $employee_id,
                'updated_by' => $this->session->user_id, 
            ));               
            redirect('employee/update/'.$employee_id, 'refresh');
            }
          }

        else {
        // false case        	
       
        $this->data['municipality'] = $this->model_municipality->getActiveMunicipality(); 
        $this->data['area'] = $this->model_area->getActiveArea(); 
        $this->data['employee_type'] = $this->model_employee_type->getActiveEmployeeType();
        $this->data['employee_status'] = $this->model_employee_status->getActiveEmployeeStatus();
        $this->data['position'] = $this->model_position->getActivePosition(); 
        $this->data['department'] = $this->model_department->getActiveDepartment(); 

        $generate_code = $this->model_employee->generateEmployeeCode();
        $this->data['generate_code'] = $generate_code;     	

        $this->render_template('employee/create', $this->data);
    }	
}



public function update($employee_id)
{      
    if(!in_array('updateEmployee', $this->permission)) {redirect('dashboard', 'refresh');}

    if(!$employee_id) {redirect('dashboard', 'refresh');}

    //--> Get the old data before updating
    $old_data = $this->model_employee->getEmployeeData($employee_id);

    $this->form_validation->set_rules('first_name', 'First Name', 'trim|required');
    $this->form_validation->set_rules('last_name', 'Last name', 'trim|required');
    $this->form_validation->set_error_delimiters('<p class="alert alert-warning">','</p>');

    if ($this->form_validation->run() == TRUE) {
        $data = array(
        'active' => $this->input->post('active'),
        'area_fk' => (($this->input->post('area') != FALSE) ? $this->input->post('area') : NULL),
        'employee_type_fk' => (($this->input->post('employee_type') != FALSE) ? $this->input->post('employee_type') : NULL),
        'employee_status_fk' => (($this->input->post('employee_status') != FALSE) ? $this->input->post('employee_status') : NULL),
        'municipality_fk' => (($this->input->post('municipality') != FALSE) ? $this->input->post('municipality') : NULL),    
        'position_fk' => (($this->input->post('position') != FALSE) ? $this->input->post('position') : NULL),  
        'address' => (($this->input->post('address') != FALSE) ? $this->input->post('address') : NULL),
        'birthday' => (($this->input->post('birthday') != FALSE) ? $this->input->post('birthday') : NULL),
        'email' => (($this->input->post('email') != FALSE) ? $this->input->post('email') : NULL),
        'first_name' => (($this->input->post('first_name') != FALSE) ? $this->input->post('first_name') : NULL),
        'last_name' => (($this->input->post('last_name') != FALSE) ? $this->input->post('last_name') : NULL),
        'employee_code' => (($this->input->post('employee_code') != FALSE) ? $this->input->post('employee_code') : NULL),
        'employment_date' => (($this->input->post('employment_date') != FALSE) ? $this->input->post('employment_date') : NULL),
        'gender' => (($this->input->post('gender') != FALSE) ? $this->input->post('gender') : NULL),
        'pag_ibig' => (($this->input->post('pag_ibig') != FALSE) ? $this->input->post('pag_ibig') : NULL),
        'phil_health' => (($this->input->post('phil_health') != FALSE) ? $this->input->post('phil_health') : NULL),    
        'phone' => (($this->input->post('phone') != FALSE) ? $this->input->post('phone') : NULL),
        'remark' => (($this->input->post('remark') != FALSE) ? $this->input->post('remark') : NULL),          
        'sss' => (($this->input->post('sss') != FALSE) ? $this->input->post('sss') : NULL),
        'tin' => (($this->input->post('tin') != FALSE) ? $this->input->post('tin') : NULL),     
        'updated_by' => $this->session->userdata('user_id'),
        );

        $update = $this->model_employee->update($employee_id, $data);
        
        if($update == true) {
            //--> Log Action
            $this->model_log->create(array(
                'employee_fk' => $employee_id,
                'subject_fk' => $employee_id,      
                'action' => 'Update',
                'attributes' => serialize(array('old' => $old_data,'new' => $data)),
                'module' => $this->log_module,
                'remark' => 'Update Employee ' . $employee_id,
                'updated_by' => $this->session->user_id, 
            ));
            $this->session->set_flashdata('success', 'Successfully updated');

            redirect('employee/update/'.$employee_id, 'refresh');
        }
        else {
            $this->session->set_flashdata('errors', 'Error occurred!!');
            redirect('employee/', 'refresh');
        }
    }
    else {
        
 
        $this->data['municipality'] = $this->model_municipality->getActiveMunicipality(); 
        $this->data['area'] = $this->model_area->getActiveArea(); 
        $this->data['employee_type'] = $this->model_employee_type->getActiveEmployeeType();
        $this->data['employee_status'] = $this->model_employee_status->getActiveEmployeeStatus();
        $this->data['position'] = $this->model_position->getActivePosition();             

        $employee_data = $this->model_employee->getEmployeeData($employee_id);
        $this->data['employee_data'] = $employee_data;

        $this->render_template('employee/edit', $this->data); 
    }   
}


public function remove()
{
    if(!in_array('deleteEmployee', $this->permission)) {redirect('dashboard', 'refresh');}
    
    $employee_id = $this->input->post('employee_id');

    $response = array();

    if($employee_id) {
            //---> Validate if the information is used in another table
            $total_used = $this->model_employee->checkIntegrity($employee_id);
            //---> If no table has this information, we can delete
            if ($total_used == 0) {   
                //--> Get the old data before deleting
                $old_data = $this->model_employee->getEmployeeData($employee_id);     
                $delete = $this->model_employee->remove($employee_id);
                if($delete == true) {
                    $response['success'] = true;
                    $response['messages'] = 'Successfully deleted';
                    //--> Log Action
                    $this->model_log->create(array(
                        'employee_fk' => $employee_id,
                        'subject_fk' => $employee_id,      
                        'action' => 'Delete',
                        'attributes' => serialize($old_data),
                        'module' => $this->log_module,
                        'remark' => 'Delete Employee ' . $employee_id,
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

    public function timeline($employee_id)
    {
        if(!in_array('viewEmployee', $this->permission)) {redirect('dashboard', 'refresh');}

        $timeline_data = $this->model_log->timeline_employee($employee_id); 
        $this->data['timeline_data'] = $timeline_data;
        $this->render_template('timeline', $this->data);
    }



//-------------------------------------   DOCUMENT ------------------------------------------------------

    
    //--> It Fetches the document data from the document table 
    //    this function is called from the datatable ajax function
    
    public function fetchEmployeeDocument()
    {
        $result = array('data' => array());

        $employee_id = $this->input->post('document_employee_id');

        $data = $this->model_employee->getEmployeeDocument($employee_id);  

        foreach ($data as $key => $value) {

            $link = base_url('upload/employees/'.$employee_id.'/'.$value['doc_name']);
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



    //-->  This function is invoked from another function to upload the documents into the employees folder
    //     of the employee

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

        if ( ! $this->upload->do_upload('employee_document')) {
            $msg_error ='This type of document is not allowed or the document is too large.'; 
            $this->session->set_flashdata('warning', $msg_error);
            redirect('employee/update/'.$this->session->employee_id, 'refresh');
            }
        else
            {
            //---> Create the document in the table document
           
            $doc_link = $directory.$this->upload->data('file_name');

            $data = array(
                'employee_fk' => $this->session->employee_id, 
                'doc_size' => $this->upload->data('file_size'),
                'doc_type' => $this->upload->data('file_type'),
                'doc_name' => $this->upload->data('file_name'),
                'updated_by' => $this->session->user_id,                 
            );

            $create = $this->model_employee->createDocument($data);
            
            if($create == true) {
                //--->  Upload the document
                $data = array('upload_data' => $this->upload->data());
                redirect('employee/update/'.$this->session->employee_id."?tab=document", 'refresh');}
            else {
                $msg_error = 'Error occurred'; 
                $this->session->set_flashdata('error', $msg_error);
                redirect('employee/', 'refresh');}
        }
    } 



    public function removeDocument()
    {
        if(!in_array('deleteDocument', $this->permission)) {redirect('dashboard', 'refresh');}
        
        $document_id = $this->input->post('document_id');
        $response = array();

        if($document_id) {
           //--> Get the link of the document for deleting the document on the directory
            $document_data = $this->model_employee->getDocument($document_id);
            $doc_link = '/upload/employees/'.$document_data['employee_fk'].'/'.$document_data['doc_name'];
            unlink(FCPATH . $doc_link);
            //--> Delete the document in the document table
            $delete = $this->model_employee->removeDocument($document_id);
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