<?php include('header.php'); ?>
<style type="text/css">
	.sortable { list-style-type: none; margin: 0; padding: 0; width: 100%; }
	.sortable li { margin: 0 3px 3px 3px; padding: 0.4em; padding-left: 1.5em; height: 18px; }
	.sortable li>span { position: absolute; margin-left: -1.3em; margin-top:.4em; }
</style>
<script type="text/javascript">
//<![CDATA[

$(document).ready(function() {
	$(".sortable").sortable();
	$(".sortable > span").disableSelection();
	//if the image already exists (phpcheck) enable the selector

	<?php if($id) : ?>
	//options related
	var ct	= $('#option_list').children().size();
	//create_sortable();
	set_accordion();
	
	// set initial count
	option_count = <?php echo count($product_options); ?>;
	
	<?php endif; ?>
	
	$( ".add_option" ).button().click(function(){
		add_option($(this).attr('rel'));
	});
	$( "#add_buttons" ).buttonset();
	
	photos_sortable();
});

function set_error(data){
	$('.error').html(data);
	$('.error').show();
}
function reset_error(){
	$('.error').html('');
	$('.error').hide();
}

function add_product_image(data)
{
	p	= data.split('.');
	
	var photo = '<?php add_image("'+p[0]+'", "'+p[0]+'.'+p[1]+'", '', '');?>';
	$('#gc_photos').append(photo);
	$('#gc_photos').sortable('destroy');
	photos_sortable();
	
	$('.button').button();
}

function remove_image(img)
{
	if(confirm('<?php echo lang('confirm_remove_image');?>'))
	{
		var id	= img.attr('rel')
		$('#gc_photo_'+id).remove();
	}
}

function photos_sortable()
{
	$('#gc_photos').sortable({	
		handle : '.gc_thumbnail',
		items: '.gc_photo',
		axis: 'y',
		scroll: true
	});
}

function add_option(type)
{
	
	if(jQuery.trim($('#option_name').val()) != '')
	{
		//increase option_count by 1
		option_count++;
		
		$('#options_accordion').append('<?php add_option("'+$('#option_name').val()+'", "'+option_count+'", "'+type+'");?>');
		
		
		//eliminate the add button if this is a text based option
		if(type == 'textarea' || type == 'textfield')
		{
			$('#add_item_'+option_count).remove();
			
		}
		
		add_item(type, option_count);
		
		//reset the option_name field
		$('#option_name').val('');
		reset_accordion();
		
	}
	else
	{
		alert('<?php echo lang('alert_must_name_option');?>');
	}
	
}

function add_item(type, id)
{
	
	var count = $('#option_items_attr_'+id+'>li').size()+1;
	append_html = '';
	
	if(type!='textfield' && type != 'textarea')
	{
		append_html = append_html + '<li id="value-'+id+'-'+count+'"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span><a onclick="if(confirm(\'<?php echo lang('confirm_remove_value');?>\')) $(\'#value-'+id+'-'+count+'\').remove()" class="ui-state-default ui-corner-all" style="float:right;"><span class="ui-icon ui-icon-circle-minus"></span></a>';
	}
	
	append_html += '<div style="margin:2px"><span><?php echo lang('name');?>: </span> <input class="req gc_tf2" type="text" name="option['+id+'][values]['+count+'][name]" value="" /> '+
	'<span><?php //echo lang('value');?>: </span> <input class="req gc_tf2" type="hidden" name="option['+id+'][values]['+count+'][value]" value="" /> '+
	'<span><?php //echo lang('weight');?>: </span> <input class="req gc_tf2" type="hidden" name="option['+id+'][values]['+count+'][weight]" value="" /> '+
	'<span><?php echo 'Qty';?>: </span> <input class="req gc_tf2" type="text" name="option['+id+'][values]['+count+'][qty]" value="" /> '+
	'<span><?php //echo lang('price');?>: </span> <input class="req gc_tf2" type="hidden" name="option['+id+'][values]['+count+'][price]" value="" />';

	if(type == 'textfield')
	{
		append_html += ' <span><?php echo lang('limit');?>: </span> <input class="req gc_tf2" type="text" name="option['+id+'][values]['+count+'][limit]" value="" />';
	}

	append_html += '</div> ';
	
	if(type!='textfield' && type != 'textarea')
	{
		append_html += '</li>';
	}
	
	
	$('#option_items_attr_'+id).append(append_html);	
	
	$(".sortable").sortable();
	$(".sortable > span").disableSelection();
	
	
}

function add_specs(type, id)
{
	
	var count = $('#option_items_'+id+'>li').size()+1;
	
	append_html = '';
	
	append_html = append_html + '<li id="value-'+id+'-'+count+'"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span><a onclick="if(confirm(\'<?php echo lang('confirm_remove_value');?>\')) $(\'#value-'+id+'-'+count+'\').remove()" class="ui-state-default ui-corner-all" style="float:right;"><span class="ui-icon ui-icon-circle-minus"></span></a>';
	
	append_html += '<div style="margin:2px"><span><?php echo lang('name');?>: </span> <input class="req gc_tf2" type="text" name="specsName[]" value="" /> '+
	'<span><?php echo lang('value');?>: </span> <input class="req gc_tf2" type="text" name="specsValue[]" value="" /> <input class="req gc_tf2" type="hidden" name="option['+id+'][values]['+count+'][value]" value="" /> ';

	append_html += '</div> ';
	
	$('#option_items_'+id).append(append_html);	
	
	$(".sortable").sortable();
	$(".sortable > span").disableSelection();
	
	
}

