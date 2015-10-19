<?php

class Store extends CI_Controller {
	
	//we collect the categories automatically with each load rather than for each function
	//this just cuts the codebase down a bit
	var $categories	= '';
	
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

	function index()
	{
		$this->load->helper('directory');
		$data['brands']	= $this->Brand_model->get_brands();
		
		$this->load->view('homestore', $data);
	}
	
	function prod($id, $sort_by="created", $sort_order="desc", $page=0)
	{
		$this->load->helper('directory');
		
		$data['store'] = $this->Brand_model->get_brand($id);
		$data['products'] = $this->Brand_model->get_brand_products($id, false, false, 'created', 'desc');
		
		$this->load->view('store', $data);
	}
}
?>