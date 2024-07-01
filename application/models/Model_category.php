<?php 

class Model_category extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	//--> Get active information
	public function getActiveCategory()
	{
		$sql = "SELECT * FROM category WHERE active = ?";
		$query = $this->db->query($sql, array(1));
		return $query->result_array();
	}

	//--> Get the category data
	public function getCategoryData($category_id = null)
	{
		if($category_id) {
			$sql = "SELECT * FROM category WHERE category_id = ?";
			$query = $this->db->query($sql, array($category_id));
			return $query->row_array();
		}

		$sql = "SELECT * FROM category";
		$query = $this->db->query($sql);
		return $query->result_array();
	}


	public function create($data)
	{
		if($data) {
			$insert = $this->db->insert('category', $data);
			return ($insert == true) ? true : false;
		}
	}


	public function update($data, $category_id)
	{
		if($data && $category_id) {
			$this->db->where('category_id', $category_id);
			$update = $this->db->update('category', $data);
			return ($update == true) ? true : false;
		}
	}
	

	public function remove($category_id)
	{
		if($category_id) {
			$this->db->where('category_id', $category_id);
			$delete = $this->db->delete('category');
			return ($delete == true) ? true : false;
		}
	}

	//---> Validate if the category is used in table Item

	public function checkIntegrity($category_id)
	{
		
		$num_rows = 0;

		$sql = "SELECT * FROM item WHERE category_fk = ?";
		$query = $this->db->query($sql, array($category_id));
		$num_rows = $query->num_rows();

		return $num_rows;
		
	}

}