function remove_option(id)
{
	if(confirm('<?php echo lang('confirm_remove_option');?>'))
	{
		$('#option-'+id).remove();
		
		option_count --;
		
		reset_accordion();
	}
}

function reset_accordion()
{
	$( "#options_accordion" ).accordion('destroy');
	$('.option_item_form').sortable('destroy');
	set_accordion();
}

function set_accordion(){
	
	var stop = false;
	$( "#options_accordion h3" ).click(function( event ) {
		if ( stop ) {
			event.stopImmediatePropagation();
			event.preventDefault();
			stop = false;
		}
	});
	
	$( "#options_accordion" ).accordion({
		autoHeight: false,
		active: option_count-1,
		header: "> div > h3"
	}).sortable({
		axis: "y",
		handle: "h3",
		stop: function() {
			stop = true;
		}
	});
	

	$('.option_item_form').sortable({
		axis: 'y',
		handle: 'span',
		stop: function() {
			stop = true;
		}
	});
	
	
}
function delete_product_option(id)
{
	//remove the option if it exists. this function is also called by the lightbox when an option is deleted
	$('#options-'+id).remove();
}
//]]>
</script>

<?php
//$enable = $sale_enable_on;
//$disable = $sale_disable_on;
$enable = "2015-07-16";
$disable = "2050-07-16";
$sale_enable_on = "2015-07-16";
$sale_disable_on = "2050-07-16";
if($new==0)
$checkNewDIsable =  "disabled";
else
$checkNewDIsable="";
if($sale==0)
$checkSaleDisable = "";
//$checkSaleDisable = "disabled";
else
$checkSaleDisable = "";

$sale_enable_on		= array('class'=>'gc_tf1', $checkSaleDisable=>"", 'name'=>'sale_enable_on', 'id'=>'sale_enable_on', 'value' => set_value('sale_enable_on', reverse_format($sale_enable_on)));
$sale_disable_on		= array('class'=>'gc_tf1', $checkSaleDisable=>"", 'name'=>'sale_disable_on', 'id'=>'sale_disable_on', 'value' => set_value('sale_disable_on', reverse_format($sale_disable_on)));
?>
<?php echo form_open($this->config->item('admin_folder').'/products/form/'.$id, 'id="product_form " name="product"'); ?>
<div class="button_set">
	<input name="submit" type="submit" value="Save Product" />
</div>

