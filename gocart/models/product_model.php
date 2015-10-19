<?php
Class Product_model extends CI_Model
{
		
	// we will store the group discount formula here
	// and apply it to product prices as they are fetched 
	var $group_discount_formula = false;
	
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
	
	function get_notifications($id){
		return $this->db->get_where('products a, notification b', array('b.product_id'=>$id, 'a.id'=>$id, 'b.flag'=>0))->result();
	}
	
	function increment_product_view($id) {
		$this->db->where('id', $id);
		$this->db->set('views', 'views+1', FALSE);
		$this->db->update('products');
	}
	
	function update_notifications($id){ 
		$this->db->where('id', $id);
		$this->db->update('notification', array('flag'=>1,'date_send'=>date("Y-m-d")));
		
	}
	
	function insert_notification($email, $product){
		$this->db->insert('notification', array('custome_email'=>$email,'product_id'=>$product,'date_added'=>date("Y-m-d")));
	}
	
	function check_notification($email, $product){
		return $this->db->get_where('notification', array('custome_email'=>$email, 'product_id'=>$product))->result();	
	}
	
	function get_products_admin($search=false, $sort_by='name', $sort_order='ASC', $limit=0, $offset=0)
	{			
		if ($search)
		{
			if(!empty($search->term))
			{
				//support multiple words
				$term = explode(' ', $search->term);

				foreach($term as $t)
				{
					if(strpos($t,'_') !== false):
						$t = str_replace('_', ' ', $t);
					endif;
					$not		= '';
					$operator	= 'OR';
					if(substr($t,0,1) == '-')
					{
						$not		= 'NOT ';
						$operator	= 'AND';
						//trim the - sign off
						$t		= substr($t,1,strlen($t));
					}

					$like	= '';
					$like	.= "( `name` ".$not."LIKE '%".$t."%' " ;
					$like	.= $operator." `price` ".$not."LIKE '%".$t."%' ";
					$like	.= $operator." `slug` ".$not."LIKE '%".$t."%' ";
					$like	.= $operator." `description` ".$not."LIKE '%".$t."%' )";

					$this->db->where($like);
				}	
			}
			if(!empty($search->start_date))
			{
				$this->db->where('created >=',$search->start_date);
			}
			if(!empty($search->end_date))
			{
				//increase by 1 day to make this include the final day
				//I tried <= but it did not function. Any ideas why?
				$search->end_date = date('Y-m-d', strtotime($search->end_date)+86400);
				$this->db->where('created <',$search->end_date);
			}
			
			if(!empty($search->new))
			{
				$this->db->where('new',$search->new);
			}
			
			if(isset($search->enabled))
			{
				$this->db->where('enabled',$search->enabled);
			}else{
				$this->db->where('enabled',1);
			}
			
		}else{
			$this->db->where('enabled',1);
		}
		
		if($limit>0)
		{
			$this->db->limit($limit, $offset);
		}
		if(!empty($sort_by))
		{
			$this->db->order_by($sort_by, $sort_order);
		}
		
		
		if(!empty($search->category))
		{
			$this->db->from('products');
			$this->db->join('category_products', 'category_products.product_id = products.id');
			$this->db->where('category_products.category_id', $search->category);
			return $this->db->get()->result();
		}else{
			return $this->db->get('products')->result();
		}
	}
	
	function get_products_admin_count($search=false, $sort_by='', $sort_order='DESC', $limit=0, $offset=0)
	{			
		if ($search)
		{
			if(!empty($search->term))
			{
				//support multiple words
				$term = explode(' ', $search->term);

				foreach($term as $t)
				{
					$not		= '';
					$operator	= 'OR';
					if(substr($t,0,1) == '-')
					{
						$not		= 'NOT ';
						$operator	= 'AND';
						//trim the - sign off
						$t		= substr($t,1,strlen($t));
					}

					$like	= '';
					$like	.= "( `name` ".$not."LIKE '%".$t."%' " ;
					$like	.= $operator." `price` ".$not."LIKE '%".$t."%' ";
					$like	.= $operator." `slug` ".$not."LIKE '%".$t."%' ";
					$like	.= $operator." `description` ".$not."LIKE '%".$t."%' )";

					$this->db->where($like);
				}	
			}
			if(!empty($search->start_date))
			{
				$this->db->where('created >=',$search->start_date);
			}
			if(!empty($search->end_date))
			{
				//increase by 1 day to make this include the final day
				//I tried <= but it did not function. Any ideas why?
				$search->end_date = date('Y-m-d', strtotime($search->end_date)+86400);
				$this->db->where('created <',$search->end_date);
			}
			
			if(!empty($search->new))
			{
				$this->db->where('new',$search->new);
			}
			
			if(isset($search->enabled))
			{
				$this->db->where('enabled',$search->enabled);
			}else{
				$this->db->where('enabled',1);
			}
			
		}else{
			$this->db->where('enabled',1);
		}
		
		if($limit>0)
		{
			$this->db->limit($limit, $offset);
		}
		if(!empty($sort_by))
		{
			$this->db->order_by($sort_by, $sort_order);
		}
		
		return $this->db->count_all_results('products');
	}

	function get_products($category_id = false, $limit = false, $offset = false, $sort_by=false, $sort_order=false, $product_filter=false, $price_filters=false)
	{
		$obj =& get_instance();
		$obj->load->model('Brand_model');
		//if we are provided a category_id, then get products according to category
		if ($category_id)
		{
			if(!empty($product_filter)){
				// Sub Queries
				$this->db->select('attributes_entity.product_id')->from('attributes_entity')->join('attributes', 'attributes_entity.attribute_id=attributes.id')->join('attributes_values', 'attributes_entity.value_id=attributes_values.id');
				$count_filter = 0;
				foreach($product_filter as $z){
					if($count_filter == 0)
						$this->db->where('(gc_attributes.name="'.$z['name'].'" AND gc_attributes_values.value="'.$z['value'].'")');
					$this->db->or_where('(gc_attributes.name="'.$z['name'].'" AND gc_attributes_values.value="'.$z['value'].'")');	
					$count_filter++;
				}
				$this->db->group_by('attributes_entity.product_id'); 
				$this->db->having('COUNT(gc_attributes.id)',sizeof($product_filter));
				$where_clause = $this->db->get()->result();
				//echo $this->db->last_query();
				$this->db->flush_cache();
				$data_filter = array();
				foreach($where_clause as $a){
					array_push($data_filter, $a->product_id);
				}
				// End Sub Queries
			}
			if(!$sort_by)
			{
				$this->db->order_by($sort_by, $sort_order);
			}else{
				$this->db->order_by('sequence', 'ASC');
			}
			$result = $this->db->select('category_products.*, products.brand_id')->from('category_products')->join('products', 'category_products.product_id=products.id')->where(array('category_id'=>$category_id, 'enabled'=>1));
			
			
			if($price_filters):
				$price_filter = explode('.', $price_filters[0]['value']);
				$this->db->where("gc_products.price BETWEEN $price_filter[0] AND $price_filter[1]");
			endif;
			
			if(!empty($product_filter)){
				//if there is no product on filtered
				if(empty($data_filter)){
					array_push($data_filter, 0);
				}
				$this->db->where_in('category_products.product_id', $data_filter);
			}
			
			//here we use the clone command to create a shallow copy of the object
			$tempdb = clone $this->db;
			//now we run the count method on this copy
			$num_rows = $tempdb->count_all_results();
			
			if($limit)
				$result = $result->limit($limit)->offset($offset);
				
			$result = $result->get()->result();
			
			//$this->db->order_by('sequence', 'ASC');
			//$result	= $this->db->get_where('category_products', array('enabled'=>1,'category_id'=>$category_id), $limit, $offset);
			//$result	= $result->result();

			$contents	= array();
			$count		= 0;
			foreach ($result as $product)
			{
				$contents[$count]	= $this->get_product($product->product_id);
				$contents[$count]->brand	= (array) $obj->Brand_model->get_brand($product->brand_id);
				$count++;
			}
			
			$this->db->flush_cache();
			$data_filter = array();
			
			foreach($contents as $j){
				array_push($data_filter, $j->id);
			}
			if(empty($data_filter)){
				array_push($data_filter, 0);
			}
			$data_filter_string = implode (", ", $data_filter);
			$query_filter = $this->db->query("SELECT a.name, c.value, count(c.value)
							FROM gc_attributes as a, gc_attributes_entity as b, gc_attributes_values as c
							WHERE a.id = b.attribute_id
							AND c.id = b.value_id
							AND b.product_id IN (".$data_filter_string.")
							GROUP BY a.id,  c.value");
							
			$a = array();
			$a['contents'] = $contents;
			$a['data_filter'] = $query_filter->result();
			$a['num_rows'] = $num_rows;
			
			return $a;
		}
		else
		{
			//sort by alphabetically by default
			if(!empty($sort_by))
			{
				$this->db->order_by($sort_by, $sort_order);
			}else{
				$this->db->order_by('created', 'DESC');
			}
			$this->db->where(array('enabled'=>1));
			if($limit)
				$result = $this->db->limit($limit)->offset($offset)->get('products');
			else
				$result	= $this->db->get('products');
			//apply group discount
			$return = $result->result();
			if($this->group_discount_formula) 
			{
				foreach($return as &$product) {
					eval('$product->price=$product->price'.$this->group_discount_formula.';');
				}
			}
			return $return;
		}

	}
	
	function get_category_products($category_id = false, $limit = false, $offset = false, $sort_by=false, $sort_order=false, $product_filter=false, $price_filters=false)
	{
		$obj =& get_instance();
		$obj->load->model('Brand_model');
		$contents	= array();
		$data_filter_string = 0;
		//if we are provided a category_id, then get products according to category
		
		if ($category_id)
		{
			if(!empty($product_filter)){
				// Sub Queries
				$this->db->select('attributes_entity.product_id')->from('attributes_entity')->join('attributes', 'attributes_entity.attribute_id=attributes.id')->join('attributes_values', 'attributes_entity.value_id=attributes_values.id');
				$count_filter = 0;
				foreach($product_filter as $z){
					if($count_filter == 0)
						$this->db->where('(gc_attributes.name="'.$z['name'].'" AND gc_attributes_values.value="'.$z['value'].'")');
					$this->db->or_where('(gc_attributes.name="'.$z['name'].'" AND gc_attributes_values.value="'.$z['value'].'")');				
					$count_filter++;
				}
				$this->db->group_by('attributes_entity.product_id'); 
				$this->db->having('COUNT(gc_attributes.id)',sizeof($product_filter));
				$where_clause = $this->db->get()->result();
				//echo $this->db->last_query();
				$this->db->flush_cache();
				$data_filter = array();
				foreach($where_clause as $a){
					array_push($data_filter, $a->product_id);
				}
				// End Sub Queries
			}
			
			if(!$sort_by)
			{
				$this->db->order_by($sort_by, $sort_order);
			}else{
				$this->db->order_by('sequence', 'ASC');
			}
			$this->db->select('category_products.*, products.brand_id')->from('category_products')->join('products', 'category_products.product_id=products.id')->where(array('category_id'=>$category_id, 'enabled'=>1));
			
			if($price_filters):
				$price_filter = explode('.', $price_filters[0]['value']);
				$this->db->where("gc_products.price BETWEEN $price_filter[0] AND $price_filter[1]");
			endif;
			
			if(!empty($product_filter)){
				//if there is no product on filtered
				if(empty($data_filter)){
					array_push($data_filter, 0);
				}
				$this->db->where_in('category_products.product_id', $data_filter);
			}
			
			//here we use the clone command to create a shallow copy of the object
			$tempdb = clone $this->db;
			//now we run the count method on this copy
			$num_rows = $tempdb->count_all_results();
			
			$this->db->group_by('category_products.product_id');
			
			if($limit)
				$this->db->limit($limit)->offset($offset);
			
			$result = $this->db->get()->result();
			
			//echo $this->db->last_query();
			//$this->db->order_by('sequence', 'ASC');
			//$result	= $this->db->get_where('category_products', array('enabled'=>1,'category_id'=>$category_id), $limit, $offset);
			//$result	= $result->result();
				
			
			$count		= 0;
			foreach ($result as $product)
			{

				$contents[$count]			= $this->get_product($product->product_id);
				$contents[$count]->brand	= (array) $obj->Brand_model->get_brand($product->brand_id);
				$count++;
			}
			
			$this->db->flush_cache();
			$data_filter = array();
			
			foreach($contents as $j){
				array_push($data_filter, $j->id);
			}
			if(empty($data_filter)){
				array_push($data_filter, 0);
			}
			$data_filter_string = implode (", ", $data_filter);
			$query_filter = $this->db->query("SELECT a.name, c.value, count(c.value)
							FROM gc_attributes as a, gc_attributes_entity as b, gc_attributes_values as c
							WHERE a.id = b.attribute_id
							AND c.id = b.value_id
							AND b.product_id IN (".$data_filter_string.")
							GROUP BY a.id,  c.value");
			$a = array();
			$a['contents'] = $contents;
			$a['data_filter'] = $query_filter->result();
			$a['num_rows'] = $num_rows;
			
			return $a;
		}
		else
		{
			//sort by alphabetically by default
			$this->db->order_by('name', 'ASC');
			$result	= $this->db->get('products');
			//apply group discount
			$return = $result->result();
			if($this->group_discount_formula) 
			{
				foreach($return as &$product) {
					eval('$product->price=$product->price'.$this->group_discount_formula.';');
				}
			}
			return $return;
		}

	}
	
	function get_all_products($limit = false, $offset = false, $sort_by="created", $sort_order="desc")
	{	
		$obj =& get_instance();
		$obj->load->model('Brand_model');
		//this one counts the total number for our pagination
		$results['count']	= $this->db->select('product_id')->from('products')->where(array('enabled'=>1))->count_all_results();
	
		$this->db->order_by($sort_by, $sort_order);
		if($limit)
			$results['products']	= $this->db->get_where('products', array('enabled'=>1), $limit, $offset)->result();
		else
			$results['products']	=  $this->db->get_where('products', array('enabled'=>1))->result();
			
		$contents	= array();
		$count		= 0;
		foreach ($results['products'] as $product)
		{

			$results['products'][$count]	= $this->get_product($product->id);
			$results['products'][$count]->brand	= (array) $obj->Brand_model->get_brand($product->brand_id);
			$count++;
		}	
		
		return $results;
	}
	
	function get_featured_products($limit = false, $offset = false, $sort_by="created", $sort_order="desc")
	{	
		$obj =& get_instance();
		$obj->load->model('Brand_model');
		//this one counts the total number for our pagination
		$results['count']	= $this->db->select('product_id')->from('products')->where(array('featured'=>1,'enabled'=>1))->count_all_results();
	
		$this->db->order_by($sort_by, $sort_order);
		if($limit)
			$results['products']	= $this->db->get_where('products', array('featured'=>1,'enabled'=>1), $limit, $offset)->result();
		else
			$results['products']	=  $this->db->get_where('products', array('featured'=>1,'enabled'=>1))->result();
			
		$contents	= array();
		$count		= 0;
		foreach ($results['products'] as $product)
		{

			$results['products'][$count]	= $this->get_product($product->id);
			$results['products'][$count]->brand	= (array) $obj->Brand_model->get_brand($product->brand_id);
			$count++;
		}	
		
		return $results;
	}
	
	function get_new_products($limit = false, $offset = false, $sort_by="created", $sort_order="desc")
	{	
		$obj =& get_instance();
		$obj->load->model('Brand_model');
		//this one counts the total number for our pagination
		$results['count']	= $this->db->select('product_id')->from('products')->where(array('new'=>1,'enabled'=>1))->count_all_results();
	
		$this->db->order_by($sort_by, $sort_order);
		if($limit)
			$results['products']	= $this->db->get_where('products', array('new'=>1,'enabled'=>1), $limit, $offset)->result();
		else
			$results['products']	=  $this->db->get_where('products', array('new'=>1,'enabled'=>1))->result();
			
		$contents	= array();
		$count		= 0;
		foreach ($results['products'] as $product)
		{

			$results['products'][$count]	= $this->get_product($product->id);
			$results['products'][$count]->brand	= (array) $obj->Brand_model->get_brand($product->brand_id);
			$count++;
		}	
		
		return $results;
	}
	
	function get_sale_products($limit = false, $offset = false, $sort_by="created", $sort_order="desc")
	{	
		$obj =& get_instance();
		$obj->load->model('Brand_model');
		//this one counts the total number for our pagination
		$results['count']	= $this->db->select('product_id')->from('products')->where(array('sale'=>1,'enabled'=>1))->count_all_results();
		$date = date("Y-m-d");

		$this->db->order_by($sort_by, $sort_order);
		if($limit)
			$results['products']	= $this->db->get_where('products', array('sale'=>1, 'enabled'=>1,  'sale_enable_on <='=>$date, 'sale_disable_on >'=>$date), $limit, $offset)->result();
		else
			$results['products']	=  $this->db->get_where('products', array('sale'=>1, 'enabled'=>1, 'sale_enable_on <='=>$date, 'sale_disable_on >'=>$date))->result();
		
		$contents	= array();
		$count		= 0;
		foreach ($results['products'] as $product)
		{

			$results['products'][$count]	= $this->get_product($product->id);
			$results['products'][$count]->brand	= (array) $obj->Brand_model->get_brand($product->brand_id);
			$count++;
		}
		
		return $results;
	}
	
	function search_products($term, $limit=false, $offset=false, $sort_by, $sort_order)
	{
		$results		= array();

		//I know this is the round about way of doing things and is not the fastest. but it is thus far the easiest.

		//this one counts the total number for our pagination
		$this->db->like('name', $term);
		$this->db->or_like('description', $term);
		$this->db->or_like('excerpt', $term);
		$this->db->or_like('sku', $term);
		$this->db->where(array('enabled'=>1));
		$results['count']	= $this->db->count_all_results('products');

		//this one gets just the ones we need.
		$this->db->like('name', $term);
		$this->db->or_like('description', $term);
		$this->db->or_like('excerpt', $term);
		$this->db->or_like('sku', $term);
		$this->db->where(array('enabled'=>1));
		
		$this->db->order_by($sort_by, $sort_order);
		if($limit)
			$results['products']	= $this->db->get('products', $limit, $offset)->result();
		else
			$results['products']	= $this->db->get('products')->result();
			
		return $results;
	}

	function count_products($id)
	{
		if($id){
			return $this->db->select('product_id')->from('category_products')->join('products', 'category_products.product_id=products.id')->where(array('category_id'=>$id, 'enabled'=>1))->count_all_results();
		}else{
			return $this->db->select('product_id')->from('products')->where(array('enabled'=>1))->count_all_results();
		}
	}

	
	function count_category_products($id)
	{
		return $this->db->select('product_id')->from('category_products')->join('products', 'category_products.product_id=products.id')->where(array('category_id'=>$id, 'enabled'=>1))->count_all_results();
	}

	function get_product($id, $sub=true)
	{
		$result	= $this->db->get_where('products', array('id'=>$id))->row();
		if(!$result)
		{
			return false;
		}
		
		$result->categories = $this->get_product_categories($result->id);
		
		// group discount?
		if($this->group_discount_formula) 
		{
			eval('$result->price=$result->price'.$this->group_discount_formula.';');
		}
		return $result;
	}
	
	function get_quantity_product($id)
	{
		$this->db->select('quantity');

		return $this->db->where('id', $id)->get('products')->row();	
	}

	function get_product_categories($id)
	{
		$cats	= $this->db->where('product_id', $id)->get('category_products')->result();
		
		$categories = array();
		foreach ($cats as $c)
		{
			$categories[] = $c->category_id;
		}
		return $categories;
	}

	function get_slug($id)
	{
		return $this->db->get_where('products', array('id'=>$id))->row()->slug;
	}

	function check_slug($str, $id=false)
	{
		$this->db->select('slug');
		$this->db->from('products');
		$this->db->where('slug', $str);
		if ($id)
		{
			$this->db->where('id !=', $id);
		}
		$count = $this->db->count_all_results();

		if ($count > 0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	function save($product, $options=false, $categories=false)
	{
		if ($product['id'])
		{
			$this->db->where('id', $product['id']);
			$this->db->update('products', $product);

			$id	= $product['id'];
		}
		else
		{
			$this->db->insert('products', $product);
			$id	= $this->db->insert_id();
		}

		/*loop through the product options and add them to the db*/
		if($options !== false)
		{
			$obj =& get_instance();
			$obj->load->model('Option_model');

			// wipe the slate
			//$obj->Option_model->clear_options($id);

			// save edited values
			$count = 1;
			foreach ($options as $option)
			{
				$values = $option['values'];
				unset($option['values']);
				$option['product_id'] = $id;
				$option['sequence'] = $count;

				$obj->Option_model->save_option($option, $values);
				$count++;
			}
		}
		
		if($categories !== false)
		{
			if($product['id'])
			{
				//get all the categories that the product is in
				$cats	= $this->get_product_categories_overwrite($id);
				
				//eliminate categories that products are no longer in
				foreach($cats as $c)
				{
					
					if(!in_array($c, $categories))
					{
						$pieces = explode(".", $c);
						$this->db->delete('category_products', array('product_id'=>$id,'category_id'=>$pieces[0], 'parent_id'=>$pieces[1]));
					}
				}
				
				//add products to new categories
				foreach($categories as $c)
				{
					if(!in_array($c, $cats))
					{
						$pieces = explode(".", $c);
						$this->db->insert('category_products', array('product_id'=>$id,'category_id'=>$pieces[0], 'parent_id'=>$pieces[1]));
					}
				}
			}
			else
			{
				//new product add them all
				foreach($categories as $c)
				{
					$pieces = explode(".", $c);
					$this->db->insert('category_products', array('product_id'=>$id,'category_id'=>$pieces[0], 'parent_id'=>$pieces[1]));
				}
			}
		}
		//$product['options_value'] = json_encode($options);
		$product['updated'] = date("Y-m-d H:i:s");
		$this->db->insert('products_log', $product);
		
		//return the product id
		return $id;
	}
	
	function get_product_categories_overwrite($id)
	{
		$cats	= $this->db->where('product_id', $id)->get('category_products')->result();
		
		$categories = array();
		foreach ($cats as $c)
		{
			$categories[] = $c->category_id.".".$c->parent_id;
		}
		return $categories;
	}
	
	// update quantity
	function update_product($product, $options=false)
	{
		if ($product['id'])
		{
			$this->db->where('id', $product['id']);
			$this->db->update('products', $product);

			$id	= $product['id'];
		}

		//loop through the product options and add them to the db
		if($options)
		{
			$this->db->where('id', $options['id']);
			$this->db->update('option_values', $options);
		}
	}
	
	function delete_product($id)
	{
		// delete product 
		$this->db->where('id', $id);
		$this->db->delete('products');

		//delete references in the product to category table
		$this->db->where('product_id', $id);
		$this->db->delete('category_products');
		
		// delete coupon reference
		$this->db->where('product_id', $id);
		$this->db->delete('coupons_products');

	}

	function add_product_to_category($product_id, $optionlist_id, $sequence)
	{
		$this->db->insert('product_categories', array('product_id'=>$product_id, 'category_id'=>$category_id, 'sequence'=>$sequence));
	}

	// Build a cart-ready product array
	function get_cart_ready_product($id, $quantity=false)
	{
		$obj =& get_instance();
		$obj->load->model('Settings_model');
		
		// retrieve settings
		if ( $settings = $obj->Settings_model->get_settings('paypal_express') ) 
		{
			$convert = $settings['convert'];
		}
		
		$db_product			= $this->get_product($id);
		if( ! $db_product)
		{
			return false;
		}
		
		$product = array();
		
		if($db_product->sale == 1):
			if($db_product->saleprice > 0):
				$date = strtotime(date("Y-m-d"));   
				if(strtotime($db_product->sale_enable_on) <= $date && strtotime($db_product->sale_disable_on) > $date):
					$product['price']	= $db_product->saleprice;
				else: 
					$product['price']	= $db_product->price;
				endif;
			else:
				$product['price']	= $db_product->price;
			endif; 
		else:
			$product['price']	= $db_product->price;   
		endif;        
                            
		
		$product['base_price'] 		= $product['price']; // price gets modified by options, show the baseline still...
		$product['conversion_price']= round($product['price']/$convert, 2);
		$product['id']				= $db_product->id;
		$product['name']			= $db_product->name;
		$product['sku']				= $db_product->sku;
		$product['excerpt']			= $db_product->excerpt;
		
		//get the primary photo for the product
		//$primary	= base_url('images/nopicture.png');
		$images = array_values((array)json_decode($db_product->images));
		if(count($images) > 0 )
		{	
			$primary	= $images[0];
			//print_r($primary);
			foreach($images as $image)
			{
				if(isset($image->primary))
				{
					$primary	= $image;
				}
			}
		}

		$product['images']			= $primary->filename;
		$product['slug']			= $db_product->slug;
		$product['weight']			= $db_product->weight;
		$product['shippable']	 	= $db_product->shippable;
		$product['taxable']			= $db_product->taxable;
		$product['fixed_quantity']	= $db_product->fixed_quantity;
		$product['options']			= array();
		
		// Some products have n/a quantity, such as downloadables	
		if (!$quantity || $quantity <= 0 || $db_product->fixed_quantity==1)
		{
			$product['quantity'] = 1;
		} else {
			$product['quantity'] = $quantity;
		}

		
		// attach list of associated downloadables
		$product['file_list']	= $this->Digital_Product_model->get_associations_by_product($id);
		
		return $product;
	}
}