<?php
Class Newsletter_model extends CI_Model
{
	function __construct()
	{
			parent::__construct();
	}
	
	
	function get_list_subscribers()
	{
		$this->db->where('flag', 0);
		$res = $this->db->get('newsletter');
		return $res->result();
	}
	
	function get_insert_newsletter($data)
	{
		$this->db->insert('send_newsletter', $data);
		return $this->db->insert_id();
	}
	
	function get_send_newsletter()
	{
		$this->db->limit(15);
		$this->db->where('flag', 0);
		$res = $this->db->get('send_newsletter');
		return $res->result();	
	}
	
	function update_send_newsletter($id, $sent){
		$this->db->where('id', $id)->update('send_newsletter', array('sent'=>$sent, 'flag'=>1));	
	}
	
	function update_fail_send_newsletter($id, $fail){
		if($fail==5)
			$this->db->where('id', $id)->update('send_newsletter', array('sent'=>$sent, 'fail'=>$fail, 'flag'=>1));
		else
			$this->db->where('id', $id)->update('send_newsletter', array('sent'=>$sent, 'fail'=>$fail));	
	}
}