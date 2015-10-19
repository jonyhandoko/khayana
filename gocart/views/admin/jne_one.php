<?php include('header.php'); ?>

<div class="button_set" style="text-align:right;">
	<strong style="float:left; font-size:12px;"><?php echo lang('sort_countries')?></strong>
	<a href="<?php echo site_url($this->config->item('admin_folder').'/places/jne_one_form'); ?>"><?php echo 'Add New JNE' ;?></a>
</div>
<br/>
<table class="gc_table" cellspacing="0" cellpadding="0">
	<thead>
		<tr>
			<th class="gc_cell_left">Province / State</th>
			<th>REG Price</th>

			<th>YES Price</th>

			<th class="gc_cell_right"></th>
		</tr>
	</thead>
	<tbody id="countries">
<?php foreach ($places as $place):?>
		<tr id="country-<?php echo $place->id;?>">
			<td><?php echo  $place->place; ?></td>
            <td><?php echo  $place->reg; ?></td>
            <td><?php echo  $place->yes; ?></td>
			<td class="gc_cell_right list_buttons" >
				<a href="<?php echo site_url($this->config->item('admin_folder').'/places/delete_jne_one/'.$place->id); ?>" onclick="return areyousure();"><?php echo lang('delete');?></a>
                <a href="<?php echo site_url($this->config->item('admin_folder').'/places/jne_one_form/'.$place->id); ?>"><?php echo lang('edit');?></a>
			</td>
	  </tr>
<?php endforeach; ?>
	</tbody>
</table>
<?php include('footer.php'); ?>
