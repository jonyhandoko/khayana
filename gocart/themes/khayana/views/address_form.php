<?php

$f_id		= array('id'=>'f_id', 'style'=>'display:none;', 'name'=>'id', 'value'=> set_value('id',$id));
$f_company	= array('id'=>'f_company', 'class'=>'input', 'name'=>'company', 'value'=> set_value('company',$company));
$f_address1	= array('id'=>'f_address1', 'class'=>'input', 'name'=>'address1', 'value'=>set_value('address1',$address1));
$f_address2	= array('id'=>'f_address2', 'class'=>'input', 'name'=>'address2', 'value'=> set_value('address2',$address2));
$f_first	= array('id'=>'f_firstname', 'class'=>'input', 'name'=>'firstname', 'value'=> set_value('firstname',$firstname));
$f_last		= array('id'=>'f_lastname', 'class'=>'input', 'name'=>'lastname', 'value'=> set_value('lastname',$lastname));
$f_email	= array('id'=>'f_email', 'class'=>'input', 'name'=>'email', 'value'=>set_value('email',$email));
$f_phone	= array('id'=>'f_phone', 'class'=>'input', 'name'=>'phone', 'value'=> set_value('phone',$phone));
$f_zip		= array('id'=>'f_zip', 'maxlength'=>'10', 'class'=>'bill input', 'name'=>'zip', 'value'=> set_value('zip',$zip));

echo form_input($f_id);

?>
<div id="form_error" class="error" style="display:none;"></div>
	<?php if ($addresses != NULL):?>
    	<input type="hidden" name="check_address" value="1"/>
    <?php else: ?>
    	<input type="hidden" name="check_address" value="0"/>
    <?php endif; ?>
	<div class="form_wrap">
		<!--<div>
			<?php echo lang('address_company');?><br/>
			<?php echo form_input($f_company);?>
		</div>-->
		<div>
			<?php echo lang('address_firstname');?><b class="r"> *</b><br/>
			<?php echo form_input($f_first);?>
		</div>
		<div>
			<?php echo lang('address_lastname');?><b class="r"> *</b><br/>
			<?php echo form_input($f_last);?>
		</div>
	</div>

	<div class="form_wrap">
		<div>
			<?php echo lang('address_email');?><b class="r"> *</b><br/>
			<?php echo form_input($f_email);?>
		</div>
		<div>
			<?php echo lang('address_phone');?><b class="r"> *</b><br/>
			<?php echo form_input($f_phone);?>
		</div>
	</div>

	<div class="form_wrap">
		<div>
			<?php echo lang('address');?><b class="r"> *</b><br/>
			<?php echo form_input($f_address1).'<br/>'.form_input($f_address2);?>
		</div>
	</div>		
	<div class="form_wrap">
		<div>
			Country<br/>
			<?php echo form_dropdown('country', array("Indonesia"=>"Indonesia","Malaysia"=>"Malaysia","Singapore"=>"Singapore"), set_value('country', $country), 'style="width:200px; display:block;" id="country_id" class="input"');?>
			<!--<select name="country" id="country_id">
				<option value="Indonesia">Indonesia</option>
				<option value="Malaysia">Malaysia</option>
				<option value="Singapore">Singapore</option>
			</select>-->
		</div>
    	<div>
			Province / City<br/>
			<?php echo form_dropdown('province_id', $provinces_menu, set_value('province_id', $province_id), 'style="width:200px; display:block;" id="f_province_id" class="input"');?>
		</div>
		<!--<div>
			Province<br/>
			<?php echo form_dropdown('province_id', $provinces_menu, set_value('province_id', $province_id), 'style="width:200px; display:block;" id="f_province_id" class="input"');?>
		</div>
		<div>
			City<br/>
			<?php echo form_dropdown('city_id', $cities_menu, set_value('province_id', $city_id), 'style="width:200px; display:block;" id="f_city_id" class="input"');?>
		</div>-->
        <div>
			Zip Code<br/>
			<?php echo form_input($f_zip);?>
		</div>
	</div>
	<div class="clear"></div>
	<div class="center">
		<input type="button" value="Submit" onclick="save_address(); return false;"/>
	</div>
	
<script type="text/javascript">

$(document).ready(function(){												
	$('#country_id').change(function(){
		$('#f_province_id').html("");
		$.post('<?php echo site_url('/places/get_jne_one_cities_menu');?>',{country:$('#country_id').val()}, function(data) {
		  $('#f_province_id').html(data);
		});

	});
});
/*$(function(){
	$('#f_province_id').change(function(){
		$.post('<?php echo site_url('cart/get_cities_menu');?>',{provinceId:$('#f_province_id').val()}, function(data) {
		  $('#f_city_id').html(data);
		});

	});
});*/

function save_address()
{
	$.post("<?php echo site_url('secure/address_form');?>/"+$('#f_id').val(), {	company: $('#f_company').val(),
																				firstname: $('#f_firstname').val(),
																				lastname: $('#f_lastname').val(),
																				email: $('#f_email').val(),
																				phone: $('#f_phone').val(),
																				address1: $('#f_address1').val(),
																				address2: $('#f_address2').val(),
																				country: $('#country_id').val(),
																				province_id: $('#f_province_id').val(),
																				city_id: $('#f_city_id').val(),
																				zip: $('#f_zip').val()
																				},
		function(data){
			if(data == 1)
			{
				window.location = "<?php echo site_url('secure/my_account');?>";
			}
			else
			{
				$('#form_error').show().html(data);
				//call resize twice to fix a wierd bug where the height is overcompensated
				$.fn.colorbox.resize();
			}
		});
}
</script>