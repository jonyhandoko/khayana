<?php include('header.php'); ?>

<?php echo form_open($this->config->item('admin_folder').'/newsletter'); ?>

<div class="button_set">
	<input type="submit" value="Saved"/>
</div>
<input type="hidden" name="send" value="send" />
<div id="gc_tabs">
	<ul>
		<li><a href="#gc_message_info">Newsletter Info</a></li>
	</ul>
	<div id="gc_message_info">

		<div class="gc_field2">
			<label for="subject">Subject</label>
			<input class="gc_tf1" type="text" name="subject" value="" size="40" />
		</div>
		<div class="gc_field gc_tinymce">
			<?php
			$data	= array('id'=>'description', 'name'=>'html', 'class'=>'tinyMCE');
			echo form_textarea($data);
			?>
		</div>
	</div>
</div>

</form>
<script type="text/javascript">
	$(document).ready(function() {
		$("#gc_tabs").tabs();
	});
</script>
<?php include('footer.php');