<div id="gc_tabs">
	<ul>
		<li><a href="#gc_product_info"><?php echo lang('description');?></a></li>
		<li><a href="#gc_product_details">Details</a></li>
		<li><a href="#gc_product_specs" style="display: none">Specs</a></li>
		<li><a href="#gc_product_categories"><?php echo lang('categories');?></a></li>
		<li><a href="#gc_product_downloads"><?php echo lang('digital_content');?></a></li>
		<li><a href="#gc_product_seo"><?php echo lang('seo');?></a></li>
		<li><a href="#gc_product_attributes" style="display: none">Attributes</a></li>
		<li><a href="#gc_product_options"><?php echo lang('options');?></a></li>
		<li><a href="#gc_product_related"><?php echo lang('related_products');?></a></li>
		<li><a href="#gc_product_photos"><?php echo lang('images');?></a></li>
	</ul>
	
	<div id="gc_product_info">
		<div class="gc_field">
		<?php
		$data	= array('id'=>'name', 'name'=>'name', 'value'=>set_value('name', $name), 'class'=>'gc_tf1');
		echo form_input($data);
		?>
		</div>
			
		<div class="gc_field gc_tinymce">
		<?php
		$data	= array('id'=>'description', 'name'=>'description', 'class'=>'tinyMCE', 'value'=>set_value('description', $description));
		echo form_textarea($data);
		?>
		</div>
		<div class="button_set">
			<input type="button" onclick="toggleEditor('description'); return false;" value="Toggle WYSIWYG" />
		</div>
	</div>
	
	<div id="gc_product_specs" style="display: none">
		<div style="text-align: left">	
			<button id="add_item_0" type="button" rel="option-type" onclick="add_specs($(this).attr('rel'), 0);"><?php echo lang('add_item');?></button>
			<div class="option_item_form">
				<?php 
					$specs=json_decode($specs);
					if(!empty($specs)):
						
				?>
				<ul class="sortable" id="option_items_0">
					<?php $counterS = 1;?>
					<?php foreach($specs as $az):?>
						
						<li id="value-0-<?php echo $counterS;?>"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>
							<div  style="margin:2px">
								<span>Name: </span><input class="req gc_tf2" type="text" name="specsName[]" value="<?php echo $az->name?>" />
								<span>Value: </span><input class="req gc_tf2" type="text" name="specsValue[]" value="<?php echo $az->value?>" />
								<a onclick="if(confirm('<?php echo lang('confirm_remove_value');?>')) $('#value-0-<?php echo $counterS;?>').remove()" class="ui-state-default ui-corner-all" style="float:right;"><span class="ui-icon ui-icon-circle-minus"></span></a>
							</div>
						</li>
						<?php $counterS++;?>
					<?php endforeach;?>
				</ul>
				<?php else:?>
				<ul class="sortable" id="option_items_attr_0">
					<li id="value-0-0"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>
						<div  style="margin:2px">
							<span>Name: </span><input class="req gc_tf2" type="text" name="specsName[]" value="Brand" />
							<span>Value: </span><input class="req gc_tf2" type="text" name="specsValue[]" value="" />
							<a onclick="if(confirm('<?php echo lang('confirm_remove_value');?>')) $('#value-0-0').remove()" class="ui-state-default ui-corner-all" style="float:right;"><span class="ui-icon ui-icon-circle-minus"></span></a>
						</div>
					</li>
					<li id="value-0-1"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>
						<div  style="margin:2px">
							<span>Name: </span><input class="req gc_tf2" type="text" name="specsName[]" value="Model Number" />
							<span>Value: </span><input class="req gc_tf2" type="text" name="specsValue[]" value="" />
							<a onclick="if(confirm('<?php echo lang('confirm_remove_value');?>')) $('#value-0-1').remove()" class="ui-state-default ui-corner-all" style="float:right;"><span class="ui-icon ui-icon-circle-minus"></span></a>
						</div>
					</li>
					<li id="value-0-2"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>
						<div  style="margin:2px">
							<span>Name: </span><input class="req gc_tf2" type="text" name="specsName[]" value="Series" />
							<span>Value: </span><input class="req gc_tf2" type="text" name="specsValue[]" value="" />
							<a onclick="if(confirm('<?php echo lang('confirm_remove_value');?>')) $('#value-0-2').remove()" class="ui-state-default ui-corner-all" style="float:right;"><span class="ui-icon ui-icon-circle-minus"></span></a>
						</div>
					</li>
					<li id="value-0-3"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>
						<div  style="margin:2px">
							<span>Name: </span><input class="req gc_tf2" type="text" name="specsName[]" value="Gender" />
							<span>Value: </span><input class="req gc_tf2" type="text" name="specsValue[]" value="" />
							<a onclick="if(confirm('<?php echo lang('confirm_remove_value');?>')) $('#value-0-3').remove()" class="ui-state-default ui-corner-all" style="float:right;"><span class="ui-icon ui-icon-circle-minus"></span></a>
						</div>
					</li>
					<li id="value-0-4"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>
						<div  style="margin:2px">
							<span>Name: </span><input class="req gc_tf2" type="text" name="specsName[]" value="Movement" />
							<span>Value: </span><input class="req gc_tf2" type="text" name="specsValue[]" value="" />
							<a onclick="if(confirm('<?php echo lang('confirm_remove_value');?>')) $('#value-0-4').remove()" class="ui-state-default ui-corner-all" style="float:right;"><span class="ui-icon ui-icon-circle-minus"></span></a>
						</div>
					</li>
					<li id="value-0-5"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>
						<div  style="margin:2px">
							<span>Name: </span><input class="req gc_tf2" type="text" name="specsName[]" value="Caliber" />
							<span>Value: </span><input class="req gc_tf2" type="text" name="specsValue[]" value="" />
							<a onclick="if(confirm('<?php echo lang('confirm_remove_value');?>')) $('#value-0-5').remove()" class="ui-state-default ui-corner-all" style="float:right;"><span class="ui-icon ui-icon-circle-minus"></span></a>
						</div>
					</li>
					<li id="value-0-6"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>
						<div  style="margin:2px">
							<span>Name: </span><input class="req gc_tf2" type="text" name="specsName[]" value="Glass" />
							<span>Value: </span><input class="req gc_tf2" type="text" name="specsValue[]" value="" />
							<a onclick="if(confirm('<?php echo lang('confirm_remove_value');?>')) $('#value-0-6').remove()" class="ui-state-default ui-corner-all" style="float:right;"><span class="ui-icon ui-icon-circle-minus"></span></a>
						</div>
					</li>
					<li id="value-0-7"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>
						<div  style="margin:2px">
							<span>Name: </span><input class="req gc_tf2" type="text" name="specsName[]" value="Case Diameter" />
							<span>Value: </span><input class="req gc_tf2" type="text" name="specsValue[]" value="" />
							<a onclick="if(confirm('<?php echo lang('confirm_remove_value');?>')) $('#value-0-7').remove()" class="ui-state-default ui-corner-all" style="float:right;"><span class="ui-icon ui-icon-circle-minus"></span></a>
						</div>
					</li>
					<li id="value-0-8"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>
						<div  style="margin:2px">
							<span>Name: </span><input class="req gc_tf2" type="text" name="specsName[]" value="Case Thickness" />
							<span>Value: </span><input class="req gc_tf2" type="text" name="specsValue[]" value="" />
							<a onclick="if(confirm('<?php echo lang('confirm_remove_value');?>')) $('#value-0-8').remove()" class="ui-state-default ui-corner-all" style="float:right;"><span class="ui-icon ui-icon-circle-minus"></span></a>
						</div>
					</li>
					<li id="value-0-9"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>
						<div  style="margin:2px">
							<span>Name: </span><input class="req gc_tf2" type="text" name="specsName[]" value="Caseback" />
							<span>Value: </span><input class="req gc_tf2" type="text" name="specsValue[]" value="" />
							<a onclick="if(confirm('<?php echo lang('confirm_remove_value');?>')) $('#value-0-9').remove()" class="ui-state-default ui-corner-all" style="float:right;"><span class="ui-icon ui-icon-circle-minus"></span></a>
						</div>
					</li>
					<li id="value-0-10"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>
						<div  style="margin:2px">
							<span>Name: </span><input class="req gc_tf2" type="text" name="specsName[]" value="Band Material" />
							<span>Value: </span><input class="req gc_tf2" type="text" name="specsValue[]" value="" />
							<a onclick="if(confirm('<?php echo lang('confirm_remove_value');?>')) $('#value-0-10').remove()" class="ui-state-default ui-corner-all" style="float:right;"><span class="ui-icon ui-icon-circle-minus"></span></a>
						</div>
					</li>
					<li id="value-0-11"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>
						<div  style="margin:2px">
							<span>Name: </span><input class="req gc_tf2" type="text" name="specsName[]" value="Buckle" />
							<span>Value: </span><input class="req gc_tf2" type="text" name="specsValue[]" value="" />
							<a onclick="if(confirm('<?php echo lang('confirm_remove_value');?>')) $('#value-0-11').remove()" class="ui-state-default ui-corner-all" style="float:right;"><span class="ui-icon ui-icon-circle-minus"></span></a>
						</div>
					</li>
					<li id="value-0-12"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>
						<div  style="margin:2px">
							<span>Name: </span><input class="req gc_tf2" type="text" name="specsName[]" value="Dial Color" />
							<span>Value: </span><input class="req gc_tf2" type="text" name="specsValue[]" value="" />
							<a onclick="if(confirm('<?php echo lang('confirm_remove_value');?>')) $('#value-0-12').remove()" class="ui-state-default ui-corner-all" style="float:right;"><span class="ui-icon ui-icon-circle-minus"></span></a>
						</div>
					</li>
					<li id="value-0-13"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>
						<div  style="margin:2px">
							<span>Name: </span><input class="req gc_tf2" type="text" name="specsName[]" value="Calendar" />
							<span>Value: </span><input class="req gc_tf2" type="text" name="specsValue[]" value="" />
							<a onclick="if(confirm('<?php echo lang('confirm_remove_value');?>')) $('#value-0-13').remove()" class="ui-state-default ui-corner-all" style="float:right;"><span class="ui-icon ui-icon-circle-minus"></span></a>
						</div>
					</li>
					<li id="value-0-14"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>
						<div  style="margin:2px">
							<span>Name: </span><input class="req gc_tf2" type="text" name="specsName[]" value="Special Features" />
							<span>Value: </span><input class="req gc_tf2" type="text" name="specsValue[]" value="" />
							<a onclick="if(confirm('<?php echo lang('confirm_remove_value');?>')) $('#value-0-14').remove()" class="ui-state-default ui-corner-all" style="float:right;"><span class="ui-icon ui-icon-circle-minus"></span></a>
						</div>
					</li>
					<li id="value-0-15"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>
						<div  style="margin:2px">
							<span>Name: </span><input class="req gc_tf2" type="text" name="specsName[]" value="Crown" />
							<span>Value: </span><input class="req gc_tf2" type="text" name="specsValue[]" value="" />
							<a onclick="if(confirm('<?php echo lang('confirm_remove_value');?>')) $('#value-0-15').remove()" class="ui-state-default ui-corner-all" style="float:right;"><span class="ui-icon ui-icon-circle-minus"></span></a>
						</div>
					</li>
					<li id="value-0-16"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>
						<div  style="margin:2px">
							<span>Name: </span><input class="req gc_tf2" type="text" name="specsName[]" value="Water resistant depth" />
							<span>Value: </span><input class="req gc_tf2" type="text" name="specsValue[]" value="" />
							<a onclick="if(confirm('<?php echo lang('confirm_remove_value');?>')) $('#value-0-16').remove()" class="ui-state-default ui-corner-all" style="float:right;"><span class="ui-icon ui-icon-circle-minus"></span></a>
						</div>
					</li>
					<li id="value-0-17"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>
						<div  style="margin:2px">
							<span>Name: </span><input class="req gc_tf2" type="text" name="specsName[]" value="Weight after packing" />
							<span>Value: </span><input class="req gc_tf2" type="text" name="specsValue[]" value="" />
							<a onclick="if(confirm('<?php echo lang('confirm_remove_value');?>')) $('#value-0-17').remove()" class="ui-state-default ui-corner-all" style="float:right;"><span class="ui-icon ui-icon-circle-minus"></span></a>
						</div>
					</li>
					<li id="value-0-18" style="height: 100px"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>
						<div  style="margin:2px">
							<span>Name: </span><input class="req gc_tf2" type="text" name="specsName[]" value="What's Inside Box" />
							<span>Value: </span>
							<textarea rows="4" cols="50" name="specsValue[]"></textarea>
							<!--<input class="req gc_tf2" type="text" name="specsValue[]" value="" />-->
							<a onclick="if(confirm('<?php echo lang('confirm_remove_value');?>')) $('#value-0-18').remove()" class="ui-state-default ui-corner-all" style="float:right;"><span class="ui-icon ui-icon-circle-minus"></span></a>
						</div>
					</li>
				</ul>
				<?php
					endif;
				?>
			</div>
		</div>
	</div>
	
	<div id="gc_product_details">
		<div class="gc_field2">
		<label for="sku"><?php echo lang('sku');?> </label>
		<?php
		$data	= array('id'=>'sku', 'name'=>'sku', 'value'=>set_value('sku', $sku), 'class'=>'gc_tf1');
		echo form_input($data);
		?>
		</div>
		<div class="gc_field2">
		<label for="store">Store</label>
		<?php
		print_r($stores_option);
		echo form_dropdown('stores', $stores_option, set_value('stores',$stores), 'id="stores"');
		?>
		</div>
		<div class="gc_field2">
		<label for="price"><?php echo lang('price');?> </label>
		<?php
		$data	= array('id'=>'price', 'name'=>'price', 'value'=>set_value('price', $price), 'class'=>'gc_tf1');
		echo form_input($data);
		?>
		</div>
        <script>
			<!--
			function enableob(o) { eval(o+".disabled = false"); }
			function disableob(o) { eval(o+".disabled = true"); }
			function toggleform(formstr,chkobstr,obstr) {
			var checked = eval(formstr+"."+chkobstr+".checked");
			var obs = obstr.split(",");
			  for (i = 0; i < obs.length; i++) {
			  obs[i] = formstr+"."+obs[i];
			  }
			  if (checked == false) {
				for (i = 0; i < obs.length; i++) {
				disableob(obs[i]);
				}
			  }
			  else {
				for (i = 0; i < obs.length; i++) {
				enableob(obs[i]);
				}
			  }
			}
			function getPrice(){
				document.getElementById("saleprice1").value=document.getElementById("saleprice").value;
			}
			-->
		</script>
        <div class="gc_field2">
			<label for="new">Featured Product<input type="checkbox" name="featured" value="1" <?php if($featured==1)echo "checked"?>/></label>
        	<label for="new">New Product<input type="checkbox" name="new" value="1" <?php if($new==1)echo "checked"?>/></label>
        	<label for="sale">Sale Product<input type="checkbox" checked name="sale" value="1" onclick="toggleform('document.product','sale','saleprice,sale_enable_on,sale_disable_on')" <?php //if($sale==1) echo "checked"?>/></label>
        </div>
		<div class="gc_field2">
		<label for="price"><?php echo lang('saleprice');?> </label>
		<?php
		$data	= array('id'=>'saleprice', $checkSaleDisable=>"", 'name'=>'saleprice', 'value'=>set_value('saleprice', $saleprice), 'class'=>'gc_tf1', 'onChange'=>'getPrice()');
		echo form_input($data);
		?>
        <input type="hidden" name="saleprice1" id="saleprice1" value="<?php echo set_value('saleprice1', $saleprice) ?>" />
		</div>
        <div class="gc_field2">
			<label for="enable_on"><?php echo "Sale Enable On";?> </label>
			<?php echo form_input($sale_enable_on); ?>
			<input type="hidden" name="enable_on_alt" id="enable_on_alt" value="<?php echo set_value('sale_enable_on', $enable) ?>" />
		</div>

		<div class="gc_field2">
			<label for="disable_on"><?php echo "Sale Disable On";?> </label>
			<?php echo form_input($sale_disable_on); ?>
			<input type="hidden" name="disable_on_alt" id="disable_on_alt" value="<?php echo set_value('sale_disable_on', $disable) ?>" />
		</div>
		<div class="gc_field2">
		<label for="weight"><?php echo lang('weight');?> </label>
		<?php
		$data	= array('id'=>'weight', 'name'=>'weight', 'value'=>set_value('weight', $weight), 'class'=>'gc_tf1');
		echo form_input($data);
		?>
		</div>
		<div class="gc_field2">
		<label for="slug"><?php echo lang('slug');?> </label>
		<?php
		$data	= array('id'=>'slug', 'name'=>'slug', 'value'=>set_value('slug', $slug), 'class'=>'gc_tf1');
		echo form_input($data);
		?>
		</div>
        <div class="gc_field2">
		<label for="slug"><?php echo lang('track_stock');?> </label>
		<?php
		 	$options = array(	 '1'	=> lang('track_stock')
								,'0'	=> lang('do_not_track_stock')
								);
			echo form_dropdown('track_stock', $options, set_value('track_stock',$track_stock), 'id="track_stock"');
		?>
		</div>
		<div class="gc_field2">
		<label for="quantity"><?php echo lang('quantity');?> </label>
		<?php
		$data	= array('id'=>'quantity', 'name'=>'quantity', 'value'=>set_value('quantity', $quantity), 'class'=>'gc_tf1');
		echo form_input($data);
		?><small><?php echo lang('quantity_in_stock_note');?></small>
		</div>
		<div class="gc_field2" style="display: none">
		<label for="slug"><?php echo lang('shippable');?> </label>
		<?php
		$options = array(	 '1'	=> lang('yes')
							,'0'	=> lang('no')
							);
			echo form_dropdown('shippable', $options, set_value('shippable',$shippable));
		?>
		</div>
		<div class="gc_field2" style="display: none">
		<label for="slug"><?php echo lang('fixed_quantity');?> </label>
		<?php
		 	$options = array(	'0'	=> lang('no'), 
								'1'	=> lang('yes')
								);
			echo form_dropdown('fixed_quantity', $options, set_value('fixed_quantity',$fixed_quantity));
		?> <small><?php echo lang('fixed_quantity_note');?></small>
		</div>
		<div class="gc_field2" style="display: none">
		<label for="slug"><?php echo lang('taxable');?> </label>
		<?php
		$options = array(	'0'	=> lang('no'), 
							'1'	=> lang('yes')
							);
			echo form_dropdown('taxable', $options, set_value('taxable',$taxable));
		?>
		</div>
		<div class="gc_field2">
		<label for="slug"><?php echo lang('enabled');?> </label>
		<?php
		 	$options = array(	 '1'	=> lang('yes')
								,'0'	=> lang('no')
								);
			echo form_dropdown('enabled', $options, set_value('enabled',$enabled));
		?>
		</div>
		<div class="gc_field">
		<label><?php echo lang('excerpt');?></label>
		<?php
		$data	= array('id'=>'excerpt', 'name'=>'excerpt', 'value'=>set_value('excerpt', $excerpt), 'class'=>'gc_tf1');
		echo form_textarea($data);
		?>
        
      
		</div>
	</div>
		 
	<div id="gc_product_categories">
		<table class="gc_table" cellspacing="0" cellpadding="0">
		    <thead>
				<tr>
					<th class="gc_cell_left" style="text-align:left"><?php echo lang('name');?></th>
					<th class="gc_cell_right"></th>
				</tr>
			</thead>
			<tbody>
				<?php
				define('ADMIN_FOLDER', $this->config->item('admin_folder'));
				function list_categories($cats, $product_categories, $sub='') {
					
					foreach ($cats as $cat):?>
					<tr class="gc_row">
						<td><?php echo  $sub.$cat['category']->name; ?></td>
						<td style="text-align:right">
							<?php if($cat['category']->parent_id == 0) $parent_id = $cat['category']->id; else $parent_id = $cat['category']->parent_id;?>
							<input type="checkbox" name="categories[]" value="<?php echo $cat['category']->id.".".$parent_id;?>" <?php echo (in_array($cat['category']->id, $product_categories))?'checked="checked"':'';?>/>
						</td>
					</tr>
					<?php
					if (sizeof($cat['children']) > 0)
					{
						$sub2 = str_replace('&rarr;&nbsp;', '&nbsp;', $sub);
							$sub2 .=  '&nbsp;&nbsp;&nbsp;&rarr;&nbsp;';
						list_categories($cat['children'], $product_categories, $sub2);
					}
					endforeach;
				}

				list_categories($categories, $product_categories);
				?>
			</tbody>
		</table>
	</div>
	
	<div id="gc_product_downloads">
		<?php echo lang('digital_products_desc') ?>
		<table class="gc_table" cellspacing="0" cellpadding="0">
				<thead>
					<tr>
						<th class="gc_cell_left"><?php echo lang('filename');?></th>
						<th><?php echo lang('title');?></th>
						<th style="width:70px;"><?php echo lang('size');?></th>
						
						<th class="gc_cell_right"></th>
					</tr>
				</thead>
				<tbody>
				<?php echo (count($file_list) < 1)?'<tr><td style="text-align:center;" colspan="6">'.lang('no_files').'</td></tr>':''?>
				<?php foreach ($file_list as $file):?>
					<tr>
						<td class="gc_cell_left"><?php echo $file->filename ?></td>
						<td><?php echo $file->title ?></td>
						<td><?php echo $file->size ?></td>
						<td><?php echo form_checkbox('downloads[]', $file->id, in_array($file->id, $product_files)); ?></td>
					</tr>
				<?php endforeach; ?>
				</tbody>
		</table>

	</div>
	
	<div id="gc_product_seo">
		<div class="gc_field2">
		<label for="seo_title"><?php echo lang('seo_title');?> </label>
		<?php
		$data	= array('id'=>'seo_title', 'name'=>'seo_title', 'value'=>set_value('seo_title', $seo_title), 'class'=>'gc_tf1');
		echo form_input($data);
		?>
		</div>
		
		<div class="gc_field">
		<label><?php echo lang('meta');?></label> <small><?php echo lang('meta_example');?></small>
		<?php
		$data	= array('id'=>'meta', 'name'=>'meta', 'value'=>set_value('meta', html_entity_decode($meta)), 'class'=>'gc_tf1');
		echo form_textarea($data);
		?>
		</div>
	</div>
	
	<div id="gc_product_attributes" style="display: none">
		<iframe src="<?php echo site_url($this->config->item('admin_folder').'/products/product_attribute_form/'.$id);?>" style="border: 0; width: 500px; height: 500px;">
			</iframe>
	</div>

	<div id="gc_product_options">
	
		
		<div id="selected_options" class="option_form">
			
				<span id="add_buttons" style="float:right;">
					<input class="gc_tf2" id="option_name" style="width:200px;" type="text" name="option_name" />
					<button type="button" class="add_option" rel="checklist"><?php echo lang('checklist');?></button>
					<!--<button type="button" class="add_option" rel="radiolist"><?php echo lang('radiolist');?></button>
					<button type="button" class="add_option" rel="textfield"><?php echo lang('textfield');?></button>
					<button type="button" class="add_option" rel="textarea"><?php echo lang('textarea');?></button>
					
					<button type="button" class="add_option" rel="droplist"><?php echo lang('droplist');?></button>-->
				</span>

			<br style="clear:both;"/>
			<div id="options_accordion">
			<?php 
				$count	= 0;
				if(!empty($product_options)):
					//print_r($product_options);
					foreach($product_options as $option):
						//print_r($option);
						$option	= (object)$option;
						
						if(empty($option->required))
						{
							$option->required = false;
						}
					?>
						<div id="option-<?php echo $count;?>">
							<h3><a href="#"><?php echo $option->type.' > '.$option->name; ?> </a></h3>
							
							<div style="text-align: left">
								<?php echo lang('option_name');?>
								
									<a style="float:right" onclick="remove_option(<?php echo $count ?>)" class="ui-state-default ui-corner-all" ><span class="ui-icon ui-icon-circle-minus"></span></a>
								<input class="input gc_tf2" type="hidden" name="option[<?php echo $count;?>][id]" value="<?php echo $option->id;?>"/>
								<input class="input gc_tf2" type="text" name="option[<?php echo $count;?>][name]" value="<?php echo $option->name;?>"/>
								
								<input type="hidden" name="option[<?php echo $count;?>][type]" value="<?php echo $option->type;?>" />
								<input class="checkbox" type="checkbox" name="option[<?php echo $count;?>][required]" value="1" <?php echo ($option->required)?'checked="checked"':'';?>/> <?php echo lang('required');?>
								
								<?php if($option->type!='textarea' && $option->type!='textfield') { ?>
								<button id="add_item_<?php echo $count;?>" type="button" rel="<?php echo $option->type;?>"onclick="add_item($(this).attr('rel'), <?php echo $count;?>);"><?php echo lang('add_item');?></button>
								<?php } ?>
								
								
								<div class="option_item_form">
								<?php if($option->type!='textarea' && $option->type!='textfield') { ?><ul class="sortable" id="option_items_attr_<?php echo $count;?>"><?php } ?>
								<?php if(!empty($option->values))
											$valcount = 0;
											foreach($option->values as $value) : 
												$value = (object)$value;?>
									
										<?php if($option->type!='textarea' && $option->type!='textfield') { ?><li id="value-<?php echo $count;?>-<?php echo $valcount;?>"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span><?php } ?>
										<div  style="margin:2px"><span><?php echo lang('name');?> </span><input class="req gc_tf2" type="text" name="option[<?php echo $count;?>][values][<?php echo $valcount ?>][name]" value="<?php echo $value->name ?>" />
										<input class="req gc_tf2" type="hidden" name="option[<?php echo $count;?>][values][<?php echo $valcount ?>][id]" value="<?php echo $value->id ?>" />
										<span><?php //echo lang('value');?> </span><input class="req gc_tf2" type="hidden" name="option[<?php echo $count;?>][values][<?php echo $valcount ?>][value]" value="<?php echo $value->value ?>" />
										<span><?php //echo lang('weight');?> </span><input class="req gc_tf2" type="hidden" name="option[<?php echo $count;?>][values][<?php echo $valcount ?>][weight]" value="<?php echo $value->weight ?>" />
                                        <span><?php echo "Qty";?> </span><input class="req gc_tf2" type="text" name="option[<?php echo $count;?>][values][<?php echo $valcount ?>][qty]" value="<?php echo $value->qty ?>" />
										<span><?php //echo lang('price');?> </span><input class="req gc_tf2" type="hidden" name="option[<?php echo $count;?>][values][<?php echo $valcount ?>][price]" value="<?php echo $value->price ?>" />
										<?php if($option->type == 'textfield'):?>
										
										<span><?php echo lang('limit');?> </span><input class="req gc_tf2" type="text" name="option[<?php echo $count;?>][values][<?php echo $valcount ?>][limit]" value="<?php echo $value->limit ?>" />

										<?php endif;?>
										<?php if($option->type!='textarea' && $option->type!='textfield') { ?>
										<a onclick="if(confirm('<?php echo lang('confirm_remove_value');?>')) $('#value-<?php echo $count;?>-<?php echo $valcount;?>').remove()" class="ui-state-default ui-corner-all" style="float:right;"><span class="ui-icon ui-icon-circle-minus"></span></a>
										<?php } ?>
										</div>
										<?php if($option->type!='textarea' && $option->type!='textfield') { ?>
										</li>
										<?php } ?>
										
									
								<?php	$valcount++;
								 		endforeach;  ?>
								 <?php if($option->type!='textarea' && $option->type!='textfield') { ?></ul><?php } ?>
								</div>
								
								
							</div>
						</div>

					<?php 
					
					
					$count++; 
					endforeach;
				endif;
				?>
				
				</div>
		</div>
	</div>
	<div id="gc_product_related">
		<div class="gc_field">
			<label><?php echo lang('select_a_product')?>: </label>
			<select id="product_list">
			<?php foreach($product_list as $p): if(!empty($p) && $id != $p->id):?>
				<option id="product_item_<?php echo $p->id;?>" value="<?php echo $p->id; ?>"><?php echo $p->name;?></option>
			<?php endif; endforeach;?>
			</select>
			
			<a href="#" onclick="add_related_product();return false;" class="button" title="Add Related Product"><?php echo lang('add_related_product');?></a>
		</div>
		<?php 
		
		$products = array();
		foreach($product_list as $p)
		{
			$products[$p->id] = $p->name;
		}
		
		?>
		<table class="gc_table" cellspacing="0" cellpadding="0">
			<thead>
				<tr>
					<th class="gc_cell_left"><?php echo lang('product_name');?></th>
					<th class="gc_cell_right"></th>
				</tr>
			</thead>
			<tbody id="product_items_container">
			<?php if(!empty($related_products)):foreach($related_products as $rel): if(!empty($rel)) :?>
				<?php 
					if(array_key_exists($rel, $products))
					{
						echo related_items($rel, $products[$rel]);
					}
				?>
			<?php endif; endforeach; endif;?>
			</tbody>
		</table>
	</div>
	<div id="gc_product_photos">
		<div class="gc_segment_content">
			<iframe src="<?php echo site_url($this->config->item('admin_folder').'/products/product_image_form');?>" style="height:120px; border:0px;">
			</iframe>
			<div id="gc_photos">
			<span class="error" style="color: red; display: none"></span>
			<?php
			
			foreach($images as $photo_id=>$photo_obj)
			{
				if(!empty($photo_obj))
				{
					$photo = (array)$photo_obj;
					add_image($photo_id, $photo['filename'], $photo['alt'], $photo['caption'], isset($photo['primary']));
				}
				
			}
			?>
			</div>
		</div>
	</div>
