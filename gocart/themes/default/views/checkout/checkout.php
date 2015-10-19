<?php include(APPPATH.'themes/'.$this->config->item('theme').'/views/header.php'); ?>
<script type="text/javascript">
$(document).ready(function() {
	$('.continue_shopping').buttonset();

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

</script>
<div style="width: 100%; position: relative;">
<div class="register-form" style="width: 400px; margin: 0 auto;">
<h1>SHIPPING ADDRESS</h1>

<hr/>
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
<input type="submit" class="button1" onclick="set_shipping_cost()"  value="CONTINUE" /><!--onclick="submit_payment_method()"-->
</form>
</div>


<div class="clear"></div>
</div>
</div>
<?php include(APPPATH.'themes/'.$this->config->item('theme').'/views/footer.php'); ?>