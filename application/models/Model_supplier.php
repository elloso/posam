<?php 

class Model_supplier extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	//--> Get active information
	public function getActiveSupplier()
	{
		$sql = "SELECT * FROM supplier WHERE active = ? ORDER BY supplier_name";
		$query = $this->db->query($sql, array(1));
		return $query->result_array();
	}

	//--> Get the supplier data
	public function getSupplierData($supplier_id = null)
	{
		if($supplier_id) {
			$sql = "SELECT * FROM supplier WHERE supplier_id = ?";
			$query = $this->db->query($sql, array($supplier_id));
			return $query->row_array();
		}

		$sql = "SELECT * FROM supplier";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function getSupplierItem($supplier_id)
	{
	
		$sql = "SELECT item_id,item_name,item_code,item_price,unit_name,category_name
			   FROM item				   
			   		LEFT JOIN unit ON unit_fk = unit_id
			   		LEFT JOIN category ON category_fk = category_id
		   	WHERE supplier_fk = ?";
		$query = $this->db->query($sql, array($supplier_id));
		return $query->result_array();
				

	}

	public function create($data)
	{
		if ($data) {
			$insert = $this->db->insert('supplier', $data);
			$supplier_id = $this->db->insert_id();	
		return ($insert == true) ? $supplier_id : false;
		}
	}



	public function update($supplier_id, $data)
	{
		if($supplier_id) {
         $this->db->where('supplier_id', $supplier_id);
			$update = $this->db->update('supplier', $data);
			return ($update == true) ? true : false;
		}
	}



	public function remove($supplier_id)
	{
		if($supplier_id) {					

			$this->db->where('supplier_id', $supplier_id);
			$delete = $this->db->delete('supplier');	

			return ($delete == true) ? true : false;

		}
	}

	//---> Validate if the supplier is used in table Item and or movement

	public function checkIntegrity($supplier_id)
	{
		
		$num_rows = 0;
		
		$sql = "SELECT * FROM item WHERE supplier_fk = ?";
		$query = $this->db->query($sql, array($supplier_id));
		$num_rows = $query->num_rows();

		return $num_rows;
		
	}


	//----------------------------------------- DOCUMENT -------------------------------------------------------------->


	public function getSupplierDocument($supplier_id)
	{
	
		$sql = "SELECT document.*
		FROM document 
		WHERE supplier_fk = ?";
		$query = $this->db->query($sql, array($supplier_id));
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