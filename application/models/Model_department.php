<?php 

class Model_department extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	//--> Get active information
	public function getActiveDepartment()
	{
		$sql = "SELECT * FROM department WHERE active = ? ORDER BY department_name";
		$query = $this->db->query($sql, array(1));
		return $query->result_array();
	}

	//--> Get the position data
	public function getDepartmentData($department_id = null)
	{
		if($department_id) {
			$sql = "SELECT * FROM department WHERE department_id = ?";
			$query = $this->db->query($sql, array($department_id));
			return $query->row_array();
		}

		$sql = "SELECT * FROM department";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function create($data)
	{
		if($data) {
			$insert = $this->db->insert('department', $data);
			return ($insert == true) ? true : false;
		}
	}

	public function update($data, $position_id)
	{
		if($data && $position_id) {
			$this->db->where('position_id', $position_id);
			$update = $this->db->update('position', $data);
			return ($update == true) ? true : false;
		}
	}

	public function remove($position_id)
	{
		if($position_id) {
			$this->db->where('position_id', $position_id);
			$delete = $this->db->delete('position');
			return ($delete == true) ? true : false;
		}
	}

	//---> Validate if the position is used in table Employee

	public function checkIntegrity($position_id)
	{
		
		$num_rows = 0;
		
		$sql = "SELECT * FROM employee WHERE position_fk = ?";
		$query = $this->db->query($sql, array($position_id));
		$num_rows = $query->num_rows();

		return $num_rows;
		
	}

}