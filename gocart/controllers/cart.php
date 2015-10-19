<?php

class Cart extends CI_Controller {
	
	//we collect the categories automatically with each load rather than for each function
	//this just cuts the codebase down a bit
	var $categories	= '';
	
	//load all the pages into this variable so we can call it from all the methods
	var $pages = '';
	
	// determine whether to display gift card link on all cart pages
	//  This is Not the place to enable gift cards. It is a setting that is loaded during instantiation.
	var $gift_cards_enabled; 
	
	var $header_text;
	
	var $customer;

	function __construct()
	{
		parent::__construct();
		
		//make sure we're not always behind ssl
		//remove_ssl();
		
		$this->load->library('Go_cart');
		$this->load->model(array('Page_model', 'Place_model', 'Product_model', 'Brand_model', 'Attribute_model', 'Digital_Product_model', 'Gift_card_model', 'Option_model', 'Order_model', 'Settings_model'));
		$this->load->helper(array('form_helper', 'formatting_helper'));
		$this->customer = $this->go_cart->customer();
	
		//fill in our variables
		//$this->categories	= $this->Category_model->get_categories_tierd(0);
		//$this->pages		= $this->Page_model->get_pages();
		
		// check if giftcards are enabled
		/*$gc_setting = $this->Settings_model->get_settings('gift_cards');
		if(!empty($gc_setting['enabled']) && $gc_setting['enabled']==1)
		{
			$this->gift_cards_enabled = true;
		}			
		else
		{
			$this->gift_cards_enabled = false;
		}*/
		
		//load the theme package
		$this->load->add_package_path(APPPATH.'themes/'.$this->config->item('theme').'/');
		
	}

	function index()
	{
		$this->load->model(array('Banner_model', 'box_model'));
		$this->load->helper('directory');
		$data['gift_cards_enabled'] = $this->gift_cards_enabled;
		$data['banners']			= $this->Banner_model->get_homepage_banners(4);
		$data['boxes']				= $this->box_model->get_homepage_boxes(3);
		$data['homepage']			= true;
		
		$json = file_get_contents('http://wp.ingeyustendi.com/?wpjson&gl&qty=3');
		$obj = json_decode($json);
		$data['json'] = $obj;
		
		$sort_by="created"; 
		$sort_order="desc"; 
		$page=0;
		//grab the products using the pagination lib
		$featured			= $this->Product_model->get_featured_products(6, $page, $sort_by, $sort_order);
		//$result					= $this->Product_model->get_new_products(6, $page, $sort_by, $sort_order);
		$data['products']		= $featured['products'];
		foreach ($data['products'] as &$p)
		{
			$p->images	= (array)json_decode($p->images);
			$p->options	= $this->Option_model->get_product_options($p->id);
		}
		
		$prods	= $this->Product_model->get_category_products(1, 9, $sort_by, $sort_order);
		$data['menwatches']	= $prods['contents'];
		foreach ($data['menwatches'] as &$k)
		{
			$k->images	= (array)json_decode($k->images);
			$k->options	= $this->Option_model->get_product_options($k->id);
		}
		
		$this->load->view('homepage', $data);
	}
	
	function social(){
		$this->load->helper('directory');
		
		$json = file_get_contents('https://api.instagram.com/v1/tags/tokitastore/media/recent?client_id=227b2bd6a19149edbdc74532a5d2e43b');
		$data['insta'] = json_decode($json);
		
		$this->load->view('social', $data);
	}
	
	function lookbooks()
	{
		$this->load->helper('directory');
		//$data['gift_cards_enabled'] = $this->gift_cards_enabled;
		$this->load->model('lookbook_model');
		$data['page_title'] = 'Lookbook';
		$data['lookbooks']				= $this->lookbook_model->get_homepage_lookbooks(12);

		$this->load->view('lookbook', $data);
	}
	
	function insert_notification(){
		$this->load->library('form_validation');
		$this->form_validation->set_rules('email', 'lang:recipient_email', 'trim|required|valid_email');
		
		if ($this->form_validation->run() == FALSE)
		{
			echo '1';
			
		}else{
			if($this->Product_model->check_notification($this->input->post('email'), $this->input->post('product')) == NULL){
				$this->Product_model->insert_notification($this->input->post('email'), $this->input->post('product'));
			}
			
			echo 'Notification Registered';
		}
		
		
	}

