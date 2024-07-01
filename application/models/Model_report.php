<?php 

class Model_report extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}


		public function getReportList($report_for)
	{
		if ($report_for == 'all') {
			$sql = "SELECT report_code,report_title
					FROM report
					WHERE report_for <> 'none'
					ORDER BY report_code";
			$query = $this->db->query($sql, array());
			return $query->result_array();
		}

		$sql = "SELECT report_code,report_title
				FROM report
				WHERE report_for = ?
				ORDER BY report_code";
		$query = $this->db->query($sql, array($report_for));
		return $query->result_array();
	}


	public function getReportTitle($report_code)
	{

	    $sql = "SELECT report_code, report_title 
				FROM report WHERE report_code = ?";
			
		$query = $this->db->query($sql, array($report_code));
		return $query->row_array();
	}



	public function getReportInfo ($report_code)
	{

		$sql = "SELECT report_code,report_title,(SELECT logo_visible FROM organization) AS 'logo_visible'
				FROM report
				WHERE report_code = ?
				ORDER BY report_code";
		$query = $this->db->query($sql, array($report_code));
		return $query->row_array();
	}



	//--> print a specific order
	public function getReportOrder($order_id)
	{
		
		$sql = "SELECT orders.*,CONCAT(last_name, ' ', first_name) AS 'employee_name',customer_name,customer.phone AS 'phone',
						area_name,municipality_name,customer.address as 'address',
						balance,order_total,(balance-order_total) AS 'previous_balance'						
		FROM orders
		LEFT JOIN customer ON customer_fk = customer_id 
		LEFT JOIN employee ON employee_fk = employee_id
		LEFT JOIN area ON customer.area_fk = area_id
		LEFT JOIN municipality ON customer.municipality_fk = municipality_id
		WHERE order_id = ?";
		$query = $this->db->query($sql, array($order_id));
		return $query->result();		

	}


	//--> print the items of a specific order_id
	public function getReportOrderItem($order_id)
	{
		
		$sql = "SELECT item_name,location_name,unit_name,item_code,
		               rate,movement.quantity AS 'quantity', 
		               (rate * movement.quantity) AS 'amount'
		FROM movement
			 JOIN item_location ON movement.item_location_fk = item_location_id
			 JOIN item ON item_location.item_fk = item_id
             LEFT JOIN unit ON unit_fk = unit_id
			 JOIN location ON item_location.location_fk = location_id

		WHERE order_fk = ?
		     AND movement.item_location_fk IS NOT NULL";
		$query = $this->db->query($sql, array($order_id));
		return $query->result();		

	}



	//--> print a specific requisition
	public function getReportRequisition($requisition_id)
	{
		
		$sql = "SELECT requisition.*,CONCAT(last_name, ' ', first_name) AS 'employee_requested_name',
					(SELECT CONCAT(last_name, ' ', first_name) FROM employee WHERE employee_id = employee_approved_fk) AS 'employee_approved_name'				
		FROM requisition
		LEFT JOIN employee ON employee_requested_fk = employee_id		
		WHERE requisition_id = ?";
		$query = $this->db->query($sql, array($requisition_id));
		return $query->result();		

	}


	//--> print the items of a specific requisition_id
	public function getReportRequisitionItem($requisition_id)
	{
		
		$sql = "SELECT item_name,location_name,unit_name,item_code,
		               movement.quantity AS 'quantity'
		FROM movement
			 JOIN item_location ON movement.item_location_fk = item_location_id
			 JOIN item ON item_location.item_fk = item_id
             LEFT JOIN unit ON unit_fk = unit_id
			 JOIN location ON item_location.location_fk = location_id
		WHERE requisition_fk = ?
		     AND movement.item_location_fk IS NOT NULL";
		$query = $this->db->query($sql, array($requisition_id));
		return $query->result();		

	}


	//--> print a specific requisition
	public function getReportDelivery($delivery_id)
	{
		
		$sql = "SELECT delivery.*,supplier_name			
		FROM delivery
		LEFT JOIN supplier ON supplier_fk = supplier_id		
		WHERE delivery_id = ?";
		$query = $this->db->query($sql, array($delivery_id));
		return $query->result();		

	}


	//--> print the items of a specific delivery_id
	public function getReportDeliveryItem($delivery_id)
	{
		
		$sql = "SELECT item_name,location_name,unit_name,item_code,
		               movement.quantity AS 'quantity'
		FROM movement
			 JOIN item_location ON movement.item_location_fk = item_location_id
			 JOIN item ON item_location.item_fk = item_id
             LEFT JOIN unit ON unit_fk = unit_id
			 JOIN location ON item_location.location_fk = location_id
		WHERE delivery_fk = ?
		     AND movement.item_location_fk IS NOT NULL";
		$query = $this->db->query($sql, array($delivery_id));
		return $query->result();		

	}



	


	//--> print a specific item
	public function getReportItem($item_id)
	{
		
		$sql = "SELECT item.*,category_name,unit_name,supplier_name,
		        CASE WHEN item.active = 1 THEN 'Yes' else 'No' END AS 'active',
		        CASE WHEN inventory = 1 THEN 'Yes' else 'No' END AS 'inventory', 
		        CASE WHEN inventory = 2 THEN null else (SELECT sum(quantity) FROM item_location WHERE item_fk = item_id) END AS 'quantity_total'

		FROM item
			LEFT JOIN unit ON unit_fk = unit_id
			LEFT JOIN category ON category_fk = category_id
			LEFT JOIN supplier ON supplier_fk = supplier_id
		WHERE item_id = ?";
		$query = $this->db->query($sql, array($item_id));
		return $query->result();		

	}



	//--> print a specific item
	public function getReportItemlocation($item_id)
	{
		
		$sql = "SELECT location_name,
				 CASE WHEN inventory = 2 THEN null else quantity END AS 'quantity'
		FROM item_location
			LEFT JOIN location ON item_location.location_fk = location_id
			JOIN item ON item_location.item_fk = item_id
		WHERE item_fk = ?";
		$query = $this->db->query($sql, array($item_id));
		return $query->result();		

	}


	//--> print a specific item
	public function getReportItemProduction($item_id)
	{
		
		$sql = "SELECT ingredient_name,formula,formula_unit
		FROM item_ingredient
			 JOIN ingredient ON item_ingredient.ingredient_fk = ingredient_id
		WHERE item_fk = ?";
		$query = $this->db->query($sql, array($item_id));
		return $query->result();		

	}



	//--> print a specific asset
	public function getReportAsset($asset_id)
	{
		
		$sql = "SELECT asset_code,asset_name,acquisition_date,
				asset_value,description,location_name,serial_number,
		        asset_type_name,availability_name,asset_quantity,
		        asset.remark AS 'asset_remark'
		FROM asset
			LEFT JOIN availability ON asset.availability_fk = availability_id
			LEFT JOIN location ON asset.location_fk = location_id
			LEFT JOIN asset_type ON asset_type_fk = asset_type_id
		WHERE asset_id = ?";
		$query = $this->db->query($sql, array($asset_id));
		return $query->result();		

	}


	//--> print the maintenance of the asset
	public function getReportAssetMaintenance($asset_id)
	{
		
		$sql = "SELECT maintenance_type_name,
		        maintenance.description AS 'description',cost,
		        DATE(maintenance_date) AS 'maintenance_date',
		        maintenance.remark AS 'maintenance_remark',
		        maintenance_name
				FROM maintenance_type
					LEFT JOIN maintenance ON maintenance.maintenance_type_fk = maintenance_type_id
				WHERE maintenance.asset_fk = ?";
		$query = $this->db->query($sql, array($asset_id));
		return $query->result();		
    }

	


	//Get maintenance documents for a specific asset

		public function getReportMaintenanceDocument($asset_id)
		{
			$sql = "SELECT doc_name, doc_size
			FROM document
			WHERE  asset_fk = ?";
			$query = $this->db->query($sql, array($asset_id));
			return $query->result();
		}


	//--> print a specific customer
	public function getReportCustomer($customer_id)
	{
		
		$sql = "SELECT customer.*,customer_type_name,area_name,municipality_name
		FROM customer
			LEFT JOIN customer_type ON customer_type_fk = customer_type_id
			LEFT JOIN area ON area_fk = area_id
			LEFT JOIN municipality ON municipality_fk = municipality_id
		WHERE customer_id = ?";
		$query = $this->db->query($sql, array($customer_id));
		return $query->result();		

	}

	public function getReportCustomerDocument($customer_id)
		{
			$sql = "SELECT doc_name, doc_size
			FROM document
			WHERE  customer_fk = ?";
			$query = $this->db->query($sql, array($customer_id));
			return $query->result();
		}	


	//--> print the order of a specific customer
	public function getReportCustomerOrder($customer_id)
	{
		
		$sql = "SELECT orders.*
		FROM orders
		WHERE customer_fk = ?
		ORDER BY order_date DESC";
		$query = $this->db->query($sql, array($customer_id));
		return $query->result();		

	}	


	//--> print the payment of a specific customer
	public function getReportCustomerPayment($customer_id)
	{
		
		$sql = "SELECT payment.*,order_no,
			CASE WHEN payment_type = 1 THEN 'Payment' ELSE 'Credit' END AS 'payment_type'
		FROM payment
		LEFT JOIN orders ON payment.order_fk = order_id
		WHERE payment.customer_fk = ?
		ORDER BY payment_date DESC";
		$query = $this->db->query($sql, array($customer_id));
		return $query->result();		

	}	


	//--> print a specific employee
	public function getReportEmployee($employee_id)
	{
		
		$sql = "SELECT employee.*,employee_type_name,area_name,municipality_name,
					CONCAT(last_name, ' ', first_name) AS 'employee_name',
					position_name,employee_status_name
		FROM employee
			LEFT JOIN employee_type ON employee_type_fk = employee_type_id
			LEFT JOIN area ON area_fk = area_id
			LEFT JOIN municipality ON municipality_fk = municipality_id
			LEFT JOIN employee_status ON employee_status_fk = employee_status_id
			LEFT JOIN position ON position_fk = position_id
		WHERE employee_id = ?";
		$query = $this->db->query($sql, array($employee_id));
		return $query->result();		

	}	


	//--> print the requisition of a specific employee
	public function getReportEmployeeRequisition($employee_id)
	{
		
		$sql = "SELECT requisition.*,CONCAT(last_name, ' ', first_name) AS 'approved_by',
					   requisition.remark AS 'remark'
		FROM requisition
		LEFT JOIN employee ON employee_approved_fk = employee_id
		WHERE employee_requested_fk = ?
		ORDER BY requisition_date DESC";
		$query = $this->db->query($sql, array($employee_id));
		return $query->result();		

	}	

	public function getReportEmployeeDocument($employee_id)
		{
			$sql = "SELECT doc_name, doc_size
			FROM document
			WHERE  employee_fk = ?";
			$query = $this->db->query($sql, array($employee_id));
			return $query->result();
		}


    //--> print a specific supplier
	public function getReportSupplier($supplier_id)
	{
		
		$sql = "SELECT supplier.*
		FROM supplier
		WHERE supplier_id = ?";
		$query = $this->db->query($sql, array($supplier_id));
		return $query->result();		

	}

	public function getReportSupplierDocument($supplier_id)
		{
			$sql = "SELECT doc_name, doc_size
			FROM document
			WHERE  supplier_fk = ?";
			$query = $this->db->query($sql, array($supplier_id));
			return $query->result();
		}	


	public function getReportSupplierItem($supplier_id)
	{
		
		$sql = "SELECT item_id,item_name,item_code,item_price,unit_name,category_name
			   FROM item				   
			   		LEFT JOIN unit ON unit_fk = unit_id
			   		LEFT JOIN category ON category_fk = category_id
		   	WHERE supplier_fk = ?";
		$query = $this->db->query($sql, array($supplier_id));
		return $query->result();		

	}			
	
	


    //---> List of items
	
	public function get_REP01($format = null)
	{
	
		$sql = "SELECT item.*,unit_name,category_name,
				CASE WHEN inventory = 2 THEN null else (SELECT sum(quantity) FROM item_location WHERE item_fk = item_id) END AS 'quantity',
				CASE WHEN inventory = 2 THEN null else ROUND(((SELECT sum(quantity) FROM item_location WHERE item_fk = item_id) * item_price),2) END AS 'total'
		FROM item		    
			LEFT JOIN unit ON item.unit_fk = unit_id
			LEFT JOIN category ON category_fk = category_id
		WHERE item.active = 1
		ORDER BY item_name";       
		
		//If the format is list, we generate a datatable.  If not, we generate
		//for using in FPDF

		if ($format == 'list') {
			$query = $this->db->query($sql, array());
			return $query->result_array();		
		} else {			
			$query = $this->db->query($sql, array());
			if ($query->num_rows() > 0) {return $query->result();}
			return NULL;
		}		

	}


	

	//---> List of assets
	
	public function get_REP02($format = null)
	{
		//--> Criteria availability
		$availability = $this->session->availability;
		
        if ($availability == 'all') {
        	$availability_from = 0;
			$availability_to = 999;
        }
        else {
			$availability_from = $availability;
			$availability_to = $availability;
		}
		
		$sql = "SELECT asset_name,asset_value,description,serial_number,asset_type_name,
		       asset_code,availability_fk,brand,asset_quantity,location_name
		FROM asset
		     LEFT JOIN location ON asset.location_fk = location_id
		     LEFT JOIN asset_type ON asset_type_fk = asset_type_id
		WHERE availability_fk BETWEEN $availability_from AND $availability_to				
		ORDER BY asset_name";       
		
		//If the format is list, we generate a datatable.  If not, we generate
		//for using in FPDF

		if ($format == 'list') {
			$query = $this->db->query($sql, array());
			return $query->result_array();		
		} else {			
			$query = $this->db->query($sql, array());
			if ($query->num_rows() > 0) {return $query->result();}
			return NULL;
		}		

	}



	//---> List of order
	
	public function get_REP03($format = null)
	{

		//--> Criteria area
		$area = $this->session->area;
        if ($area == 'all') {
        	$area_from = 0;
			$area_to = 999;
        }
        else {
			$area_from = $area;
			$area_to = $area;
		}

		//--> Criteria municipality
		$municipality = $this->session->municipality;
        if ($municipality == 'all') {
        	$municipality_from = 0;
			$municipality_to = 999;
        }
        else {
			$municipality_from = $municipality;
			$municipality_to = $municipality;
		}

		$date_from = $this->session->date_from;
		$date_to = $this->session->date_to;
		if ($date_from == null) {
			$date_from = "'1900-01-01'";
		} else {
			$date_from = "'" . $date_from . "'";
		}
		if ($date_to == null) {
			$date_to = "'2500-01-01'";
		} else {
			$date_to = "'" . $date_to . "'";
		}


		$sql = "SELECT orders.*,CONCAT(last_name, ' ', first_name) AS 'employee_name',
						customer_name,customer.phone AS 'phone',
						area_name,municipality_name,order_total
		FROM orders
		LEFT JOIN customer ON customer_fk = customer_id 
		LEFT JOIN employee ON employee_fk = employee_id
		LEFT JOIN area ON customer.area_fk = area_id
		LEFT JOIN municipality ON customer.municipality_fk = municipality_id
		WHERE order_date BETWEEN $date_from AND $date_to
			AND IFNULL(customer.area_fk,0) BETWEEN $area_from AND $area_to
			AND IFNULL(customer.municipality_fk,0) BETWEEN $municipality_from AND $municipality_to
		ORDER BY order_no";

		//If the format is list, we generate a datatable.  If not, we generate
		//for using in FPDF

		if ($format == 'list') {
			$query = $this->db->query($sql, array());
			return $query->result_array();		
		} else {			
			$query = $this->db->query($sql, array());
			if ($query->num_rows() > 0) {return $query->result();}
			return NULL;
		}		

	}


	//---> List of Customers

	public function get_REP04($format = null)
	{
		//--> Criteria type of customer 
		$customer_type = $this->session->customer_type;
        if ($customer_type == 'all') {
        	$customer_type_from = 0;
			$customer_type_to = 999;
        }
        else {
			$customer_type_from = $customer_type;
			$customer_type_to = $customer_type;
		}
	
		$sql = "SELECT customer.*,customer_type_name,area_name,municipality_name
		FROM customer
			LEFT JOIN customer_type ON customer_type_fk = customer_type_id
			LEFT JOIN area ON area_fk = area_id
			LEFT JOIN municipality ON municipality_fk = municipality_id
		WHERE customer_type_fk BETWEEN	$customer_type_from and $customer_type_to	
		ORDER BY customer_name";       
		
		//If the format is list, we generate a datatable.  If not, we generate
		//for using in FPDF

		if ($format == 'list') {
			$query = $this->db->query($sql, array());
			return $query->result_array();		
		} else {			
			$query = $this->db->query($sql, array());
			if ($query->num_rows() > 0) {return $query->result();}
			return NULL;
		}		

	}


	//--> List of Employees

	public function get_REP05($format = null)
	{

		//--> Criteria type of human employees
		$employee_type = $this->session->employee_type;
        if ($employee_type == 'all') {
        	$employee_type_from = 0;
			$employee_type_to = 999;
        }
        else {
			$employee_type_from = $employee_type;
			$employee_type_to = $employee_type;
		}
		
		$sql = "SELECT employee.*,employee_type_name,area_name,municipality_name,
					position_name,employee_status_name,
					CONCAT(last_name, ' ', first_name) AS 'employee_name'
		FROM employee
			LEFT JOIN employee_type ON employee_type_fk = employee_type_id
			LEFT JOIN area ON area_fk = area_id
			LEFT JOIN municipality ON municipality_fk = municipality_id
			LEFT JOIN employee_status ON employee_status_fk = employee_status_id
			LEFT JOIN position ON position_fk = position_id
	    WHERE employee_type_fk BETWEEN	$employee_type_from and $employee_type_to 	
		ORDER BY last_name, first_name";
		
		//If the format is list, we generate a datatable.  If not, we generate
		//for using in FPDF

		if ($format == 'list') {
			$query = $this->db->query($sql, array());
			return $query->result_array();		
		} else {			
			$query = $this->db->query($sql, array());
			if ($query->num_rows() > 0) {return $query->result();}
			return NULL;
		}			

	}	


	//---> Summary of Orders
	
	public function get_REP06($format = null)
	{

		//--> Criteria area
		$area = $this->session->area;
        if ($area == 'all') {
        	$area_from = 0;
			$area_to = 999;
        }
        else {
			$area_from = $area;
			$area_to = $area;
		}


		//--> Criteria customer
		$customer = $this->session->customer;
        if ($customer == 'all') {
        	$customer_from = 0;
			$customer_to = 999;
        }
        else {
			$customer_from = $customer;
			$customer_to = $customer;
		}


		//--> Date used will be date order

		$date_from = $this->session->date_from;
		$date_to = $this->session->date_to;
		if ($date_from == null) {
			$date_from = "'1900-01-01'";
		} else {
			$date_from = "'" . $date_from . "'";
		}
		if ($date_to == null) {
			$date_to = "'2500-01-01'";
		} else {
			$date_to = "'" . $date_to . "'";
		}

		$sql = "SELECT area_name,municipality_name,customer_name,customer.area_fk,
						orders.*,customer.phone AS 'phone'
						
		FROM orders
			LEFT JOIN customer ON customer_fk = customer_id 
			LEFT JOIN area ON customer.area_fk = area_id
			LEFT JOIN municipality ON customer.municipality_fk = municipality_id
		WHERE order_date BETWEEN $date_from AND $date_to
			AND customer.area_fk BETWEEN $area_from AND $area_to
			AND orders.customer_fk BETWEEN $customer_from AND $customer_to
		ORDER BY area_name,municipality_name,customer_name";
		
		//If the format is list, we generate a datatable.  If not, we generate
		//for using in FPDF

		if ($format == 'list') {
			$query = $this->db->query($sql, array());
			return $query->result_array();		
		} else {			
			$query = $this->db->query($sql, array());
			if ($query->num_rows() > 0) {return $query->result();}
			return NULL;
		}	


	}

	//--> Get the total of items for each area with order date
	public function getReport06TotalItemByArea($area)
	{   
		//--> Criteria area
        if ($area == 'all') {
        	$area_from = 0;
			$area_to = 999;
        }
        else {
			$area_from = $area;
			$area_to = $area;
		}	

		//--> Criteria customer
		$customer = $this->session->customer;
        if ($customer == 'all') {
        	$customer_from = 0;
			$customer_to = 999;
        }
        else {
			$customer_from = $customer;
			$customer_to = $customer;
		}
		
		$date_from = $this->session->date_from;
		$date_to = $this->session->date_to;
		if ($date_from == null) {
			$date_from = "'1900-01-01'";
		} else {
			$date_from = "'" . $date_from . "'";
		}
		if ($date_to == null) {
			$date_to = "'2500-01-01'";
		} else {
			$date_to = "'" . $date_to . "'";
		}

		$sql = "SELECT SUM(movement.quantity) AS 'quantity',item_name
		FROM movement
			JOIN orders ON movement.order_fk = order_id
			JOIN item_location ON item_location_fk = item_location_id
			JOIN item ON item_location.item_fk = item_id
			JOIN customer ON orders.customer_fk = customer_id
		WHERE order_date BETWEEN $date_from AND $date_to
		    AND customer.area_fk BETWEEN $area_from AND $area_to
		    AND orders.customer_fk BETWEEN $customer_from AND $customer_to
		GROUP BY item_name";
		$query = $this->db->query($sql, array());

		if ($query->num_rows() > 0) {return $query->result();}
		
		return NULL;

	}
	



	//---> Summary of Deliveries
	
	public function get_REP07($format = null)
	{


		//--> Criteria area
		$area = $this->session->area;
        if ($area == 'all') {
        	$area_from = 0;
			$area_to = 999;
        }
        else {
			$area_from = $area;
			$area_to = $area;
		}


		//--> Criteria customer
		$customer = $this->session->customer;
        if ($customer == 'all') {
        	$customer_from = 0;
			$customer_to = 999;
        }
        else {
			$customer_from = $customer;
			$customer_to = $customer;
		}



		//--> Criteria municipality
		$municipality = $this->session->municipality;
        if ($municipality == 'all') {
        	$municipality_from = 0;
			$municipality_to = 999;
        }
        else {
			$municipality_from = $municipality;
			$municipality_to = $municipality;
		}

		//--> Date used will be date delivery

		$date_from = $this->session->date_from;
		$date_to = $this->session->date_to;
		if ($date_from == null) {
			$date_from = "'1900-01-01'";
		} else {
			$date_from = "'" . $date_from . "'";
		}
		if ($date_to == null) {
			$date_to = "'2500-01-01'";
		} else {
			$date_to = "'" . $date_to . "'";
		}


		$sql = "SELECT area_name,municipality_name,customer_name,customer.area_fk,
						orders.*,CONCAT(last_name, ' ', first_name) AS 'employee_name',customer.phone AS 'phone',
						balance,order_total,(balance - order_total) AS 'previous_balance'

						
		FROM orders
			LEFT JOIN customer ON customer_fk = customer_id 
			LEFT JOIN employee ON employee_fk = employee_id
			LEFT JOIN area ON customer.area_fk = area_id
			LEFT JOIN municipality ON customer.municipality_fk = municipality_id
		WHERE delivery_date BETWEEN $date_from AND $date_to
			AND IFNULL(customer.area_fk,0) BETWEEN $area_from AND $area_to
			AND IFNULL(customer.municipality_fk,0) BETWEEN $municipality_from AND $municipality_to
			AND orders.customer_fk BETWEEN $customer_from AND $customer_to
		ORDER BY area_name,municipality_name,customer_name";

		//If the format is list, we generate a datatable.  If not, we generate
		//for using in FPDF

		if ($format == 'list') {
			$query = $this->db->query($sql, array());
			return $query->result_array();		
		} else {			
			$query = $this->db->query($sql, array());
			if ($query->num_rows() > 0) {return $query->result();}
			return NULL;
		}		


	}


	//--> Get the total of items for each area with delivery date
	public function getReport07TotalItemByArea($area)
	{   
		//--> Criteria area
        if ($area == 'all') {
        	$area_from = 0;
			$area_to = 999;
        }
        else {
			$area_from = $area;
			$area_to = $area;
		}	

		//--> Criteria customer
		$customer = $this->session->customer;
        if ($customer == 'all') {
        	$customer_from = 0;
			$customer_to = 999;
        }
        else {
			$customer_from = $customer;
			$customer_to = $customer;
		}

		$date_from = $this->session->date_from;
		$date_to = $this->session->date_to;
		if ($date_from == null) {
			$date_from = "'1900-01-01'";
		} else {
			$date_from = "'" . $date_from . "'";
		}
		if ($date_to == null) {
			$date_to = "'2500-01-01'";
		} else {
			$date_to = "'" . $date_to . "'";
		}

		$sql = "SELECT SUM(movement.quantity) AS 'quantity',item_name
		FROM movement
			JOIN orders ON movement.order_fk = order_id
			JOIN item_location ON item_location_fk = item_location_id
			JOIN item ON item_location.item_fk = item_id
			JOIN customer ON orders.customer_fk = customer_id
		WHERE delivery_date BETWEEN $date_from AND $date_to
		    AND customer.area_fk BETWEEN $area_from AND $area_to
		    AND orders.customer_fk BETWEEN $customer_from AND $customer_to
		GROUP BY item_name";
		$query = $this->db->query($sql, array());

		if ($query->num_rows() > 0) {return $query->result();}
		
		return NULL;

	}



	//--> print the order slip in batch
	public function get_REP08($format = null)
	{

		//--> Criteria availability
		$area = $this->session->area;
        if ($area == 'all') {
        	$area_from = 0;
			$area_to = 999;
        }
        else {
			$area_from = $area;
			$area_to = $area;
		}


		//--> Criteria area
		$area = $this->session->area;
        if ($area == 'all') {
        	$area_from = 0;
			$area_to = 999;
        }
        else {
			$area_from = $area;
			$area_to = $area;
		}

		//--> Date used will be date delivery

		$date_from = $this->session->date_from;
		$date_to = $this->session->date_to;
		if ($date_from == null) {
			$date_from = "'1900-01-01'";
		} else {
			$date_from = "'" . $date_from . "'";
		}
		if ($date_to == null) {
			$date_to = "'2500-01-01'";
		} else {
			$date_to = "'" . $date_to . "'";
		}

		
		$sql = "SELECT orders.*,CONCAT(last_name, ' ', first_name) AS 'employee_name',
						customer_name,customer.phone AS 'phone',
						area_name,municipality_name,customer.address as 'address',
						balance,order_total,(balance - order_total) AS 'previous_balance'
	
		FROM orders
		LEFT JOIN customer ON customer_fk = customer_id 
		LEFT JOIN employee ON employee_fk = employee_id
		LEFT JOIN area ON customer.area_fk = area_id
		LEFT JOIN municipality ON customer.municipality_fk = municipality_id
		WHERE delivery_date BETWEEN $date_from AND $date_to
		    AND IFNULL(customer.area_fk,0) BETWEEN $area_from AND $area_to
		    ORDER BY customer.area_fk,customer.municipality_fk,customer_name";
		
		//If the format is list, we generate a datatable.  If not, we generate
		//for using in FPDF

		if ($format == 'list') {
			$query = $this->db->query($sql, array());
			return $query->result_array();		
		} else {			
			$query = $this->db->query($sql, array());
			if ($query->num_rows() > 0) {return $query->result();}
			return NULL;
		}			

	}

	


	//--> Get the total of items for each area
	public function getReport08TotalItemByArea()
	{

		$date_from = $this->session->date_from;
		$date_to = $this->session->date_to;
		if ($date_from == null) {
			$date_from = "'1900-01-01'";
		} else {
			$date_from = "'" . $date_from . "'";
		}
		if ($date_to == null) {
			$date_to = "'2500-01-01'";
		} else {
			$date_to = "'" . $date_to . "'";
		}

		//--> Criteria area
		$area = $this->session->area;
        if ($area == 'all') {
        	$area_from = 0;
			$area_to = 999;
        }
        else {
			$area_from = $area;
			$area_to = $area;
		}

		$sql = "SELECT area_name,item_name,SUM(movement.quantity) AS 'quantity'
		FROM movement
			JOIN orders ON movement.order_fk = order_id
			JOIN item_location ON item_location_fk = item_location_id
			JOIN item ON item_location.item_fk = item_id
			JOIN customer ON orders.customer_fk = customer_id
            LEFT JOIN area ON customer.area_fk = area_id
		WHERE order_date BETWEEN $date_from AND $date_to
		    AND IFNULL(customer.area_fk,0) BETWEEN $area_from AND $area_to
		GROUP BY area_name,item_name    
		ORDER BY area_name,item_name";

		$query = $this->db->query($sql, array());

		if ($query->num_rows() > 0) {return $query->result();}
		
		return NULL;

	}


	//---> Summary of Payments
	
	public function get_REP09($format = null)
	{

		//--> Criteria area
		$area = $this->session->area;
        if ($area == 'all') {
        	$area_from = 0;
			$area_to = 999;
        }
        else {
			$area_from = $area;
			$area_to = $area;
		}


		//--> Criteria customer
		$customer = $this->session->customer;
        if ($customer == 'all') {
        	$customer_from = 0;
			$customer_to = 999;
        }
        else {
			$customer_from = $customer;
			$customer_to = $customer;
		}

		//--> Date used will be date payment

		$date_from = $this->session->date_from;
		$date_to = $this->session->date_to;
		if ($date_from == null) {
			$date_from = "'1900-01-01'";
		} else {
			$date_from = "'" . $date_from . "'";
		}
		if ($date_to == null) {
			$date_to = "'2500-01-01'";
		} else {
			$date_to = "'" . $date_to . "'";
		}

		$sql = "SELECT payment.*,
		area_name,municipality_name,customer_name,customer.area_fk,sales_invoice_no,
		order_total,order_no,customer.phone AS 'phone',
		CASE WHEN payment_type = 1 THEN 'Payment' ELSE 'Credit' END AS 'payment_type'
						
		FROM payment
			LEFT JOIN orders ON payment.order_fk = order_id
			LEFT JOIN customer ON payment.customer_fk = customer_id 
			LEFT JOIN area ON customer.area_fk = area_id
			LEFT JOIN municipality ON customer.municipality_fk = municipality_id
		WHERE payment_date BETWEEN $date_from AND $date_to
			AND customer.area_fk BETWEEN $area_from AND $area_to
			AND payment.customer_fk BETWEEN $customer_from AND $customer_to
		ORDER BY area_name,municipality_name,customer_name";
		
		//If the format is list, we generate a datatable.  If not, we generate
		//for using in FPDF

		if ($format == 'list') {
			$query = $this->db->query($sql, array());
			return $query->result_array();		
		} else {			
			$query = $this->db->query($sql, array());
			if ($query->num_rows() > 0) {return $query->result();}
			return NULL;
		}	

	}



	//---> Statement of Account
	
	public function get_REP10($format = null)
	{

		//--> Criteria customer
		$customer = $this->session->customer;

		//--> Date used will be date order

		$date_from = $this->session->date_from;
		$date_to = $this->session->date_to;
		if ($date_from == null) {
			$date_from = "'1900-01-01'";
		} else {
			$date_from = "'" . $date_from . "'";
		}
		if ($date_to == null) {
			$date_to = "'2500-01-01'";
		} else {
			$date_to = "'" . $date_to . "'";
		}

		$sql = "SELECT area_name,municipality_name,customer_name,customer.area_fk,
						orders.*
						
		FROM orders
			LEFT JOIN customer ON customer_fk = customer_id 
			LEFT JOIN area ON customer.area_fk = area_id
			LEFT JOIN municipality ON customer.municipality_fk = municipality_id
		WHERE order_date BETWEEN $date_from AND $date_to
			AND orders.customer_fk = $customer
		ORDER BY order_date";
		
		//If the format is list, we generate a datatable.  If not, we generate
		//for using in FPDF

		if ($format == 'list') {
			$query = $this->db->query($sql, array());
			return $query->result_array();		
		} else {			
			$query = $this->db->query($sql, array());
			if ($query->num_rows() > 0) {return $query->result();}
			return NULL;
		}	


	}


	//--> Get the total of items for each customer with order date
	public function getReport10TotalItemByCustomer($customer)
	{   
		//--> Criteria customer
		$customer = $this->session->customer;     

		
		$date_from = $this->session->date_from;
		$date_to = $this->session->date_to;
		if ($date_from == null) {
			$date_from = "'1900-01-01'";
		} else {
			$date_from = "'" . $date_from . "'";
		}
		if ($date_to == null) {
			$date_to = "'2500-01-01'";
		} else {
			$date_to = "'" . $date_to . "'";
		}

		$sql = "SELECT SUM(movement.quantity) AS 'quantity',item_name
		FROM movement
			JOIN orders ON movement.order_fk = order_id
			JOIN item_location ON item_location_fk = item_location_id
			JOIN item ON item_location.item_fk = item_id
			JOIN customer ON orders.customer_fk = customer_id
		WHERE order_date BETWEEN $date_from AND $date_to
		    AND orders.customer_fk = $customer
		GROUP BY item_name";
		$query = $this->db->query($sql, array());

		if ($query->num_rows() > 0) {return $query->result();}
		
		return NULL;

	}


	//--> Get the payment for each customer with payment date
	public function getReport10Payment($customer)
	{   
		//--> Criteria customer
		//    If it's all, we take the customer choosen in the report screen
		//    else we are in the treatment of a specific customer for the totals.
        if ($customer == 'all') {
        	$customer_from = $this->session->customer;
			$customer_to = $this->session->customer;
        }
        else {
			$customer_from = $customer;
			$customer_to = $customer;
		}		
		
		//--> Date used will be date payment

		$date_from = $this->session->date_from;
		$date_to = $this->session->date_to;
		if ($date_from == null) {
			$date_from = "'1900-01-01'";
		} else {
			$date_from = "'" . $date_from . "'";
		}
		if ($date_to == null) {
			$date_to = "'2500-01-01'";
		} else {
			$date_to = "'" . $date_to . "'";
		}

		$sql = "SELECT payment.*,sales_invoice_no,order_total,order_no,
						CASE WHEN payment_type = 1 THEN 'Payment' ELSE 'Credit' END AS 'payment_type',
						DATE(payment.updated_date) AS 'updated_date',
					   	(SELECT user_name FROM user WHERE payment.updated_by = user.user_id) AS 'updated_by'
						
		FROM payment
			LEFT JOIN orders ON payment.order_fk = order_id
		WHERE payment_date BETWEEN $date_from AND $date_to
		    AND payment.customer_fk BETWEEN $customer_from AND $customer_to
		ORDER BY payment_date";
		
		$query = $this->db->query($sql, array());

		if ($query->num_rows() > 0) {return $query->result();}
		
		return NULL;

	}
	


	//---> Reordering report
	
	public function get_REP11($format = null)
	{
	
		$sql = "SELECT item.*,unit_name,category_name,
				 (SELECT sum(quantity) FROM item_location WHERE item_fk = item_id) AS 'quantity'                 
		FROM item		    
			LEFT JOIN unit ON item.unit_fk = unit_id
			LEFT JOIN category ON category_fk = category_id
		WHERE (SELECT SUM(quantity) FROM item_location WHERE item_fk = item_id) <= ordering_point 
              OR (SELECT SUM(quantity) FROM item_location WHERE item_fk = item_id) <= safety_stock
		    AND item.active = 1
		    AND item.inventory = 1  
		ORDER BY item_name";       
		
		//If the format is list, we generate a datatable.  If not, we generate
		//for using in FPDF

		if ($format == 'list') {
			$query = $this->db->query($sql, array());
			return $query->result_array();		
		} else {			
			$query = $this->db->query($sql, array());
			if ($query->num_rows() > 0) {return $query->result();}
			return NULL;
		}		

	}



	//--> print list of requisitions
	public function get_REP12($format = null)
	{

		//--> Criteria employee
		$employee = $this->session->employee;
        if ($employee == 'all') {
        	$employee_from = 0;
			$employee_to = 999;
        }
        else {
			$employee_from = $employee;
			$employee_to = $employee;
		}

		$date_from = $this->session->date_from;
		$date_to = $this->session->date_to;
		if ($date_from == null) {
			$date_from = "'1900-01-01'";
		} else {
			$date_from = "'" . $date_from . "'";
		}
		if ($date_to == null) {
			$date_to = "'2500-01-01'";
		} else {
			$date_to = "'" . $date_to . "'";
		}
			
		$sql = "SELECT requisition.*,CONCAT(last_name, ' ', first_name) AS 'employee_requested_name',
					(SELECT CONCAT(last_name, ' ', first_name) FROM employee WHERE employee_id = employee_approved_fk) AS 'employee_approved_name'				
		FROM requisition
		LEFT JOIN employee ON employee_requested_fk = employee_id		
		WHERE requisition_date BETWEEN $date_from AND $date_to 
		      AND employee_requested_fk BETWEEN $employee_from AND $employee_to ";


		//If the format is list, we generate a datatable.  If not, we generate
		//for using in FPDF

		if ($format == 'list') {
			$query = $this->db->query($sql, array());
			return $query->result_array();		
		} else {			
			$query = $this->db->query($sql, array());
			if ($query->num_rows() > 0) {return $query->result();}
			return NULL;
		}				

	}


	//--> print list of requisitions
	public function get_REP13($format = null)
	{

		$date_from = $this->session->date_from;
		$date_to = $this->session->date_to;
		if ($date_from == null) {
			$date_from = "'1900-01-01'";
		} else {
			$date_from = "'" . $date_from . "'";
		}
		if ($date_to == null) {
			$date_to = "'2500-01-01'";
		} else {
			$date_to = "'" . $date_to . "'";
		}
			
		$sql = "SELECT SUM(order_total) AS 'total_amount',COUNT(*) AS 'number_of_order',
	       				ROUND(AVG(order_total),2) AS 'average_amount',order_date		
	       				
			FROM orders		
			WHERE order_date BETWEEN $date_from AND $date_to
	        GROUP BY order_date
	        ORDER BY order_date";


		//If the format is list, we generate a datatable.  If not, we generate
		//for using in FPDF

		if ($format == 'list') {
			$query = $this->db->query($sql, array());
			return $query->result_array();		
		} else {			
			$query = $this->db->query($sql, array());
			if ($query->num_rows() > 0) {return $query->result();}
			return NULL;
		}				

	}



	//---> List of Suppliers

	public function get_REP14($format = null)
	{
	
		$sql = "SELECT supplier.*
		FROM supplier	
		ORDER BY supplier_name";       
		
		//If the format is list, we generate a datatable.  If not, we generate
		//for using in FPDF

		if ($format == 'list') {
			$query = $this->db->query($sql, array());
			return $query->result_array();		
		} else {			
			$query = $this->db->query($sql, array());
			if ($query->num_rows() > 0) {return $query->result();}
			return NULL;
		}		

	}



	//--> List of deliveries by date
	public function get_REP15($format = null)
	{

		//--> Criteria supplier
		$supplier = $this->session->supplier;
        if ($supplier == 'all') {
        	$supplier_from = 0;
			$supplier_to = 999;
        }
        else {
			$supplier_from = $supplier;
			$supplier_to = $supplier;
		}

		$date_from = $this->session->date_from;
		$date_to = $this->session->date_to;
		if ($date_from == null) {
			$date_from = "'1900-01-01'";
		} else {
			$date_from = "'" . $date_from . "'";
		}
		if ($date_to == null) {
			$date_to = "'2500-01-01'";
		} else {
			$date_to = "'" . $date_to . "'";
		}

	
		$sql = "SELECT delivery.*,supplier_name
		FROM delivery
		     JOIN supplier ON delivery.supplier_fk = supplier_id
		WHERE delivery_date BETWEEN $date_from AND $date_to
		AND supplier_id BETWEEN $supplier_from AND $supplier_to
		ORDER BY delivery_date, supplier_name";

		//If the format is list, we generate a datatable.  If not, we generate
		//for using in FPDF

		if ($format == 'list') {
			$query = $this->db->query($sql, array());
			return $query->result_array();		
		} else {			
			$query = $this->db->query($sql, array());
			if ($query->num_rows() > 0) {return $query->result();}
			return NULL;
		}		

	}


	//--> print the items of a specific order_id
	public function getREP15Item($delivery_id)
	{
		
		$sql = "SELECT item_name,movement.quantity AS 'quantity'
		FROM movement
			 JOIN item_location ON movement.item_location_fk = item_location_id
			 JOIN item ON item_location.item_fk = item_id
             JOIN delivery ON delivery_fk = delivery_id

		WHERE delivery_fk = ?";
		$query = $this->db->query($sql, array($delivery_id));
		return $query->result();		

	}




	//--> Get a specific list of the settings
	public function getReportSetting($setting)
	{
		if ($setting == 'unit') {
			$sql = "SELECT unit_id as 'id',unit_name as 'name','no code' AS 'code',
					CASE WHEN active = 1 THEN 'Yes' else 'No' END AS 'active' 
					FROM unit ORDER BY name";
			$query = $this->db->query($sql, array());
			return $query->result();	
		}

		elseif ($setting == 'asset_type') {
			$sql = "SELECT asset_type_id as 'id',asset_type_name as 'name',asset_type_code as 'code',
					CASE WHEN active = 1 THEN 'Yes' else 'No' END AS 'active' 
					FROM asset_type ORDER BY name";
			$query = $this->db->query($sql, array());
			return $query->result();	
		}

		elseif ($setting == 'area') {
			$sql = "SELECT area_id as 'id',area_name as 'name','no code' AS 'code',
					CASE WHEN active = 1 THEN 'Yes' else 'No' END AS 'active' 
					FROM area ORDER BY name";
			$query = $this->db->query($sql, array());
			return $query->result();	
		}

		elseif ($setting == 'availability') {
			$sql = "SELECT availability_id as 'id',availability_name as 'name','no code' AS 'code',
					CASE WHEN active = 1 THEN 'Yes' else 'No' END AS 'active' 
					FROM availability ORDER BY name";
			$query = $this->db->query($sql, array());
			return $query->result();	
		}

		elseif ($setting == 'category') {
			$sql = "SELECT category_id as 'id',category_name as 'name','no code' AS 'code',
					CASE WHEN active = 1 THEN 'Yes' else 'No' END AS 'active' 
					FROM category ORDER BY name";
			$query = $this->db->query($sql, array());
			return $query->result();	
		}


		elseif ($setting == 'customer_type') {
			$sql = "SELECT customer_type_id as 'id',customer_type_name as 'name',customer_type_code as 'code',
					CASE WHEN active = 1 THEN 'Yes' else 'No' END AS 'active' 
					FROM customer_type ORDER BY name";
			$query = $this->db->query($sql, array());
			return $query->result();	
		}


		elseif ($setting == 'employee_type') {
			$sql = "SELECT employee_type_id as 'id',employee_type_name as 'name',employee_type_code as 'code',
					CASE WHEN active = 1 THEN 'Yes' else 'No' END AS 'active' 
					FROM employee_type ORDER BY name";
			$query = $this->db->query($sql, array());
			return $query->result();	
		}


		elseif ($setting == 'employee_status') {
			$sql = "SELECT employee_status_id as 'id',employee_status_name as 'name',employee_status_code as 'code',
					CASE WHEN active = 1 THEN 'Yes' else 'No' END AS 'active' 
					FROM employee_status ORDER BY name";
			$query = $this->db->query($sql, array());
			return $query->result();	
		}

		elseif ($setting == 'ingredient') {
			$sql = "SELECT ingredient_id as 'id',ingredient_name as 'name',CONCAT('/',formula) as 'code',
					CASE WHEN active = 1 THEN 'Yes' else 'No' END AS 'active' 
					FROM ingredient ORDER BY name";
			$query = $this->db->query($sql, array());
			return $query->result();	
		}

		elseif ($setting == 'supplier') {
			$sql = "SELECT supplier_id as 'id',supplier_name as 'name',phone as 'code',
					CASE WHEN active = 1 THEN 'Yes' else 'No' END AS 'active' 
					FROM supplier ORDER BY supplier_name";
			$query = $this->db->query($sql, array());
			return $query->result();	
		}


		elseif ($setting == 'maintenance_type') {
			$sql = "SELECT maintenance_type_id as 'id',maintenance_type_name as 'name',maintenance_type_code as 'code',
					CASE WHEN active = 1 THEN 'Yes' else 'No' END AS 'active' 
					FROM maintenance_type ORDER BY name";
			$query = $this->db->query($sql, array());
			return $query->result();	
		}

		elseif ($setting == 'location') {
			$sql = "SELECT location_id as 'id',location_name as 'name',location_code as 'code',
					CASE WHEN active = 1 THEN 'Yes' else 'No' END AS 'active' 
					FROM location ORDER BY name";
			$query = $this->db->query($sql, array());
			return $query->result();	
		}

		elseif ($setting == 'municipality') {
			$sql = "SELECT municipality_id as 'id',municipality_name as 'name','no code' AS 'code',
					CASE WHEN active = 1 THEN 'Yes' else 'No' END AS 'active' 
					FROM municipality ORDER BY name";
			$query = $this->db->query($sql, array());
			return $query->result();	
		}

		elseif ($setting == 'position') {
			$sql = "SELECT position_id as 'id',position_name as 'name',position_code as 'code',
					CASE WHEN active = 1 THEN 'Yes' else 'No' END AS 'active' 
					FROM position ORDER BY name";
			$query = $this->db->query($sql, array());
			return $query->result();	
		}

		
	}



// Update of the title of the report

public function getReport($report_id = null)
	{
		if($report_id) {
			$sql = "SELECT * FROM report where report_id = ?";
			$query = $this->db->query($sql, array($report_id));
			return $query->row_array();
		}

		$sql = "SELECT * FROM report WHERE report_for = 'report'";
		$query = $this->db->query($sql);
		return $query->result_array();
	}


	public function update($data, $report_id)
	{
		if($data && $report_id) {
			$this->db->where('report_id', $report_id);
			$update = $this->db->update('report', $data);
			return ($update == true) ? true : false;
		}
	}

	
}