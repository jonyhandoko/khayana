<script type="text/javascript">
$(document).ready(function() {	
	//disable the form elements under billing if the checkbox is checked
	if($('#different_address').is(':checked'))
	{
		toggle_billing_address_form(true);
	}
	
	//add the disabled class to to disabled fields
	$('*:disabled').addClass('disabled');

	// automatically copy values when the checkbox is checked
	$('.ship').change(function(){
		if($('#different_address').is(':checked'))
		{
			copy_shipping_address();
		}
	});	
	
	// populate zone menu with country selection
	$('#ship_province_id').change(function(){
			populate_zone_menu('ship');
		});

	$('#bill_country_id').change(function(){
			populate_zone_menu('bill');
		});	

});
// context is ship or bill
var shipping_required = <?php echo ($this->go_cart->requires_shipping()) ? 'true' : 'false'; ?>;
var shipping = Array();
//var shipping_choice = '<?php /*$shipping=$this->go_cart->shipping_method(); if($shipping) echo $shipping['method'];*/ ?>';

function populate_zone_menu(context, value)
{
	$.post('<?php echo site_url('https://www.scarletcollection.com/secure/get_cities_menu');?>',{provinceId:$('#ship_province_id').val()}, function(data) {
		  $('#ship_city_id').html(data);
		  
	/*$.post('<?php //echo site_url('locations/get_zone_menu');?>',{id:$('#'+context+'_country_id').val()}, function(data) {
		$('#'+context+'_zone_id').html(data);*/
		
		//if the ship country is changed, and copy shipping address is checked, then reset the billing address to blank
		if(context == 'ship' && $('#different_address').is(':checked'))
		{
			$('#bill_zone_id').html(data).val($('#bill_zone_id option:first').val());
		}
	});
}
function toggle_billing_address_form(checked)
{
	if(!checked)
	{
		clear_billing_address();
		$('.bill').attr('disabled', false);
		$('.bill').removeClass('disabled');
	}
	else
	{
		copy_shipping_address();
		$('.bill').attr('disabled', true);
		$('.bill').addClass('disabled');
	}
}

function clear_billing_address()
{
	$('.bill').val('');
}

function copy_shipping_address()
{
	//$('#bill_company').val($('#ship_company').val());
	$('#bill_firstname').val($('#ship_firstname').val());
	$('#bill_lastname').val($('#ship_lastname').val());
	$('#bill_address1').val($('#ship_address1').val());
	$('#bill_address2').val($('#ship_address2').val());
	$('#bill_city').val($('#ship_city').val());
	$('#bill_zip').val($('#ship_zip').val());
	$('#bill_phone').val($('#ship_phone').val());
	$('#bill_email').val($('#ship_email').val());
	$('#bill_country_id').val($('#ship_country_id').val());
}

