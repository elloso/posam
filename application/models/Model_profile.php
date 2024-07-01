<?php 

class Model_profile extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function getProfileData($profile_id = null) 
	{
		if($profile_id) {
			$sql = "SELECT * FROM profile WHERE profile_id = ?";
			$query = $this->db->query($sql, array($profile_id));
			return $query->row_array();
		}

		$sql = "SELECT * FROM profile WHERE profile_id != ?";
		$query = $this->db->query($sql, array(1));
		return $query->result_array();
	}

	public function create($data = '')
	{
		$create = $this->db->insert('profile', $data);
		return ($create == true) ? true : false;
	}

	public function edit($data, $profile_id)
	{
		$this->db->where('profile_id', $profile_id);
		$update = $this->db->update('profile', $data);
		return ($update == true) ? true : false;	
	}

	public function delete($profile_id)
	{
		$this->db->where('profile_id', $profile_id);
		$delete = $this->db->delete('profile');
		return ($delete == true) ? true : false;
	}

	public function existInUserProfile($profile_id)
	{
		$sql = "SELECT * FROM user WHERE profile_fk = ?";
		$query = $this->db->query($sql, array($profile_id));
		return ($query->num_rows() > 1) ? true : false;
	}

	public function getUserProfileByUserId($user_id) 
	{
		$sql = "SELECT * FROM user 
		JOIN profile ON profile_id = user.profile_fk 
		WHERE user_id = ?";
		$query = $this->db->query($sql, array($user_id));
		$result = $query->row_array();

		return $result;

	}
}