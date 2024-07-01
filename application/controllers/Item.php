<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Item extends Admin_Controller
{
	public function __construct()
	{
		parent::__construct();

		$this->not_logged_in();

		$this->data['page_title'] = 'Item';
        $this->data['active_tab'] = $this->input->get('tab') ?? 'item';
        $this->log_module = 'Item';
        
	}

	public function index()
	{
        if(!in_array('viewItem', $this->permission)) {redirect('dashboard', 'refresh');}

		$this->render_template('item/index', $this->data);	
	}


    //-->  For creation of drop-down list 

    public function fetchActiveItem() 
    {
        $data = $this->model_item->getActiveItem();
        echo json_encode($data);

    }


    public function fetchItemDataById($item_id) 
    {
        if($item_id) {
            $data = $this->model_item->getItemData($item_id);
            echo json_encode($data);
        }

        return false;
    }


	public function fetchItemData()
	{
		$result = array('data' => array());

		$data = $this->model_item->getItemData();

		foreach ($data as $key => $value) {

            $item_name = $value['item_name'];

            $buttons = '';

            if(in_array('updateItem', $this->permission)) {
    			$buttons .= '<a href="'.base_url('item/update/'.$value['item_id']).'" class="btn btn-default"><i class="fa fa-pencil"></i></a>';
                $item_name = '<a href="'.base_url('item/update/'.$value['item_id']).'">'.$value['item_name'].'</a>';
                $buttons .= '<a href="'.base_url('item/timeline/'.$value['item_id']).'" class="btn btn-default"><i class="fa fa-clock-o"></i></a>';
            }

            if(in_array('deleteItem', $this->permission)) { 
    			$buttons .= ' <button type="button" class="btn btn-default" onclick="removeFunc('.$value['item_id'].')" data-toggle="modal" data-target="#removeModal"><i class="fa fa-trash"></i></button>';
            }

            if(in_array('viewItem', $this->permission)) {
                $buttons .= '<a href="'.base_url('report_item/report_item/'.$value['item_id']).'" target="_blank" class="btn btn-default"><i class="fa fa-print"></i></a>';} 

            // The parameter 2 will add new quantity for the item
            if(in_array('updateMovement', $this->permission)) {
                $buttons .= '<button type="button" class="btn btn-default" onclick="movement('.$value['item_id'].',1)" data-toggle="modal" data-target="#movementModal"><i class="fa fa-plus" title="I N  Inventory"></i></button>';    
            }

            // The parameter 1 will remove the quantity for the item
            if(in_array('updateMovement', $this->permission)) {
                $buttons .= '<button type="button" class="btn btn-default" onclick="movement('.$value['item_id'].',2)" data-toggle="modal" data-target="#movementModal"><i class="fa fa-minus" title="O U T  of Inventory"></i></button>';    
            }
			

            if ($value['inventory'] = 1 AND $value['ordering_point'] <> NULL AND $value['quantity'] <= $value['ordering_point'])     
                {$status = '<span class="label label-danger">Order !</span>';} 
            else { $status = '';}               

			$result['data'][$key] = array(
                $item_name,
                $value['item_code'],
                $value['category_name'],
                $value['unit_name'],    		
				$value['item_price'],
                $value['quantity'],  
                $value['ordering_point'],  
                $status,              
				$buttons
			);
		} // /foreach

		echo json_encode($result);
	}	


	public function create()
	{
		if(!in_array('createItem', $this->permission)) {redirect('dashboard', 'refresh');}

		$this->form_validation->set_rules('item_name', 'Item name', 'trim|required');
        $this->form_validation->set_rules('category', 'Category', 'trim|required');
		$this->form_validation->set_rules('item_price', 'Price', 'trim|required');       
        $this->form_validation->set_error_delimiters('<p class="alert alert-warning">','</p>');


        if ($this->form_validation->run() == TRUE) {   

            $data = array(
            'active' => $this->input->post('active'),  
            'inventory' => $this->input->post('inventory'),          
            'category_fk' => (($this->input->post('category') != FALSE) ? $this->input->post('category') : NULL),
            'supplier_fk' => (($this->input->post('supplier') != FALSE) ? $this->input->post('supplier') : NULL),
            'item_code' => (($this->input->post('item_code') != FALSE) ? $this->input->post('item_code') : NULL),
            'brand' => (($this->input->post('brand') != FALSE) ? $this->input->post('brand') : NULL),
            'ordering_point' => (($this->input->post('ordering_point') != FALSE) ? $this->input->post('ordering_point') : NULL),
            'safety_stock' => (($this->input->post('safety_stock') != FALSE) ? $this->input->post('safety_stock') : NULL),
            'price_date' => (($this->input->post('price_date') != FALSE) ? $this->input->post('price_date') : NULL),
            'description' => (($this->input->post('description') != FALSE) ? $this->input->post('description') : NULL),         
            'item_price' => $this->input->post('item_price'),
            'unit_fk' => (($this->input->post('unit') != FALSE) ? $this->input->post('unit') : NULL),
            'item_name' => $this->input->post('item_name'),
            'remark' => (($this->input->post('remark') != FALSE) ? $this->input->post('remark') : NULL),            
            'updated_by' => $this->session->userdata('user_id'),
            ); 

            $item_id = $this->model_item->create($data);

            if($item_id) {
                $this->session->set_flashdata('success', 'Successfully created');
                //--> Log Action
                $this->model_log->create(array(
                    'item_fk' => $item_id,
                    'subject_fk' => $item_id,      
                    'action' => 'Create',
                    'attributes' => serialize($data),
                    'module' => $this->log_module,
                    'remark' => 'Create Item ' . $item_id,
                    'updated_by' => $this->session->user_id, 
                ));   
                redirect('item/update/'.$item_id, 'refresh');
            }
            else {
                $this->session->set_flashdata('errors', 'Error occurred!!');
                redirect('item/', 'refresh');
            }

        }
        else {
            // false case           
            $this->data['category'] = $this->model_category->getActiveCategory();
            $this->data['supplier'] = $this->model_supplier->getActiveSupplier();   
            $this->data['unit'] = $this->model_unit->getActiveUnit();           
            $this->data['location'] = $this->model_location->getActiveLocation();       

            $this->render_template('item/create', $this->data);
        }   
    }




    

	public function update($item_id)
	{      
        if(!in_array('updateItem', $this->permission)) {redirect('dashboard', 'refresh');}

        if(!$item_id) {redirect('dashboard', 'refresh');}

        //--> Get the old data before updating
        $old_data = $this->model_item->getItemData($item_id);

        $this->form_validation->set_rules('item_name', 'Item name', 'trim|required');
        $this->form_validation->set_rules('category', 'Category', 'trim|required');
        $this->form_validation->set_rules('item_price', 'Price', 'trim|required');        
        $this->form_validation->set_error_delimiters('<p class="alert alert-warning">','</p>');

        if ($this->form_validation->run() == TRUE) {
            $data = array(
                'active' => $this->input->post('active'),
                'inventory' => $this->input->post('inventory'), 
                'category_fk' => (($this->input->post('category') != FALSE) ? $this->input->post('category') : NULL),
                'supplier_fk' => (($this->input->post('supplier') != FALSE) ? $this->input->post('supplier') : NULL),                
                'item_code' => (($this->input->post('item_code') != FALSE) ? $this->input->post('item_code') : NULL), 
                'brand' => (($this->input->post('brand') != FALSE) ? $this->input->post('brand') : NULL),
                'ordering_point' => (($this->input->post('ordering_point') != FALSE) ? $this->input->post('ordering_point') : NULL),
                'safety_stock' => (($this->input->post('safety_stock') != FALSE) ? $this->input->post('safety_stock') : NULL),
                'price_date' => (($this->input->post('price_date') != FALSE) ? $this->input->post('price_date') : NULL),
                'description' => (($this->input->post('description') != FALSE) ? $this->input->post('description') : NULL),         
                'item_price' => $this->input->post('item_price'),
                'unit_fk' => (($this->input->post('unit') != FALSE) ? $this->input->post('unit') : NULL),
                'item_name' => $this->input->post('item_name'),
                'remark' => (($this->input->post('remark') != FALSE) ? $this->input->post('remark') : NULL),            
                'updated_by' => $this->session->userdata('user_id'),
            );


            $update = $this->model_item->update($item_id, $data);
            
            if($update == true) {
                //--> Log Action
                $this->model_log->create(array(
                    'item_fk' => $item_id,
                    'subject_fk' => $item_id,      
                    'action' => 'Update',
                    'attributes' => serialize(array('old' => $old_data,'new' => $data)),
                    'module' => $this->log_module,
                    'remark' => 'Update Item ' . $item_id,
                    'updated_by' => $this->session->user_id, 
                ));
                $this->session->set_flashdata('success', 'Successfully updated');
                redirect('item/update/'.$item_id, 'refresh');
            }
            else {
                $this->session->set_flashdata('errors', 'Error occurred!!');
                redirect('item/', 'refresh');
            }
        }
        else {
            
     
            $this->data['category'] = $this->model_category->getActiveCategory(); 
            $this->data['supplier'] = $this->model_supplier->getActiveSupplier(); 
            $this->data['unit'] = $this->model_unit->getActiveUnit();             
            $this->data['location'] = $this->model_location->getActiveLocation();    

            $item_data = $this->model_item->getItemData($item_id);
            $this->data['item_data'] = $item_data;

            $this->render_template('item/edit', $this->data); 
        }   
    }




public function remove()
{
    if(!in_array('deleteItem', $this->permission)) {redirect('dashboard', 'refresh');}
    
    $item_id = $this->input->post('item_id');

    $response = array();

    if($item_id) {
        //---> Validate if the information is used in another table
        $total_used = $this->model_item->checkIntegrity($item_id);
        //---> If no table has this information, we can delete
        if ($total_used == 0) {   
            //--> Get the old data before deleting
            $old_data = $this->model_item->getItemData($item_id);     
            $delete = $this->model_item->remove($item_id);
            if($delete == true) {
                $response['success'] = true;
                $response['messages'] = 'Successfully deleted';
                //--> Log Action
                $this->model_log->create(array(
                    'item_fk' => $item_id,
                    'subject_fk' => $item_id,      
                    'action' => 'Delete',
                    'attributes' => serialize($old_data),
                    'module' => $this->log_module,
                    'remark' => 'Delete Item ' . $item_id,
                    'updated_by' => $this->session->user_id, 
                ));
            }
            else {
                $response['success'] = false;
                $response['messages'] ='Error in the database while deleting the information';}
            }

        else {
            //---> There is at least one movement having this information
            $response['success'] = false;
            $response['messages'] = 'At least one movement was found for this item.  You cannot delete.';}

        }
        else {
            $response['success'] = false;
            $response['messages'] = 'Refresh the page again';}

        echo json_encode($response);
    }


    //--> Redirects to the timeline

    public function timeline($item_id)
    {
        if(!in_array('viewItem', $this->permission)) {redirect('dashboard', 'refresh');}

        $timeline_data = $this->model_log->timeline_item($item_id); 
        $this->data['timeline_data'] = $timeline_data;
        $this->render_template('timeline', $this->data);
    }


 //---------------------------------- Item location ------------------------------------------------>


    //-->  For creation of drop-down list 

    public function fetchItemLocation($item_id) 
    {
        $data = $this->model_item->getItemLocationData($item_id);
        echo json_encode($data);

    }   


    public function fetchItemLocationDataById($item_location_id) 
    {
        if($item_location_id) {
            $data = $this->model_item->getItemLocationDataById($item_location_id);
            echo json_encode($data);
        }

        return false;
    }

    
    public function fetchItemLocationData($item_id)
    {
        $result = array('data' => array());

        $data = $this->model_item->getItemLocationData($item_id); 
        
        foreach ($data as $key => $value) {

            $location_name = $value['location_name'];

            $buttons = '';

            if(in_array('updateItem', $this->permission)) {
               $buttons .= '<button type="button" class="btn btn-default" onclick="editLocation('.$value['item_location_id'].')" data-toggle="modal" data-target="#editModalLocation"><i class="fa fa-pencil"></i></button>';
               $location_name ='  <a data-target="#editModalLocation" onclick="editLocation('.$value['item_location_id'].')" data-toggle="modal" href="#editModalLocation">'.$value['location_name'].'</a>';
            }   

   
            if(in_array('deleteItem', $this->permission)) { 
                $buttons .= ' <button type="button" class="btn btn-default" onclick="removeItemLocation('.$value['item_location_id'].')" data-toggle="modal" data-target="#removeModalLocation"><i class="fa fa-trash"></i></button>';
            }
  
            $result['data'][$key] = array(              
                $location_name,
                $value['quantity'],  
                $value['remark'],              
                $buttons
            );

        } // /foreach

        echo json_encode($result);
    } 


    public function createItemLocation()
    {
        if(!in_array('createItem', $this->permission)) {redirect('dashboard', 'refresh');}

        $this->form_validation->set_rules('location', 'Location', 'trim|required');
        $this->form_validation->set_rules('quantity', 'Quantity', 'trim|required');
        $this->form_validation->set_error_delimiters('<p class="alert alert-warning">','</p>');


        if ($this->form_validation->run() == TRUE) { 

            $data = array(  
            'item_fk' => $this->session->item_id,
            'location_fk' => $this->input->post('location'),    
            'quantity' => $this->input->post('quantity'),            
            'remark' => (($this->input->post('remark_location') != FALSE) ? $this->input->post('remark_location') : NULL), 
            );

            $create = $this->model_item->createItemLocation($data);

            if($create == true) 
                {$response['success'] = true;
                $response['messages'] = 'Successfully created';}
            else 
                {$response['success'] = false;
                $response['messages'] = 'Error in the database while creating the information';}            
            
        }
        else {
            $response['success'] = false;
            foreach ($_POST as $key => $value) {
                $response['messages'][$key] = form_error($key);
            }
        }

        echo json_encode($response);
   
    }


    public function updateItemLocation($item_location_id)
    {

        if(!in_array('updateItem', $this->permission)) {redirect('dashboard', 'refresh');}

        $response = array();

        if($item_location_id) {
            $this->form_validation->set_rules('edit_quantity', 'Quantity', 'trim|required');
            $this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');

            if ($this->form_validation->run() == TRUE) {
                $data = array(
                    'location_fk' => $this->input->post('edit_location'),
                    'quantity' => $this->input->post('edit_quantity'),            
                    'remark' => (($this->input->post('edit_remark_location') != FALSE) ? $this->input->post('edit_remark_location') : NULL), 
                );

                $update = $this->model_item->updateItemLocation($data, $item_location_id);
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


    //-->  Removes the maintenance_type information from the database 
    //     and returns the json format operation messages

    public function removeItemLocation()
    {
        if(!in_array('deleteItem', $this->permission)) {redirect('dashboard', 'refresh');}
        
        $item_location_id = $this->input->post('item_location_id');

        $response = array();

        if($item_location_id) {
            //---> Validate if the information is used in other table 
            $total_used = $this->model_item->checkIntegrityItemLocation($item_location_id);
            //---> If not used, we can delete
            if ($total_used == 0) {  
                //--> Get the old data before deleting
                $old_data = $this->model_item->getItemLocationDataById($item_location_id);      
                $delete = $this->model_item->removeItemLocation($item_location_id);
                if($delete == true) {
                    $response['success'] = true;
                    $response['messages'] = 'Successfully deleted';
                    //--> Log Action
                    $this->model_log->create(array(
                        'subject_fk' =>$item_location_id,      
                        'action' => 'Delete Item Location',
                        'attributes' => serialize($old_data),
                        'module' => $this->log_module,
                        'remark' => 'Delete Item Location ' . $item_location_id,
                        'updated_by' => $this->session->user_id, 
                    ));
                    }
                else {
                    $response['success'] = false;
                    $response['messages'] = 'Error in the database while deleting the information';}
                }

            else {
                //---> There is at least one table having this information
                $response['success'] = false;
                $response['messages'] = 'At least one order uses this information.  You cannot delete.';}

        }
        else {
            $response['success'] = false;
            $response['messages'] = 'Refresh the page again';}


        echo json_encode($response);
    

}



 //---------------------------------- Item ingredient ------------------------------------------------>


    //-->  For creation of drop-down list 

    public function fetchItemIngredient($item_id) 
    {
        $data = $this->model_item->getItemIngredientData($item_id);
        echo json_encode($data);

    }   


    public function fetchItemIngredientDataById($item_ingredient_id) 
    {
        if($item_ingredient_id) {
            $data = $this->model_item->getItemIngredientDataById($item_ingredient_id);
            echo json_encode($data);
        }

        return false;
    }

    
    public function fetchItemIngredientData($item_id)
    {
        $result = array('data' => array());

        $data = $this->model_item->getItemIngredientData($item_id);   

        foreach ($data as $key => $value) {

            $ingredient_name = $value['ingredient_name'];

            $buttons = '';

            if(in_array('updateItem', $this->permission)) {
               $buttons .= '<button type="button" class="btn btn-default" onclick="editIngredient('.$value['item_ingredient_id'].')" data-toggle="modal" data-target="#editModalIngredient"><i class="fa fa-pencil"></i></button>';
               $ingredient_name ='  <a data-target="#editModalIngredient" onclick="editIngredient('.$value['item_ingredient_id'].')" data-toggle="modal" href="#editModalIngredient">'.$value['ingredient_name'].'</a>';
            }   

   
            if(in_array('deleteItem', $this->permission)) { 
                $buttons .= ' <button type="button" class="btn btn-default" onclick="removeItemIngredient('.$value['item_ingredient_id'].')" data-toggle="modal" data-target="#removeModalIngredient"><i class="fa fa-trash"></i></button>';
            }
  
            $result['data'][$key] = array(              
                $ingredient_name,
                $value['formula'],
                $value['remark'],              
                $buttons
            );

        } // /foreach

        echo json_encode($result);
    } 


    public function createItemIngredient()
    {
        if(!in_array('createItem', $this->permission)) {redirect('dashboard', 'refresh');}

        $this->form_validation->set_rules('ingredient', 'Ingredient', 'trim|required');
        $this->form_validation->set_error_delimiters('<p class="alert alert-warning">','</p>');


        if ($this->form_validation->run() == TRUE) { 

            $data = array(  
            'item_fk' => $this->session->item_id,
            'ingredient_fk' => $this->input->post('ingredient'),    
            'remark' => (($this->input->post('remark_ingredient') != FALSE) ? $this->input->post('remark_ingredient') : NULL), 
            );

            $create = $this->model_item->createItemIngredient($data);

            if($create == true) 
                {$response['success'] = true;
                $response['messages'] = 'Successfully created';}
            else 
                {$response['success'] = false;
                $response['messages'] = 'Error in the database while creating the information';}            
            
        }
        else {
            $response['success'] = false;
            foreach ($_POST as $key => $value) {
                $response['messages'][$key] = form_error($key);
            }
        }

        echo json_encode($response);
   
    }


    public function updateItemIngredient($item_ingredient_id)
    {

        if(!in_array('updateItem', $this->permission)) {redirect('dashboard', 'refresh');}

        $response = array();

        if($item_ingredient_id) {
            $this->form_validation->set_rules('edit_ingredient', 'Ingredient', 'trim|required');
            $this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');

            if ($this->form_validation->run() == TRUE) {
                $data = array(
                    'ingredient_fk' => $this->input->post('edit_ingredient'),
                    'remark' => (($this->input->post('edit_remark_ingredient') != FALSE) ? $this->input->post('edit_remark_ingredient') : NULL), 
                );

                $update = $this->model_item->updateItemIngredient($data, $item_ingredient_id);
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


    //-->  Removes the information from the database 
    //     and returns the json format operation messages

    public function removeItemIngredient()
    {
        if(!in_array('deleteItem', $this->permission)) {redirect('dashboard', 'refresh');}
        
        $item_ingredient_id = $this->input->post('item_ingredient_id');

        $response = array();

        if($item_ingredient_id) {
            
            //--> Get the old data before deleting
            $old_data = $this->model_item->getItemIngredientDataById($item_ingredient_id);      
            $delete = $this->model_item->removeItemIngredient($item_ingredient_id);
            if($delete == true) {
                $response['success'] = true;
                $response['messages'] = 'Successfully deleted';
                //--> Log Action
                $this->model_log->create(array(
                    'subject_fk' =>$item_ingredient_id,      
                    'action' => 'Delete Item Ingredient',
                    'attributes' => serialize($old_data),
                    'module' => $this->log_module,
                    'remark' => 'Delete Item Ingredient ' . $item_ingredient_id,
                    'updated_by' => $this->session->user_id, 
                ));
                }
            else {
                $response['success'] = false;
                $response['messages'] = 'Error in the database while deleting the information';}
            }            
        else {
            $response['success'] = false;
            $response['messages'] = 'Refresh the page again';}


        echo json_encode($response);
    

}


 //--------------------------------------- Movement -------------------------------------------------->


    public function fetchMovementData($item_id) 
    {

        $result = array('data' => array());

        $date_from = $this->input->get('date_from') ?? NULL;
        $date_to = $this->input->get('date_to') ?? NULL;
        $in_out = $this->input->get('in_out') ?? NULL;

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

        //--> Criteria inventory (type movement)
        if ($in_out == 'all') {
            $in_out_from = "1";
            $in_out_to = "2";
        }
        else {
            $in_out_from = $in_out;
            $in_out_to = $in_out;
        }

        $data = $this->model_item->getMovement($item_id, $date_from, $date_to, $in_out_from, $in_out_to);

        foreach ($data as $key => $value) {

            $buttons = '';
            $order_no = $value['order_no'];
            $requisition_no = $value['requisition_no'];
            $delivery_no = $value['delivery_no'];
            $customer_name = $value['customer_name'];
            $supplier_name = $value['supplier_name'];
            $employee_name = $value['employee_name'];

             if(in_array('deleteMovement', $this->permission) 
                    and $value['order_no'] == null 
                    and $value['requisition_no'] == null 
                    and $value['delivery_no'] == null) { 
                $buttons .= ' <button type="button" class="btn btn-default" onclick="removeMovementItem('.$value['movement_id'].')" data-toggle="modal" data-target="#removeModalItem"><i class="fa fa-trash"></i></button>';
            }

            if(in_array('updateOrder', $this->permission)) {
                $order_no = '<a href="'.base_url('order/update/'.$value['order_fk']).'">'.$value['order_no'].'</a>';
                $requisition_no = '<a href="'.base_url('requisition/update/'.$value['requisition_fk']).'">'.$value['requisition_no'].'</a>';
                $delivery_no = '<a href="'.base_url('delivery/update/'.$value['delivery_fk']).'">'.$value['delivery_no'].'</a>';
                $customer_name = '<a href="'.base_url('customer/update/'.$value['customer_id']).'">'.$value['customer_name'].'</a>';
                $supplier_name = '<a href="'.base_url('supplier/update/'.$value['supplier_id']).'">'.$value['supplier_name'].'</a>';
                $employee_name = '<a href="'.base_url('employee/update/'.$value['employee_id']).'">'.$value['employee_name'].'</a>';
                } 

            $result['data'][$key] = array(
                $value['date_movement'],
                $value['location_name'],
                $value['type_movement'].' '.$value['quantity'],
                $value['price'],
                $order_no,
                $customer_name,                
                $requisition_no,
                $employee_name,
                $delivery_no,
                $supplier_name,
                $buttons,
            );
        } 

        echo json_encode($result);
    }     


    public function movement()
    {

        if(!in_array('updateMovement', $this->permission)) {redirect('dashboard', 'refresh');}


        $response = array();

        $this->form_validation->set_rules('item_location_movement', 'Location', 'trim|required');
        $this->form_validation->set_rules('item_quantity_movement', 'Quantity', 'trim|required');
        $this->form_validation->set_rules('item_date_movement', 'Date of movement', 'trim|required');
        $this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');

        if ($this->form_validation->run() == TRUE) {
            $data = array(
                'item_location_fk' => (($this->input->post('item_location_movement') != FALSE) ? $this->input->post('item_location_movement') : NULL), 
                'type_movement' => $this->input->post('item_type_movement'),
                'quantity' => $this->input->post('item_quantity_movement'),  
                'rate' => $this->input->post('item_rate_movement'), 
                'date_movement' => $this->input->post('item_date_movement'),
                'remark' => $this->input->post('item_remark_movement'),
                'updated_by' => $this->session->userdata('user_id'),     
            );

            $create = $this->model_item->createMovement($data);

            if($create == true) {
                // now increase (in = 1) or decrease (out = 2) the quantity for the item
                if ($this->input->post('item_type_movement') ==1) {
                    $item_location_data = $this->model_item->getItemLocationDataById($this->input->post('item_location_movement'));  
                    $quantity = $item_location_data['quantity'] + $this->input->post('item_quantity_movement');
                    $update_item_location = array('quantity' => $quantity);
                    $this->model_item->updateItemLocation($update_item_location, $this->input->post('item_location_movement'));     
                } else {
                    $item_location_data = $this->model_item->getItemLocationDataById($this->input->post('item_location_movement'));
                    $quantity = $item_location_data['quantity'] - $this->input->post('item_quantity_movement');
                    $update_item_location = array('quantity' => $quantity);
                    $this->model_item->updateItemLocation($update_item_location, $this->input->post('item_location_movement'));
                }

                $response['success'] = true;
                $response['messages'] ='Successfully created';
            }
            else {
                $response['success'] = false;
                $response['messages'] = 'Error in the database while creating the information';         
            }
        }
        else {
            $response['success'] = false;
            foreach ($_POST as $key => $value) {
                $response['messages'][$key] = form_error($key);
            }
        }

        echo json_encode($response);
   }



   public function removeMovement()
    {
        if(!in_array('deleteMovement', $this->permission)) {redirect('dashboard', 'refresh');}
        
        $movement_id = $this->input->post('movement_id');

        $response = array();

        if($movement_id) {

            //---> Replace the quantity in the location 

            $movement_data = $this->model_item->getMovementDataById($movement_id);
            $item_location_data = $this->model_item->getItemLocationDataById($movement_data['item_location_fk']);

            if ($item_location_data == null) {
                //No update on the quantity.  This location was removed but the movement was kept
                }
            else
                { //we will update the quantity to add the quantity to the location            
                if ($movement_data['type_movement'] == 1) {
                    $quantity = $item_location_data['quantity'] - $movement_data['quantity'];
                } else {
                    $quantity = $item_location_data['quantity'] + $movement_data['quantity'];
                } 
                
                $update_item_location = array('quantity' => $quantity);
                $this->model_item->updateItemLocation($update_item_location, $movement_data['item_location_fk']); 
                }  

            $delete = $this->model_item->removeMovement($movement_id);


            if($delete == true) {
                $response['success'] = true;
                $response['messages'] = "Successfully removed"; 
            }
            else {
                $response['success'] = false;
                $response['messages'] = "Error in the database while removing the item information";
            }
        }
        else {
            $response['success'] = false;
            $response['messages'] = "Refresh the page again!!";
        }

        echo json_encode($response);
    }

}