function save_customer()
{
	$('#save_customer_loader').show();
	// temporarily enable the billing fields (if disabled)
	if($('#different_address').is(':checked'))
	{
		$('.bill').attr('disabled', false);
		$('.bill').removeClass('disabled');
	}
	//send data to server
	form_data  = $('#customer_info_form').serialize();
	
	
	
	$.post('<?php echo site_url('checkout/save_customer') ?>', form_data, function(response)
	{
		if(typeof response != "object") // error
		{
			display_error('customer', '<?php echo lang('communication_error');?>');
			return;
		}
		
		if(response.status=='success')
		{
			//populate the information from ajax, so someone cannot use developer tools to edit the form after it's saved
			$('#customer_info_fields').html(response.view);
			
			//$('input:button, button').button();			
			 // and update the summary to show proper tax information / discounts
			 //update_summary();
		}
		else if(response.status=='error')
		{
			display_error('customer', response.error);
			$('#save_customer_loader').hide();
		}
	}, 'json');
	
	function display_error(id, error){
		$('#customer_error_box').html(error);
		$('#customer_error_box').show();
	}
}
</script>
<?php /* Only show this javascript if the user is logged in */ ?>
<?php if($this->Customer_model->is_logged_in(false, false)) : ?>
<script type="text/javascript">
	
	var address_type = 'ship';
	$(document).ready(function(){
		$('.address_picker').click(function(){
			$.colorbox({href:'#address_manager', inline:true, height:'400px', width:'400px'});
			address_type = $(this).attr('rel');
		});
	});

	<?php
	$add_list = array();
	foreach($customer_addresses as $row) {
		// build a new array
		$add_list[$row['id']] = $row['field_data'];
	}
	$add_list = json_encode($add_list);
	echo "eval(addresses=$add_list);";
	?>
		
	function populate_address(address_id)
	{

		if(address_id=='') return;
		
		// update the visuals

		// - this is redundant, but it updates the visuals before the operation begins
		if(shipping_required && address_type=='ship')
		{
			$('#shipping_loading').show();
			$('#shipping_method_list').hide();
		}

		// - populate the fields
		$.each(addresses[address_id], function(key, value){
			$('#'+address_type+'_'+key).val(value);
		});	
		
		// - save the address id
		$('#'+address_type+'_address_id').val(address_id);

		// repopulate the zone list, set the right value, then copy all to billing
		$.post('<?php echo site_url('locations/get_zone_menu');?>',{id:$('#'+address_type+'_country_id').val()}, function(data) {
			// - uncheck the option box if they choose a billing address
			if(address_type=='bill')
			{
				$('#different_address').attr('checked', false);
				$('.bill').attr('disabled', false);
				$('.bill').removeClass('disabled');
				$('#bill_zone_id').html(data);
				$('#bill_zone_id').val(zone_id);
			} 
			else 
			{
				if($('#different_address').is(':checked'))
				{
					// copy the rest of the fields
					copy_shipping_address();
				}	
			}
		});		
	}
	
</script>
<?php endif;?>

<?php
//$countries = $this->Location_model->get_countries_menu();
//$provinces = $this->Place_model->get_provinces_menu();
$provinces = $this->Place_model->get_jne_one_menu($customer['ship_address']['country']);


//form elements
$s_address1	= array('id'=>'ship_address1', 'class'=>'ship input ship_req', 'name'=>'ship_address1', 'value'=>@$customer['ship_address']['address1']);
$s_address2	= array('id'=>'ship_address2', 'class'=>'ship input', 'name'=>'ship_address2', 'value'=> @$customer['ship_address']['address2']);
$s_first	= array('id'=>'ship_firstname', 'class'=>'ship input ship_req', 'name'=>'ship_firstname', 'value'=> @$customer['ship_address']['firstname']);
$s_last		= array('id'=>'ship_lastname', 'class'=>'ship input ship_req', 'name'=>'ship_lastname', 'value'=> @$customer['ship_address']['lastname']);
$s_email	= array('id'=>'ship_email', 'class'=>'ship input ship_req', 'name'=>'ship_email', 'value'=>@$customer['ship_address']['email']);
$s_phone	= array('id'=>'ship_phone', 'class'=>'ship input ship_req', 'name'=>'ship_phone', 'value'=> @$customer['ship_address']['phone']);
//$s_city		= array('id'=>'ship_city', 'class'=>'ship input ship_req', 'name'=>'ship_city', 'value'=>@$customer['ship_address']['city']);
$s_zip		= array('id'=>'ship_zip', 'maxlength'=>'10', 'class'=>'ship input ship_req', 'name'=>'ship_zip', 'value'=> @$customer['ship_address']['zip']);

