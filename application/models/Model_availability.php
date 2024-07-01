<?php 

class Model_availability extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	//--> Get active information
	public function getActiveAvailability()
	{
		$sql = "SELECT * FROM availability WHERE active = ?";
		$query = $this->db->query($sql, array(1));
		return $query->result_array();
	}

	//--> Get the availability data
	public function getAvailabilityData($availability_id = null)
	{
		if($availability_id) {
			$sql = "SELECT * FROM availability WHERE availability_id = ?";
			$query = $this->db->query($sql, array($availability_id));
			return $query->row_array();
		}

		$sql = "SELECT * FROM availability";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function create($data)
	{
		if($data) {
			$insert = $this->db->insert('availability', $data);
			return ($insert == true) ? true : false;
		}
	}

	public function update($data, $availability_id)
	{
		if($data && $availability_id) {
			$this->db->where('availability_id', $availability_id);
			$update = $this->db->update('availability', $data);
			return ($update == true) ? true : false;
		}
	}

	public function remove($availability_id)
	{
		if($availability_id) {
			$this->db->where('availability_id', $availability_id);
			$delete = $this->db->delete('availability');
			return ($delete == true) ? true : false;
		}
	}


	//---> Validate if the availability is used in table Employee
	public function checkIntegrity($availability_id)
	{
		$num_rows = 0;

		$sql = "SELECT * FROM asset WHERE availability_fk = ?";
		$query = $this->db->query($sql, array($availability_id));
		$num_rows = $query->num_rows();

		return $num_rows;
		
	}

}