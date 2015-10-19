<?php include(APPPATH.'themes/'.$this->config->item('theme').'/views/header.php'); ?>
<script type="text/javascript">
$(document).ready(function() {
	//$('.continue_shopping').buttonset();

	// higlight  fields
	$('.input').focus(function(){
		$(this).addClass('input_hover');
	});
	
	// higlight fields
	$('.input').blur(function(){
		$(this).removeClass('input_hover');
	});
	
	<?php if(isset($customer['ship_address'])):?>
		$.post('<?php echo site_url('checkout/customer_details');?>', function(data){
			//populate the form with their information
			$('#customer_info_fields').html(data);
			//$('input:button, input:submit, button').button();
		});
	<?php else:	?>
		get_customer_form();
	<?php endif;?>

});
function get_customer_form()
{
	//the loader will only show if someone is editing their existing information
	$('#save_customer_loader').show();
	//hide the button again
	$('#submit_button_container').hide();
	
	//remove the shipping and payment forms
	$('#shipping_payment_container').html('<div class="checkout_block"><img alt="loading" src="<?php echo base_url('images/ajax-loader.gif');?>"/><br style="clear:both;"/></div>').hide();
	$.post('<?php echo site_url('checkout/customer_form'); ?>', function(data){
		//populate the form with their information
		$('#customer_info_fields').html(data);
		//$('input:button, input:submit, button').button();		
	});
}

function save_order()
{
	//submit additional order details
	//$.post('<?php echo site_url('checkout/save_additional_details');?>', $('#additional_details_form').serialize(), function(){
	//$('#order_submit_form').trigger('submit');
	//thus must be a callback, otherwise there is a risk of the form submitting without the additional details saved
	// if we need to save a payment method
	//frm_data = $('#pmnt_form_'+chosen_method).serialize();
	frm_data = $('input:radio[name=payment_method]:checked').serialize();
	if($('input:radio[name=payment_method]:checked').val()=='paypal_express'){
		
		$.post('<?php echo site_url('checkout/save_payment_method');?>', frm_data, function(response)
		{
			//alert(response);
			if(typeof response != "object")
			{
				display_error('payment', '<?php echo lang('error_save_payment') ?>');

				return;
			}

			if(response.status=='success')
			{
				// send them on to place the order
				$('#order_submit_form').trigger('submit');
			}
			else if(response.status=='error')
			{
				display_error('payment', response.error);
			}

		}, 'json');
	} else if($('input:radio[name=payment_method]:checked').val()=='bank_transfer') {
		$.post('<?php echo site_url('checkout/save_payment_method');?>', frm_data, function(response)
		{
			if(typeof response != "object")
			{
				display_error('payment', '<?php echo lang('error_save_payment') ?>');

				return;
			}

			if(response.status=='success')
			{
				// send them on to place the order
				$('#order_submit_form').trigger('submit');
			}
			else if(response.status=='error')
			{
				display_error('payment', response.error);
			}

		}, 'json');
	} else {
		alert("Please choose payment method");
	}
}

</script>
<div class="product">
	<div class="container-fluid">
		<div class="def-temp">
			<div class="head">
			  <div class="row">
				<div class="col-xs-12">
				  <img src="images/watch.png" class="img-responsive pull-left">
				  <h3 class="title"><span class="orange">SHIPPING</span></h3>
				  <ol class="breadcrumb pull-right">
					<li><a href="">Home</a></li>
					<li><a href="">Brands</a></li>
					<li><a href="">DKNY</a></li>
					<li class="active">Lorem Ipsum Dolor</li>
				  </ol>
				</div>
			  </div>
			</div>
		</div>
		<div class="content">
			<div class="row" style="margin-bottom: 30px;">
				<div class="col-sm-6">
					<h3 class="title"><span class="orange">SHIPPING</span> ADDRESS</h3>
					
					<div class="register-form" style="padding: 35px;">
						<form id="order_submit_form" action="<?php echo site_url('checkout/order_summary'); ?>" method="post">
						<?php
						//$bill	= $customer['bill_address'];
						$ship	= $customer['ship_address'];
						?>

						<div class="checkout_block"  >
							<div id="customer_info_fields">
								<h3><?php echo lang('customer_information');?></h3>
								<img alt="loading" src="<?php echo base_url('images/ajax-loader.gif');?>"/>
							</div>
						</div>

						<div id="submit_button_container" style="display:none; text-align:center; padding-top:10px;">

						<input type="hidden" name="process_order" value="true">
						
						
						</div>
						
					</div>
				</div>
				<div class="col-sm-6">
					<div class="payment-box" style="border: 3px solid #CCC; padding: 10px 30px; margin-bottom: 25px;">
						<h3 class="title"><span class="orange">PAYMENT</span> METHOD</h3>
						<input type="radio" checked name="payment_method" value="bank_transfer" /> <label>BANK TRANSFER</label>
						<p>&nbsp;&nbsp;&nbsp;&nbsp;BANK BCA JONY HANDOKO - 313131313</p>
						<p>&nbsp;&nbsp;&nbsp;&nbsp;BANK MANDIRI JONY HANDOKO - 313131313</p>
						<br/>
						<!--<input type="radio" name="payment_method" value="paypal_express"/> <label>PAYPAL</label>-->
					</div>
					
					<div class="order-box" style="border: 3px solid #CCC; padding: 10px 30px;">
						<h3 class="title"><span class="orange">YOUR</span> ORDERS</h3>
						<div class="row" style="padding: 20px;">
							<?php if ($this->go_cart->total_items()==0):?>
								<div class="message">There are no products in your cart!</div>
							<?php else: ?>
								<div class="row" style="margin-bottom: 20px;">
								<?php
									$grandtotal = 0;
									$subtotal = 0;
									//print_r($this->go_cart->contents());

									foreach ($this->go_cart->contents() as $cartkey=>$product):
								?>
								<div class="col-xs-2">
									<img class="media-object" width="50" src="<?php echo base_url('uploads/product/thumb/'.$product['images']);?>" alt="cart-2.jpg">
								</div>
								<div class="col-xs-6" style="text-align: left">
									<p><b><?php echo $product['name']; ?></b></p>
									<p class="price"><?php echo $product['quantity'] ?>x <?php echo format_currency($product['base_price']);   ?></p>
								</div>
								<div class="col-xs-4">
								
								</div>
								<?php endforeach;?>
								</div>
								<div class="row">
									<div class="col-xs-8">
										<p>CART SUBTOTAL</p>
									</div>
									<div class="col-xs-4">
										<?php echo format_currency($this->go_cart->subtotal());?>
									</div>
									<div class="col-xs-8">
										<p>SHIPPING</p>
									</div>
									<div class="col-xs-4">
										<?php echo "<span class='shipping'>".format_currency($this->go_cart->shipping_cost())."</span>";?>
									</div>
								</div>
								<div class="row" style="background-color: #F5F5F5; padding: 10px 0;">
									<div class="col-xs-8">
										ORDER TOTAL
									</div>
									<div class="col-xs-4">
										<?php echo "<span class='grandtotal'>".format_currency($this->go_cart->total())."</span>"; ?>
									</div>
								</div>
								<div class="row" style="text-align: right; margin-top: 15px;">
										<input type="button" class="btn btn-black" onclick="return save_order();" value="CONTINUE" /><!--onclick="submit_payment_method()"-->
								</div>
							<?php endif;?>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

</div>
<?php include(APPPATH.'themes/'.$this->config->item('theme').'/views/footer.php'); ?>