?>

	<div id="customer_error_box" class="error" style="display:none"></div>
	<form id="customer_info_form">
		<h3><?php echo lang('customer_information');?></h3>
		<div class="thing">
			<div class="form_wrap">
				<!--<div style="font-weight:bold"><?php echo lang('shipping_address');?></div>-->
			</div>
			<div class="form_wrap">
				<?php if($this->Customer_model->is_logged_in(false, false)) : ?>
				<div>
					<button type="button" class="btn btn-block btn-orange address_picker" rel="ship">Choose Shipping Address</button>
					<br/>
				</div>
				<?php endif; ?>
			</div>
			<div class="form-group">
			<input type="hidden" name="ship_email" value="<?php echo $customer['ship_address']['email'];?>"/>
			<div class="col-sm-6">
			  <input type="text" class="form-control" id="ship_firstname" name="ship_firstname" placeholder="first name"  value="<?php echo $customer['ship_address']['firstname'];?>">
			</div>
			<div class="col-sm-6">
			  <input type="text" class="form-control" id="ship_lastname" name="ship_lastname" placeholder="last name"  value="<?php echo $customer['ship_address']['lastname'];?>">
			</div>
		  </div>
		  <div class="form-group">
			<div class="col-sm-12">
			  <input type="text" class="form-control" id="ship_address1" name="ship_address1" placeholder="address 1"  value="<?php echo $customer['ship_address']['address1'];?>">
			</div>
		  </div>
		  <div class="form-group">
			<div class="col-sm-12">
			  <input type="text" class="form-control" id="ship_address2" name="ship_address2" placeholder="address 2"  value="<?php echo (!empty($customer['ship_address']['address2']))?$customer['ship_address']['address2'].'':'';?>">
			</div>
		  </div>
		  <div class="form-group">
			<div class="col-sm-6">
			  <?php echo form_dropdown('ship_province_id',$provinces, @$customer['ship_address']['province_id'], 'id="ship_province_id" class="form-control ship input ship_req"');?>
			</div>
			<div class="col-sm-6">
			  <input type="text" class="form-control number" id="ship_sip" name="ship_zip" placeholder="zip code"  value="<?php echo $customer['ship_address']['zip'];?>">
			</div>
		  </div>
		  <div class="form-group">
			<div class="col-sm-12">
			  <input type="text" class="form-control number" id="ship_phone" name="ship_phone" placeholder="phone"  value="<?php echo $customer['ship_address']['phone'];?>">
			</div>
		  </div>
		  <div class="form-group">
			<div class="col-sm-12">
				<button type="button" class="btn btn-block btn-maroon" onclick="save_customer();">CONTINUE</button>
			</div>
		  </div>
		</div>		
	</form>
	
	<br style="clear:both;"/>
	<table style="margin-top:10px;">
		<tr>
			<!--<td><input type="button" value="<?php echo lang('form_continue');?>" onclick="save_customer()"/></td>-->
			<td><img id="save_customer_loader" alt="loading" src="<?php echo base_url('images/ajax-loader.gif');?>" style="display:none;"/></td>
		</tr>
	</table>
	


<?php if($this->Customer_model->is_logged_in(false, false)) : ?>
<div id="stored_addresses" style="display:none;">
	<div id="address_manager">
		<h3 style="text-align:center;"><?php echo lang('your_addresses');?></h3>
		<script type="text/javascript">
		$(document).ready(function(){
			$('#country_id').change(function(){
				$('#ship_province_id').html("");
				$.post('<?php echo site_url('/places/get_jne_one_cities_menu');?>',{country:$('#country_id').val()}, function(data) {
				  $('#ship_province_id').html(data);
				});

			});
			
			$('#address_list .my_account_address:even').addClass('address_bg');
		});
		</script>
		<div id="address_list">
			
		<?php
		$c = 1;
		foreach($customer_addresses as $a):?>
			<div class="my_account_address" id="address_<?php echo $a['id'];?>">
				<div class="address_toolbar">
					<input type="button" class="choose_address" onclick="populate_address(<?php echo $a['id'];?>); $.colorbox.close()" value="<?php echo lang('form_choose');?>" />
				</div>
				<?php
				$b	= $a['field_data'];
				echo nl2br(format_address($b));
				?>
			</div>
		<?php endforeach;?>
		</div>
	</div>
</div>
<?php endif;?>