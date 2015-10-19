<?php include('header.php'); ?>
<script>
function areyousure()
{
	return confirm('<?php echo 'Are you sure?';?>');
}
//]]>
</script>
<?php echo form_open($this->config->item('admin_folder')."/places/save_city/".$id); ?>
<div class="button_set" style="text-align:left;">
	<strong style="float:left; font-size:12px;"><?php echo lang('sort_countries')?></strong>
	<a href="<?php echo site_url($this->config->item('admin_folder')."/places"); ?>"><?php echo 'Back';?></a>
    <a href="<?php echo site_url($this->config->item('admin_folder')."/places/jne_cities/".$id."?value=form"); ?>"><?php echo 'Edit';?></a>
    
	
	<input type="submit" value="<?php echo lang('save');?>" style="height: 28px;"/>
	<a href="<?php echo site_url($this->config->item('admin_folder')."/places/jne_city_form/".$id); ?>"><?php echo 'Add New City';?></a>

</div>
<br/>

<table class="gc_table" cellspacing="0" cellpadding="0" style="width: auto !important">
	<thead>
		<tr>
			<th class="gc_cell_left"><?php echo 'Name';?></th>
			<th><?php echo "REG"?></th>
			<th><?php echo "YES";?></th>
            <th class="gc_cell_right"></th>
		</tr>
	</thead>
	<tbody id="countries">
<?php if(isset($_REQUEST['value']) && $_REQUEST['value'] == 'form'){ ?>
<?php foreach ($jneAreas as $jneArea):?>
		<tr id="<?php echo $jneArea->id;?>">
        	<td>
            <?php $area = $this->Place_model->get_city($jneArea->city_id); $name = $area->name;
            $data	= array('id'=>$jneArea->id, 'name'=>'fieldname['.$jneArea->id.'][name]', 'value'=>set_value('name', $name), 'class'=>'gc_tf1');
			echo form_input($data);
			?></td>
            <td>
            <?php 
            $data	= array('id'=>'jne_reg', 'name'=>'fieldname['.$jneArea->id.'][reg]', 'value'=>set_value('name', $jneArea->reg), 'class'=>'gc_tf1');
			echo form_input($data);
			?></td>
            <td>
            <?php 
            $data	= array('id'=>'jne_yes', 'name'=>'fieldname['.$jneArea->id.'][yes]', 'value'=>set_value('name', $jneArea->yes), 'class'=>'gc_tf1');
			echo form_input($data);
			?></td>

	  </tr>
<?php endforeach; ?>
<?php
	}else{
		foreach ($jneAreas as $jneArea):?>
			<tr id="country-<?php echo $jneArea->id;?>">
            <?php $area = $this->Place_model->get_city($jneArea->city_id); $name = $area->name;?>
            <td style="width: 200px; text-align: left;"><?php echo  $name; ?></td>
            <td style="width: 100px; text-align: left;"><?php echo  $jneArea->reg; ?></td>
            <td style="width: 100px; text-align: left;"><?php echo  $jneArea->yes; ?></td>
            <td class="gc_cell_right list_buttons" >
			<a href="<?php echo site_url($this->config->item('admin_folder').'/places/delete_city/'.$jneArea->id); ?>" onclick="return areyousure();"><?php echo lang('delete');?></a></td>
	  </tr>
<?php endforeach; }?>
	</tbody>
</table>
</form>
<?php include('footer.php'); ?>
