<?php 

class Model_ingredient extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	//--> Get active information
	public function getActiveIngredient()
	{
		$sql = "SELECT * FROM ingredient WHERE active = ?";
		$query = $this->db->query($sql, array(1));
		return $query->result_array();
	}

	//--> Get the ingredient data
	public function getIngredientData($ingredient_id = null)
	{
		if($ingredient_id) {
			$sql = "SELECT * FROM ingredient WHERE ingredient_id = ?";
			$query = $this->db->query($sql, array($ingredient_id));
			return $query->row_array();
		}

		$sql = "SELECT * FROM ingredient";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function create($data)
	{
		if($data) {
			$insert = $this->db->insert('ingredient', $data);
			return ($insert == true) ? true : false;
		}
	}

	public function update($data, $ingredient_id)
	{
		if($data && $ingredient_id) {
			$this->db->where('ingredient_id', $ingredient_id);
			$update = $this->db->update('ingredient', $data);
			return ($update == true) ? true : false;
		}
	}

	public function remove($ingredient_id)
	{
		if($ingredient_id) {
			$this->db->where('ingredient_id', $ingredient_id);
			$delete = $this->db->delete('ingredient');
			return ($delete == true) ? true : false;
		}
	}


	//---> Validate if the ingredient is used in table Employee
	public function checkIntegrity($ingredient_id)
	{

		$num_rows = 0;

		$sql = "SELECT * FROM item WHERE ingredient_fk = ?";
		$query = $this->db->query($sql, array($ingredient_id));
		$num_rows = $query->num_rows();

		return $num_rows;
		
	}

}