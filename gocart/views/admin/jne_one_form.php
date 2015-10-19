<?php include('header.php'); ?>

<?php echo form_open($this->config->item('admin_folder').'/places/jne_one_form/'.$id); ?>

<div class="button_set">
	<input type="submit" value="<?php echo lang('save');?>" />
</div>

<div id="gc_tabs">
	<ul>
		<li><a href="#gc_country_details">JNE Details</a></li>
	</ul>
	
	<div id="gc_country_details">
		<div class="gc_field2">
		<label><?php echo lang('name');?></label>
			<?php
			$data	= array('id'=>'name', 'name'=>'place', 'value'=>set_value('place', $place), 'class'=>'gc_tf1', 'style'=>'width:250px');
			echo form_input($data);
			?>
        </div>
        <div class="gc_field2">
        <label>REG Price</label>
            <?php
			$reg	= array('id'=>'reg', 'name'=>'reg', 'value'=>set_value('reg', $reg), 'class'=>'gc_tf1', 'style'=>'width:250px');
			echo form_input($reg);
			?>
        </div>
        <div class="gc_field2">
        <label>YES Price</label>
            <?php
			$yes	= array('id'=>'yes', 'name'=>'yes', 'value'=>set_value('yes', $yes), 'class'=>'gc_tf1', 'style'=>'width:250px');
			echo form_input($yes);
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
