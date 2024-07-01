<?php 

class Model_area extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	//--> Get active information
	public function getActiveArea()
	{
		$sql = "SELECT * FROM area WHERE active = ? ORDER BY area_name";
		$query = $this->db->query($sql, array(1));
		return $query->result_array();
	}

	//--> Get the area data
	public function getAreaData($area_id = null)
	{
		if($area_id) {
			$sql = "SELECT * FROM area WHERE area_id = ?";
			$query = $this->db->query($sql, array($area_id));
			return $query->row_array();
		}

		$sql = "SELECT * FROM area";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function create($data)
	{
		if($data) {
			$insert = $this->db->insert('area', $data);
			return ($insert == true) ? true : false;
		}
	}

	public function update($data, $area_id)
	{
		if($data && $area_id) {
			$this->db->where('area_id', $area_id);
			$update = $this->db->update('area', $data);
			return ($update == true) ? true : false;
		}
	}

	public function remove($area_id)
	{
		if($area_id) {
			$this->db->where('area_id', $area_id);
			$delete = $this->db->delete('area');
			return ($delete == true) ? true : false;
		}
	}

		//---> Validate if the area is used in table Item

	public function checkIntegrity($area_id)
	{
		
		$num_rows = 0;
		
		$sql = "SELECT * FROM customer WHERE area_fk = ?";
		$query = $this->db->query($sql, array($area_id));
		$num_rows = $query->num_rows();

		return $num_rows;
		
	}

}