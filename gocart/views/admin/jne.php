<?php include('header.php'); ?>

<div class="button_set" style="text-align:right;">
	<strong style="float:left; font-size:12px;"><?php echo lang('sort_countries')?></strong>
	<a href="<?php echo site_url($this->config->item('admin_folder').'/places/jne_province_form'); ?>"><?php echo 'Add New Province' ;?></a>
</div>
<br/>
<table class="gc_table" cellspacing="0" cellpadding="0">
	<thead>
		<tr>
			<th class="gc_cell_left"><?php echo lang('name');?></th>

			<th class="gc_cell_right"></th>
		</tr>
	</thead>
	<tbody id="countries">
<?php foreach ($places as $place):?>
		<tr id="country-<?php echo $place->id;?>">
			<td><?php echo  $place->name; ?></td>
			<td class="gc_cell_right list_buttons" >
				<a href="<?php echo site_url($this->config->item('admin_folder').'/places/delete_province/'.$place->id); ?>" onclick="return areyousure();"><?php echo lang('delete');?></a>
                <a href="<?php echo site_url($this->config->item('admin_folder').'/places/jne_province_form/'.$place->id); ?>"><?php echo lang('edit');?></a>
                <a href="<?php echo site_url($this->config->item('admin_folder').'/places/jne_cities/'.$place->id); ?>"><?php echo 'View';?></a>
				
			</td>
	  </tr>
<?php endforeach; ?>
	</tbody>
</table>
<?php include('footer.php'); ?>
