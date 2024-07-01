<?php 

class Model_employee_status extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	//--> Get active information
	public function getActiveEmployeeStatus()
	{
		$sql = "SELECT * FROM employee_status WHERE active = ? ORDER BY employee_status_name ASC";
		$query = $this->db->query($sql, array(1));
		return $query->result_array();
	}

	//--> Get the data of the table
	public function getEmployeeStatusData($employee_status_id = null)
	{
		if($employee_status_id) {
			$sql = "SELECT * FROM employee_status WHERE employee_status_id = ?";
			$query = $this->db->query($sql, array($employee_status_id));
			return $query->row_array();
		}

		$sql = "SELECT * FROM employee_status";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function create($data)
	{
		if($data) {
			$insert = $this->db->insert('employee_status', $data);
			return ($insert == true) ? true : false;
		}
	}

	public function update($data, $employee_status_id)
	{
		if($data && $employee_status_id) {
			$this->db->where('employee_status_id', $employee_status_id);
			$update = $this->db->update('employee_status', $data);
			return ($update == true) ? true : false;
		}
	}

	public function remove($employee_status_id)
	{
		if($employee_status_id) {
			$this->db->where('employee_status_id', $employee_status_id);
			$delete = $this->db->delete('employee_status');
			return ($delete == true) ? true : false;
		}
	}

	//---> Validate if the employee status is used in table Employee
	public function checkIntegrity($employee_status_id)
	{
		$sql = "SELECT * FROM employee WHERE employee_status_fk = ?";
		$query = $this->db->query($sql, array($employee_status_id));
		return $query->num_rows();
		
	}

}