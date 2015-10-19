<?php include('header.php'); ?>

<div class="button_set" style="text-align:right; width: 450px;">
	<a href="<?php echo site_url($this->config->item('admin_folder').'/attributes/attribute_form'); ?>">Add New Attributes</a>
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
<?php foreach ($attributes as $attribute):?>
		<tr id="attributes-<?php echo $attribute->id;?>">
			<td><?php echo  ucfirst($attribute->name); ?></td>
			<td class="gc_cell_right list_buttons" >
				<a href="<?php echo site_url($this->config->item('admin_folder').'/attributes/view/'.$attribute->id); ?>">View</a>
				<a href="<?php echo site_url($this->config->item('admin_folder').'/attributes/attribute_form/'.$attribute->id); ?>">Edit</a>
                <a href="<?php echo site_url($this->config->item('admin_folder').'/attributes/delete_attribute/'.$attribute->id); ?>" onclick="return areyousure();">Delete</a>
                
			</td>
	  </tr>
<?php endforeach; ?>
	</tbody>
</table>
<?php include('footer.php'); ?>
