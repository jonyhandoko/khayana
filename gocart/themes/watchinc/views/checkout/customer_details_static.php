<script type="text/javascript">
//if this page is loaded, it means that we can load payment and shipping info too.
$('#shipping_payment_container').show();
$('#submit_button_container').show();

/*$.post('<?php echo site_url('checkout/shipping_payment_methods');?>', function(data){
	$('#shipping_payment_container').html(data);
});*/

<?php if(isset($address_update)&& $address_update==1):?>
	$('.shipping').html("<?php echo format_currency($this->go_cart->shipping_cost());?>");
	$('.grandtotal').html("<?php echo format_currency($this->go_cart->total());?>");
<?php endif;?>

$(document).ready(function() {
	$('.address').change(function(e){
		$.post('<?php echo site_url('checkout/customer_details');?>', function(data){
			//populate the form with their information
			$('#customer_info_fields').html("A");
		});
	});
});
</script>
<?php
//$bill	= $customer['bill_address'];
$ship	= $customer['ship_address'];
?>


<div class="greet">
	<p>Please enter your valid address</p>
</div>
<div class="thing">
	<div class="form-group">
		<div class="col-sm-12">
			<button type="button" class="btn btn-block btn-orange" onclick="get_customer_form();">CHANGE ADDRESS</button>
			<br/><br/>
		</div>
	</div>
	<form class="form-horizontal form-clean" role="form">
	  <div class="form-group">
		<div class="col-sm-6">
		  <input type="text" class="form-control" name="city" placeholder="first name" disabled value="<?php echo $ship['firstname'];?>">
		</div>
		<div class="col-sm-6">
		  <input type="text" class="form-control" name="state" placeholder="last name" disabled value="<?php echo $ship['lastname'];?>">
		</div>
	  </div>
	  <div class="form-group">
		<div class="col-sm-12">
		  <input type="text" class="form-control" name="address" placeholder="address 1" disabled value="<?php echo $ship['address1'];?>">
		</div>
	  </div>
	  <div class="form-group">
		<div class="col-sm-12">
		  <input type="text" class="form-control" name="address" placeholder="address 2" disabled value="<?php echo (!empty($ship['address2']))?$ship['address2'].'':'';?>">
		</div>
	  </div>
	  <div class="form-group">
		<div class="col-sm-6">
		  <input type="text" class="form-control" name="city" placeholder="province" disabled value="<?php echo $ship['province'];?>">
		</div>
		<!--<div class="col-sm-4">
		  <input type="text" class="form-control" name="state" placeholder="state">
		</div>-->
		<div class="col-sm-6">
		  <input type="text" class="form-control number" name="zipCode" placeholder="zip code" disabled value="<?php echo $ship['zip'];?>">
		</div>
	  </div>
	  <div class="form-group">
		<div class="col-sm-12">
		  <input type="text" class="form-control number" name="phone" placeholder="phone" disabled value="<?php echo $ship['phone'];?>">
		</div>
	  </div>
	  <div class="form-group">
		<div class="col-sm-12">
		  <!--<button type="button" class="btn btn-block btn-maroon">CONTINUE</button>-->
		</div>
	  </div>
	  <!--<div class="checkbox">
		<label>
		  <input type="checkbox"> use same address for billing
		</label>
	  </div>-->
	</form>
</div>
        