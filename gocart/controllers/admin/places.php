<?php

class Places extends Admin_Controller {	
	
	function __construct()
	{		
		parent::__construct();
		remove_ssl();
		
		$this->auth->check_access('Admin', true);
		$this->load->model('Place_model');
		//$this->lang->load('location');
	}
	
	/*function index()
	{
		$data['page_title']	= 'Places';
		$data['places']	= $this->Place_model->get_provinces();
		
		$this->load->view($this->config->item('admin_folder').'/jne', $data);
	}*/
	
	function index()
	{
		$data['page_title']	= 'Places';
		$data['places']	= $this->Place_model->get_jne_one();
		
		$this->load->view($this->config->item('admin_folder').'/jne_one', $data);
	}
	
	function jne_one_form($id = false)
	{
		$this->load->helper('form');
		$this->load->library('form_validation');
		
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		$data['page_title']		= "JNE From";
		
		$data['id']					= '';
		$data['place']				= '';
		$data['reg']				= '';
		$data['yes']				= '';
		
		if($id){
			$jneOne		= (array)$this->Place_model->get_jne_one_single($id);
			//print_r($jneOne);
			//if the country does not exist, redirect them to the country list with an error
			if (!$jneOne)
			{
				$this->session->set_flashdata('error', 'error_jne_not_found');
				redirect($this->config->item('admin_folder').'/places');
			}
			
			$data	= array_merge($data, $jneOne);
		}
		
		$this->form_validation->set_rules('place', 'Place', 'trim|required');
		
		if ($this->form_validation->run() == FALSE)
		{
			$this->load->view($this->config->item('admin_folder').'/jne_one_form', $data);
		}else
		{
			$save['id']					= $id;
			$save['place']				= $this->input->post('place');
			$save['reg']				= $this->input->post('reg');
			$save['yes']				= $this->input->post('yes');
			
			$promo_id = $this->Place_model->save_jne_one($save);
			
			$this->session->set_flashdata('message', 'message_save_jne');
			
			//go back to the product list
			redirect($this->config->item('admin_folder').'/places');
		}
	}
	
	function jne_province_form($id = false)
	{
		$this->load->helper('form');
		$this->load->library('form_validation');
		
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		$data['page_title']		= "Province From";
		
		$data['id']					= '';
		$data['name']				= '';
		
		if($id){
			$province		= (array)$this->Place_model->get_province($id);
			//if the country does not exist, redirect them to the country list with an error
			if (!$province)
			{
				$this->session->set_flashdata('error', 'error_province_not_found');
				redirect($this->config->item('admin_folder').'/places');
			}
			
			$data	= array_merge($data, $province);
		}
		
		$this->form_validation->set_rules('name', 'lang:name', 'trim|required');
		
		if ($this->form_validation->run() == FALSE)
		{
			$this->load->view($this->config->item('admin_folder').'/jne_province_form', $data);
		}else
		{
			$save['id']					= $id;
			$save['name']				= $this->input->post('name');
		
			$promo_id = $this->Place_model->save_province($save);
			
			$this->session->set_flashdata('message', 'message_save_province');
			
			//go back to the product list
			redirect($this->config->item('admin_folder').'/places');
		}
	}
	
