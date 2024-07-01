<?php 

class Model_item extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	
	public function getItemData($item_id = null)
	{
		if($item_id) {
			$sql = "SELECT item.*,unit_name,category_name,
							   (SELECT sum(quantity) FROM item_location WHERE item_fk = item_id) AS 'quantity'
			   FROM item				   
			   		LEFT JOIN unit ON unit_fk = unit_id
			   		LEFT JOIN category ON category_fk = category_id
		   	WHERE item_id = ?";
			$query = $this->db->query($sql, array($item_id));
			return $query->row_array();
		}

		$sql = "SELECT item_id,item_name,item_code,category_name,unit_name,item_price,
						CASE WHEN inventory = 1 THEN 		
						(SELECT sum(quantity) FROM item_location WHERE item_fk = item_id) ELSE NULL END AS 'quantity',
						ordering_point,inventory
					FROM item
						LEFT JOIN unit ON unit_fk = unit_id 
						LEFT JOIN category ON category_fk = category_id
					ORDER BY item_name ASC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}


	public function getActiveItem()
	{

		$sql = "SELECT item_id, item_name
		FROM item WHERE active = ?		
		ORDER BY item_name ASC";
		$query = $this->db->query($sql, array(1));
		return $query->result_array();
	}


	public function create($data)
	{
		if ($data) {
			$insert = $this->db->insert('item', $data);
			$item_id = $this->db->insert_id();	
		return ($insert == true) ? $item_id : false;
		}
	}



	public function update($item_id, $data)
	{
		if($item_id) {
         $this->db->where('item_id', $item_id);
			$update = $this->db->update('item', $data);
			return ($update == true) ? true : false;
		}
	}



	public function remove($item_id)
	{
		if($item_id) {					

			//We need to find the item id to delete the movement of the inventory

    	$sql = "DELETE m FROM movement m
		  JOIN item_location l ON m.item_location_fk = l.item_location_id
		  WHERE l.item_fk = ?";
			$this->db->query($sql, array($item_id));

			$this->db->where('item_fk', $item_id);
			$delete_location = $this->db->delete('item_location');

			$this->db->where('item_fk', $item_id);
			$delete_ingredient = $this->db->delete('item_ingredient');

			$this->db->where('item_id', $item_id);
			$delete = $this->db->delete('item');	

			return ($delete == true && $delete_location && $delete_ingredient) ? true : false;

		}
	}


	//---> Validate if the item is used in other tables
	public function checkIntegrity($item_id)
	{
		$sql = "SELECT * FROM movement 
		JOIN item_location ON item_location_fk = item_location_id
		WHERE item_fk = ?";
		$query = $this->db->query($sql, array($item_id));
		return $query->num_rows();
		
	}


	//---> Validate if the item is used in other tables
	public function checkIntegrityItemLocation($item_location_id)
	{
		$sql = "SELECT * FROM movement 
		JOIN item_location ON item_location_fk = item_location_id
		WHERE item_location_fk = ?";
		$query = $this->db->query($sql, array($item_location_id));
		return $query->num_rows();
		
	}



	public function countTotalItem()
	{
		$sql = "SELECT * FROM item";
		$query = $this->db->query($sql);
		return $query->num_rows();
	}




//--------------------------------------------- Location ------------------------------------------------------------>


	// get the location item data
	public function getItemLocationData($item_id = null)
	{
		
		//--> If all, then we create a complete list of item with location
		if($item_id) {
			//-->else we return the list of location for a specific item
			$sql = "SELECT item_location_id,location_name,item_code,
							   item_fk,location_fk,item_name,item_location.remark as 'remark',
							   CASE WHEN inventory = 2 THEN 0 ELSE quantity END as 'quantity' 	
					FROM item_location 
						 JOIN location ON item_location.location_fk = location_id
						 JOIN item ON item_location.item_fk = item_id
					WHERE item_fk = ?";
			$query = $this->db->query($sql, array($item_id));
			return $query->result_array();
			}

		$sql = "SELECT item_location_id,item_name, location_name,item_code,
						   item_fk,location_fk,item_location.remark as 'remark',
						   CASE WHEN inventory = 2 THEN 0 ELSE quantity END as 'quantity' 
				FROM item_location 
					 JOIN location ON item_location.location_fk = location_id
					 JOIN item ON item_location.item_fk = item_id
				ORDER BY item_name";
		$query = $this->db->query($sql);
		return $query->result_array();
	
	}



	// get the location item data
	public function getItemLocationDataById($item_location_id)
	{
		if(!$item_location_id) {return false;}

		$sql = "SELECT *
				FROM item_location 
				JOIN item ON item_location.item_fk = item_id
				WHERE item_location_id = ?";
		$query = $this->db->query($sql, array($item_location_id));
		return $query->row_array();
	}


    public function createItemLocation($data)
	{
		if($data) {
			$insert = $this->db->insert('item_location', $data);
			return ($insert == true) ? true : false;
		}
	}

	public function updateItemLocation($data, $item_location_id)
	{
		if($data && $item_location_id) {
			$this->db->where('item_location_id', $item_location_id);
			$update = $this->db->update('item_location', $data);
			return ($update == true) ? true : false;
		}
	}


	public function removeItemLocation($item_location_id)
	{
		if($item_location_id) {
			$this->db->where('item_location_id', $item_location_id);
			$delete = $this->db->delete('item_location');
			return ($delete == true) ? true : false;
		}
	}


	// get the list of location
	public function getItemLocation($item_id)
	{

		$sql = "SELECT location_id,item_fk, location_fk,
		        location_name,location.quantity AS 'quantity',
		        DATE(date_location) AS 'date_location',location.remark as 'remark',
		        (CASE WHEN type_location = 1 THEN '+'  ELSE '-' END) AS 'type_location' 
				FROM location
					LEFT JOIN location ON location.location_fk = location_id
				WHERE location.item_fk = ?";
		$query = $this->db->query($sql, array($item_id));
		return $query->result_array();
	}	



