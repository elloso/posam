<?php 

class Model_maintenance_type extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	//--> Get active information
	public function getActiveMaintenanceType()
	{
		$sql = "SELECT * FROM maintenance_type WHERE active = ? ORDER BY maintenance_type_name ASC";
		$query = $this->db->query($sql, array(1));
		return $query->result_array();
	}

	//--> Get the data of the table
	public function getMaintenanceTypeData($maintenance_type_id = null)
	{
		if($maintenance_type_id) {
			$sql = "SELECT * FROM maintenance_type WHERE maintenance_type_id = ?";
			$query = $this->db->query($sql, array($maintenance_type_id));
			return $query->row_array();
		}

		$sql = "SELECT * FROM maintenance_type";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function create($data)
	{
		if($data) {
			$insert = $this->db->insert('maintenance_type', $data);
			return ($insert == true) ? true : false;
		}
	}

	public function update($data, $maintenance_type_id)
	{
		if($data && $maintenance_type_id) {
			$this->db->where('maintenance_type_id', $maintenance_type_id);
			$update = $this->db->update('maintenance_type', $data);
			return ($update == true) ? true : false;
		}
	}

	public function remove($maintenance_type_id)
	{
		if($maintenance_type_id) {
			$this->db->where('maintenance_type_id', $maintenance_type_id);
			$delete = $this->db->delete('maintenance_type');
			return ($delete == true) ? true : false;
		}
	}

	//---> Validate if the maintenance type is used in table Maintenance
	public function checkIntegrity($maintenance_type_id)
	{
		$sql = "SELECT * FROM maintenance WHERE maintenance_type_fk = ?";
		$query = $this->db->query($sql, array($maintenance_type_id));
		return $query->num_rows();
		
	}

}