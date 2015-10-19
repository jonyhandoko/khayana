<?php
Class attribute_model extends CI_Model
{	
	//get all attributes
	function get_attributes(){
		$result	= $this->db->get('attributes')-> result();
		return $result;
	}
	
	function get_attributes_array(){
		$result	= $this->db->get('attributes')-> result_array();
		return $result;
	}

	function get_attributes_value(){
		$this->db->select('*'); // <-- There is never any reason to write this line!
		$this->db->from('attributes');
		$this->db->join('attributes_values', 'attributes_values.attr_id = attributes.id');

		$result = $this->db->get()-> result();
		return $result;
	}
	
	function get_attributes_product($product_id){
		//$result	= $this->db->select('attributes.id as id, attributes.name as name, attributes_entity.product_id as product_id')->from('attributes')->join('attributes_entity', 'attributes_entity.product_id='.$product_id,'left')->group_by('attributes.id');
		
		$result = $this->db->query("
		SELECT `gc_attributes`.`id` as id, `gc_attributes`.`name` as name, `gc_attributes_entity`.`value_id` as value_id FROM (`gc_attributes`) LEFT JOIN `gc_attributes_entity` ON `gc_attributes_entity`.`product_id` = ".$product_id." AND `gc_attributes_entity`.`attribute_id` = `gc_attributes`.`id` GROUP BY `gc_attributes`.`id`
		");
		
		return $result->result();
	}
	
	//get single attribute
	function get_attribute($attribute_id){
		$result	= $this->db->get_where('attributes', array('id'=>$attribute_id))->row();
		
		if(!$result)
		{
			return false;
		}
		
		return $result;
	}
	
	//save attribute
	function save_attribute($data)
	{
		if ($data['id'])
		{
			$this->db->trans_start();
			$this->db->where('id', $data['id']);
			$this->db->update('attributes', $data);
			$this->db->trans_complete();
		}
		else
		{
			$this->db->trans_start();
			$this->db->insert('attributes', $data);
			$this->db->trans_complete();
		}
	}
	
	//save attribute
	function save_attribute_value_new($data)
	{
		if ($data['id'])
		{
			$this->db->trans_start();
			$this->db->where('id', $data['id']);
			$this->db->update('attributes_values', $data);
			$this->db->trans_complete();
		}
		else
		{
			$this->db->trans_start();
			$this->db->insert('attributes_values', $data);
			$this->db->trans_complete();
		}
	}
	
	//delete attribute
	function delete_attribute($id)
	{		
		$this->db->trans_start();
		$this->db->where('id', $id);
		$this->db->delete('attributes');
		$this->db->trans_complete();
	}
	
	//get all attribute detail
	function get_attributes_values($attribute_id){
		$result	= $this->db->get_where('attributes_values', array('attr_id'=>$attribute_id))->result();
		
		return $result;
	}
	
	function get_attributes_value_array(){
		$result	= $this->db->get('attributes_values')-> result_array();
		return $result;
	}
	
	//get single attribute detail
	function get_attribute_value($attribute_id){
		$result	= $this->db->get_where('attributes_values', array('id'=>$attribute_id))->row();
		
		if(!$result)
		{
			return false;
		}
		
		return $result;
	}
	
	//save attribute detail
	function save_attribute_value($data)
	{
		if ($data['id'])
		{
			$this->db->trans_start();
			$this->db->where('id', $data['id']);
			$this->db->update('attributes_values', $data);
			$this->db->trans_complete();
		}
		else
		{
			$this->db->trans_start();
			$this->db->insert('attributes_values', $data);
			$this->db->trans_complete();
		}
	}
	
	//delete attribute detail
	function delete_attribute_value($id)
	{		
		$this->db->trans_start();
		$this->db->where('id', $id);
		$this->db->delete('attributes_values');
		$this->db->trans_complete();
	}
	
	function delete_attribute_entity($product_id){
		$this->db->trans_start();
		$this->db->where('product_id', $product_id);
		$this->db->delete('attributes_entity');
		$this->db->trans_complete();
	}
	
	function save_attribute_entity($product_id, $save=false){
		if(!$save){
		
		}else{
			//delete all attribute entity
			$this->delete_attribute_entity($product_id);
			
			foreach($save['attributes'] as $a){
				$data['product_id'] = $product_id;
				$data['attribute_id'] = $a['attr_id'];
				$data['value_id'] = $a['attr_val'];
				$this->db->trans_start();
				$this->db->insert('attributes_entity', $data);
				$this->db->trans_complete();
			}
		}
	}
}