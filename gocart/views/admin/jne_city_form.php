<?php include('header.php'); ?>

<?php echo form_open($this->config->item('admin_folder').'/places/jne_city_form/'.$id); ?>

<div class="button_set">
	<a href="<?php echo site_url($this->config->item('admin_folder')."/places/jne_cities/".$id); ?>"><?php echo 'Back';?></a>
	<input type="submit" value="<?php echo lang('save');?>" />
</div>

<div id="gc_tabs">
	<ul>
		<li><a href="#gc_country_details"><?php echo 'City Details';?></a></li>
	</ul>
	
	<div id="gc_country_details">
		<div class="gc_field2">
		<label>City Name</label>
			<?php
			$data	= array('id'=>'name', 'name'=>'name', 'class'=>'gc_tf1', 'style'=>'width:250px');
			echo form_input($data);
			?>
            <br/>
        <label>REG Price</label>
			<?php
			$reg	= array('id'=>'reg', 'name'=>'reg', 'class'=>'gc_tf1', 'style'=>'width:250px');
			echo form_input($reg);
			?>
            <br/>
        <label>YES Price</label>
			<?php
			$ok	= array('id'=>'yes', 'name'=>'yes', 'class'=>'gc_tf1', 'style'=>'width:250px');
			echo form_input($ok);
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
