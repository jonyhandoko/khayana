<?php include(APPPATH.'themes/'.$this->config->item('theme').'/views/header.php'); ?>



<?php if(!$login_check):?>
<!-- Container -->
<div class="container">
	<div class="greet">
	  <h3>HELLO VALUE CUSTOMER</h3>
	  <p>It Looks Like you wish to order without creating an account. So complete the form address below</p>
	</div>
	<div class="thing">
	  <div class="row">
		<div class="col-sm-2 col-md-4"></div>
		<div class="col-sm-8 col-md-4">
			<?php echo form_open('secure/login', array('class'=>'form-horizontal form-clean', 'role'=>'form'))?>
			<div class="form-group">
			  <div class="col-sm-12">
				<input type="text" class="form-control" name="email" placeholder="username">
			  </div>
			</div>
			<div class="form-group">
			  <div class="col-sm-12">
				<input type="password" class="form-control" name="password" placeholder="password">
			  </div>
			</div>
			<div class="form-group">
			  <div class="col-sm-12">
				<input type="hidden" value="checkout/order_summary" name="redirect"/>
                <input type="hidden" value="submitted" name="submitted"/>
				<button type="submit" class="btn btn-block btn-maroon">LOG IN</button>
			  </div>
			</div>
			</form>
		</div>
	  </div>
	  <div class="greet">
		  <h3>NEW CUSTOMER</h3>
		  <p>It Looks Like you wish to order without creating an account. So complete the form address below</p>
	  </div>
	  <div class="row">
		<div class="col-sm-2 col-md-4"></div>
		<div class="col-sm-8 col-md-4">
		  <form class="form-horizontal form-clean" role="form">
			<div class="form-group">
			  <div class="col-sm-6">
				<input type="text" class="form-control" name="firstName" placeholder="first name">
			  </div>
			  <div class="col-sm-6">
				<input type="text" class="form-control" name="lastName" placeholder="last name">
			  </div>
			</div>
			<div class="form-group">
			  <div class="col-sm-12">
				<input type="text" class="form-control" name="address" placeholder="address">
			  </div>
			</div>
			<div class="form-group">
			  <div class="col-sm-12">
				<input type="text" class="form-control number" name="zipCode" placeholder="zip code">
			  </div>
			</div>
			<div class="form-group">
			  <div class="col-sm-12">
				<input type="text" class="form-control" name="city" placeholder="city">
			  </div>
			</div>
			<div class="form-group">
			  <div class="col-sm-12">
				<input type="text" class="form-control number" name="phoneNumber" placeholder="phone number">
			  </div>
			</div>
			<div class="form-group">
			  <div class="col-sm-12">
				<input type="email" class="form-control" name="email" placeholder="email">
			  </div>
			</div>
			<div class="form-group">
			  <div class="col-sm-12">
				<button type="submit" class="btn btn-block btn-maroon">CONTINUE</button>
			  </div>
			</div>
		  </form>
		</div>
		<div class="col-sm-2 col-md-4"></div>
	  </div>
	</div>
