<?php

class Brands extends Admin_Controller {	
	
	function __construct()
	{		
		parent::__construct();
		remove_ssl();
		
		$this->auth->check_access('Admin', true);
		$this->load->model('Brand_model');
		$this->lang->load('location');
	}
	
	function index()
	{
		$data['page_title']	= 'Brands';
		$data['brands']	= $this->Brand_model->get_brands();
		
		$this->load->view($this->config->item('admin_folder').'/brands', $data);
	}
	
	function organize_brand_details()
	{
		$brands	= $this->input->post('brand');
		echo $brands;
		$this->Brand_model->organize_brand_details($brands);
	}
	
	function brand_form($id = false)
	{
		$this->load->helper('form');
		$this->load->library('form_validation');
		
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
	
		
		$data['page_title']		= "Brand Details";
		
		//default values are empty if the product is new
		$data['brand_id']		= '';
		$data['brand_name']		= '';
		$data['banner_image']	= '';
		$data['box_image']		= '';
		$data['description']	= '';
		$data['slug']			= '';
		
		if ($id)
		{	
			$brand		= (array)$this->Brand_model->get_brand($id);
			
			//if the brand does not exist, redirect them to the country list with an error
			if (!$brand)
			{
				$this->session->set_flashdata('error', 'Brand not found');
				redirect($this->config->item('admin_folder').'/brands');
			}
			
			$data	= array_merge($data, $brand);
		}
		$this->form_validation->set_rules('brand_name', 'lang:description', 'trim|required');
	
		if ($this->form_validation->run() == FALSE)
		{
			$this->load->view($this->config->item('admin_folder').'/brand_form', $data);
		}
		else
		{
			$save['brand_id']				= $id;
			$save['brand_name']				= $this->input->post('brand_name');
			$save['description']			= $this->input->post('description');
			
			
			// Upload banner image
			$config['upload_path']		= 'uploads/store';
			$config['allowed_types']	= 'gif|jpg|png';
			$config['max_size']			= $this->config->item('size_limit');
			$config['max_width']		= '';
			$config['max_height']		= '';
			$config['encrypt_name']		= true;
			$this->load->library('upload', $config);
			
			$uploadedBox	= $this->upload->do_upload('box_image');
			if($uploadedBox)
			{
				if($data['box_image'] != '')
				{
					$file = $data['box_image'];
					
					//delete the existing file if needed
					if(file_exists($file))
					{
						unlink($file);
					}
				}
				
				$imageBox			= $this->upload->data();
				$save['box_image']	= $config['upload_path'].'/'.$imageBox['file_name'];
			}
			
			
			$uploaded	= $this->upload->do_upload('brand_image');
			if($uploaded)
			{
				if($data['banner_image'] != '')
				{
					$file = $data['banner_image'];
					
					//delete the existing file if needed
					if(file_exists($file))
					{
						unlink($file);
					}
				}
				
				$image			= $this->upload->data();
				$save['banner_image']	= $config['upload_path'].'/'.$image['file_name'];
			}/*else{
				$data['error']	= $this->upload->display_errors();
				echo $data['error'];
				//$this->load->view($this->config->item('admin_folder').'/brand_form/', $data);
				return; //end script here if there is an error
			}*/
			
			if($this->upload->display_errors() != '')
			{
				$data['error'] = $this->upload->display_errors();
			}
			
			$this->load->helper('text');
			
			//first check the slug field
			$slug = $this->input->post('slug');
			
			//if it's empty assign the name field
			if(empty($slug) || $slug=='')
			{
				$slug = $this->input->post('brand_name');
			}
			
			$slug	= url_title(convert_accented_characters($slug), 'dash', TRUE);
			
			
			//validate the slug
			$this->load->model('Routes_model');

			if($id)
			{
				$slug		= $this->Routes_model->validate_slug($slug, $data['route_id']);
				$route_id	= $data['route_id'];
				
				$route['id']	= $route_id;
				$route['slug']	= $slug;			
				$route_id	= $this->Routes_model->save($route);
				
				$save['route_id']				= $route_id;
				$save['slug']					= $slug;
				//$route['route']	= 'store/'.$id;
				
				$promo_id = $this->Brand_model->save_Brand($save);
			}
			else
			{
				$slug	= $this->Routes_model->validate_slug($slug);
				
				$promo_id = $this->Brand_model->save_Brand($save);
				
				$route['slug']	= $slug;					
				$route['route']	= 'store/prod/'.$promo_id;
				$route_id	= $this->Routes_model->save($route);
				
				$new_save['brand_id']				= $promo_id;
				$new_save['route_id']				= $route_id;
				$new_save['slug']					= $slug;
				$promo_id = $this->Brand_model->save_Brand($new_save);
			}
			
			
			$this->session->set_flashdata('message', 'Brand saved');
			
			//go back to the product list
			redirect($this->config->item('admin_folder').'/brands');
		}
	}

	
	function delete_brand($id = false)
	{
		if ($id)
		{	
			$brand	= $this->Brand_model->get_brand($id);
			//if the promo does not exist, redirect them to the customer list with an error
			if (!$brand)
			{
				$this->session->set_flashdata('error', 'Brand not found');
				redirect($this->config->item('admin_folder').'/brands');
			}
			else
			{
				$this->Brand_model->delete_brand($id);
				
				$this->session->set_flashdata('message', 'Brand has been deleted');
				redirect($this->config->item('admin_folder').'/brands');
			}
		}
		else
		{
			//if they do not provide an id send them to the promo list page with an error
			$this->session->set_flashdata('error', 'Brand not found');
			redirect($this->config->item('admin_folder').'/brands');
		}
	}
	