</div>

</form>

<?php
function add_image($photo_id, $filename, $alt, $caption, $primary=false)
{	ob_start();
	?>
	<div class="gc_photo" id="gc_photo_<?php echo $photo_id;?>">
		<table cellspacing="0" cellpadding="0">
			<tr>
				<td style="width:81px;padding-right:10px;" rowspan="2">
					<input type="hidden" name="images[<?php echo $photo_id;?>][filename]" value="<?php echo $filename;?>"/>
					<img class="gc_thumbnail" width="200" src="<?php echo base_url('uploads/product/thumb/'.$filename);?>"/>
				</td>
				<td>
					<input type="radio" name="primary_image" value="<?php echo $photo_id;?>" <?php if($primary) echo 'checked="checked"';?>/> <?php echo lang('primary');?>
					
					<a onclick="return remove_image($(this));" rel="<?php echo $photo_id;?>" class="button" style="float:right; font-size:9px;"><?php echo lang('remove');?></a>
				</td>
			</tr>
			<tr>
				<td>
					<table>
						<tr>
							<td><?php echo lang('alt_tag');?></td>
							<td><input name="images[<?php echo $photo_id;?>][alt]" value="<?php echo $alt;?>" class="gc_tf2"/></td>
						</tr>
						<tr>
							<td><?php echo lang('caption');?></td>
							<td><textarea name="images[<?php echo $photo_id;?>][caption]"><?php echo $caption;?></textarea></td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
	</div>
	<?php
	$stuff = ob_get_contents();

	ob_end_clean();
	
	echo replace_newline($stuff);
}

