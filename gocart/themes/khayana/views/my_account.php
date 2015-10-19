<?php include('header.php');?>
<link type="text/css" href="<?php echo base_url('js/jquery/colorbox/colorbox.css');?>" rel="stylesheet" />
<script type="text/javascript" src="<?php echo base_url('js/jquery/colorbox/jquery.colorbox-min.js');?>"></script>
<?php
if(validation_errors())
{
	echo '<div class="error">'.validation_errors().'</div>';
}
?>

<script>
$(document).ready(function(){
	$('.delete_address').click(function(){
		if($('.delete_address').length > 1)
		{
			if(confirm('<?php echo lang('delete_address_confirmation');?>'))
			{
				$.post("<?php echo site_url('secure/delete_address');?>", { id: $(this).attr('rel') },
					function(data){
						$('#address_'+data).remove();
						$('#address_list .my_account_address').removeClass('address_bg');
						$('#address_list .my_account_address:even').addClass('address_bg');
					});
			}
		}
		else
		{
			alert('<?php echo lang('error_must_have_address');?>');
		}	
	});
	
	$('.edit_address').click(function(){
		$.colorbox({	href: '<?php echo site_url('secure/address_form'); ?>/'+$(this).attr('rel'), width:'600px', height:'500px'}, function(){
			//$('input:submit, input:button, button').button();
		});
	});
	
	/*if ($.browser.webkit) {
	    $('input:password').attr('autocomplete', 'off');
	}*/
});


function set_default(address_id, type)
{
	$('.create_dialog_style').show();
	$.post('<?php echo site_url('secure/set_default_address') ?>/',{id:address_id, type:type}, function(data){
		$('.create_dialog_style').hide();
	});
}


</script>

<?php
//$company	= array('id'=>'company', 'class'=>'input1', 'name'=>'company', 'value'=> set_value('company', $customer['company']));
$first		= array('id'=>'firstname', 'class'=>'input1', 'name'=>'firstname', 'value'=> set_value('firstname', $info->firstname));
$last		= array('id'=>'lastname', 'class'=>'input1', 'name'=>'lastname1', 'value'=> set_value('lastname', $info->lastname));
$email		= array('id'=>'email', 'class'=>'input1', 'name'=>'email', 'disabled'=>'disabled', 'value'=> set_value('email', $info->email));
$phone		= array('id'=>'phone', 'class'=>'input1', 'name'=>'phone', 'value'=> set_value('phone', $info->phone));

$password	= array('id'=>'password', 'class'=>'input1', 'name'=>'password', 'value'=>'');
$confirm	= array('id'=>'confirm', 'class'=>'input1', 'name'=>'confirm', 'value'=>'');
?>	

<!-- Container -->
<div class="container">
<div class="thing">
  <div class="row">
	<div class="col-sm-2">
	  <div class="list-group list-clean regular">
		<a href="/secure/my_account" class="list-group-item active">PROFILE</a>
		<a href="/secure/my_orders" class="list-group-item">ORDERS</a>
		<a href="/cart/confirmation_payment" class="list-group-item">PAYMENT</a>
	  </div>
	</div>
	<div class="col-sm-10">
	  <div class="greet">
		<h3 class="text-left">PROFILE</h3>
	  </div>
	  <div class="panel panel-as-table panel-lite">
		<div class="panel-body">
			 <div class="row seperator">
				<div class="col-sm-6">
						<table>
						<tr>
							<td width="100">
								<?php echo lang('account_firstname');?><b class="r"> *</b>
								<br/>
								<?php echo form_input($first);?>
							</td>
							<td width="100">
								<?php echo lang('account_lastname');?><b class="r"> *</b>
								<br/>
								<?php echo form_input($last);?>
							</td>
						</tr>
						<tr>
							<td width="100">
								Email *
								<br/>
								<?php echo form_input($email);?>
							</td>
							<td width="100">
								Phone</b>
								<br/>
								<?php echo form_input($phone);?>
							</td>
						</tr>
						<tr>
							<td colspan="2"><input type="checkbox" name="email_subscribe" value="1" <?php if((bool)$info->email_subscribe) { ?> checked="checked" <?php } ?>/> <?php echo lang('account_newsletter_subscribe');?></td>
						</tr>
						<tr>
							<td width="100">
								Password
								<br/>
								<?php echo form_password($password);?>
							</td>
							<td width="100">
								Confirm Password</b>
								<br/>
								<?php echo form_password($confirm);?>
							</td>
						</tr>
						<tr>
							<td colspan="2" align="right"><input type="submit" value="Save Information" class="button2"  /></td>
						</tr>
					</table>
				</div>
				
				<div class="col-sm-6">
					<?php if ($addresses != NULL):?>
						<table>
							<tr>
								<td colspan="2">
									<?php if(count($addresses)<2){?><input type="button" class="edit_address right" rel="0" value="<?php echo lang('add_address');?>"/><?php }?><span>(Max 2 addresses)</span>
								</td>
							</tr>
							<script type="text/javascript">
								$(document).ready(function(){
									$('#address_list .my_account_address:even').addClass('address_bg');	
								});
								</script>
							<?php
							$c = 1;
							foreach($addresses as $a):?>
							<tr>
								<td width="80">Address <?php echo $c;?></td>
								
								<td>
									
										<div class="my_account_address" id="address_<?php echo $a['id'];?>">
											<div class="address_toolbar">
												<!--<input type="radio" name="bill_chk" onclick="set_default(<?php echo $a['id'] ?>, 'bill')" <?php if($customer['default_billing_address']==$a['id']) echo 'checked="checked"'?> /> <?php echo lang('default_billing');?> --><input type="radio" name="ship_chk" onclick="set_default(<?php echo $a['id'] ?>,'ship')" <?php if($customer['default_shipping_address']==$a['id']) echo 'checked="checked"'?>/> <?php echo lang('default_shipping');?>
											</div>
		<br/>
											<?php
											$b	= $a['field_data'];
											echo nl2br(format_address($b));
											$c++;
											?>
										</div>
								</td>
							</tr>
							<td colspan="2" align="right">
								<input type="button" class="delete_address button2" rel="<?php echo $a['id'];?>" value="<?php echo lang('form_delete');?>" />
								<input type="button" class="edit_address button2" rel="<?php echo $a['id'];?>" value="<?php echo lang('form_edit');?>" />
							</td>
							<?php endforeach;?>
						</table>
						<?php else: ?>
						<input type="button" class="edit_address right" rel="0" value="<?php echo lang('add_address');?>"/><span>(Max 2 addresses)</span>
						<p>Please fill at least 1 shipping address</p>
						<?php endif;?>
				</div>
			 </div>
		</div>
	  </div>
	</div>
  </div>
</div>
</div>
<!-- ./Container -->

<?php include('footer.php');?>