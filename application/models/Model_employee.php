<?php 

class Model_employee extends CI_Model
{
	public function __construct()
	{
		parent::__construct();

	}

	
	public function getEmployeeData($employee_id = null)
	{
		if($employee_id) {
			$sql = "SELECT employee.*,area_name,municipality_name,
							CONCAT(last_name, ' ', first_name) AS 'employee_name'
		   FROM employee
			   LEFT JOIN area ON employee.area_fk = area_id
			   LEFT JOIN municipality ON employee.municipality_fk = municipality_id
		   WHERE employee_id = ?";
			$query = $this->db->query($sql, array($employee_id));
			return $query->row_array();
		}

		$sql = "SELECT employee.*,area_name,municipality_name,employee_type_name,
						CONCAT(last_name, ' ', first_name) AS 'employee_name'	
		FROM employee 
		 	LEFT JOIN area ON employee.area_fk = area_id
		   LEFT JOIN municipality ON employee.municipality_fk = municipality_id
		   LEFT JOIN employee_type ON employee.employee_type_fk = employee_type_id
		ORDER BY last_name,first_name ASC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}


	public function getActiveEmployee()
	{

		$sql = "SELECT employee.*,area_name,municipality_name,CONCAT(last_name, ' ', first_name) AS 'employee_name'
		FROM employee 
			LEFT JOIN area ON employee.area_fk = area_id
			LEFT JOIN municipality ON employee.municipality_fk = municipality_id
		WHERE employee.active = ?		
		ORDER BY last_name,first_name ASC";
		$query = $this->db->query($sql, array(1));
		return $query->result_array();
	}


	public function create($data)
	{
		if ($data) {
			$insert = $this->db->insert('employee', $data);
			$employee_id = $this->db->insert_id();	
		return ($insert == true) ? $employee_id : false;
		}
	}



	public function update($employee_id, $data)
	{
		if($employee_id) {
         $this->db->where('employee_id', $employee_id);
			$update = $this->db->update('employee', $data);
			return ($update == true) ? true : false;
		}
	}



	public function remove($employee_id)
	{
		if($employee_id) {					

			$this->db->where('employee_id', $employee_id);
			$delete = $this->db->delete('employee');	

			return ($delete == true) ? true : false;

		}
	}


	//---> Validate if the employee is used in other tables
	public function checkIntegrity($employee_id)
	{
		$sql = "SELECT * FROM orders WHERE employee_fk = ?";
		$query = $this->db->query($sql, array($employee_id));
		return $query->num_rows();
		
	}

	

	public function countTotalEmployee()
	{
		$sql = "SELECT * FROM employee";
		$query = $this->db->query($sql);
		return $query->num_rows();
	}



	public function generateEmployeeCode()
	{  
		// We need to verify if employee exists in the database to create
		// the first occurence of the employee code EMP001
		$sql = "SELECT CASE WHEN count(*) = 0 THEN 'EMP001' ELSE 
					(SELECT CASE WHEN SUBSTRING(employee_code,4,3) < 100 THEN
							CONCAT('EMP',LPAD(SUBSTRING(employee_code,4,3) + 1, 3, 0)) 
							ELSE 	CONCAT('EMP',SUBSTRING(employee_code,4,3) + 1)
							END 
						FROM employee 
						ORDER BY employee_code DESC LIMIT 1) END AS 'employee_code'
		FROM employee";
		$query = $this->db->query($sql);
		return $query->row_array();
		
	}



//----------------------------------------- DOCUMENT -------------------------------------------------------------->


	public function getEmployeeDocument($employee_id)
	{
	
		$sql = "SELECT document.*
		FROM document 
		WHERE employee_fk = ?";
		$query = $this->db->query($sql, array($employee_id));
		return $query->result_array();
				

	}


	public function createDocument($data)
	{
		if($data) {
			$insert = $this->db->insert('document', $data);
			return ($insert == true) ? true : false;
		}
	}

	public function removeDocument($document_id)
	{
		if($document_id) {
			$this->db->where('document_id', $document_id);
			$delete = $this->db->delete('document');
			return ($delete == true) ? true : false;
		}
	}

	public function getDocument($document_id = null)
	{
		$sql = "SELECT *
		FROM document
		WHERE document_id = ?";
		$query = $this->db->query($sql, array($document_id));
		return $query->row_array();

	}




}