<?php

class Blog extends CI_Controller {
	
	//we collect the categories automatically with each load rather than for each function
	//this just cuts the codebase down a bit
	var $blogs	= '';
	
	//load all the pages into this variable so we can call it from all the methods
	var $pages = '';
	
	var $header_text;
	
	var $customer;

	function __construct()
	{
		parent::__construct();
		
		//make sure we're not always behind ssl
		//remove_ssl();
		
		$this->load->library('Go_cart');
		$this->load->model(array('Page_model', 'Place_model', 'Product_model', 'Brand_model', 'Option_model', 'Order_model', 'Settings_model'));
		$this->load->helper(array('form_helper', 'formatting_helper'));
		$this->customer = $this->go_cart->customer();
		
		//load the theme package
		$this->load->add_package_path(APPPATH.'themes/'.$this->config->item('theme').'/');
		
	}

	function index($url="")
	{
		if($url==""):
			$data['blog_page'] = 'home';
			$json = file_get_contents('http://wp.watchinc.co.id/?wpjson&gl');
			$obj = json_decode($json);
			$data['json'] = $obj;
		else:
			$data['blog_page'] = 'detail';
			$str = strstr($url, "--");
			$id = substr($str, 2);
			
			$json = file_get_contents('http://wp.watchinc.co.id/?wpjson&dt&pid='.$id);
			$obj = json_decode($json);
			$data['detail'] = $obj;
		endif;
		
		$this->load->view('blog', $data);
	}
}
?>