	function page($id)
	{
		$this->load->model('Page_model');
		$data['page']				= $this->Page_model->get_page($id);
		$data['fb_like']			= true;

		$data['page_title']			= $data['page']->title;
		
		$data['meta']				= $data['page']->meta;
		$data['seo_title']			= $data['page']->seo_title;
		
		$data['gift_cards_enabled'] = $this->gift_cards_enabled;
		
		$json = file_get_contents('http://wp.watchinc.co.id/?wpjson&gl');
		$obj = json_decode($json);
		$data['json'] = $obj;
		
		$this->load->view('page', $data);
	}
	
	function blog($url="")
	{				
		if($url==""):
			$data['blog_page'] = 'home';
			$json = file_get_contents('http://wp.ingeyustendi.com/?wpjson&gl');
			$obj = json_decode($json);
			$data['json'] = $obj;
		else:
			$data['blog_page'] = 'detail';
			$str = strstr($url, "--");
			$id = substr($str, 2);
			
			$json = file_get_contents('http://wp.ingeyustendi.com/?wpjson&dt&pid='.$id);
			$obj = json_decode($json);
			$data['detail'] = $json;
		endif;
		
		$this->load->view('blog', $data);
	}
	
	function search($term="", $sort_by="created", $sort_order="desc", $page = 0)
	{
		$this->load->model('Search_model');
		
		$data['page_title']			= "Search";
		//$data['gift_cards_enabled']	= $this->gift_cards_enabled;
		if(isset($_REQUEST['term'])){
			$term = $this->input->post('term');
		}
		/*//check to see if we have a search term
		if(!$code)
		{
			//if the term is in post, save it to the db and give me a reference
			$term		= $this->input->post('term');
			$code		= $this->Search_model->record_term($term);
		}
		else
		{
			//if we have the md5 string, get the term
			$term	= $this->Search_model->get_term($code);
		}

		if(empty($term))
		{
			//if there is still no search term throw an error
			$this->load->view('search_error', $data);
		}
		else
		{*/
	
			$data['page_title']	= 'Search';
			$data['gift_cards_enabled'] = $this->gift_cards_enabled;
		
			//set up pagination
			$this->load->library('pagination');
			$config['base_url']		= base_url().'cart/search/'.$term.'/'.$sort_by.'/'.$sort_order;
			$config['uri_segment']	= 6;
			$config['per_page']		= 9;
		
			//grab the products using the pagination lib
			if($page && $page == "all" ){
				$result					= $this->Product_model->search_products($term, false, false, $sort_by, $sort_order);
			}else{
				$result					= $this->Product_model->search_products($term, $config['per_page'], $page, $sort_by, $sort_order);
			}
			
			$config['total_rows']	= $result['count'];
			$this->pagination->initialize($config);
	
			$data['products']		= $result['products'];
			$data['term'] = $term;
			foreach ($data['products'] as &$p)
			{
				$p->images	= (array)json_decode($p->images);
				$p->options	= $this->Option_model->get_product_options($p->id);
			}
			
			$this->load->view('category', $data);
		//}
	}
	
	function all($sort_by="created", $sort_order="desc", $page=0)
	{
		$data['product_columns']	= $this->config->item('product_columns');
		//$data['gift_cards_enabled'] = $this->gift_cards_enabled;
		
		$data['page_title']	= "New Arrivals";
		
		//set up pagination
		$this->load->library('pagination');
		$config['base_url']		= base_url().'/cart/all/'.$sort_by.'/'.$sort_order.'/';
		$config['uri_segment']	= 5;
		$config['per_page']		= 1;
		
		//grab the products using the pagination lib
		if($page && $page == "all" ){
			$result					= $this->Product_model->get_all_products(false, false, $sort_by, $sort_order);
		}else{
			$result					= $this->Product_model->get_all_products($config['per_page'], $page, $sort_by, $sort_order);
		}
			
		$config['total_rows']	= $result['count'];
		$this->pagination->initialize($config);

		$data['products']		= $result['products'];
		
		//$config['total_rows']	= $this->Product_model->count_category_products($data['category']->id);
		
		//grab the products using the pagination lib
		foreach ($data['products'] as &$p)
		{
			$p->images	= (array)json_decode($p->images);
			$p->options	= $this->Option_model->get_product_options($p->id);
		}
		
		$this->load->view('category', $data);
	}
	
