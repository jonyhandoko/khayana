<?php include('header.php'); ?>

<div class="button_set" style="text-align:right; width: 450px;">
	<a href="<?php echo site_url($this->config->item('admin_folder').'/brands/brand_form'); ?>">Add New Brand</a>
</div>
<br/>
<table class="gc_table" cellspacing="0" cellpadding="0" style="width: 450px;">
	<thead>
		<tr>
			<th class="gc_cell_left">Name</th>
			<th class="gc_cell_right"></th>
		</tr>
	</thead>
	<tbody id="brands">
<?php foreach ($brands as $brand):?>
		<tr id="brands-<?php echo $brand->brand_id;?>">
			<td><?php echo  $brand->brand_name; ?></td>
			<td class="gc_cell_right list_buttons" >
				<!--<a href="<?php //echo site_url($this->config->item('admin_folder').'/brands/view/'.$brand->brand_id); ?>">View</a>-->
				<a href="<?php echo site_url($this->config->item('admin_folder').'/brands/brand_form/'.$brand->brand_id); ?>">Edit</a>
                <a href="<?php echo site_url($this->config->item('admin_folder').'/brands/delete_brand/'.$brand->brand_id); ?>" onclick="return areyousure();">Delete</a>
                
			</td>
	  </tr>
<?php endforeach; ?>
	</tbody>
</table>
<?php include('footer.php'); ?>
