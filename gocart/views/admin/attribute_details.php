<?php include('header.php'); ?>
<script type="text/javascript">
//<![CDATA[
$(document).ready(function(){
	create_sortable();	
});
// Return a helper with preserved width of cells
var fixHelper = function(e, ui) {
	ui.children().each(function() {
		$(this).width($(this).width());
	});
	return ui;
};
function create_sortable()
{
	$('#attributes').sortable({
		scroll: true,
		helper: fixHelper,
		axis: 'y',
		update: function(){
			save_sortable();
		}
	});	
	$('#attributes').sortable('enable');
}

function save_sortable()
{
	serial=$('#attributes').sortable('serialize');
	$.ajax({
		url:'<?php echo site_url($this->config->item('admin_folder').'/attributes/organize_attribute_details');?>',
		type:'POST',
		data:serial
	});
}
function areyousure()
{
	return confirm('<?php echo lang('confirm_delete_zone');?>');
}
</script>

<div class="button_set" style="text-align:right; width: 450px;">
	<a href="<?php echo site_url($this->config->item('admin_folder').'/attributes'); ?>">Back</a>
	<a href="<?php echo site_url($this->config->item('admin_folder').'/attributes/attribute_detail_form?attribute_id='.$id); ?>">Add Attribute Detail</a>
</div>
<br/>
<table class="gc_table" cellspacing="0" cellpadding="0" style="width: 450px;">
	<thead>
		<tr>
			<th class="gc_cell_left">Name</th>
			<th class="gc_cell_right"></th>
		</tr>
	</thead>
	<tbody id="attributes">
<?php foreach ($attribute_details as $attribute_detail):?>
		<tr id="attribute-<?php echo $attribute_detail->id;?>">
			<td class="gc_cell_left"><?php echo  ucfirst($attribute_detail->value); ?></td>
			<td class="gc_cell_right list_buttons" >
				<a href="<?php echo site_url($this->config->item('admin_folder').'/attributes/delete_attribute_detail/'.$attribute_detail->id).'?attribute_id='.$id; ?>" onclick="return areyousure();"><?php echo lang('delete');?></a>
				<a href="<?php echo site_url($this->config->item('admin_folder').'/attributes/attribute_detail_form/'.$attribute_detail->id).'?attribute_id='.$id; ?>"><?php echo lang('edit');?></a>
			</td>
	  </tr>
<?php endforeach; ?>
	</tbody>
</table>
<?php include('footer.php'); ?>
