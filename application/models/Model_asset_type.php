<?php 

class Model_asset_type extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	//--> Get active information
	public function getActiveAssetType()
	{
		$sql = "SELECT * FROM asset_type WHERE active = ? ORDER BY asset_type_name ASC";
		$query = $this->db->query($sql, array(1));
		return $query->result_array();
	}

	//--> Get the data of the table
	public function getAssetTypeData($asset_type_id = null)
	{
		if($asset_type_id) {
			$sql = "SELECT * FROM asset_type WHERE asset_type_id = ?";
			$query = $this->db->query($sql, array($asset_type_id));
			return $query->row_array();
		}

		$sql = "SELECT * FROM asset_type";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function create($data)
	{
		if($data) {
			$insert = $this->db->insert('asset_type', $data);
			return ($insert == true) ? true : false;
		}
	}

	public function update($data, $asset_type_id)
	{
		if($data && $asset_type_id) {
			$this->db->where('asset_type_id', $asset_type_id);
			$update = $this->db->update('asset_type', $data);
			return ($update == true) ? true : false;
		}
	}

	public function remove($asset_type_id)
	{
		if($asset_type_id) {
			$this->db->where('asset_type_id', $asset_type_id);
			$delete = $this->db->delete('asset_type');
			return ($delete == true) ? true : false;
		}
	}

	//---> Validate if the asset type is used in table Asset
	public function checkIntegrity($asset_type_id)
	{
		$sql = "SELECT * FROM asset WHERE asset_type_fk = ?";
		$query = $this->db->query($sql, array($asset_type_id));
		return $query->num_rows();
		
	}

}