<?php

class Newsletter extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		
		//make sure we're not always behind ssl
		//remove_ssl();
		
		$this->load->library('Go_cart');
		$this->load->model(array('Settings_model','Newsletter_model'));
	
	}

	function index()
	{
		
	}
	
	function insert_newsletter(){
		$send = $this->input->post('send');
		if(!empty($send))
		{
			$subscribers = $this->Newsletter_model->get_list_subscribers();
			print_r($subscribers);
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
		}
	}
	
	function send_newsletter(){
		$send_newsletters = $this->Newsletter_model->get_send_newsletter();
		$now = date('Y-m-d H:i:s');
		
		$this->load->library('email');
		
		$config['mailtype'] = 'html';
		
		if($send_newsletters!=NULL){
			foreach($send_newsletters as $send){
				$this->email->clear();
				$this->email->initialize($config);
				
				$this->email->from('sales@scarletcollection.com', $this->config->item('company_name'));
				$this->email->to($send->recipient);
	
				//email the admin
				//$this->email->bcc($this->config->item('email'));
				
				$this->email->subject($send->subject);
				
				$this->email->message(html_entity_decode($send->html));
				if($this->email->send())
				{
					// update the newsletter table with the new startNum    
					$updateStartNum = $this->Newsletter_model->update_send_newsletter($send->id, $now);
				}else{
					$updateStartNum = $this->Newsletter_model->update_fail_send_newsletter($send->id, $send->fail+1);	
				}
			
			}
			sleep(5);
			redirect("newsletter/send_newsletter");
		}
	}
}