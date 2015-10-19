<?php include('header.php'); ?>

<?php echo form_open_multipart($this->config->item('admin_folder').'/brands/brand_form/'.$brand_id); ?>

<div class="button_set">
	<input type="submit" value="<?php echo lang('save');?>" />
</div>

<div id="gc_tabs">
	<ul>
		<li><a href="#gc_country_details"><?php echo lang('details');?></a></li>
	</ul>
	
	<div id="gc_brand_details">
		<div class="gc_field2">
		<label>Brand Name</label>
			<?php
			$data	= array('id'=>'BrandName', 'name'=>'brand_name', 'value'=>set_value('brand_name', $brand_name), 'class'=>'gc_tf1');
			echo form_input($data);
			?>
		</div>
		
		<div class="gc_field2">
		<label>Brand Slug</label>
			<?php
			$data	= array('id'=>'BrandSlug', 'name'=>'slug', 'value'=>set_value('slug', $slug), 'class'=>'gc_tf1');
			echo form_input($data);
			?>
		</div>
		
		<div class="gc_field2">
		<label>Box Image</label>
			<input type="file" name="box_image"/>
			<br/>
			<img width="600" src="<?php echo base_url($box_image);?>"/>
		</div>
		
		<div class="gc_field2">
		<label>Banner Image</label>
			<input type="file" name="brand_image"/>
			<br/>
			<img width="600" src="<?php echo base_url($banner_image);?>"/>
		</div>
		
		<div class="gc_field2">
		<label>Description</label>
			<div class="gc_field gc_tinymce">
			<?php
			$data	= array('id'=>'description', 'name'=>'description', 'class'=>'tinyMCE', 'value'=>set_value('description', $description));
			echo form_textarea($data);
			?>
			</div>
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
