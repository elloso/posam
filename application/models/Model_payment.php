<?php 

class Model_payment extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}


	public function getPaymentData($payment_id = null)
	{
		if($payment_id) {
			$sql = "SELECT payment.*,order_no 
			FROM payment 
			LEFT JOIN orders ON order_fk = order_id
			WHERE payment_id = ?";
			$query = $this->db->query($sql, array($payment_id));
			return $query->row_array();
		}

		$sql = "SELECT * FROM payment";
		$query = $this->db->query($sql);
		return $query->result_array();
	}


	// get the list of payment
	public function getPayment($customer_id, $date_from = NULL, $date_to = NULL)
	{

		$sql = "SELECT payment_id,payment_type,amount_paid,payment_date,
					   payment_remark,order_no,order_id,DATE(payment.updated_date) AS 'updated_date',
					   (SELECT user_name FROM user WHERE payment.updated_by = user.user_id) AS 'updated_by'
				FROM payment
					 LEFT JOIN orders ON order_fk = order_id
				WHERE payment.customer_fk = ?
					 AND payment_date BETWEEN $date_from AND $date_to";
		$query = $this->db->query($sql, array($customer_id));
		return $query->result_array();
	}

	
	
	public function create($data)
	{
		if($data) {
			$insert = $this->db->insert('payment', $data);
			return ($insert == true) ? true : false;
		}
	}

	public function update($data, $payment_id)
	{
		if($data && $payment_id) {
			$this->db->where('payment_id', $payment_id);
			$update = $this->db->update('payment', $data);
			return ($update == true) ? true : false;
		}
	}

	public function remove($payment_id)
	{
		if($payment_id) {
			$this->db->where('payment_id', $payment_id);
			$delete = $this->db->delete('payment');
			return ($delete == true) ? true : false;
		}
	}

}