	function view($brand_id)
	{
		$data['brand']	= $this->Brand_model->get_brand($brand_id);
		$data['id'] = $brand_id;
		if(!$data['brand'])
		{
			$this->session->set_flashdata('error', 'Brand not found');
			redirect($this->config->item('admin_folder').'/brands');
		}
		$data['brand_details']	= $this->Brand_model->get_brand_details($brand_id);
		
		$data['page_title']	= sprintf('Brand Details', $data['brand']->description);

		$this->load->view($this->config->item('admin_folder').'/brand_details', $data);
	}
	
	function brand_detail_form($id = false)
	{
		$brand_id = $this->input->get_post('brand_id');
		
		$this->load->helper('form');
		$this->load->library('form_validation');
		
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
	
		
		$data['page_title']		= "Brand Detail";
		
		//default values are empty if the product is new
		$data['attr_det_id']		= '';
		$data['description']		= '';

		if ($id)
		{	
			$brand		= (array)$this->Brand_model->get_brand_detail($id);
			
			//if the brand does not exist, redirect them to the country list with an error
			if (!$brand)
			{
				$this->session->set_flashdata('error', 'Brand not found');
				redirect($this->config->item('admin_folder').'/brands/view/'.$brand_id);
			}
			
			$data	= array_merge($data, $brand);
		}
		
		$this->form_validation->set_rules('description', 'lang:description', 'trim|required');
	
		if ($this->form_validation->run() == FALSE)
		{
			if (!$brand_id)
			{	
				$this->session->set_flashdata('error', 'Brand not found');
				redirect($this->config->item('admin_folder').'/brands');
			}
			$data['brand_id'] = $brand_id;
			$this->load->view($this->config->item('admin_folder').'/brand_detail_form', $data);
		}
		else
		{
			if (!$brand_id)
			{	
				$this->session->set_flashdata('error', 'Brand not found');
				redirect($this->config->item('admin_folder').'/brands');
			}
			
			$save['attr_det_id']				= $id;
			$save['brand_id']				= $brand_id;
			$save['description']				= $this->input->post('description');

			$promo_id = $this->Brand_model->save_brand_detail($save);
			
			$this->session->set_flashdata('message', 'Brand Detail saved');
			
			//go back to the product list
			redirect($this->config->item('admin_folder').'/brands/view/'.$brand_id);
		}
	}
}