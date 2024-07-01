<?php 

class Model_order extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}


	public function getOrderData($order_id = null)
	{
		if($order_id) {
			$sql = "SELECT orders.*,customer_name,area_name,municipality_name,phone,
					balance,(balance - order_total) as 'previous_balance',
					DATE(orders.updated_date) AS 'updated_date',
					(SELECT user_name FROM user WHERE orders.updated_by = user.user_id) AS 'updated_by'
			FROM orders 
			LEFT JOIN customer ON customer_fk = customer_id
			LEFT JOIN area ON customer.area_fk = area_id
			LEFT JOIN municipality ON customer.municipality_fk = municipality_id
			WHERE order_id = ?";
			$query = $this->db->query($sql, array($order_id));
			return $query->row_array();
		}

		$sql = "SELECT orders.*,customer_name,area_name,municipality_name,phone,
					balance,(balance - order_total) as 'previous_balance',
					DATE(orders.updated_date) AS 'updated_date',
					(SELECT user_name FROM user WHERE orders.updated_by = user.user_id) AS 'updated_by'
			FROM orders 
			LEFT JOIN customer ON customer_fk = customer_id
			LEFT JOIN area ON customer.area_fk = area_id
			LEFT JOIN municipality ON customer.municipality_fk = municipality_id
			ORDER BY order_id DESC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}


	public function getOrderDataByDate($date_from = NULL, $date_to = NULL, $area_from = NULL, $area_to = NULL)
	{

		$sql = "SELECT orders.*,customer_name,balance,area_name,
		               DATE(orders.updated_date) AS 'updated_date',
					   (SELECT user_name FROM user WHERE orders.updated_by = user.user_id) AS 'updated_by'
		FROM orders 
		LEFT JOIN customer ON customer_fk = customer_id
		LEFT JOIN area ON customer.area_fk = area_id
		WHERE order_date BETWEEN $date_from AND $date_to
			  AND customer.area_fk BETWEEN $area_from AND $area_to
		ORDER BY order_id DESC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}



	public function getMovementData($order_id = null)
	{
		if(!$order_id) {return false;}

		$sql = "SELECT movement_id,order_fk,item_location_fk,order_amount,rate, 
					   location_fk,item_fk,movement.quantity AS 'quantity' 
				FROM movement 
					 JOIN item_location ON movement.item_location_fk = item_location_id
				WHERE order_fk = ?";
		$query = $this->db->query($sql, array($order_id));
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
		$insert = $this->db->insert('orders', $data);
		$order_id = $this->db->insert_id();

		$count_item = count($this->input->post('item'));

    	for($x = 0; $x < $count_item; $x++) {
    		//Create a movement entry.  It will be the order item
    		$movements = array(
    			'order_fk' => $order_id,  
    			'item_location_fk' => ($this->input->post('item')[$x]),
    			'quantity' => $this->input->post('qty')[$x],
    			'date_movement' => date("Y-m-d"),
    			'type_movement' => 2,   //1=IN of inventory -- 2=OUT of inventory
    			'rate' => $this->input->post('rate')[$x],
    			'order_amount' => $this->input->post('amount_value')[$x],
    			'remark' => 'Order '.($this->input->post('customer_name')),
    			'updated_by' => $this->session->userdata('user_id'),    			
    		);

    		$this->db->insert('movement', $movements);

    		// now decrease the stock from the item 
    		$item_data = $this->model_item->getItemLocationDataById($this->input->post('item')[$x]);
    		$qty = $item_data['quantity'] - $this->input->post('qty')[$x];

    		$update_item = array('quantity' => $qty);
    		$this->model_item->updateItemLocation($update_item, $this->input->post('item')[$x]);
    	}

		return ($order_id) ? $order_id : false;
	}



	public function update($order_id, $data)
	{
		if($order_id) {

			$this->db->where('order_id', $order_id);
			$update = $this->db->update('orders', $data);

			// now the order item 
			// first we will replace the item qty to original and subtract the qty again

			$get_movement = $this->getMovementData($order_id);

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
			$this->db->where('order_fk', $order_id);
			$this->db->delete('movement');

			// now decrease the item qty
			$count_item = count($this->input->post('item'));
	    	for($x = 0; $x < $count_item; $x++) {
	    		$movements = array(
    			'order_fk' => $order_id,  
    			'item_location_fk' => ($this->input->post('item')[$x]),
    			'quantity' => $this->input->post('qty')[$x],
    			'type_movement' => 2,  //1=IN of inventory -- 2=OUT of inventory
    			'date_movement' => date("Y-m-d"),
    			'rate' => $this->input->post('rate')[$x],
    			'order_amount' => $this->input->post('amount_value')[$x],
    			'remark' => 'Order '.($this->input->post('customer_name')),
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



	public function remove($order_id)
	{
		if($order_id) {			

			// now the order item 
			// first we will replace the item qty in the inventory

			$get_movement = $this->getMovementData($order_id);

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

			$this->db->where('order_fk', $order_id);
			$delete_item = $this->db->delete('movement');

			//--> Update the balance of the customer
			// Get the customer id and order_total to remove from the balance
			$order_data = $this->getOrderData($order_id);
    		$balance = $this->model_customer->getCustomerData($order_data['customer_fk']);
    		$new_balance = $balance['balance'] - $order_data['order_total'];        		
			$update_balance = array('balance' => $new_balance);
			$this->model_customer->updateBalance($update_balance, $order_data['customer_fk']);

			//---> Delete the order
			$this->db->where('order_id', $order_id);
			$delete = $this->db->delete('orders');

			return ($delete == true && $delete_item) ? true : false;
		}
	}



	public function countMovementItem($order_id)
	{
		if($order_id) {
			$sql = "SELECT * FROM movement WHERE order_fk = ?";
			$query = $this->db->query($sql, array($order_id));
			return $query->num_rows();
		}
	}


	public function countTotalOrderDay($order_date)
	{
		$sql = "SELECT * FROM orders 
				WHERE orders.order_date = ? ";
		$query = $this->db->query($sql, array($order_date));
		return $query->num_rows();
	}

	

	public function countTotalByIngredient($date)
	{
		$sql = "SELECT CONCAT(ingredient_name,' (/',formula,' ',formula_unit,')') AS ingredient_name,
						SUM(movement.quantity) AS 'total_order',
						(SUM(movement.quantity) / ingredient.formula) AS 'total_ingredient'
				FROM movement					
				JOIN item_location ON item_location_fk = item_location_id
                JOIN item ON item_location.item_fk = item_id
				JOIN item_ingredient ON item_ingredient.item_fk = item_id                
				JOIN ingredient ON item_ingredient.ingredient_fk = ingredient_id
				JOIN orders ON movement.order_fk = order_id
				WHERE orders.order_date = ?
				AND movement.order_fk IS NOT NULL
				GROUP BY ingredient_name";
		$query = $this->db->query($sql, array($date));
		return $query->result_array();
	}


	public function generateOrderNo()
	{   
		// We need to verify if one order exists in the database to create
		// the first occurence of the order
		// We also check if the year is changing to restart the order no to 00001		

		$num_rows = 0;
		$array['next_no'] = substr(date('Y'),2,2) .'00001';
		
		$sql = "SELECT * FROM orders";
		$query = $this->db->query($sql, array());
		$num_rows = $query->num_rows();

		if ($num_rows > 0) { 

			$sql = "SELECT CASE WHEN (SELECT COUNT(*) 
									  FROM orders 
									  WHERE SUBSTRING(order_no,1,2) = SUBSTRING(YEAR(CURDATE()),3,2)) > 0 
						       THEN (order_no + 1) ELSE CONCAT(SUBSTRING(YEAR(CURDATE()),3,2),'00001') END 
								AS 'next_no'
					FROM orders 
					ORDER BY order_no DESC LIMIT 1";			
				$query = $this->db->query($sql, array());
				return $query->row_array();
			}
	
		return $array; 
	
	}


	public function countTotalOrder()
	{
		$sql = "SELECT * FROM orders";
		$query = $this->db->query($sql, array());
		return $query->num_rows();
	}

}