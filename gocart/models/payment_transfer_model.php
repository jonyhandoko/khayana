<?php
Class Payment_transfer_model extends CI_Model
{

	//this is the expiration for a non-remember session
	var $session_expire	= 7200;
	
	
	function __construct()
	{
		parent::__construct();
		
		// check for possible group discount 
		$customer = $this->session->userdata('customer');
		
		
	}
	
	function save_payment_transfer($data){
		$this->db->insert('payment', $data);
		//$id	= $this->db->insert_id();
		
		$this->db->where('order_number', $data['order_number']);
		$this->db->update('orders', array('status'=>'Confirmed'));
	}
	
	function save_payment_paypal($data){
		$this->db->insert('paypal_payment', $data);
	
		return $id	= $this->db->insert_id();
	}
	
	/********************************************************************

	********************************************************************/
	
	
	function get_payment_transfers($status,$sortorder)
	{	
		$this->db->select('orders.id as orderid, payment.*');
		$this->db->from('payment');
		if($status)
			$this->db->where('payment.status',$status);
		
		$this->db->order_by('payment.status', $sortorder);
		$this->db->join('orders', 'orders.order_number = payment.order_number', 'left');
		$result = $this->db->get();		
		return $result->result();
	}
	
	function get_payment_transfer($payment_id)
	{	
		$this->db->where('id', $payment_id);
		$result = $this->db->get('payment');		
		return $result->row();
	}
	
	function delete_payment_transfer($payment_id)
	{	
		$this->db->where('id', $payment_id);
		$this->db->update('payment', array('status'=>'DELETED'));
	}
	
	function get_payment_transfers_count()
	{	
		return $this->db->count_all_results('payment');
	}
	
	function get_paid($payment_id, $order_number)
	{	
		$this->db->where('id', $payment_id);
		$this->db->update('payment', array('status'=>'PAID'));

                $this->db->where('order_number', $order_number);
		$this->db->update('orders', array('status'=>'Processing'));
	}
	
	
}