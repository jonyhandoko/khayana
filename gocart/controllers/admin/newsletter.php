<?php

class Newsletter extends Admin_Controller {	

	function __construct()
	{		
		parent::__construct();

		remove_ssl();
		$this->load->model('Newsletter_model');
		$this->load->helper(array('formatting', 'utility'));
	}
	
	function index()
	{
		$this->load->helper('form');
		$this->load->library('form_validation');
		$data2['page_title'] = "Newsletter";
		$send = $this->input->post('send');
		if(!empty($send))
		{
			$this->form_validation->set_rules('subject', 'lang:subject', 'trim|required|max_length[100]');
			$this->form_validation->set_rules('html', 'lang:message_content', 'trim|required');
			
			if ($this->form_validation->run() == FALSE)
			{
				$data2['errors'] = validation_errors();
			}
			else{
		
				$subscribers = $this->Newsletter_model->get_list_subscribers();
				
				$now = date('Y-m-d H:i:s');
				$data['created'] = $now;
				$data['subject'] = $this->input->post('subject');
				$data['html'] =$this->input->post('html');
				
				foreach($subscribers as $subscriber){
					$data['recipient'] = $subscriber->email;
					$this->Newsletter_model->get_insert_newsletter($data);	
				}
				$this->load->library('email');
				
				$config['mailtype'] = 'html';
				$this->email->initialize($config);
					
				$this->email->from('webmaster@scarletcollection.com', $this->config->item('company_name'));
				$this->email->to("jonyhandoko@hotmail.com");
		
				//email the admin
				//$this->email->bcc($this->config->item('email'));
				
				$this->email->subject("ScarletCollection Send NewsLetter");
				
				$this->email->message("ScarletCollection Send NewsLetter");
				$this->email->send();
				
				$this->session->set_flashdata('message', 'Newsletter has been saved');
				
				redirect($this->config->item('admin_folder').'/newsletter');
			}
		}
				
		$this->load->view($this->config->item('admin_folder').'/newsletter', $data2);
	}	
}