	function jne_city_form($id = false)
	{
		$this->load->helper('form');
		$this->load->library('form_validation');
		
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		$data['page_title']		= "City From";
		
		$data['id']					= '';
		$data['name']				= '';
		$data['reg']				= '';
		$data['ok']				= '';
		
		if($id){
			$province		= (array)$this->Place_model->get_province($id);
			//if the country does not exist, redirect them to the country list with an error
			if (!$province)
			{
				$this->session->set_flashdata('error', 'error_province_not_found');
				redirect($this->config->item('admin_folder').'/places');
			}
			
			$data	= array_merge($data, $province);
		}
		
		$this->form_validation->set_rules('name', 'lang:name', 'trim|required');
		$this->form_validation->set_rules('reg', 'lang:REG Price', 'trim|required');
		$this->form_validation->set_rules('yes', 'lang:OK Price', 'trim|required');
		
		if ($this->form_validation->run() == FALSE)
		{
			$this->load->view($this->config->item('admin_folder').'/jne_city_form', $data);
		}else
		{
			$save_city['province_id']					= $id;
			$save_city['name']				= $this->input->post('name');
		
			$city_id = $this->Place_model->save_city($save_city);
			
			$save['province_id']					= $id;
			$save['city_id']					= $city_id;
			
			$save['reg']				= $this->input->post('reg');
			$save['yes']				= $this->input->post('yes');
			
			
			$city_id = $this->Place_model->save_jne_shipping($save);
			
			$this->session->set_flashdata('message', 'message_save_city');
			
			//go back to the product list
			redirect($this->config->item('admin_folder').'/places/jne_cities/'.$id);
		}
	}
	
	function jne_cities($province_id)
	{
		$data['page_title']	= 'JNE';
		$this->load->helper('form');
		$this->load->library('form_validation');
		$data['id']=$province_id;
		$data['jneAreas'] = $this->Place_model->get_shipping_cost($province_id);
		
		$this->load->view($this->config->item('admin_folder').'/jne_cities', $data);
	}
	
	function get_cities_menu()
	{
		$id	= $this->input->post('provinceId');
		$zones	= $this->Place_model->get_cities_menu($id);
		
		foreach($zones as $id=>$z):?>
		
		<option value="<?php echo $id;?>"><?php echo $z;?></option>
		
		<?php endforeach;
	}
	
	function save_city($id)
	{
		$cities = $this->input->post('fieldname');
		$count = 0;
		foreach($cities as $city=>$value){
			$jne_shipping = $this->Place_model->get_jne_shipping($city);
			$save_city['id'] = $jne_shipping->city_id;
			$save_city['name'] = $value['name'];
			$this->Place_model->save_city($save_city);
			
			$save_jne['id'] = $city;
			$save_jne['reg'] = $value['reg'];
			$save_jne['yes'] = $value['yes'];
			$this->Place_model->save_jne_shipping($save_jne);
		}
		redirect($this->config->item('admin_folder').'/places/jne_cities/'.$id);
		//return false;
	}
	
	function delete_province($id=false)
	{
		if ($id)
		{	
			$location	= $this->Place_model->get_province($id);
			//if the promo does not exist, redirect them to the customer list with an error
			if (!$location)
			{
				$this->session->set_flashdata('error', 'Province not found');
				redirect($this->config->item('admin_folder').'/places/'.$id);
			}
			else
			{
				$location	= $this->Place_model->get_province($id);
				$this->Place_model->delete_province($id);
				
				$this->session->set_flashdata('message', 'Province '.$location->name.' Deleted');
				redirect($this->config->item('admin_folder').'/places');
			}
		}
		else
		{
			//if they do not provide an id send them to the promo list page with an error
			$this->session->set_flashdata('error', 'City not found');
			redirect($this->config->item('admin_folder').'/places/jne_cities');
		}
	}
	
	function delete_city($id=false)
	{
		if ($id)
		{	
			$location	= $this->Place_model->get_jne_shipping($id);

			if (!$location)
			{
				$this->session->set_flashdata('error', 'City not found');
				redirect($this->config->item('admin_folder').'/places');
			}
			else
			{
				$this->Place_model->delete_city($location->city_id);
				$this->Place_model->delete_jne_shipping($id);
				$this->session->set_flashdata('message', 'City Deleted');
				redirect($this->config->item('admin_folder').'/places/jne_cities/'.$location->province_id);
			}
		}
		else
		{
			//if they do not provide an id send them to the promo list page with an error
			$this->session->set_flashdata('error', 'City not found');
			redirect($this->config->item('admin_folder').'/places/jne_cities');
		}
	}
}