function add_option($name, $option_id, $type)
{
	ob_start();
	?>
	<div id="option-<?php echo $option_id;?>">
		<h3><a href="#"><?php echo $type.' > '.$name; ?></a></h3>
		<div style="text-align: left">
			<?php echo lang('option_name');?>
			<span style="float:right">
			
			<a onclick="remove_option(<?php echo $option_id ?>)" class="ui-state-default ui-corner-all" style="float:right;"><span class="ui-icon ui-icon-circle-minus"></span></a></span>
			<input class="input gc_tf1" type="text" name="option[<?php echo $option_id;?>][name]" value="<?php echo $name;?>"/>
			<input type="hidden" name="option[<?php echo $option_id;?>][type]" value="<?php echo $type;?>" />
			<input class="checkbox" type="checkbox" name="option[<?php echo $option_id;?>][required]" value="1"/> <?php echo lang('required');?>
			
	
			<button id="add_item_<?php echo $option_id;?>" type="button" rel="<?php echo $type;?>"onclick="add_item($(this).attr(\'rel\'), <?php echo $option_id;?>);"><?php echo lang('add_item');?></button>
		  
			<div class="option_item_form" >
				<ul class="sortable" id="option_items_attr_<?php echo $option_id;?>">
				
				</ul>
			</div>
		</div>
	</div>
	<?php
	$stuff = ob_get_contents();

	ob_end_clean();
	
	echo replace_newline($stuff);
}
//this makes it easy to use the same code for initial generation of the form as well as javascript additions
function replace_newline($string) {
  return (string)str_replace(array("\r", "\r\n", "\n", "\t"), ' ', $string);
}
?>
<script type="text/javascript">
//<![CDATA[