	function newarrival($sort_by="created", $sort_order="desc", $page=0)
	{
		$data['product_columns']	= $this->config->item('product_columns');
		//$data['gift_cards_enabled'] = $this->gift_cards_enabled;
		
		$data['page_title']	= "New Arrivals";
		
		//set up pagination
		$this->load->library('pagination');
		$config['base_url']		= base_url().'new/'.$sort_by.'/'.$sort_order.'/';
		$config['uri_segment']	= 4;
		$config['per_page']		= 9;
		
		//grab the products using the pagination lib
		if($page && $page == "all" ){
			$result					= $this->Product_model->get_new_products(false, false, $sort_by, $sort_order);
		}else{
			$result					= $this->Product_model->get_new_products($config['per_page'], $page, $sort_by, $sort_order);
		}
			
		$config['total_rows']	= $result['count'];
		$this->pagination->initialize($config);

		$data['products']		= $result['products'];
		
		//$config['total_rows']	= $this->Product_model->count_category_products($data['category']->id);
		
		//grab the products using the pagination lib
		foreach ($data['products'] as &$p)
		{
			$p->images	= (array)json_decode($p->images);
			$p->options	= $this->Option_model->get_product_options($p->id);
		}
		
		$this->load->view('category', $data);
	}
	
	function sale($sort_by="created", $sort_order="desc", $page=0)
	{
		$data['product_columns']	= $this->config->item('product_columns');
		//$data['gift_cards_enabled'] = $this->gift_cards_enabled;
		
		$data['page_title']	= "Sale";
		
		//set up pagination
		$this->load->library('pagination');
		$config['base_url']		= base_url().'sale/'.$sort_by.'/'.$sort_order.'/';
		$config['uri_segment']	= 4;
		$config['per_page']		= 9;
		
		//grab the products using the pagination lib
		if($page && $page == "all" ){
			$result					= $this->Product_model->get_sale_products(false, false, $sort_by, $sort_order);
		}else{
			$result					= $this->Product_model->get_sale_products($config['per_page'], $page, $sort_by, $sort_order);
		}
			
		$config['total_rows']	= $result['count'];
		$this->pagination->initialize($config);

		$data['products']		= $result['products'];
		
		//$config['total_rows']	= $this->Product_model->count_category_products($data['category']->id);
		
		//grab the products using the pagination lib
		foreach ($data['products'] as &$p)
		{
			$p->images	= (array)json_decode($p->images);
			$p->options	= $this->Option_model->get_product_options($p->id);
		}
		
		$this->load->view('category', $data);
	}
	
