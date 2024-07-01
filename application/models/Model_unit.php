<?php 

class Model_unit extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	//--> Get active information
	public function getActiveUnit()
	{
		$sql = "SELECT * FROM unit WHERE active = ?";
		$query = $this->db->query($sql, array(1));
		return $query->result_array();
	}

	//--> Get the unit data
	public function getUnitData($unit_id = null)
	{
		if($unit_id) {
			$sql = "SELECT * FROM unit WHERE unit_id = ?";
			$query = $this->db->query($sql, array($unit_id));
			return $query->row_array();
		}

		$sql = "SELECT * FROM unit";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function create($data)
	{
		if($data) {
			$insert = $this->db->insert('unit', $data);
			return ($insert == true) ? true : false;
		}
	}

	public function update($data, $unit_id)
	{
		if($data && $unit_id) {
			$this->db->where('unit_id', $unit_id);
			$update = $this->db->update('unit', $data);
			return ($update == true) ? true : false;
		}
	}

	public function remove($unit_id)
	{
		if($unit_id) {
			$this->db->where('unit_id', $unit_id);
			$delete = $this->db->delete('unit');
			return ($delete == true) ? true : false;
		}
	}

		//---> Validate if the unit is used in table Item

	public function checkIntegrity($unit_id)
	{

		$num_rows = 0;
		
		$sql = "SELECT * FROM item WHERE unit_fk = ?";
		$query = $this->db->query($sql, array($unit_id));
		$num_rows = $query->num_rows();

		$sql = "SELECT * FROM asset WHERE unit_fk = ?";
		$query = $this->db->query($sql, array($unit_id));
		$num_rows = $query->num_rows();

		return $num_rows;
		
	}

}