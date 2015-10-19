<?php

class Attributes extends Admin_Controller {	
	
	function __construct()
	{		
		parent::__construct();
		remove_ssl();
		
		$this->auth->check_access('Admin', true);
		$this->load->model('Attribute_model');
		$this->lang->load('location');
	}
	
	function index()
	{
		$data['page_title']	= 'Attributes';
		$data['attributes']	= $this->Attribute_model->get_attributes();
		
		$this->load->view($this->config->item('admin_folder').'/attributes', $data);
	}
	
	function attribute_form($id = false)
	{
		$this->load->helper('form');
		$this->load->library('form_validation');
		
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
	
		
		$data['page_title']		= "Attribute Details";
		
		//default values are empty if the product is new
		$data['attribute_id']		= '';
		$data['description']		= '';

		if ($id)
		{	
			$attribute		= (array)$this->Attribute_model->get_attribute($id);
			
			//if the attribute does not exist, redirect them to the country list with an error
			if (!$attribute)
			{
				$this->session->set_flashdata('error', 'Attribute not found');
				redirect($this->config->item('admin_folder').'/attributes');
			}
			
			$data	= array_merge($data, $attribute);
		}
		
		$this->form_validation->set_rules('description', 'lang:description', 'trim|required');
	
		if ($this->form_validation->run() == FALSE)
		{
			$this->load->view($this->config->item('admin_folder').'/attribute_form', $data);
		}
		else
		{
			$save['attribute_id']				= $id;
			$save['description']				= $this->input->post('description');

			$promo_id = $this->Attribute_model->save_attribute($save);
			
			$this->session->set_flashdata('message', 'Attribute saved');
			
			//go back to the product list
			redirect($this->config->item('admin_folder').'/attributes');
		}
	}

	
	function delete_attribute($id = false)
	{
		if ($id)
		{	
			$attribute	= $this->Attribute_model->get_attribute($id);
			//if the promo does not exist, redirect them to the customer list with an error
			if (!$attribute)
			{
				$this->session->set_flashdata('error', 'Attribute not found');
				redirect($this->config->item('admin_folder').'/attributes');
			}
			else
			{
				$this->Attribute_model->delete_attribute($id);
				
				$this->session->set_flashdata('message', 'Attribute has been deleted');
				redirect($this->config->item('admin_folder').'/attributes');
			}
		}
		else
		{
			//if they do not provide an id send them to the promo list page with an error
			$this->session->set_flashdata('error', 'Attribute not found');
			redirect($this->config->item('admin_folder').'/attributes');
		}
	}
	
	function view($attribute_id)
	{
		$data['attribute']	= $this->Attribute_model->get_attribute($attribute_id);
		$data['id'] = $attribute_id;
		if(!$data['attribute'])
		{
			$this->session->set_flashdata('error', 'Attribute not found');
			redirect($this->config->item('admin_folder').'/attributes');
		}
		$data['attribute_details']	= $this->Attribute_model->get_attributes_values($attribute_id);
		
		$data['page_title']	= sprintf('Attribute Details', $data['attribute']->name);

		$this->load->view($this->config->item('admin_folder').'/attribute_details', $data);
	}
	
	function attribute_detail_form($id = false)
	{
		$attribute_id = $this->input->get_post('attribute_id');
		
		$this->load->helper('form');
		$this->load->library('form_validation');
		
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
	
		
		$data['page_title']		= "Attribute Detail";
		
		//default values are empty if the product is new
		$data['attr_det_id']		= '';
		$data['description']		= '';

		if ($id)
		{	
			$attribute		= (array)$this->Attribute_model->get_attribute_detail($id);
			
			//if the attribute does not exist, redirect them to the country list with an error
			if (!$attribute)
			{
				$this->session->set_flashdata('error', 'Attribute not found');
				redirect($this->config->item('admin_folder').'/attributes/view/'.$attribute_id);
			}
			
			$data	= array_merge($data, $attribute);
		}
		
		$this->form_validation->set_rules('description', 'lang:description', 'trim|required');
	
		if ($this->form_validation->run() == FALSE)
		{
			if (!$attribute_id)
			{	
				$this->session->set_flashdata('error', 'Attribute not found');
				redirect($this->config->item('admin_folder').'/attributes');
			}
			$data['attribute_id'] = $attribute_id;
			$this->load->view($this->config->item('admin_folder').'/attribute_detail_form', $data);
		}
		else
		{
			if (!$attribute_id)
			{	
				$this->session->set_flashdata('error', 'Attribute not found');
				redirect($this->config->item('admin_folder').'/attributes');
			}
			
			$save['id']				= $id;
			$save['attr_id']				= $attribute_id;
			$save['value']				= $this->input->post('description');

			$promo_id = $this->Attribute_model->save_attribute_value_new($save);
			
			$this->session->set_flashdata('message', 'Attribute Detail saved');
			
			//go back to the product list
			redirect($this->config->item('admin_folder').'/attributes/view/'.$attribute_id);
		}
	}
}