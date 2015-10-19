<?php

class Payment_transfer extends Admin_Controller {	

	function __construct()
	{		
		parent::__construct();

		remove_ssl();
		$this->load->model('Order_model');
		$this->load->model('Search_model');
		$this->load->model('Place_model');
		$this->load->model('Payment_transfer_model');
		$this->load->helper(array('formatting', 'utility'));
	}
	
	function index($status='CONFIRMATION', $sortorder='desc', $code=0, $page=0, $rows=15)
	{
		$sort_by ='';
		$this->load->helper('form');
		$this->load->helper('date');
		$this->load->model('Customer_model');
		$data['code']		= $code;
		$data['message']	= $this->session->flashdata('message');
		$data['page_title']	= 'Payment Transfer';
		//$data['code']		= $code;
		$term				= false;
		
		if($status=="ALL")
			$status = false;
		$data['status'] = $status;
		
 		$data['term']	= $term;
		$data['sort_by']	= $sort_by;
		$data['sortorder']	= $sortorder;
 		$data['payment_transfers']	= $this->Payment_transfer_model->get_payment_transfers($status, $sortorder);
		$data['total']	= $this->Payment_transfer_model->get_payment_transfers_count();
				
		$this->load->view($this->config->item('admin_folder').'/payment_transfer', $data);
	}
	
	function delete($payment_id=false){
		if($payment_id){
			$this->Payment_transfer_model->delete_payment_transfer($payment_id);
			$this->session->set_flashdata('message', 'Payment has deleted');
		}else{
			$this->session->set_flashdata('error', 'No Payment selected to be deleted');
		}
		//redirect as to change the url
		redirect($this->config->item('admin_folder').'/payment_transfer');	
	}
	
	function paid($payment_id=false){
		$this->load->helper('date');
		$this->load->model('Customer_model');
		
		if($payment_id){
		        $data = $this->Payment_transfer_model->get_payment_transfer($payment_id);	
			
			$customer = $this->Customer_model->get_customer($data->customer_id);
			$order = $this->Order_model->get_order_total_shop($data->order_number);
			$this->load->library('email');
			
			$config['mailtype'] = 'html';
			$this->email->initialize($config);
			$this->load->model('messages_model');
			
			
			// Send the user a confirmation email
			
			// - get the email template]
			$row = $this->messages_model->get_message(9);
			
			$row['content'] = html_entity_decode($row['content']);
			
			// set replacement values for subject & body
			// {customer_name}
			$row['subject'] = str_replace('{customer_name}', $customer->firstname.' '.$customer->lastname, $row['subject']);
			$row['content'] = str_replace('{customer_name}', $customer->firstname.' '.$customer->lastname, $row['content']);
			
			// {url}
			$row['subject'] = str_replace('{url}', $this->config->item('base_url'), $row['subject']);
			$row['content'] = str_replace('{url}', $this->config->item('base_url'), $row['content']);
			
			// {site_name}
			$row['subject'] = str_replace('{site_name}', $this->config->item('company_name'), $row['subject']);
			$row['content'] = str_replace('{site_name}', $this->config->item('company_name'), $row['content']);
			
			$row['subject'] = str_replace('{order_number}', $data->order_number, $row['subject']);
			
			$row['content'] = str_replace('{order_number}', $data->order_number, $row['content']);
			$row['content'] = str_replace('{amount_paid}', $data->amount_paid, $row['content']);
			$row['content'] = str_replace('{payment_date}', $data->payment_date, $row['content']);
				
			// {order_summary}
			//$row['content'] = str_replace('{order_summary}', $this->load->view('order_email', $data, true), $row['content']);
			
			// {download_section}
			//$row['content'] = str_replace('{download_section}', $download_section, $row['content']);
				
			
	
			$this->email->from($this->config->item('email'), $this->config->item('company_name'));
			
			$this->email->to($customer->email);
			
			//email the admin
			//$this->email->bcc($this->config->item('email'));
			
			$this->email->subject($row['subject']);
			$this->email->message($row['content']);
			
			if ( ! $this->email->send())
			{
				// Generate error
				$this->session->set_flashdata('error', 'Selected payment is error, please try again!');
			}else{
				if($order->status != "Shipped"){
					$this->Payment_transfer_model->get_paid($payment_id, $data->order_number);	
				}
				// if customer is regular customer and has shopping more than 1 million, they will get 10% disc for every purchased
				/*if($customer->group_id == 1){
					if($order->total >= 1000000){
						$this->Customer_model->set_group($data->customer_id,2);
	     					
						$content = $this->messages_model->get_message(12);
						$content['content'] = html_entity_decode($content['content']);
						
						$this->email->from($this->config->item('email'), $this->config->item('company_name'));
				
						$this->email->to($customer->email);
						
						//email the admin
						//$this->email->bcc($this->config->item('email'));
						
						$this->email->subject($content['subject']);
						$this->email->message($content['content']);
						
						$this->email->send();
					}		
				}*/
				$this->session->set_flashdata('message', 'Payment has paid and email sent');
			}
			
			
		}else{
			$this->session->set_flashdata('error', 'No Payment selected to be paid');
		}	
		
		//redirect as to change the url
		redirect($this->config->item('admin_folder').'/payment_transfer');	
		
	}
	
}