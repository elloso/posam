<?php 

class Model_organization extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	
	public function getOrganizationData($organization_id = null)
	{
		if($organization_id) {
			$sql = "SELECT * FROM organization WHERE organization_id = ?";
			$query = $this->db->query($sql, array($organization_id));
			return $query->row_array();
		}
	}

	public function update($data, $organization_id)
	{
		if($data && $organization_id) {
			$this->db->where('organization_id', $organization_id);
			$update = $this->db->update('organization', $data);
			return ($update == true) ? true : false;
		}
	}


}