	function category($id, $sort_by="created", $sort_order="desc", $page=0)
	{
		//get the category
		$data['category']			= $this->Category_model->get_category($id);
		if (!$data['category'])
		{
			show_404();
		}
		
		//Product Filter
		$product_filter = array();
		$price_filter = array();
		if($this->input->get('filterColor')){
			array_push($product_filter, array('name'=>'color', 'value'=>$this->input->get('filterColor')));
		}
		
		if($this->input->get('filterMovement')){
			array_push($product_filter, array('name'=>'movement', 'value'=>$this->input->get('filterMovement')));
		}
		
		if($this->input->get('filterType')){
			array_push($product_filter, array('name'=>'type', 'value'=>$this->input->get('filterType')));
		}
		
		if($this->input->get('filterBand')){
			array_push($product_filter, array('name'=>'band', 'value'=>$this->input->get('filterBand')));
		}
		
		if($this->input->get('filterFeatured')){
			array_push($product_filter, array('name'=>'featured', 'value'=>$this->input->get('filterFeatured')));
		}
		
		if($this->input->get('filterPrice')){
			array_push($price_filter, array('name'=>'price', 'value'=>$this->input->get('filterPrice')));
		}
		
		$data['subcategories']		= $this->Category_model->get_categories($data['category']->id);
		$data['product_columns']	= $this->config->item('product_columns');
		$data['gift_cards_enabled'] = $this->gift_cards_enabled;
		
		$data['meta']		= $data['category']->meta;
		$data['seo_title']	= $data['category']->seo_title;
		
		$data['page_title']	= $data['category']->name;
		//set up pagination
		$this->load->library('pagination');
		$config['base_url']		= base_url().$data['category']->slug.'/'.$sort_by.'/'.$sort_order.'/';
		$config['parameters']	= "";
		$counterPF = 0;
		$param = "";
		if(!empty($product_filter)){
			foreach($product_filter as $pf){
				if($counterPF == 0)
					$param .= "?";
				$param .= "filter".ucfirst($pf['name'])."=".$pf['value'];
			}
			$config['parameters'] = $param;
		}
		if(!empty($price_filter)){
			if($counterPF == 0)
				$config['parameters'] .= "?";
			$config['parameters'] .= "filterPrice=".$price_filter[0]['value'];
		}
		$data['current_url'] = $config['base_url'];
		if($data['category']->parent_id != 0){
			$config['uri_segment']	= 5;
		}else{
			$config['uri_segment']	= 4;
		}
		$config['per_page']		= 9;
		//$config['total_rows']	= $this->Product_model->count_category_products($data['category']->id);
		
		//grab the products using the pagination lib
		if($page && $page == "all" ){
			if($data['category']->parent_id != 0){
				$data['products']	= $this->Product_model->get_products($data['category']->id, false, false, $sort_by, $sort_order, $product_filter, $price_filter);
				$config['total_rows']	= $this->Product_model->count_products($data['category']->id);
			}else{
				$data['products']	= $this->Product_model->get_category_products($data['category']->id, false, false, $sort_by, $sort_order, $product_filter, $price_filter);
				$config['total_rows']	= $this->Product_model->count_category_products($data['category']->id);
			}
		}else{
			if($data['category']->parent_id != 0){
				$prods = $this->Product_model->get_products($data['category']->id, $config['per_page'], $page, $sort_by, $sort_order, $product_filter, $price_filter);
				$data['products']	= $prods['contents'];
				$filter_opt = array();
				$attributes = $this->Attribute_model->get_attributes_value();
				/*foreach($attributes as $j):
					$filter_opt[$j->name] = array();
				endforeach;*/
				foreach($attributes as $z):
					/*foreach($prods['data_filter'] as $k):
						if(strtoupper($k->name)==strtoupper($z->name)){
							$filter_opt[$z->name][]=$k->value;
						}
					endforeach;*/
					$filter_opt[$z->name][]=$z->value;
				endforeach;
				$data['data_filter'] = $filter_opt;
				$config['total_rows']	= $prods['num_rows'];
				$data['parent_category'] = $this->Category_model->get_category($data['category']->parent_id);
			}else{
				$prods = $this->Product_model->get_category_products($data['category']->id, $config['per_page'], $page, $sort_by, $sort_order, $product_filter, $price_filter);
				$data['products']	= $prods['contents'];
				$filter_opt = array();
				$attributes = $this->Attribute_model->get_attributes_value();
				/*foreach($attributes as $j):
					$filter_opt[$j->name] = array();
				endforeach;*/
				foreach($attributes as $z):
					/*foreach($prods['data_filter'] as $k):
						if(strtoupper($k->name)==strtoupper($z->name)){
							$filter_opt[$z->name][]=$k->value;
						}
					endforeach;*/
					$filter_opt[$z->name][]=$z->value;
				endforeach;
				$data['data_filter'] = $filter_opt;
				$config['total_rows']	= $prods['num_rows'];
			}
			
			
		}
		
		$this->pagination->initialize($config);
			
		foreach ($data['products'] as &$p)
		{
			$p->images	= (array)json_decode($p->images);
			$p->options	= $this->Option_model->get_product_options($p->id);
		}
		
		$this->load->view('category', $data);
	}
	
	function collection($sort_by="created", $sort_order="desc", $page=0)
	{
		
		//get the category
		
		$data['category']			= $this->Category_model->get_category(4);
				
		//if (!$data['category'])
		//{
		//	show_404();
		//}
		
		$data['subcategories']		= $this->Category_model->get_categories($data['category']->id);
		$data['product_columns']	= $this->config->item('product_columns');
		//$data['gift_cards_enabled'] = $this->gift_cards_enabled;
		
		//$data['meta']		= $data['category']->meta;
		//$data['seo_title']	= $data['category']->seo_title;
		
		$data['page_title']	= 'Collection';
		
		$this->load->view('collection', $data);
	}
	
