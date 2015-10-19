<?php

class Places extends CI_Controller {	
	
	function __construct()
	{		
		parent::__construct();
		//remove_ssl();
		$this->load->model('Place_model');
		//$this->lang->load('location');
	}
	
	function index()
	{
		$data['page_title']	= 'Places';
		$data['places']	= $this->Place_model->get_provinces();
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
	
	function jne_cities($province_id)
	{
		$data['page_title']	= 'JNE';
		$this->load->helper('form');
		$this->load->library('form_validation');
		$data['id']=$province_id;
		$data['jneAreas'] = $this->Place_model->get_shipping_cost($province_id);
		
		$this->load->view($this->config->item('admin_folder').'/jne_cities', $data);
	}
	
	function get_jne_one_cities_menu()
	{		
		if(isset($_REQUEST['country'])){
			$zones	= $this->Place_model->get_jne_one_menu($this->input->post('country'));
		}else{
			$zones	= $this->Place_model->get_jne_one_menu("Indonesia");
		}
		
		foreach($zones as $id=>$z):?>
		
		<option value="<?php echo $id;?>"><?php echo $z;?></option>
		
		<?php endforeach;
		
		
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
			$location	= $this->Place_model->get_city($id);
			//if the promo does not exist, redirect them to the customer list with an error
			if (!$location)
			{
				$this->session->set_flashdata('error', 'City not found');
				redirect($this->config->item('admin_folder').'/places/jne_cities/'.$id);
			}
			else
			{
				$this->Place_model->delete_city($id);
				
				$this->session->set_flashdata('message', 'City Deleted');
				redirect($this->config->item('admin_folder').'/places/jne_cities');
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