var option_count	= $('#options_accordion>h3').size();
	
var count = <?php echo $count;?>;

function add_related_product()
{

	//if the related product is not already a related product, add it
	if($('#related_product_'+$('#product_list').val()).length == 0 && $('#product_list').val() != null)
	{
		<?php $new_item	 = str_replace(array("\n", "\t", "\r"),'',related_items("'+$('#product_list').val()+'", "'+$('#product_item_'+$('#product_list').val()).html()+'"));?>
		var related_product = '<?php echo $new_item;?>';
		$('#product_items_container').append(related_product);
		$('.list_buttons').buttonset();
	}
	else
	{
		if($('#product_list').val() == null)
		{
			alert('<?php echo lang('alert_select_product');?>');
		}
		else
		{
			alert('<?php echo lang('alert_product_related');?>');
		}
	}
}

function remove_related_product(id)
{
	if(confirm('<?php echo lang('confirm_remove_related');?>?'))
	{
		$('#related_product_'+id).remove();
	}
}

function photos_sortable()
{
	$('#gc_photos').sortable({	
		handle : '.gc_thumbnail',
		items: '.gc_photo',
		axis: 'y',
		scroll: true
	});
}

//]]>
</script>
<script type="text/javascript">
	$(document).ready(function() {
		//$("#sale_enable_on").datepicker({ dateFormat: 'mm-dd-yy', altField: '#enable_on_alt', altFormat: 'yy-mm-dd' });
		//$("#sale_disable_on").datepicker({ dateFormat: 'mm-dd-yy', altField: '#disable_on_alt', altFormat: 'yy-mm-dd' });
	});
</script>

<?php
function related_items($id, $name) {
	return '
			<tr id="related_product_'.$id.'" class="gc_row">
				<td class="gc_cell_left" >
					<input type="hidden" name="related_products[]" value="'.$id.'"/>
					'.$name.'</td>
				<td class="gc_cell_right list_buttons">
					<a href="#" onclick="remove_related_product('.$id.'); return false;">'.lang('remove').'</a>
				</td>
			</tr>
		';
 } ?>
<?php include('footer.php'); ?>