	function product($id)
	{
		//get the product
		$data['product']	= $this->Product_model->get_product($id);
		$categories = $this->Category_model->get_categories_product($id);
		//print_r($categories);
		$data['cats'] = $categories;
		/*if($category->parent_id!=0)
			$data['parent'] = $this->Category_model->get_category_name($category->parent_id);
		else
			$data['parent'] = "";
		$data['child'] = $this->Category_model->get_category_name($category->category_id);
		$data['brand'] = $this->Brand_model->get_brand($data['product']->brand_id);
		*/
		
		
		if(!$data['product'] || $data['product']->enabled==0)
		{
			show_404();
		}

		// load the digital language stuff
		//$this->lang->load('digital_product');
		
		$data['options']	= $this->Option_model->get_product_options($data['product']->id);
		
		$related			= (array)json_decode($data['product']->related_products);
		$data['related']	= array();
		foreach($related as $r)
		{
			$r					= $this->Product_model->get_product($r);
			if($r)
			{
				$r->images			= (array)json_decode($r->images);
				$r->options			= $this->Option_model->get_product_options($r->id);
				$data['related'][]	= $r;
			}
			
		}
		$data['posted_options']		= $this->session->flashdata('option_values');
		$data['specs']			= json_decode($data['product']->specs);
		$data['page_title']			= $data['product']->name;
		$data['meta']				= $data['product']->meta;
		$data['seo_title']			= $data['product']->seo_title;
			
		if($data['product']->images == 'false')
		{
			$data['product']->images = array();
		}
		else
		{
			$data['product']->images	= array_values((array)json_decode($data['product']->images));
		}
		
		//$data['gift_cards_enabled'] = $this->gift_cards_enabled;
		//$this->Product_model->increment_product_view($id);	
		
		$this->load->view('product', $data);
		//$this->output->cache(60);
	}
	
	
	function add_to_cart()
	{
		// Get our inputs
		$product_id		= $this->input->post('id');
		$quantity 		= $this->input->post('quantity');
		$post_options 	= $this->input->post('option');
		$cartkey		= $this->input->post('cartkey');

		// Get a cart-ready product array
		$product = $this->Product_model->get_cart_ready_product($product_id, $quantity);
		
		//if out of stock purchase is disabled, check to make sure there is inventory to support the cart.
		if(!$this->config->item('allow_os_purchase') && (bool)$product['track_stock'])
		{
			$stock	= $this->Product_model->get_product($product_id);
			
			//loop through the products in the cart and make sure we don't have this in there already. If we do get those quantities as well
			$items		= $this->go_cart->contents();
			$qty_count	= $quantity;
			foreach($items as $item)
			{
				if(intval($item['id']) == intval($product_id))
				{
					$qty_count = $qty_count + $item['quantity'];
				}
			}
			
			
			if($stock->quantity < $qty_count)
			{
				//we don't have this much in stock
				$this->session->set_flashdata('error', sprintf(lang('not_enough_stock'), $stock->name, $stock->quantity));
				$this->session->set_flashdata('cartkey', $cartkey);
				$this->session->set_flashdata('quantity', $quantity);
				$this->session->set_flashdata('option_values', $post_options);

				redirect($this->Product_model->get_slug($product_id));
			}
			
		}
		
		// Validate Options 
		// this returns a status array, with product item array automatically modified and options added
		//  Warning: this method receives the product by reference
		$status = $this->Option_model->validate_product_options($product, $post_options);
		// don't add the product if we are missing required option values
		if( ! $status['validated'])
		{
			//if the cartkey does not exist, this will simply be blank
			$this->session->set_flashdata('cartkey', $cartkey);
			$this->session->set_flashdata('quantity', $quantity);
			$this->session->set_flashdata('error', $status['message']);
			$this->session->set_flashdata('option_values', $post_options);			
		
			redirect($this->Product_model->get_slug($product_id));
		
		}else{
			//loop through the products in the cart and make sure we don't have this in there already. If we do get those quantities as well
			$items		= $this->go_cart->contents();
			$qty_count	= $quantity;
			foreach($items as $item)
			{
				if(intval($item['id']) == intval($product_id))
				{
					$qty_count = $qty_count + $item['quantity'];
				}
			}
			$stock	= $this->Product_model->get_product($product_id);
			
			if(!empty($post_options)){
				
				$opt_value = $this->Option_model->get_value($post_options[key($post_options)]);

				if ($opt_value->qty < $qty_count)
				{
					//we don't have this much in stock
					$this->session->set_flashdata('error', sprintf(lang('not_enough_stock'), $stock->name, $opt_value->qty));
					
					$this->session->set_flashdata('cartkey', $cartkey);
					$this->session->set_flashdata('quantity', $quantity);
					
					$this->session->set_flashdata('option_values', $post_options);
					
					redirect($this->Product_model->get_slug($product_id));
				}
				
				$qty_count = $qty_count + $opt_value->qty;
			}else{
				if ($stock->quantity < $qty_count)
				{
					//we don't have this much in stock
					$this->session->set_flashdata('error', sprintf(lang('not_enough_stock'), $stock->name, $stock->quantity));
					$this->session->set_flashdata('cartkey', $cartkey);
					$this->session->set_flashdata('quantity', $quantity);
					$this->session->set_flashdata('option_values', $post_options);
		
					redirect($this->Product_model->get_slug($product_id));
				}
			}
				
			//Add the original option vars to the array so we can edit it later
			$product['post_options']	= $post_options;
			$product['cartkey']			= $cartkey;

			// Add the product item to the cart, also updates coupon discounts automatically
			$this->go_cart->insert($product);
			// go go gadget cart!
			//redirect('cart/view_cart');
			$base_url = base_url("/cart/view_cart");
			$this->session->set_flashdata('message_product', '"'.$stock->name.'" has been added to cart. View Cart <a href="'.$base_url.'">here<a/>');
			redirect($this->Product_model->get_slug($product_id));
		}
		
	}
	
