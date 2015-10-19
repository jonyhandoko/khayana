<?php

class Products extends Admin_Controller {	
	
	private $use_inventory = false;
	
	function __construct()
	{		
		parent::__construct();
		//force_ssl();

		$this->auth->check_access('Admin', true);
		$this->load->model('Search_model');
		$this->load->model('Product_model');
		$this->load->model('Brand_model');
		$this->load->helper('form');
		$this->lang->load('product');
		$this->load->helper(array('formatting', 'utility'));
		$this->lang->load('order');
	}

	function index($code=0, $page=0, $rows=false)
	{
		$data['page_title']	= lang('products');
		$data['message']	= $this->session->flashdata('message');
		$data['categories']	= $this->Category_model->get_categories();
		$term				= false;
		
		$post	= $this->input->post(null, false);
		if($post)
		{
			//if the term is in post, save it to the db and give me a reference
			$term	= json_encode($post);
			$data['code']	= $this->Search_model->record_term($term);
			$code = $data['code'];
			//reset the term to an object for use
			$term	= (object)$post;
		}
		elseif ($code)
		{
			$term	= $this->Search_model->get_term($code);
			$term	= json_decode($term);
		} 

 		$data['term']	= $term;
 		
		$data['products']	= $this->Product_model->get_products_admin($term, 'sku', 'ASC', $rows, $page);
		//echo $this->db->last_query();
		if($term)
			$data['total']	= $this->Product_model->get_products_admin_count($term);
		
		//$data['products']	= $this->Product_model->get_products();

		$this->load->view($this->config->item('admin_folder').'/products', $data);
	}
	
	function bulk_save()
	{
		$products	= $this->input->post('product');
		
		if(!$products)
		{
			$this->session->set_flashdata('error',  lang('error_bulk_no_products'));
			redirect($this->config->item('admin_folder').'/products');
		}
				
		foreach($products as $id=>$product)
		{
			if(!isset($product['new']))
				$product['new'] = 0;
			$product['id']	= $id;
			$this->Product_model->save($product);
		}
		
		$this->session->set_flashdata('message', lang('message_bulk_update'));
		redirect($this->config->item('admin_folder').'/products');
	}
	
