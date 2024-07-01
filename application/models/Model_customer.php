<?php 

class Model_customer extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	
	public function getCustomerData($customer_id = null)
	{

		$today_date = Date('Ymd');
		
		if($customer_id) {
			$sql = "SELECT customer.*,area_name,municipality_name,customer_type_name
		   FROM customer
			   LEFT JOIN area ON customer.area_fk = area_id
			   LEFT JOIN municipality ON customer.municipality_fk = municipality_id
			   LEFT JOIN customer_type ON customer.customer_type_fk = customer_type_id
		   WHERE customer_id = ?";
			$query = $this->db->query($sql, array($customer_id));
			return $query->row_array();
		}

		$sql = "SELECT customer.*,$today_date as 'today_date',
						area_name,municipality_name,customer_type_name,
						(SELECT count(*) FROM orders WHERE customer_fk = customer_id AND order_date = $today_date) AS 'order_today'
						
			FROM customer 
			   LEFT JOIN area ON customer.area_fk = area_id
			   LEFT JOIN municipality ON customer.municipality_fk = municipality_id
			   LEFT JOIN customer_type ON customer.customer_type_fk = customer_type_id
			ORDER BY customer_name ASC";
			$query = $this->db->query($sql);
			return $query->result_array();
			
	}


	public function getActiveCustomer()
	{

		$sql = "SELECT customer.*,area_name,municipality_name
		FROM customer 
			LEFT JOIN area ON customer.area_fk = area_id
			LEFT JOIN municipality ON customer.municipality_fk = municipality_id
		WHERE customer.active = ?		
		ORDER BY customer_name ASC";
		$query = $this->db->query($sql, array(1));
		return $query->result_array();
	}


	public function create($data)
	{
		if ($data) {
			$insert = $this->db->insert('customer', $data);
			$customer_id = $this->db->insert_id();	
		return ($insert == true) ? $customer_id : false;
		}
	}



	public function update($customer_id, $data)
	{
		if($customer_id) {
         $this->db->where('customer_id', $customer_id);
			$update = $this->db->update('customer', $data);
			return ($update == true) ? true : false;
		}
	}



	public function remove($customer_id)
	{
		if($customer_id) {					

			$this->db->where('customer_id', $customer_id);
			$delete = $this->db->delete('customer');	

			return ($delete == true) ? true : false;

		}
	}


	public function updateBalance($data, $customer_id)
	{
		if($data && $customer_id) {
			$this->db->where('customer_id', $customer_id);
			$update = $this->db->update('customer', $data);
			return ($update == true) ? true : false;
		}
	}


	//---> Validate if the customer is used in other tables
	public function checkIntegrity($customer_id)
	{

		$num_rows = 0;
		
		$sql = "SELECT * FROM orders WHERE customer_fk = ?";
		$query = $this->db->query($sql, array($customer_id));
		$num_rows = $num_rows + $query->num_rows();

		$sql = "SELECT * FROM payment WHERE customer_fk = ?";
		$query = $this->db->query($sql, array($customer_fk));
		$num_rows = $num_rows + $query->num_rows();

		return $num_rows;
		
	}



	public function countTotalCustomer()
	{
		$sql = "SELECT * FROM customer";
		$query = $this->db->query($sql);
		return $query->num_rows();
	}


	public function generateCustomerCode()
	{   
	    // We need to verify if one customer exists in the database to create
		// the first occurence of the customer code CUS001
		$sql = "SELECT CASE WHEN count(*) = 0 THEN 'CUS001' ELSE 
					(SELECT CASE WHEN SUBSTRING(customer_code,4,3) < 100 THEN
							CONCAT('CUS',LPAD(SUBSTRING(customer_code,4,3) + 1, 3, 0)) 
							ELSE 	CONCAT('CUS',SUBSTRING(customer_code,4,3) + 1)
							END 
					FROM customer 
					ORDER BY customer_code DESC LIMIT 1) END AS 'customer_code'
				FROM customer";
		$query = $this->db->query($sql);
		return $query->row_array();

	
	}




//----------------------------------------- ORDER -------------------------------------------------------------->

	public function getCustomerOrderByDate($customer_id = null, $date_from = NULL, $date_to = NULL)
	{

		$sql = "SELECT orders.*,DATE(updated_date) AS 'updated_date',
					   (SELECT user_name FROM user WHERE orders.updated_by = user.user_id) AS 'updated_by'
				FROM orders 	
				WHERE customer_fk = ?
				      AND order_date BETWEEN $date_from AND $date_to 
				ORDER BY order_no DESC";
		$query = $this->db->query($sql, array($customer_id));
		return $query->result_array();
	}


		public function getCustomerOrder($customer_id = null)
	{

		$sql = "SELECT orders.*,DATE(updated_date) AS 'updated_date',
					   (SELECT user_name FROM user WHERE orders.updated_by = user.user_id) AS 'updated_by'
				FROM orders 	
				WHERE customer_fk = ?
				ORDER BY order_no DESC";
		$query = $this->db->query($sql, array($customer_id));
		return $query->result_array();
	}



//----------------------------------------- DOCUMENT -------------------------------------------------------------->


	public function getCustomerDocument($customer_id)
	{
	
		$sql = "SELECT document.*
		FROM document 
		WHERE customer_fk = ?";
		$query = $this->db->query($sql, array($customer_id));
		return $query->result_array();
				

	}


	public function createDocument($data)
	{
		if($data) {
			$insert = $this->db->insert('document', $data);
			return ($insert == true) ? true : false;
		}
	}

	public function removeDocument($document_id)
	{
		if($document_id) {
			$this->db->where('document_id', $document_id);
			$delete = $this->db->delete('document');
			return ($delete == true) ? true : false;
		}
	}

	public function getDocument($document_id = null)
	{
		$sql = "SELECT *
		FROM document
		WHERE document_id = ?";
		$query = $this->db->query($sql, array($document_id));
		return $query->row_array();

	}

}