	function view_cart()
	{
		
		$data['page_title']	= 'View Cart';
		//$data['gift_cards_enabled'] = $this->gift_cards_enabled;
		
		$this->load->view('view_cart', $data);
	}
	
	function confirmation_payment()
	{
		//to redirect back to this page after successfully login
		$this->session->set_flashdata('redirect', 'cart/confirmation_payment');
		//make sure they're logged in if the config file requires it
		if(!$this->Customer_model->is_logged_in(false, "/secure/login"))
		{
			//$this->session->set_flashdata('redirect', 'cart/confirmation_payment');
			redirect('https://www.scarletcollection.com/secure/login');
		}
		
		$customer = $this->go_cart->customer();
		
		$order = $this->Order_model->get_percustomer_orders_pending($customer['id']);
		
		$data['orders'] = $order;
		
		$data['page_title'] = "Confirmation Payment";
		
		$this->load->view('confirmation_payment', $data);	
	}
	
	function payment_process(){
		//to redirect back to this page after successfully login
		$this->session->set_flashdata('redirect', 'cart/confirmation_payment');
		//make sure they're logged in if the config file requires it
		if(!$this->Customer_model->is_logged_in())
		{
			$this->session->set_flashdata('redirect', 'cart/confirmation_payment');
			redirect('secure/login');
		}
		
		$this->load->library('form_validation');
		$this->load->model('Payment_transfer_model');
		
		$customer = $this->go_cart->customer();
		
		$this->form_validation->set_rules('order_number', 'Order Number', 'numeric|required');
		$this->form_validation->set_rules('bank', 'Bank', 'required');
		$this->form_validation->set_rules('paymentmethod', 'From', 'trim|required');
		$this->form_validation->set_rules('name', 'Account Name', 'trim|required');
		$this->form_validation->set_rules('number', 'Account Number', 'trim');
		$this->form_validation->set_rules('telephone', 'Telephone', 'numeric|required');
		$this->form_validation->set_rules('amount', 'Account Name', 'numeric|trim|required');
		$this->form_validation->set_rules('date', 'Payment Date', 'trim|required');
		
		if ($this->form_validation->run() == FALSE)
		{
			
			$data['error']				= validation_errors();
			$data['page_title']			= "Confirmation Payment";
			$order = $this->Order_model->get_customer_orders_pending($customer['id']);
			$data['orders'] = $order;
			$this->load->view('confirmation_payment', $data);
		}else{
		
			// Get our inputs
			$save['order_number']		= $this->input->post('order_number');
			$save['customer_id']		= $customer['id'];
			$save['transfer_to'] 		= $this->input->post('bank');
			$save['transfer_from'] 	= $this->input->post('paymentmethod');
			$save['account_holder']		= $this->input->post('name');
			$save['account_number']		= $this->input->post('number');
			$save['phone']		= $this->input->post('telephone');
			$save['amount_paid'] 		= $this->input->post('amount');
			
			$save['payment_date'] 	= date("Y-m-d", strtotime($this->input->post('date')));
			$save['status'] 	= "CONFIRMATION";
			$content = '<p>Order Number: '.$save['order_number'].'</p><p>Transfer to: '.$save['transfer_to'].'</p><p>Transfer From: '.$save['transfer_from'].'</p><p>Account Name: '.$save['account_holder'].'</p><p> Account Number: '.$save['account_number'].'</p><p>Amount Paid: '.$save['amount_paid'].'</p><p>Payment Date: '.$this->input->post('date').'</p>';
			
			//echo $save['order_number'];
				
			$this->Payment_transfer_model->save_payment_transfer($save);
			
			$this->load->library('email');
		
			$config['mailtype'] = 'html';
			$this->email->initialize($config);

			$this->email->from('webmaster@scarletcollection.com', $this->config->item('company_name'));
			$this->email->to('sales@scarletcollection.com');

			//email the admin
			//$this->email->bcc($this->config->item('email'));
			
			$this->email->subject('Confirmation Payment ('.$save['order_number'].')');
			
			$this->email->message($content);
			$this->email->send();	
			
			$this->session->set_flashdata('message', "Confirmation Payment Success");
			//go back to the product list
			redirect('cart/confirmation_payment');
		}	
	}
	
