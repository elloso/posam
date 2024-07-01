<?php 

class Model_delivery extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}


	public function getDeliveryData($delivery_id = null)
	{
		if($delivery_id) {
			$sql = "SELECT delivery.*,supplier_name,
					(SELECT user_name FROM user WHERE delivery.updated_by = user.user_id) AS 'updated_by'
			FROM delivery 
			LEFT JOIN supplier ON supplier_fk = supplier_id			
			WHERE delivery_id = ?";
			$query = $this->db->query($sql, array($delivery_id));
			return $query->row_array();
		}

		$sql = "SELECT delivery.*,supplier_name,
					(SELECT user_name FROM user WHERE delivery.updated_by = user.user_id) AS 'updated_by'
			FROM delivery 
			LEFT JOIN supplier ON supplier_fk = supplier_id		
			ORDER BY delivery_id DESC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}


	public function getDeliveryDataByDate($date_from = NULL, $date_to = NULL, $supplier_from = NULL, $supplier_to = NULL)
	{

		$sql = "SELECT delivery.*,supplier_name,
					(SELECT user_name FROM user WHERE delivery.updated_by = user.user_id) AS 'updated_by'
		FROM delivery 
		LEFT JOIN supplier ON supplier_fk = supplier_id		
		WHERE delivery_date BETWEEN $date_from AND $date_to
			  AND supplier_fk BETWEEN $supplier_from AND $supplier_to
		ORDER BY delivery_date DESC,delivery_id DESC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}


	public function getDeliveryDataBySupplier($supplier_id, $date_from = NULL, $date_to = NULL)
	{

		$sql = "SELECT delivery.*,supplier_name,
					(SELECT user_name FROM user WHERE delivery.updated_by = user.user_id) AS 'updated_by'
		FROM delivery 
		LEFT JOIN supplier ON supplier_fk = supplier_id		
		WHERE supplier_fk = $supplier_id
			  AND delivery_date BETWEEN $date_from AND $date_to
		ORDER BY delivery_id DESC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}



	public function getMovementData($delivery_id = null)
	{
		if(!$delivery_id) {return false;}

		$sql = "SELECT movement_id,delivery_fk,item_location_fk,rate, 
					   location_fk,item_fk,movement.quantity AS 'quantity' 
				FROM movement 
					 JOIN item_location ON movement.item_location_fk = item_location_id
				WHERE delivery_fk = ?";
		$query = $this->db->query($sql, array($delivery_id));
		return $query->result_array();
	}




	public function getItemPrice($item_location_id)
	{
		$sql = "SELECT item_price
			FROM item_location 
				 JOIN item ON item_location.item_fk = item_id
			WHERE item_location_id = ?";
		$query = $this->db->query($sql, array($item_location_id));
		return $query->row_array();		

	}


	public function create($data)
	{
		$insert = $this->db->insert('delivery', $data);
		$delivery_id = $this->db->insert_id();

		$count_item = count($this->input->post('item'));

    	for($x = 0; $x < $count_item; $x++) {
    		//Create a movement entry.  It will be the delivery item
    		$movements = array(
    			'delivery_fk' => $delivery_id,  
    			'item_location_fk' => ($this->input->post('item')[$x]),
    			'quantity' => $this->input->post('qty')[$x],
    			'rate' => $this->input->post('rate')[$x],
    			'date_movement' => date("Y-m-d"),
    			'type_movement' => 1,  //1=IN of inventory -- 2=OUT of inventory
    			'remark' => 'Delivery ',
    			'updated_by' => $this->session->userdata('user_id'),    			
    		);

    		$this->db->insert('movement', $movements);

    		// now increase the stock from the item 
    		$item_data = $this->model_item->getItemLocationDataById($this->input->post('item')[$x]);
    		$qty = $item_data['quantity'] + $this->input->post('qty')[$x];

    		$update_item = array('quantity' => $qty);
    		$this->model_item->updateItemLocation($update_item, $this->input->post('item')[$x]);
    	}

		return ($delivery_id) ? $delivery_id : false;
	}



	public function update($delivery_id, $data)
	{
		if($delivery_id) {

			$this->db->where('delivery_id', $delivery_id);
			$update = $this->db->update('delivery', $data);

			// now the delivery item 
			// first we will replace the item qty to original and add the qty again

			$get_movement = $this->getMovementData($delivery_id);

			foreach ($get_movement as $k => $v) {
				$item_location_id = $v['item_location_fk'];
				$qty = $v['quantity'];
				// get the item 
				$item_data = $this->model_item->getItemLocationDataById($item_location_id);
				$update_qty = $item_data['quantity'] - $qty;
				$update_item_data = array('quantity' => $update_qty);
				
				// update the item qty
				$this->model_item->updateItemLocation($update_item_data, $item_location_id);
				}

			// now remove the movement item data 
			$this->db->where('delivery_fk', $delivery_id);
			$this->db->delete('movement');

			// now increase the item qty
			$count_item = count($this->input->post('item'));
	    	for($x = 0; $x < $count_item; $x++) {
	    		$movements = array(
    			'delivery_fk' => $delivery_id,  
    			'item_location_fk' => ($this->input->post('item')[$x]),
    			'quantity' => $this->input->post('qty')[$x],
    			'rate' => $this->input->post('rate')[$x],
    			'type_movement' => 1,  //1=IN of inventory -- 2=OUT of inventory
    			'date_movement' => date("Y-m-d"),
    			'remark' => 'Delivery ',
    			'updated_by' => $this->session->userdata('user_id'),    			
    		);

    		$this->db->insert('movement', $movements);

	    		//  decrease the stock from the item
	    		$item_data = $this->model_item->getItemLocationDataById($this->input->post('item')[$x]);
	    		$qty = $item_data['quantity'] + $this->input->post('qty')[$x];

	    		$update_item = array('quantity' => $qty);
	    		$this->model_item->updateItemLocation($update_item, $this->input->post('item')[$x]);
	    	}

			return true;
		}
	}



	public function remove($delivery_id)
	{
		if($delivery_id) {			

			// now the delivery item 
			// first we will replace the item qty in the inventory

			$get_movement = $this->getMovementData($delivery_id);

			foreach ($get_movement as $k => $v) {
				$item_location_id = $v['item_location_fk'];
				$qty = $v['quantity'];
				// get the item 
				$item_data = $this->model_item->getItemLocationDataById($item_location_id);
				$update_qty = $item_data['quantity'] - $qty;
				$update_item_data = array('quantity' => $update_qty);
				
				// update the item qty
				$this->model_item->updateItemLocation($update_item_data, $item_location_id);
				}

			$this->db->where('delivery_fk', $delivery_id);
			$delete_item = $this->db->delete('movement');

						//---> Delete the delivery
			$this->db->where('delivery_id', $delivery_id);
			$delete = $this->db->delete('delivery');

			return ($delete == true && $delete_item) ? true : false;
		}
	}



	public function countMovementItem($delivery_id)
	{
		if($delivery_id) {
			$sql = "SELECT * FROM movement WHERE delivery_fk = ?";
			$query = $this->db->query($sql, array($delivery_id));
			return $query->num_rows();
		}
	}

	


	public function generateDeliveryNo()
	{  

		// We need to verify if one delivery exists in the database to create
		// the first occurence of the delivery no
		$sql = "SELECT CASE WHEN count(*) = 0 THEN CONCAT('D',SUBSTRING(YEAR(CURDATE()),3,2),'-1') 
						    ELSE CONCAT('D',SUBSTRING(YEAR(CURDATE()),3,2), '-', 
						    	(SELECT CAST(SUBSTRING(delivery_no,5,5) AS UNSIGNED) + 1  
						    	 FROM delivery 
						    	 ORDER BY CAST(SUBSTRING(delivery_no,5,5) AS UNSIGNED) DESC LIMIT 1)) END AS 'next_no'
				FROM delivery";
		$query = $this->db->query($sql, array());
		return $query->row_array();
		
	}



}