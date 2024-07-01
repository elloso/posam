<?php 

class Model_location extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	//--> Get active information
	public function getActiveLocation()
	{
		$sql = "SELECT *
				FROM location 
				WHERE active = ? 
				ORDER BY location_name";
		$query = $this->db->query($sql, array(1));
		return $query->result_array();
	}

	//--> Get the location data
	public function getLocationData($location_id = null)
	{
		if($location_id) {
			$sql = "SELECT * FROM location WHERE location_id = ?";
			$query = $this->db->query($sql, array($location_id));
			return $query->row_array();
		}

		$sql = "SELECT * FROM location";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function create($data)
	{
		if($data) {
			$insert = $this->db->insert('location', $data);
			return ($insert == true) ? true : false;
		}
	}

	public function update($data, $location_id)
	{
		if($data && $location_id) {
			$this->db->where('location_id', $location_id);
			$update = $this->db->update('location', $data);
			return ($update == true) ? true : false;
		}
	}

	public function remove($location_id)
	{
		if($location_id) {
			$this->db->where('location_id', $location_id);
			$delete = $this->db->delete('location');
			return ($delete == true) ? true : false;
		}
	}

	//---> Validate if the location is used in table Item_location

	public function checkIntegrity($location_id)
	{
		
		$num_rows = 0;
		
		$sql = "SELECT * FROM item_location WHERE location_fk = ?";
		$query = $this->db->query($sql, array($location_id));
		$num_rows = $query->num_rows();

		$sql = "SELECT * FROM asset_location WHERE location_fk = ?";
		$query = $this->db->query($sql, array($location_id));
		$num_rows = $num_rows + $query->num_rows();

		return $num_rows;
		
	}

}