	function remove_item($key)
	{
		//drop quantity to 0
		$this->go_cart->update_cart(array($key=>0));
		
		redirect('cart/view_cart');
	}
	
	function update_cart($redirect = false)
	{
		//if redirect isn't provided in the URL check for it in a form field
		if(!$redirect)
		{
			$redirect = $this->input->post('redirect');
		}
		
		// see if we have an update for the cart
		$item_keys		= $this->input->post('cartkey');
		$coupon_code	= $this->input->post('coupon_code');
		$gc_code		= $this->input->post('gc_code');
			
			
		//get the items in the cart and test their quantities
		$items			= $this->go_cart->contents();
		$new_key_list	= array();
		//first find out if we're deleting any products
		foreach($item_keys as $key=>$quantity)
		{
			if(intval($quantity) === 0)
			{
				//this item is being removed we can remove it before processing quantities.
				//this will ensure that any items out of order will not throw errors based on the incorrect values of another item in the cart
				$this->go_cart->update_cart(array($key=>$quantity));
			}
			else
			{
				//create a new list of relevant items
				$new_key_list[$key]	= $quantity;
			}
		}
		$response	= array();
		foreach($new_key_list as $key=>$quantity)
		{
			$product	= $this->go_cart->item($key);
			//if out of stock purchase is disabled, check to make sure there is inventory to support the cart.
			if(!$this->config->item('allow_os_purchase') && (bool)$product['track_stock'])
			{
				$stock	= $this->Product_model->get_product($product['id']);
			
				//loop through the new quantities and tabluate any products with the same product id
				$qty_count	= $quantity;
				foreach($new_key_list as $item_key=>$item_quantity)
				{
					if($key != $item_key)
					{
						$item	= $this->go_cart->item($item_key);
						//look for other instances of the same product (this can occur if they have different options) and tabulate the total quantity
						if($item['id'] == $stock->id)
						{
							$qty_count = $qty_count + $item_quantity;
						}
					}
				}
				if($stock->quantity < $qty_count)
				{
					if(isset($response['error']))
					{
						$response['error'] .= '<p>'.sprintf(lang('not_enough_stock'), $stock->name, $stock->quantity).'</p>';
					}
					else
					{
						$response['error'] = '<p>'.sprintf(lang('not_enough_stock'), $stock->name, $stock->quantity).'</p>';
					}
				}
				else
				{
					//this one works, we can update it!
					//don't update the coupons yet
					$this->go_cart->update_cart(array($key=>$quantity));
				}
			}
		}
		
		//if we don't have a quantity error, run the update
		if(!isset($response['error']))
		{
			//update the coupons and gift card code
			$response = $this->go_cart->update_cart(false, $coupon_code, $gc_code);
			// set any messages that need to be displayed
		}
		else
		{
			$response['error'] = '<p>'.lang('error_updating_cart').'</p>'.$response['error'];
		}
		
		
		//check for errors again, there could have been a new error from the update cart function
		if(isset($response['error']))
		{
			$this->session->set_flashdata('error', $response['error']);
		}
		if(isset($response['message']))
		{
			$this->session->set_flashdata('message', $response['message']);
		}
		
		if($redirect)
		{
			redirect($redirect);
		}
		else
		{
			redirect('cart/view_cart');
		}
	}

	
	/***********************************************************
			Gift Cards
			 - this function handles adding gift cards to the cart
	***********************************************************/
	
