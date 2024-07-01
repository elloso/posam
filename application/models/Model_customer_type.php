<?php 

class Model_customer_type extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	//--> Get active information
	public function getActiveCustomerType()
	{
		$sql = "SELECT * FROM customer_type WHERE active = ? ORDER BY customer_type_name ASC";
		$query = $this->db->query($sql, array(1));
		return $query->result_array();
	}

	//--> Get the data of the table
	public function getCustomerTypeData($customer_type_id = null)
	{
		if($customer_type_id) {
			$sql = "SELECT * FROM customer_type WHERE customer_type_id = ?";
			$query = $this->db->query($sql, array($customer_type_id));
			return $query->row_array();
		}

		$sql = "SELECT * FROM customer_type";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function create($data)
	{
		if($data) {
			$insert = $this->db->insert('customer_type', $data);
			return ($insert == true) ? true : false;
		}
	}

	public function update($data, $customer_type_id)
	{
		if($data && $customer_type_id) {
			$this->db->where('customer_type_id', $customer_type_id);
			$update = $this->db->update('customer_type', $data);
			return ($update == true) ? true : false;
		}
	}

	public function remove($customer_type_id)
	{
		if($customer_type_id) {
			$this->db->where('customer_type_id', $customer_type_id);
			$delete = $this->db->delete('customer_type');
			return ($delete == true) ? true : false;
		}
	}

	//---> Validate if the customer type is used in table Customer
	public function checkIntegrity($customer_type_id)
	{
		$sql = "SELECT * FROM customer WHERE customer_type_fk = ?";
		$query = $this->db->query($sql, array($customer_type_id));
		return $query->num_rows();
		
	}

}