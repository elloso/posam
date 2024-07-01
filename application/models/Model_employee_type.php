<?php 

class Model_employee_type extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	//--> Get active information
	public function getActiveEmployeeType()
	{
		$sql = "SELECT * FROM employee_type WHERE active = ? ORDER BY employee_type_name ASC";
		$query = $this->db->query($sql, array(1));
		return $query->result_array();
	}

	//--> Get the data of the table
	public function getEmployeeTypeData($employee_type_id = null)
	{
		if($employee_type_id) {
			$sql = "SELECT * FROM employee_type WHERE employee_type_id = ?";
			$query = $this->db->query($sql, array($employee_type_id));
			return $query->row_array();
		}

		$sql = "SELECT * FROM employee_type";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function create($data)
	{
		if($data) {
			$insert = $this->db->insert('employee_type', $data);
			return ($insert == true) ? true : false;
		}
	}

	public function update($data, $employee_type_id)
	{
		if($data && $employee_type_id) {
			$this->db->where('employee_type_id', $employee_type_id);
			$update = $this->db->update('employee_type', $data);
			return ($update == true) ? true : false;
		}
	}

	public function remove($employee_type_id)
	{
		if($employee_type_id) {
			$this->db->where('employee_type_id', $employee_type_id);
			$delete = $this->db->delete('employee_type');
			return ($delete == true) ? true : false;
		}
	}

	//---> Validate if the employee type is used in table Employee
	public function checkIntegrity($employee_type_id)
	{
		$sql = "SELECT * FROM employee WHERE employee_type_fk = ?";
		$query = $this->db->query($sql, array($employee_type_id));
		return $query->num_rows();
		
	}

}