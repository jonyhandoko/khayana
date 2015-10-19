<?php
class Place_model extends CI_Model 
{
	function __construct()
	{
		parent::__construct();
	}

	function get_provinces(){
		return $this->db->get('provinces')->result();
	}
	
	function get_jne_one(){
		return $this->db->order_by('place', 'ASC')->get('jne_one')->result();
	}
	
	function get_jne_one_menu($country = "Indonesia")
	{	
		$provinces	= $this->db->where('country', $country)->order_by('place', 'ASC')->get('jne_one')->result();
		$return		= array();
		foreach($provinces as $c)
		{
			$return[$c->id] = $c->place;
		}
		return $return;
	}
	
	function get_jne_one_single($id){
		$this->db->where('id', $id);
		return $this->db->get('jne_one')->row();	
	}
	
	function get_provinces_menu()
	{	
		$provinces	= $this->db->order_by('name', 'ASC')->get('provinces')->result();
		$return		= array();
		foreach($provinces as $c)
		{
			$return[$c->id] = $c->name;
		}
		return $return;
	}
	
	function get_cities($province_id){
		$this->db->where('province_id', $province_id);
		return $this->db->get('cities')->result();
	}
	
	function get_cities_menu($province_id)
	{
		$cities	= $this->db->where('province_id',$province_id)->get('cities')->result();
		$return	= array();
		foreach($cities as $c)
		{
			$return[$c->id] = $c->name;
		}
		return $return;
	}
	
	function get_province($id){
		$this->db->where('id', $id);
		return $this->db->get('provinces')->row();	
	}
	
	function save_jne_one($data)
	{
		if(!$data['id']) 
		{
			$this->db->insert('jne_one', $data);
			return $this->db->insert_id();
		} 
		else 
		{
			$this->db->where('id', $data['id']);
			$this->db->update('jne_one', $data);
			return $data['id'];
		}
	}
	
	function save_province($data)
	{
		if(!$data['id']) 
		{
			$this->db->insert('provinces', $data);
			return $this->db->insert_id();
		} 
		else 
		{
			$this->db->where('id', $data['id']);
			$this->db->update('provinces', $data);
			return $data['id'];
		}
	}
	
	function get_city($id){
		$this->db->where('id', $id);
		return $this->db->get('cities')->row();	
	}
	
	function save_city($data)
	{
		if(!isset($data['id'])) 
		{
			$this->db->insert('cities', $data);
			return $this->db->insert_id();
		} 
		else 
		{
			$this->db->where('id', $data['id']);
			$this->db->update('cities', $data);
			return $data['id'];
		}
	}
	
	function save_jne_shipping($data)
	{
		if(!$data['id']) 
		{
			$this->db->insert('jne_shipping', $data);
			return $this->db->insert_id();
		} 
		else 
		{
			$this->db->where('id', $data['id']);
			$this->db->update('jne_shipping', $data);
			return $data['id'];
		}
	}
	
	function delete_city($id)
	{
		$this->db->where('id', $id);
		$this->db->delete('cities');	
	}
	
	function delete_province($id)
	{
		$this->db->where('id', $id);
		$this->db->delete('provinces');	
		$this->db->where('province_id', $id);
		$this->db->delete('cities');	
	}
	
	function get_shipping_cost($provinces_id){
		$this->db->where('province_id', $provinces_id);
		return $this->db->get('jne_shipping')->result();	
	}
	
	function get_cost($provinces_id, $city_id){
		$this->db->where('province_id', $provinces_id, 'city_id', $city_id);
		return $this->db->get('jne_shipping')->row();	
	}
	
	function get_jne_shipping($id)
	{
		$this->db->where('id', $id);
		return $this->db->get('jne_shipping')->row();	
	}
	
	function delete_jne_shipping($id)
	{
		$this->db->where('id', $id);
		$this->db->delete('jne_shipping');	
	}
}
	
?>