	function giftcard()
	{
		if(!$this->gift_cards_enabled) redirect('/');
		
		$this->load->helper('utility_helper');
		
		// Load giftcard settings
		$gc_settings = $this->Settings_model->get_settings("gift_cards");
				
		$this->load->library('form_validation');
		
		$data['allow_custom_amount']	= (bool) $gc_settings['allow_custom_amount'];
		$data['preset_values']			= explode(",",$gc_settings['predefined_card_amounts']);
		
		if($data['allow_custom_amount'])
		{
			$this->form_validation->set_rules('custom_amount', 'lang:custom_amount', 'numeric');
		}
		
		$this->form_validation->set_rules('amount', 'lang:amount', 'required');
		$this->form_validation->set_rules('preset_amount', 'lang:preset_amount', 'numeric');
		$this->form_validation->set_rules('gc_to_name', 'lang:recipient_name', 'trim|required');
		$this->form_validation->set_rules('gc_to_email', 'lang:recipient_email', 'trim|required|valid_email');
		$this->form_validation->set_rules('gc_from', 'lang:sender_email', 'trim|required');
		$this->form_validation->set_rules('message', 'lang:custom_greeting', 'trim|required');
		
		if ($this->form_validation->run() == FALSE)
		{
			$data['error']				= validation_errors();
			$data['page_title']			= lang('giftcard');
			$data['gift_cards_enabled']	= $this->gift_cards_enabled;
			$this->load->view('giftcards', $data);
		}
		else
		{
			
			// add to cart
			
			$card['price'] = set_value(set_value('amount'));
			
			$card['id']				= -1; // just a placeholder
			$card['sku']			= lang('giftcard');
			$card['base_price']		= $card['price']; // price gets modified by options, show the baseline still...
			$card['name']			= lang('giftcard');
			$card['code']			= generate_code(); // from the utility helper
			$card['excerpt']		= sprintf(lang('giftcard_excerpt'), set_value('gc_to_name'));
			$card['weight']			= 0;
			$card['quantity']		= 1;
			$card['shippable']		= false;
			$card['taxable']		= 0;
			$card['fixed_quantity'] = true;
			$card['is_gc']			= true; // !Important
			
			$card['gc_info'] = array("to_name"	=> set_value('gc_to_name'),
									 "to_email"	=> set_value('gc_to_email'),
									 "from"		=> set_value('gc_from'),
									 "personal_message"	=> set_value('message')
									 );
			
			// add the card data like a product
			$this->go_cart->insert($card);
			
			redirect('cart/view_cart');
		}
	}
	
	
	function contactus()
	{
		//to redirect back to this page after successfully login
		$this->session->set_flashdata('redirect', 'cart/contactus');
		
		$send = $this->input->post('send');
		if(!empty($send))
		{
			// send the message
			$this->load->library('email');
			
			$config['mailtype'] = 'html';
			
			$this->email->initialize($config);
	
			$this->email->from('webmaster@scarletcollection.com', $this->config->item('company_name'));
			$this->email->to('service@scarletcollection.com');
			
			$subject = $this->input->post('subject').' ('.$this->input->post('name').')';
			$this->email->subject($subject);
			
			$content = "";
			$content .= "<p>Name: ".$this->input->post('name')."</p>";
			$content .= "<p>Phone: ".$this->input->post('phoneno')."</p>";
			$content .= "<p>E-mail: ".$this->input->post('email')."</p>";
			$content .= "<p></p>";
			$content .= "<p>Content: <br/> ".$this->input->post('content')."</p>";
			
			$this->email->message(html_entity_decode($content));
			
			$this->email->send();
			$this->session->set_flashdata('message', 'Message has been sent');
			redirect('cart/contactus');
		}
		
		$data['page_title'] = "Contact Us";
		
		$this->load->view('contact_us', $data);	
	}

        function get_cities_menu()
	{
		$id	= $this->input->post('provinceId');
		$zones	= $this->Place_model->get_cities_menu($id);
		
		foreach($zones as $id=>$z):?>
		
		<option value="<?php echo $id;?>"><?php echo $z;?></option>
		
		<?php endforeach;
	}
	
	function newsletter(){
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('newsletter', 'Email', 'trim|required|valid_email');
		
		if ($this->form_validation->run() == FALSE)
		{
			echo 'Email validation wrong';
		}else{
			$this->Customer_model->insert_newsletter($this->input->post('newsletter'));
			echo 'Your email has been submitted';
		}
	}
	
	function set_currency(){
		session_start();
		if(isset($_POST['currency']))
			$_SESSION['currency'] = $_POST['currency'];
			
		echo $_SESSION['currency'];
	}
	
}