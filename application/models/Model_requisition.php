<?php 

class Model_requisition extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}


	public function getRequisitionData($requisition_id = null)
	{
		if($requisition_id) {
			$sql = "SELECT requisition.*,CONCAT(last_name, ' ', first_name) AS 'employee_requested_name',
					DATE(requisition.updated_date) AS 'updated_date',
					(SELECT user_name FROM user WHERE requisition.updated_by = user.user_id) AS 'updated_by'
			FROM requisition 
			LEFT JOIN employee ON employee_requested_fk = employee_id			
			WHERE requisition_id = ?";
			$query = $this->db->query($sql, array($requisition_id));
			return $query->row_array();
		}

		$sql = "SELECT requisition.*,CONCAT(last_name, ' ', first_name) AS 'employee_requested_name',
					DATE(requisition.updated_date) AS 'updated_date',
					(SELECT user_name FROM user WHERE requisition.updated_by = user.user_id) AS 'updated_by'
			FROM requisition 
			LEFT JOIN employee ON employee_requested_fk = employee_id		
			ORDER BY requisition_id DESC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}


	public function getRequisitionDataByDate($date_from = NULL, $date_to = NULL, $employee_from = NULL, $employee_to = NULL)
	{

		$sql = "SELECT requisition_id,requisition_no,requisition_date,CONCAT(last_name, ' ', first_name) AS 'employee_requested_name',
					   (SELECT CONCAT(last_name, ' ', first_name) FROM employee WHERE employee_id = employee_approved_fk) AS 'employee_approved_name',	
		               DATE(requisition.updated_date) AS 'updated_date',
					   (SELECT user_name FROM user WHERE requisition.updated_by = user.user_id) AS 'updated_by'
		FROM requisition 
		LEFT JOIN employee ON employee_requested_fk = employee_id		
		WHERE requisition_date BETWEEN $date_from AND $date_to
			  AND employee_requested_fk BETWEEN $employee_from AND $employee_to
		ORDER BY requisition_date DESC,requisition_id DESC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}


	public function getRequisitionDataByEmployee($employee_id, $date_from = NULL, $date_to = NULL)
	{

		$sql = "SELECT requisition.*,CONCAT(last_name, ' ', first_name) AS 'employee_requested_name',
		               DATE(requisition.updated_date) AS 'updated_date',
					   (SELECT user_name FROM user WHERE requisition.updated_by = user.user_id) AS 'updated_by',
					   (SELECT CONCAT(last_name, ' ', first_name) FROM employee WHERE employee_id = employee_approved_fk) AS 'employee_approved_name'
		FROM requisition 
		LEFT JOIN employee ON employee_requested_fk = employee_id		
		WHERE employee_requested_fk = $employee_id
			  AND requisition_date BETWEEN $date_from AND $date_to
		ORDER BY requisition_id DESC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}



	public function getMovementData($requisition_id = null)
	{
		if(!$requisition_id) {return false;}

		$sql = "SELECT movement_id,requisition_fk,item_location_fk,item_location.quantity AS 'quantity_item', 
					   location_fk,item_fk,movement.quantity AS 'quantity' 
				FROM movement 
					 JOIN item_location ON movement.item_location_fk = item_location_id
				WHERE requisition_fk = ?";
		$query = $this->db->query($sql, array($requisition_id));
		return $query->result_array();
	}




	public function getItemData($item_location_id)
	{
		$sql = "SELECT item_price,quantity AS 'quantity_item'
			FROM item_location 
				 JOIN item ON item_location.item_fk = item_id
			WHERE item_location_id = ?";
		$query = $this->db->query($sql, array($item_location_id));
		return $query->row_array();		

	}


	public function create($data)
	{
		$insert = $this->db->insert('requisition', $data);
		$requisition_id = $this->db->insert_id();

		$count_item = count($this->input->post('item'));

    	for($x = 0; $x < $count_item; $x++) {
    		//Create a movement entry.  It will be the requisition item
    		$movements = array(
    			'requisition_fk' => $requisition_id,  
    			'item_location_fk' => ($this->input->post('item')[$x]),
    			'quantity' => $this->input->post('qty')[$x],
    			'date_movement' => date("Y-m-d"),
    			'type_movement' => 2,   //1=IN of inventory -- 2=OUT of inventory
    			'remark' => 'Requisition ',
    			'updated_by' => $this->session->userdata('user_id'),    			
    		);

    		$this->db->insert('movement', $movements);

    		// now decrease the stock from the item 
    		$item_data = $this->model_item->getItemLocationDataById($this->input->post('item')[$x]);
    		$qty = $item_data['quantity'] - $this->input->post('qty')[$x];

    		$update_item = array('quantity' => $qty);
    		$this->model_item->updateItemLocation($update_item, $this->input->post('item')[$x]);
    	}

		return ($requisition_id) ? $requisition_id : false;
	}



	public function update($requisition_id, $data)
	{
		if($requisition_id) {

			$this->db->where('requisition_id', $requisition_id);
			$update = $this->db->update('requisition', $data);

			// now the requisition item 
			// first we will replace the item qty to original and subtract the qty again

			$get_movement = $this->getMovementData($requisition_id);

			foreach ($get_movement as $k => $v) {
				$item_location_id = $v['item_location_fk'];
				$qty = $v['quantity'];
				// get the item 
				$item_data = $this->model_item->getItemLocationDataById($item_location_id);
				$update_qty = $qty + $item_data['quantity'];
				$update_item_data = array('quantity' => $update_qty);
				
				// update the item qty
				$this->model_item->updateItemLocation($update_item_data, $item_location_id);
				}

			// now remove the movement item data 
			$this->db->where('requisition_fk', $requisition_id);
			$this->db->delete('movement');

			// now decrease the item qty
			$count_item = count($this->input->post('item'));
	    	for($x = 0; $x < $count_item; $x++) {
	    		$movements = array(
    			'requisition_fk' => $requisition_id,  
    			'item_location_fk' => ($this->input->post('item')[$x]),
    			'quantity' => $this->input->post('qty')[$x],
    			'type_movement' => 2,  //1=IN of inventory -- 2=OUT of inventory
    			'date_movement' => date("Y-m-d"),
    			'remark' => 'Requisition ',
    			'updated_by' => $this->session->userdata('user_id'),    			
    		);

    		$this->db->insert('movement', $movements);

	    		//  decrease the stock from the item
	    		$item_data = $this->model_item->getItemLocationDataById($this->input->post('item')[$x]);
	    		$qty = $item_data['quantity'] - $this->input->post('qty')[$x];

	    		$update_item = array('quantity' => $qty);
	    		$this->model_item->updateItemLocation($update_item, $this->input->post('item')[$x]);
	    	}

			return true;
		}
	}



	public function remove($requisition_id)
	{
		if($requisition_id) {			

			// now the requisition item 
			// first we will replace the item qty in the inventory

			$get_movement = $this->getMovementData($requisition_id);

			foreach ($get_movement as $k => $v) {
				$item_location_id = $v['item_location_fk'];
				$qty = $v['quantity'];
				// get the item 
				$item_data = $this->model_item->getItemLocationDataById($item_location_id);
				$update_qty = $qty + $item_data['quantity'];
				$update_item_data = array('quantity' => $update_qty);
				
				// update the item qty
				$this->model_item->updateItemLocation($update_item_data, $item_location_id);
				}

			$this->db->where('requisition_fk', $requisition_id);
			$delete_item = $this->db->delete('movement');

						//---> Delete the requisition
			$this->db->where('requisition_id', $requisition_id);
			$delete = $this->db->delete('requisition');

			return ($delete == true && $delete_item) ? true : false;
		}
	}



	public function countMovementItem($requisition_id)
	{
		if($requisition_id) {
			$sql = "SELECT * FROM movement WHERE requisition_fk = ?";
			$query = $this->db->query($sql, array($requisition_id));
			return $query->num_rows();
		}
	}

	


	public function generateRequisitionNo()
	{  

		// We need to verify if one requisition exists in the database to create
		// the first occurence of the requisition no
		$sql = "SELECT CASE WHEN count(*) = 0 THEN CONCAT('R',SUBSTRING(YEAR(CURDATE()),3,2),'-1') 
						    ELSE CONCAT('R',SUBSTRING(YEAR(CURDATE()),3,2), '-', 
						    	(SELECT CAST(SUBSTRING(requisition_no,5,5) AS UNSIGNED) + 1  
						    	 FROM requisition 
						    	 ORDER BY CAST(SUBSTRING(requisition_no,5,5) AS UNSIGNED) DESC LIMIT 1)) END AS 'next_no'
				FROM requisition";
		$query = $this->db->query($sql, array());
		return $query->row_array();
		
	}



}