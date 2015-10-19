<?php include('header.php'); ?>

<?php 

echo form_open($this->config->item('admin_folder').'/attributes/attribute_detail_form/'.$attr_det_id.'?attribute_id='.$attribute_id); 



?>

<div class="button_set">
	<input type="button" value="Back" onclick="location.href='/<?php echo $this->config->item('admin_folder').'/attributes/view/'.$attr_det_id;?>'"/>
	<input type="submit" value="<?php echo lang('save');?>" />
</div>

<div id="gc_tabs">
	<ul>
		<li><a href="#gc_country_details"><?php echo lang('details');?></a></li>
	</ul>
	
	<div id="gc_attribute_details">
		<div class="gc_field2">
		<label>Description</label>
			<?php
			$data	= array('id'=>'Description', 'name'=>'description', 'value'=>set_value('description', $description), 'class'=>'gc_tf1');
			echo form_input($data);
			?>
		</div>
	</div>
	
</div>
</form>

<script type="text/javascript">
$(document).ready(function(){
	$("#gc_tabs").tabs();
});
</script>


<?php include('footer.php'); ?>