</div>
<!-- ./Container -->
<?php else: ?>
<script>
$(document).ready(function() {
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
// some behavior controlling global variables
var logged_in_user = <?php if($this->Customer_model->is_logged_in(false, false)) echo "true"; else echo "false"; ?>;

var shipping_required = <?php echo ($this->go_cart->requires_shipping()) ? 'true' : 'false'; ?>;
var shipping = Array();
var shipping_choice = '<?php $shipping=$this->go_cart->shipping_method(); if($shipping) print_r($shipping); ?>';

var addr_context = '';
var ship_to_bill_address = <?php if(isset($customer['ship_to_bill_address'])) { echo $customer['ship_to_bill_address']; } else { echo 'false'; } ?>;
var addresses;
var cart_total = <?php echo $this->go_cart->total(); ?>;
// Set payment info
function submit_payment_method()
{
	
	//clear_errors();
	errors = false;
	
	/*if (document.theForm.jqdemo1.checked == false){
		alert ('Please check all confirmed boxes!');
		document.theForm.jqdemo1.focus();
		return false;
	}else if(document.theForm.jqdemo2.checked == false){
		alert ('Please check all confirmed boxes!');
		document.theForm.jqdemo2.focus();
		return false;
	}else if(document.theForm.jqdemo3.checked == false) 
	{
		alert ('Please check all confirmed boxes!');
		document.theForm.jqdemo3.focus();
		return false;	
	}else { 	
		//$('#redirect_path').val('checkout');
		//return true;
	}*/
		
	// verify a shipping method is chosen
	/*if(shipping_required && $('input:radio[name=shipping_input]:checked').val()===undefined && $('input:radio[name=shipping_input]').length > 0)
	{
		display_error('shipping', '<?php echo lang('error_choose_shipping');?>');
		errors = true;
	}*/
		
	// stop here if we have problems
	if(errors)
	{
		return false;
	}

	// send the customer data again and then submit the order
	save_order();
}

function save_order()
{
	//submit additional order details
	//$.post('<?php echo site_url('checkout/save_additional_details');?>', $('#additional_details_form').serialize(), function(){
		//$('#order_submit_form').trigger('submit');
		//thus must be a callback, otherwise there is a risk of the form submitting without the additional details saved
		// if we need to save a payment method
	if(cart_total>0) {
		//frm_data = $('#pmnt_form_'+chosen_method).serialize();
		/*frm_data = $('input:radio[name=payment_method]:checked').serialize();
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
		}*/
		$('#order_submit_form').trigger('submit');
	}
}
</script>

<!-- Container -->
<form id="order_submit_form" action="<?php echo site_url('checkout/place_order'); ?>" name="theForm" method="post">
<div class="product">
	<div class="container-fluid">
		<div class="def-temp">
			<div class="head">
			  <div class="row">
				<div class="col-xs-12">
				  <img src="<?php echo base_url('/images/watchinc/watch.png');?>" class="img-responsive pull-left">
				  <h3 class="title"><span class="orange">ORDER</span> SUMMARY</h3>
				</div>
			  </div>
			</div>
		</div>
		<div class="thing">
		  <div class="row">
			<div class="col-md-2"></div>
			<div class="col-sm-12 col-md-8">
			  <div class="panel panel-as-table">
				<div class="panel-heading">
				  <div class="row">
					<div class="col-sm-6">
					  <p>PRODUCT</p>
					</div>
					<div class="col-sm-2">
					  <p class="text-center">PRICE</p>
					</div>
					<div class="col-sm-2">
					  <p class="text-center">QUANTITY</p>
					</div>
					<div class="col-sm-2">
					  <p class="text-center">TOTAL</p>
					</div>
				  </div>
				</div>
				<div class="panel-body">
				  <?php
					$grandtotal = 0;
					foreach ($this->go_cart->contents() as $cartkey=>$product):?>
				  <div class="row">
					<div class="col-sm-6">
					  <div class="media">
						<div class="pull-left">
						  <img class="media-object" height="100" src="<?php echo base_url('uploads/product/thumb/'.$product['images']);?>" alt="cart-2.jpg">
						</div>
						<div class="media-body">
						  <p><?php echo $product['name']; ?></p>
						</div>
					  </div>
					</div>
					<div class="col-sm-2">
					  <div class="row">
						<div class="col-xs-6 col-sm-12">
						  <p class="price text-center"><?php echo format_currency($product['price']); ?></p>
						</div>
					  </div>
					</div>
					<div class="col-sm-2">
					  <div class="row">
						<div class="col-xs-6 col-sm-12">
						  <p class="price text-center"><?php echo $product['quantity'] ?></p>
						</div>
					  </div>
					</div>
					<div class="col-sm-2">
					  <div class="row">
						<div class="col-xs-6 col-sm-12">
						  <p class="price text-center"><?php echo format_currency($product['price']*$product['quantity']); ?></p>
						</div>
					  </div>
					</div>
				  </div>
				  <?php
					endforeach;
				  ?>
				</div>
				<div class="panel-footer">
				  <div class="divider">
					<div class="sum light no-discount">
					  <div class="row">
						<div class="col-sm-6"></div>
						<div class="col-xs-6 col-sm-4">
						  <p>Total Item Price</p>
						</div>
						<div class="col-xs-6 col-sm-2">
						  <p><?php echo format_currency($this->go_cart->subtotal());?></p>
						</div>
					  </div>
					  <div class="row">
						<div class="col-sm-6"></div>
						<div class="col-xs-6 col-sm-4">
						  <p>Delivery Costs</p>
						</div>
						<div class="col-xs-6 col-sm-2">
						  <p><?php echo "<span class='shipping'>".format_currency($this->go_cart->shipping_cost())."</span>";?></p>
						</div>
					  </div>
					</div>
				  </div>
				  <div class="divider off">
					<div class="total light">
					  <div class="row">
						<div class="col-sm-6"></div>
						<div class="col-xs-6 col-sm-4">
						  <p>Total</p>
						</div>
						<div class="col-xs-6 col-sm-2">
						  <p><?php echo "<span class='grandtotal'>".format_currency($this->go_cart->total())."</span>"; ?></p>
						</div>
					  </div>
					</div>
				  </div>
			
				  <div class="act">
					<div class="text-center">
					  <div class="row">
						<div class="col-xs-2 col-md-3"></div>
						<div class="col-xx col-xs-8 col-md-6">
						  <input id="redirect_path" type="hidden" name="redirect" value=""/>
						  <input type="hidden" name="process_order" value="true">
						  <button class="btn btn-block btn-orange" type="button" onclick="return submit_payment_method();">CONFIRM ORDER</button>
						</div>
						<div class="col-xs-2 col-md-3"></div>
					  </div>
					</div>
				  </div>
				  </form>
				</div>
			  </div>
			</div>
			<div class="col-md-2"></div>
		  </div>
		</div>
	</div>
</div>
<!-- ./Container -->
<?php endif; ?>

<?php include(APPPATH.'themes/'.$this->config->item('theme').'/views/footer.php'); ?>