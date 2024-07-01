<?php 

class Model_maintenance extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}


	public function getMaintenanceData($maintenance_id = null)
	{
		if($maintenance_id) {
			$sql = "SELECT * FROM maintenance where maintenance_id = ?";
			$query = $this->db->query($sql, array($maintenance_id));
			return $query->row_array();
		}

		$sql = "SELECT * FROM maintenance";
		$query = $this->db->query($sql);
		return $query->result_array();
	}


	// get the list of maintenance
	public function getMaintenance($asset_id)
	{

		$sql = "SELECT maintenance_id,maintenance_name,		        
		        DATE(maintenance_date) AS 'maintenance_date',remark,
		        maintenance_type_name
				FROM maintenance
					 JOIN maintenance_type ON maintenance.maintenance_type_fk = maintenance_type_id
				WHERE maintenance.asset_fk = ?";
		$query = $this->db->query($sql, array($asset_id));
		return $query->result_array();
	}


	public function getMaintenanceAsset($asset_id = null)
	{
		$sql = "SELECT * FROM maintenance WHERE asset_fk = ?";
		$query = $this->db->query($sql, array($asset_id));
		return $query->result_array();
	}
	
	
	public function create($data)
	{
		if($data) {
			$insert = $this->db->insert('maintenance', $data);
			return ($insert == true) ? true : false;
		}
	}

	public function update($data, $maintenance_id)
	{
		if($data && $maintenance_id) {
			$this->db->where('maintenance_id', $maintenance_id);
			$update = $this->db->update('maintenance', $data);
			return ($update == true) ? true : false;
		}
	}

	public function remove($maintenance_id)
	{
		if($maintenance_id) {
			$this->db->where('maintenance_id', $maintenance_id);
			$delete = $this->db->delete('maintenance');
			return ($delete == true) ? true : false;
		}
	}



}