<?php
Class brand_model extends CI_Model
{	
	//start jony
	function __construct()
	{
		parent::__construct();
		
		// check for possible group discount 
		$customer = $this->session->userdata('customer');
		if(isset($customer['group_discount_formula'])) 
		{
			$this->group_discount_formula = $customer['group_discount_formula'];
		}
	}
	
	
	//get all brands
	function get_brands(){
		$result	= $this->db->get('brands')-> result();
		return $result;
	}
	
	/*function get_brands_array(){
		$result	= $this->db->get('brands')-> result_array();
		return $result;
	}*/
	
	function get_brands_array()
	{
		$get_brands = array();
		//$counter = 0;
		
		$result = $this->db->get('brands')->result();	
		
		foreach($result as $tempLoop)
		{
			$get_brands[$tempLoop->brand_id] = $tempLoop->brand_name;
			//$counter ++;  	
		}
		
		return $get_brands;
	}
	
	//get single brand
	function get_brand($brand_id){
		$result	= $this->db->get_where('brands', array('brand_id'=>$brand_id))->row();
		
		if(!$result)
		{
			return false;
		}
		
		return $result;
	}
	
	//get brand products
	function get_brand_products($id, $limit = false, $offset = false, $sort_by="created", $sort_order="desc")
	{
		$this->db->order_by($sort_by, $sort_order);
		if($limit)
			$results	= $this->db->get_where('products', array('brand_id'=>$id), $limit, $offset)->result();
		else
			$results	=  $this->db->get_where('products', array('brand_id'=>$id))->result();
			
		return $results;
	}
	
	//save brand
	function save_brand($data)
	{
		if ($data['brand_id'])
		{
			$this->db->trans_start();
			$this->db->where('brand_id', $data['brand_id']);
			$this->db->update('brands', $data);
			$this->db->trans_complete();
			
			$id = $data['brand_id'];
		}
		else
		{
			$this->db->trans_start();
			$this->db->insert('brands', $data);
			$id	= $this->db->insert_id();
			$this->db->trans_complete();
			
			
		}
		
		return $id;
	}
	
	//delete brand
	function delete_brand($id)
	{		
		$this->db->trans_start();
		$this->db->where('brand_id', $id);
		$this->db->delete('brands');
		$this->db->trans_complete();
	}
	
	//end jony
	
}