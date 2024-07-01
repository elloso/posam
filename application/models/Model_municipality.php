<?php 

class Model_municipality extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	//--> Get active information
	public function getActiveMunicipality()
	{
		$sql = "SELECT * FROM municipality WHERE active = ?";
		$query = $this->db->query($sql, array(1));
		return $query->result_array();
	}

	//--> Get the municipality data
	public function getMunicipalityData($municipality_id = null)
	{
		if($municipality_id) {
			$sql = "SELECT * FROM municipality WHERE municipality_id = ?";
			$query = $this->db->query($sql, array($municipality_id));
			return $query->row_array();
		}

		$sql = "SELECT * FROM municipality";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function create($data)
	{
		if($data) {
			$insert = $this->db->insert('municipality', $data);
			return ($insert == true) ? true : false;
		}
	}

	public function update($data, $municipality_id)
	{
		if($data && $municipality_id) {
			$this->db->where('municipality_id', $municipality_id);
			$update = $this->db->update('municipality', $data);
			return ($update == true) ? true : false;
		}
	}

	public function remove($municipality_id)
	{
		if($municipality_id) {
			$this->db->where('municipality_id', $municipality_id);
			$delete = $this->db->delete('municipality');
			return ($delete == true) ? true : false;
		}
	}

		//---> Validate if the municipality is used in table Item

	public function checkIntegrity($municipality_id)
	{
		
		$num_rows = 0;
		
		$sql = "SELECT * FROM customer WHERE municipality_fk = ?";
		$query = $this->db->query($sql, array($municipality_id));
		$num_rows = $query->num_rows();

		return $num_rows;
		
	}

}