<?php

class Model_log extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}



	public function create($data)
	{
		if($data) {
			$insert = $this->db->insert('log', $data);
			return ($insert == true) ? true : false;
		}
	}

	public function timeline($id)
    {
        $sql = "SELECT * FROM log WHERE subject_fk = ? ORDER BY timestamp DESC";
        $query = $this->db->query($sql, array($id));
        return $query->result_array();
    }

     public function timeline_asset($asset_id)
    {
        $sql = "SELECT log.*,(SELECT user_name FROM user WHERE log.updated_by = user.user_id) AS 'updated_by'    
        FROM log 
        WHERE asset_fk = ? 
        ORDER BY updated_date DESC";
        $query = $this->db->query($sql, array($asset_id));
        return $query->result_array();
    }


    public function timeline_customer($customer_id)
    {
        $sql = "SELECT log.*,(SELECT user_name FROM user WHERE log.updated_by = user.user_id) AS 'updated_by'    
        FROM log 
        WHERE customer_fk = ? 
        ORDER BY updated_date DESC";
        $query = $this->db->query($sql, array($customer_id));
        return $query->result_array();
    }



    public function timeline_item($item_id)
    {
        $sql = "SELECT log.*,(SELECT user_name FROM user WHERE log.updated_by = user.user_id) AS 'updated_by'    
        FROM log 
        WHERE item_fk = ? 
        ORDER BY updated_date DESC";
        $query = $this->db->query($sql, array($item_id));
        return $query->result_array();
    }


    public function timeline_employee($employee_id)
    {
        $sql = "SELECT log.*,(SELECT user_name FROM user WHERE log.updated_by = user.user_id) AS 'updated_by'    
        FROM log 
        WHERE employee_fk = ? 
        ORDER BY updated_date DESC";
        $query = $this->db->query($sql, array($employee_id));
        return $query->result_array();
    }


    public function timeline_supplier($supplier_id)
    {
        $sql = "SELECT log.*,(SELECT user_name FROM user WHERE log.updated_by = user.user_id) AS 'updated_by'    
        FROM log 
        WHERE supplier_fk = ? 
        ORDER BY updated_date DESC";
        $query = $this->db->query($sql, array($supplier_id));
        return $query->result_array();
    }
    

    public function timeline_order($order_id)
    {
        $sql = "SELECT log.*,(SELECT user_name FROM user WHERE log.updated_by = user.user_id) AS 'updated_by'    
        FROM log 
        WHERE order_fk = ? 
        ORDER BY updated_date DESC";
        $query = $this->db->query($sql, array($order_id));
        return $query->result_array();
    }

    
}

?>