	function form($id = false, $duplicate = false)
	{
		$this->product_id	= $id;
		$this->load->helper('form');
		$this->load->helper('date');
		$this->load->library('form_validation');
		$this->load->model(array('Option_model', 'Category_model', 'Digital_Product_model', 'Attribute_model'));
		$this->lang->load('digital_product');
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		
		$data['categories']		= $this->Category_model->get_categories_tierd();
		$data['product_list']	= $this->Product_model->get_products();
		$data['file_list']		= $this->Digital_Product_model->get_list();
		$data['stores_option']	= $this->Brand_model->get_brands_array();
		$data['attributes']		= $this->Attribute_model->get_attributes();
		
		//Get all attributes values
		foreach($data['attributes'] as $attrlist){
			$attrlist->values = $this->Attribute_model->get_attributes_values($attrlist->id);
		}

		$data['page_title']		= lang('product_form');

		//default values are empty if the product is new
		$data['id']					= '';
		$data['sku']				= '';
		$data['stores']			= '';
		$data['name']				= '';
		$data['slug']				= '';
		$data['description']		= '';
		$data['specs']				= '';
		$data['excerpt']			= '';
		$data['price']				= '';
		$data['saleprice']			= '';
		$data['sale_enable_on']		= '';
		$data['sale_disable_on']	= '';
		$data['featured']			= '';
		$data['new']				= '';
		$data['sale']				= '';
		$data['weight']				= '';
		$data['track_stock'] 		= '';
		$data['seo_title']			= '';
		$data['meta']				= '';
		$data['shippable']			= '';
		$data['taxable']			= '';
		$data['fixed_quantity']		= '';
		$data['quantity']			= '';
		$data['enabled']			= '';
		$data['related_products']	= array();
		$data['product_categories']	= array();
		$data['images']				= array();
		$data['product_files']		= array();

		//create the photos array for later use
		$data['photos']		= array();

		if ($id)
		{	
			// get the existing file associations and create a format we can read from the form to set the checkboxes
			$pr_files 		= $this->Digital_Product_model->get_associations_by_product($id);
			foreach($pr_files as $f)
			{
				$data['product_files'][]  = $f->file_id;
			}
			
			// get product & options data
			$data['product_options']	= $this->Option_model->get_product_options($id);
			$product					= $this->Product_model->get_product($id);
			
			//if the product does not exist, redirect them to the product list with an error
			if (!$product)
			{
				$this->session->set_flashdata('error', lang('error_not_found'));
				redirect($this->config->item('admin_folder').'/products');
			}
			
			//helps us with the slug generation
			$this->product_name	= $this->input->post('slug', $product->slug);
			
			//set values to db values
			$data['id']					= $id;
			$data['sku']				= $product->sku;
			$data['stores']				= $product->brand_id;
			$data['name']				= $product->name;
			$data['seo_title']			= $product->seo_title;
			$data['meta']				= $product->meta;
			$data['slug']				= $product->slug;
			$data['description']		= $product->description;
			$data['specs']				= $product->specs;
			$data['excerpt']			= $product->excerpt;
			$data['price']				= $product->price;
			$data['saleprice']			= $product->saleprice;
			$data['sale_enable_on']		= $product->sale_enable_on;
			$data['sale_disable_on']	= $product->sale_disable_on;
			$data['featured']			= $product->featured;
			$data['new']				= $product->new;
			$data['sale']				= $product->sale;
			$data['weight']				= $product->weight;
			$data['track_stock'] 		= $product->track_stock;
			$data['shippable']			= $product->shippable;
			$data['quantity']			= $product->quantity;
			$data['taxable']			= $product->taxable;
			$data['fixed_quantity']		= $product->fixed_quantity;
			$data['enabled']			= $product->enabled;
			
			//make sure we haven't submitted the form yet before we pull in the images/related products from the database
			if(!$this->input->post('submit'))
			{
				$data['product_categories']	= $product->categories;
				$data['related_products']	= json_decode($product->related_products);
				$data['images']				= (array)json_decode($product->images);
			}
		}
		
		//if $data['related_products'] is not an array, make it one.
		if(!is_array($data['related_products']))
		{
			$data['related_products']	= array();
		}
		if(!is_array($data['product_categories']))
		{
			$data['product_categories']	= array();
		}
		
		//no error checking on these
		$this->form_validation->set_rules('caption', 'Caption');
		$this->form_validation->set_rules('primary_photo', 'Primary');

		$this->form_validation->set_rules('sku', 'lang:sku', 'trim');
		$this->form_validation->set_rules('seo_title', 'lang:seo_title', 'trim');
		$this->form_validation->set_rules('meta', 'lang:meta_data', 'trim');
		$this->form_validation->set_rules('name', 'lang:name', 'trim|required|max_length[64]');
		$this->form_validation->set_rules('slug', 'lang:slug', 'trim');
		$this->form_validation->set_rules('description', 'lang:description', 'trim');
		$this->form_validation->set_rules('excerpt', 'lang:excerpt', 'trim');
		$this->form_validation->set_rules('price', 'lang:price', 'trim|numeric|floatval');
		$this->form_validation->set_rules('saleprice', 'lang:saleprice', 'trim|numeric|floatval');
		$this->form_validation->set_rules('weight', 'lang:weight', 'trim|numeric|floatval');
		$this->form_validation->set_rules('track_stock', 'lang:track_stock', 'trim|numeric');
		$this->form_validation->set_rules('quantity', 'lang:quantity', 'trim|numeric');
		$this->form_validation->set_rules('shippable', 'lang:shippable', 'trim|numeric');
		$this->form_validation->set_rules('taxable', 'lang:taxable', 'trim|numeric');
		$this->form_validation->set_rules('fixed_quantity', 'lang:fixed_quantity', 'trim|numeric');
		$this->form_validation->set_rules('enabled', 'lang:enabled', 'trim|numeric');

		/*
		if we've posted already, get the photo stuff and organize it
		if validation comes back negative, we feed this info back into the system
		if it comes back good, then we send it with the save item
		
		submit button has a value, so we can see when it's posted
		*/
		
		if($duplicate)
		{
			$data['id']	= false;
		}

		if($this->input->post('submit'))
		{
			//reset the product options that were submitted in the post
			$data['product_options']	= $this->input->post('option');
			$data['related_products']	= $this->input->post('related_products');
			$data['product_categories']	= $this->input->post('categories');
			$data['images']				= $this->input->post('images');
			$data['product_files']		= $this->input->post('downloads');
			$data['product_specs_name']	= $this->input->post('specsName');
			$data['product_specs_value']= $this->input->post('specsValue');
		}
		
		
		if ($this->form_validation->run() == FALSE)
		{
			$this->load->view($this->config->item('admin_folder').'/product_form', $data);
		}
		else
		{
			$this->load->helper('text');
			
			//$a =$this->input->post('attributes');print_r($this->input->post('attributes'));echo $a[0]["attr_val"];return false;
			
			//first check the slug field
			$slug = $this->input->post('slug');
			
			//if it's empty assign the name field
			if(empty($slug) || $slug=='')
			{
				$slug = $this->input->post('name');
			}
			
			$slug	= url_title(convert_accented_characters($slug), 'dash', TRUE);
			
			//validate the slug
			$this->load->model('Routes_model');

			if($id)
			{
				$slug		= $this->Routes_model->validate_slug($slug, $product->route_id);
				$route_id	= $product->route_id;
				$save['updated']			= date("Y-m-d H:i:s");
			}
			else
			{
				$slug	= $this->Routes_model->validate_slug($slug);
				
				$route['slug']	= $slug;	
				$route_id	= $this->Routes_model->save($route);
				$save['created']				= date("Y-m-d H:i:s");
			}
			$specs = array();
			$counterSpecs = 0;
			foreach($data['product_specs_name'] as $a){
				array_push($specs, array("name"=>$a,"value"=>$data['product_specs_value'][$counterSpecs]));
				$counterSpecs++;
			}
			$specs = json_encode($specs);

			$save['id']					= $id;
			$save['sku']				= $this->input->post('sku');
			$save['brand_id']			= $this->input->post('stores');
			$save['name']				= $this->input->post('name');
			$save['seo_title']			= $this->input->post('seo_title');
			$save['meta']				= $this->input->post('meta');
			$save['description']		= $this->input->post('description');
			$save['specs']				= $specs;
			$save['excerpt']			= $this->input->post('excerpt');
			$save['price']				= $this->input->post('price');
			$save['saleprice']			= $this->input->post('saleprice1');
			$save['sale_enable_on']		= $this->input->post('enable_on_alt');
			$save['sale_disable_on']	= $this->input->post('disable_on_alt');
			$save['featured']			= $this->input->post('featured');
			$save['new']				= $this->input->post('new');
			$save['sale']				= $this->input->post('sale');
			$save['weight']				= $this->input->post('weight');
			$save['track_stock']		= $this->input->post('track_stock');
			$save['fixed_quantity']		= $this->input->post('fixed_quantity');
			$save['quantity']			= $this->input->post('quantity');
			$save['shippable']			= $this->input->post('shippable');
			$save['taxable']			= $this->input->post('taxable');
			$save['enabled']			= $this->input->post('enabled');
			$post_images				= $this->input->post('images');
			
			$save['slug']				= $slug;
			$save['route_id']			= $route_id;
			
			if($primary	= $this->input->post('primary_image'))
			{
				if($post_images)
				{
					foreach($post_images as $key => &$pi)
					{
						if($primary == $key)
						{
							$pi['primary']	= true;
							continue;
						}
					}	
				}
				
			}
			
			$save['images']				= json_encode($post_images);
			
			
			if($this->input->post('related_products'))
			{
				$save['related_products'] = json_encode($this->input->post('related_products'));
			}
			else
			{
				$save['related_products'] = '';
			}
			
			//save categories
			$categories			= $this->input->post('categories');

			// format options
			$options	= array();
			
			//print_r($this->input->post('option'));return false;
			if($this->input->post('option'))
			{
				foreach ($this->input->post('option') as $option)
				{
					$options[]	= $option;
				}

			}	
			
			// save product 
			$product_id	= $this->Product_model->save($save, $options, $categories);
			
			// add file associations
			// clear existsing
			$this->Digital_Product_model->disassociate(false, $product_id);
			// save new
			$downloads = $this->input->post('downloads');
			if(is_array($downloads))
			{
				foreach($downloads as $d)
				{
					$this->Digital_Product_model->associate($d, $product_id);
				}
			}			

			//save the route
			$route['id']	= $route_id;
			$route['slug']	= $slug;
			$route['route']	= 'cart/product/'.$product_id;
			
			$this->Routes_model->save($route);
			
			if($data['quantity'] <1 && $save['quantity'] !=0){
				$notifylist = $this->Product_model->get_notifications($id);
				foreach($notifylist as $notify){
					//echo $notify->name.' '.$notify->slug.' '.$notify->id;	
					$this->load->helper('string');
					$this->load->library('email');
					$config['mailtype'] = 'html';
					$this->email->initialize($config);
				
					$this->email->from($this->config->item('email'), $this->config->item('site_name'));
					$this->email->to($notify->custome_email);
					$this->email->subject($this->config->item('site_name').': '.$notify->name.' restock');
					$this->email->message('Your product <strong>'.$notify->name.'</strong> has been restock <br/> Please click here <a href="'.base_url().$notify->slug.'">here</a>');
					$this->email->send();
					
					$this->Product_model->update_notifications($notify->id);
				}
				
			}
			
			$this->session->set_flashdata('message', lang('message_saved_product'));

			//go back to the product list
			redirect($this->config->item('admin_folder').'/products/form/'.$product_id);
		}
	}
	
