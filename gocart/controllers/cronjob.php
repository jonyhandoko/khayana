<?php

class Cronjob extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		
		//make sure we're not always behind ssl
		//remove_ssl();
		
		$this->load->library('Go_cart');
		$this->load->model(array('Place_model', 'Product_model', 'Option_model', 'Order_model', 'Settings_model'));
	
	}

	function index()
	{
		
	}
	
	function cancelation_order(){
		$this->load->model('Option_model');
		// - get the email template
		$this->load->model('messages_model');
		$this->load->library('email');
		//$config['mailtype'] = 'html';
		$config = Array(
				'protocol' => 'smtp',
				'smtp_host' => 'smtp.office365.com',
				'smtp_port' => 587,
				'smtp_user' => 'sales@watchinc.co.id',
				'smtp_pass' => 'Makmur123',
				'smtp_crypto' => 'tls',
				'crlf'		=> '\n',
				'mailtype'  => 'html'
			);
		
		$orders = $this->Order_model->get_customer_orders_pending();
		$now = date('Y-m-d H:i:s');
		foreach($orders as $order){
			
			// Check if today date is bigger than ordered_on date
			if(strtotime(date("Y-m-d H:i:s", strtotime($order->ordered_on)) . " + 3 day") < strtotime($now)){
				if($order->status == "Pending"){
					//echo $order->status;	
				}elseif($order->status == "Processing"){
					//echo $order->status;
				}
				$row = $this->messages_model->get_message(11);
				$data = $this->Order_model->get_order($order->id);
				//echo $order->order_number;
				foreach($data->contents as $orderkey=>$product)
				{
					//echo ' '.$product['quantity'];
					// Print options
					//print_r($product);
					$update_option = false;
					if(isset($product['options']) && $product['options']!=NULL)
					{
						$key =  key($product['post_options']);
						
						$option_value = $this->Option_model->get_value($product['post_options'][$key]);
						//echo $product['post_options'][$key];
						//print_r($option_value);
						$update_option['id'] = $product['post_options'][$key];
						$update_option['qty'] = $option_value->qty+$product['quantity'];
						
						//echo $update_option['qty'];
					}
					$update_product['id'] = $product['id'];
					$update_product['quantity'] =  $this->Product_model->get_quantity_product($product['id'])->quantity+$product['quantity'];
					//print_r($update_option);
					//print_r($update_product);
					
					$this->Product_model->update_product($update_product, $update_option);
					
					//echo ' '.$product['id'];
					
					
				}
				$this->Order_model->cancel_order($order->id);
				
				$row['content'] = html_entity_decode($row['content']);
		
				// set replacement values for subject & body
				
				$row['content'] = str_replace('{order_number}', $order->order_number, $row['content']);
				
				
				$this->email->initialize($config);
				$this->email->from($this->config->item('email'), $this->config->item('company_name'));
				$this->email->to($order->email);
                                $this->email->bcc($this->config->item('email'));
				$this->email->subject('Your order ('.$order->order_number.') has been cancelled');
				$this->email->message($row['content']);
				$this->email->send();
				//echo "<br/>";
			}elseif(strtotime(date("Y-m-d H:i:s", strtotime($order->ordered_on)) . " + 2 day") < strtotime($now) && ($order->reminder!=1)){
				$row = $this->messages_model->get_message(13);
				
				$row['content'] = html_entity_decode($row['content']);
		
				// set replacement values for subject & body
				
				//$row['content'] = str_replace('{order_number}', $order->order_number, $row['content']);
				//$row['subject'] = str_replace('{order_number}', $order->order_number, $row['subject']);
				//$row['subject'] = str_replace('{amount_paid}', format_currency($order->total), $row['content']);
				
				
				$this->email->initialize($config);
				$this->email->from($this->config->item('email'), $this->config->item('company_name'));
				$this->email->to($order->email);
                                $this->email->bcc($this->config->item('email'));
				$this->email->subject($row['subject']);
				$this->email->message($row['content']);
				$this->email->send();
				
				$this->Order_model->set_reminder($order->id);
			}
		}
		
	}
	
}