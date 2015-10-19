<?php include('header.php'); ?>

<?php echo form_open($this->config->item('admin_folder').'/places/jne_province_form/'.$id); ?>

<div class="button_set">
	<input type="submit" value="<?php echo lang('save');?>" />
</div>

<div id="gc_tabs">
	<ul>
		<li><a href="#gc_country_details"><?php echo 'Province Details';?></a></li>
	</ul>
	
	<div id="gc_country_details">
		<div class="gc_field2">
		<label><?php echo lang('name');?></label>
			<?php
			$data	= array('id'=>'name', 'name'=>'name', 'value'=>set_value('name', $name), 'class'=>'gc_tf1', 'style'=>'width:250px');
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
