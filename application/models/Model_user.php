<?php 

class Model_user extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	
	public function getUserData($user_id = null)
	{
		if($user_id) {
			$sql = "SELECT user.*,profile_name 
			FROM user 
		    JOIN profile ON profile_fk = profile_id
			WHERE user_id = ?";
			$query = $this->db->query($sql, array($user_id));
			return $query->row_array();
		}

		$sql = "SELECT user.*
		FROM user ORDER BY user_name ASC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}


		public function getUserProfile($user_id = null) 
	{
		if($user_id) {
			$sql = "SELECT * FROM user WHERE user_id = ?";
			$query = $this->db->query($sql, array($user_id));
			$result = $query->row_array();

			$profile_fk = $result['profile_fk'];
			$p_sql = "SELECT * FROM profile WHERE profile_id = ?";
			$p_query = $this->db->query($p_sql, array($profile_fk));
			$q_result = $p_query->row_array();
			return $q_result;
		}
	}
	
	



	public function create()
	{

		if(empty($this->input->post('password'))) {
	    	$data = array(
	    		'active' => $this->input->post('active'), 
	    		'username' => (($this->input->post('username') != FALSE) ? $this->input->post('username') : NULL), 
	    		'email' => (($this->input->post('email') != FALSE) ? $this->input->post('email') : NULL),   		
	    		'phone' => $this->input->post('phone'),
	    		'user_name' => $this->input->post('user_name'),
	    		'remark' => (($this->input->post('remark') != FALSE) ? $this->input->post('remark') : NULL),  
	    		'profile_fk' => (($this->input->post('profile') != FALSE) ? $this->input->post('profile') : NULL),   		
	    		'updated_by' => $this->session->userdata('user_id'),
	    	);}
	    else  {
	    	$password = $this->password_hash($this->input->post('password'));
		    $data = array(
	    		'active' => $this->input->post('active'), 
	    		'username' => (($this->input->post('username') != FALSE) ? $this->input->post('username') : NULL), 
	    		'email' => (($this->input->post('email') != FALSE) ? $this->input->post('email') : NULL),   		
	    		'phone' => $this->input->post('phone'),
	    		'user_name' => $this->input->post('user_name'),
	    		'remark' => (($this->input->post('remark') != FALSE) ? $this->input->post('remark') : NULL),  
	            'password' => $password,		
	    		'profile_fk' => (($this->input->post('profile') != FALSE) ? $this->input->post('profile') : NULL),   		
	    		'updated_by' => $this->session->userdata('user_id'),
	    	);}

		$insert = $this->db->insert('user', $data);
		$user_id = $this->db->insert_id();		

		return ($user_id) ? $user_id : false;
	}



	public function update($user_id, $data)
	{
		if($user_id) {
		    $this->db->where('user_id', $user_id);
			$update = $this->db->update('user', $data);
			return true;
		}
	}


    public function password_hash($pass = '')
	{
		if($pass) {
			$password = password_hash($pass, PASSWORD_DEFAULT);
			return $password;
		}
	}	


	

	

	public function remove($user_id)
	{
		if($user_id) {
			$this->db->where('user_id', $user_id);
			$delete = $this->db->delete('user');
			return ($delete == true) ? true : false;

		}
	}

	public function countTotalUser()
	{
		$sql = "SELECT * FROM user";
		$query = $this->db->query($sql);
		return $query->num_rows();
	}


 


}