	function product_attribute_form($product_id=false, $id=false){
		$this->load->model(array('Attribute_model'));
		$data['product_id'] = $product_id;
		if($id)
			$data['id'] = $id;
		else
			$data['id'] = '';
			
		if(!$product_id){
			$data['attributes']		= $this->Attribute_model->get_attributes();
			//Get all attributes values
			foreach($data['attributes'] as $attrlist){
				$attrlist->values = $this->Attribute_model->get_attributes_values($attrlist->id);
			}
		}else{
			$data['attributes'] = $this->Attribute_model->get_attributes_product($product_id);
			//Get all attributes values
			foreach($data['attributes'] as $attrlist){
				$attrlist->values = $this->Attribute_model->get_attributes_values($attrlist->id);
			}
		}
		
		if($this->input->post('submit'))
		{
				$save['attributes'] = $this->input->post('attributes');
				$this->Attribute_model->save_attribute_entity($product_id, $save);
		}
		
		$this->load->view($this->config->item('admin_folder').'/iframe/product_attribute_view', $data);
	}
	
	function product_image_form()
	{
		$data['file_name'] = false;
		$data['error']	= false;
		$this->load->view($this->config->item('admin_folder').'/iframe/product_image_uploader', $data);
	}
	
	function product_image_upload()
	{
		$data['file_name'] = false;
		$data['error']	= false;
		
		$config['allowed_types'] = 'gif|jpg|png';
		//$config['max_size']	= $this->config->item('size_limit');
		$config['upload_path'] = 'uploads/product/original';
		$config['encrypt_name'] = true;
		$config['remove_spaces'] = true;


		$this->load->library('upload', $config);
		
		if ( $this->upload->do_upload())
		{
			$upload_data	= $this->upload->data();
			
			$this->load->library('image_lib');
			
			if($upload_data['image_width']=='762' && $upload_data['image_height']=='1100'){
				/*
				
				I find that ImageMagick is more efficient that GD2 but not everyone has it
				if your server has ImageMagick then you can change out the line
				
				$config['image_library'] = 'gd2';
				
				with
				
				$config['library_path']		= '/usr/bin/convert'; //make sure you use the correct path to ImageMagic
				$config['image_library']	= 'ImageMagick';
				*/			
				
				/*this is the larger image
				$config['image_library'] = 'gd2';
				$config['source_image'] = 'uploads/product/original/'.$upload_data['file_name'];
				$config['new_image']	= 'uploads/product/medium/'.$upload_data['file_name'];
				$config['maintain_ratio'] = FALSE;
				$config['width'] = 476;
				$config['height'] = 476;
				$this->image_lib->initialize($config);
				$this->image_lib->resize();
				$this->image_lib->clear();*/

				/*thumbnail image*/
				$config['image_library'] = 'gd2';
				$config['source_image'] = 'uploads/product/original/'.$upload_data['file_name'];
				$config['new_image']	= 'uploads/product/thumb/'.$upload_data['file_name'];
				$config['maintain_ratio'] = TRUE;
				$config['width'] = 303;
				$config['height'] = 438;
				$this->image_lib->initialize($config); 
				$this->image_lib->resize();
				$this->image_lib->clear();


				$data['file_name']	= $upload_data['file_name'];
			}else{
				$data['error'] = 'Image Size does not match. (762 x 1100)';
			}
		}
		
		if($this->upload->display_errors() != '')
		{
			$data['error'] = $this->upload->display_errors();
		}
		
		$this->load->view($this->config->item('admin_folder').'/iframe/product_image_uploader', $data);
	}
	
	function delete($id = false)
	{
		if ($id)
		{	
			$product	= $this->Product_model->get_product($id);
			//if the product does not exist, redirect them to the customer list with an error
			if (!$product)
			{
				$this->session->set_flashdata('error', lang('error_not_found'));
				redirect($this->config->item('admin_folder').'/products');
			}
			else
			{

				// remove the slug
				$this->load->model('Routes_model');
				$this->Routes_model->remove('('.$product->slug.')');

				//if the product is legit, delete them
				$this->Product_model->delete_product($id);

				$this->session->set_flashdata('message', lang('message_deleted_product'));
				redirect($this->config->item('admin_folder').'/products');
			}
		}
		else
		{
			//if they do not provide an id send them to the product list page with an error
			$this->session->set_flashdata('error', lang('error_not_found'));
			redirect($this->config->item('admin_folder').'/products');
		}
	}
}