//--------------------------------------------- Ingredient ------------------------------------------------------------>


	// get the ingredient item data
	public function getItemIngredientData($item_id = null)
	{
		//--> If all, then we create a complete list of item with ingredient
		if($item_id) {
			//-->else we return the list of ingredient for a specific item
			$sql = "SELECT item_ingredient_id,ingredient_name,item_code,formula,
							   item_ingredient.remark as 'remark',item_fk,item_ingredient.ingredient_fk,item_name 	
					FROM item_ingredient 
						 JOIN ingredient ON item_ingredient.ingredient_fk = ingredient_id
						 JOIN item ON item_ingredient.item_fk = item_id
					WHERE item_fk = ?";
			$query = $this->db->query($sql, array($item_id));
			return $query->result_array();
			}

		$sql = "SELECT item_ingredient_id,item_name, ingredient_name,item_code,formula,
						   item_ingredient.remark as 'remark',item_fk,item_ingredient.ingredient_fk
				FROM item_ingredient 
					 JOIN ingredient ON item_ingredient.ingredient_fk = ingredient_id
					 JOIN item ON item_ingredient.item_fk = item_id
				ORDER BY item_name";
		$query = $this->db->query($sql);
		return $query->result_array();
	
	}



	// get the ingredient item data
	public function getItemIngredientDataById($item_ingredient_id)
	{
		if(!$item_ingredient_id) {return false;}

		$sql = "SELECT *
				FROM item_ingredient 
				WHERE item_ingredient_id = ?";
		$query = $this->db->query($sql, array($item_ingredient_id));
		return $query->row_array();
	}


    public function createItemIngredient($data)
	{
		if($data) {
			$insert = $this->db->insert('item_ingredient', $data);
			return ($insert == true) ? true : false;
		}
	}

	public function updateItemIngredient($data, $item_ingredient_id)
	{
		if($data && $item_ingredient_id) {
			$this->db->where('item_ingredient_id', $item_ingredient_id);
			$update = $this->db->update('item_ingredient', $data);
			return ($update == true) ? true : false;
		}
	}


	public function removeItemIngredient($item_ingredient_id)
	{
		if($item_ingredient_id) {
			$this->db->where('item_ingredient_id', $item_ingredient_id);
			$delete = $this->db->delete('item_ingredient');
			return ($delete == true) ? true : false;
		}
	}


	// get the list of ingredient
	public function getItemIngredient($item_id)
	{

		$sql = "SELECT ingredient_id,item_fk, ingredient_fk,
		        ingredient_name,ingredient.remark as 'remark'
				FROM item_ingredient
					LEFT JOIN ingredient ON ingredient.ingredient_fk = ingredient_id
				WHERE ingredient.item_fk = ?";
		$query = $this->db->query($sql, array($item_id));
		return $query->result_array();
	}	






 //----------------------------------------- Movement ------------------------------------------------------->


    public function createMovement($data)
	{
		if($data) {
			$insert = $this->db->insert('movement', $data);
			return ($insert == true) ? true : false;
		}
	}


	public function removeMovement($movement_id)
	{
		if($movement_id) {
			$this->db->where('movement_id', $movement_id);
			$delete = $this->db->delete('movement');
			return ($delete == true) ? true : false;
		}
	}


	// get the list of movement
	public function getMovement($item_id, $date_from = NULL, $date_to = NULL, $in_out_from = NULL, $in_out_to = NULL)
	{

		$sql = "SELECT movement_id,movement.item_location_fk,location_name,movement.quantity AS 'quantity',
				  CASE WHEN rate IS NULL THEN item_price ELSE rate END AS 'price',
				  CONCAT(last_name, ' ', first_name) AS 'employee_name',employee_id,
				  delivery_fk,delivery_id,delivery_no,supplier_name,supplier_id,
		        DATE(date_movement) AS 'date_movement',movement.remark as 'remark',order_no,order_fk,
		        (CASE WHEN type_movement = 1 THEN '+'  ELSE '-' END) AS 'type_movement',customer_name,customer_id,
		        requisition_no,requisition_fk 
				FROM movement
					LEFT JOIN item_location ON movement.item_location_fk = item_location_id
               LEFT JOIN item ON item_location.item_fk = item_id
					LEFT JOIN location ON item_location.location_fk = location_id
					LEFT JOIN orders ON movement.order_fk = order_id
					LEFT JOIN customer ON orders.customer_fk = customer_id
					LEFT JOIN requisition ON movement.requisition_fk = requisition_id
					LEFT JOIN employee ON requisition.employee_requested_fk = employee_id
					LEFT JOIN delivery ON movement.delivery_fk = delivery_id
					LEFT JOIN supplier ON delivery.supplier_fk = supplier_id
				WHERE item_location.item_fk = ?
				AND type_movement BETWEEN $in_out_from AND $in_out_to
				AND movement.date_movement BETWEEN $date_from AND $date_to";
		$query = $this->db->query($sql, array($item_id));
		return $query->result_array();
	}


	// get the location item data
	public function getMovementDataById($movement_id = null)
	{
		if(!$movement_id) {return false;}

		$sql = "SELECT type_movement,quantity,item_location_fk
		FROM movement 
		WHERE movement_id = ?";
		$query = $this->db->query($sql, array($movement_id));
		return $query->row_array();
	}




}