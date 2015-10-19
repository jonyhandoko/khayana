<?php include('header.php'); ?>
<script type="text/javascript">
function areyousure()
{
	return confirm('<?php echo lang('confirm_delete_product');?>');
}
</script>

<?php	
	if ($term)
	{
		echo '<p id="searched_for"><div style="width:70%;float:left;"><strong>'.sprintf(lang('search_returned'), intval($total)).'</strong></div><div style="width:29% float:right; text-align:right;"><a href="'.base_url().$this->config->item('admin_folder').'/products" class="button">all products</a></div></p>';
		
	}
?>


<div style="margin-bottom: 50px;">
    <div class="gc_order_search" style="float:left">
        <?php echo form_open($this->config->item('admin_folder').'/products', array('id'=>'search_form')); ?>
            From <input id="start_top"  value="<?php if(!empty($term->start_date)) echo $term->start_date;?>" class="gc_tf1" type="start_date" /> 
                <input id="start_top_alt" type="hidden" name="start_date" />
            To <input id="end_top" value="<?php if(!empty($term->end_date)) echo $term->end_date;?>" class="gc_tf1" type="end_date" />
                <input id="end_top_alt" type="hidden" name="end_date" />
                
                New <input type="checkbox" name="new" value="1"  <?php if(!empty($term->new) && $term->new == 1) echo "checked"; ?>/>
                
                Enabled <input type="radio" name="enabled" value="1" <?php if(isset($term->enabled) && $term->enabled == 1) echo "checked"; ?>/>
                
                Disabled <input type="radio" name="enabled" value="0" <?php if(isset($term->enabled) && $term->enabled == 0) echo "checked"; ?>/>
                
            <?php echo lang('term')?> <input id="top" type="text" class="gc_tf1" name="term" value="<?php if(!empty($term->term)) echo $term->term;?>" /> 
            
            <input type="reset">
            <input type="submit" value="Search" />
            <!--<span class="button_set"><a href="#" onclick="do_search('top'); return false;"><?php echo lang('search')?></a>-->
			<br/>
			<label>Category</label>
			<select name="category">
				<option value="">SELECT..</option>
				<?php
					foreach($categories as $cc):
				?>
						<option value="<?php echo $cc->id;?>"><?php echo $cc->name;?></option>
				<?php
					endforeach;
				?>
			</select>
            </span>
        </form>
    </div>
    
    <div class="button_set" style="float: right; clear:none; margin: 0 !important; ">
        <a href="#" onclick="$('#bulk_form').submit(); return false;"><?php echo lang('bulk_save');?></a>
        <a href="<?php echo site_url($this->config->item('admin_folder').'/products/form');?>"><?php echo lang('add_new_product');?></a>
    </div>

</div>
<div style="font-weight: bold; color: white; background-color: #EB5F5F; width: 120px; padding: 8px;">Total Quantity: <span id="prod_qty" style="font-size: 16px;">0</span></div>
<?php $quantity = 0; ?>
<?php echo form_open($this->config->item('admin_folder').'/products/bulk_save', array('id'=>'bulk_form'));?>
	<table class="gc_table" cellspacing="0" cellpadding="0">
		<thead>
			<tr>
				<th><?php echo lang('name');?></th>
				<th style="width:60px;">Ref No</th>
				<th style="width:60px;"><?php echo lang('price');?></th>
				<th style="width:60px;"><?php echo lang('saleprice');?></th>
				<th style="width:60px;"><?php echo lang('quantity');?></th>
                <th style="text-align:center"> New</th>
				<th style="width:60px;"><?php echo lang('enabled');?></th>
				<th class="gc_cell_right"></th>
			</tr>
		</thead>
		<tbody>
		<?php echo (count($products) < 1)?'<tr><td style="text-align:center;" colspan="6">'.lang('no_products').'</td></tr>':''?>
	<?php foreach ($products as $product):?>
			<tr class="gc_row">
				<td><?php echo form_input(array('name'=>'product['.$product->id.'][name]','value'=>form_decode($product->name), 'class'=>'gc_tf3'));?></td>
				<td><?php echo form_input(array('name'=>'product['.$product->id.'][sku]', 'value'=>set_value('sku', $product->sku), 'class'=>'gc_tf3'));?></td>
				<td><?php echo form_input(array('name'=>'product['.$product->id.'][price]', 'value'=>set_value('price', $product->price), 'class'=>'gc_tf3'));?></td>
				<td><?php echo form_input(array('name'=>'product['.$product->id.'][saleprice]', 'value'=>set_value('saleprice', $product->saleprice), 'class'=>'gc_tf3'));?></td>
				<td><?php echo ((bool)$product->track_stock)?form_input(array('name'=>'product['.$product->id.'][quantity]', 'value'=>set_value('quantity', $product->quantity), 'class'=>'gc_tf3')):'N/A';?></td>
				<td style="text-align:center">
                	<input type="checkbox" name="<?php echo 'product['.$product->id.'][new]';?>" value="1" <?php if($product->new==1)echo "checked"?>/>
                </td>
                <td>
					<?php
					 	$options = array(
			                  '1'	=> lang('enabled'),
			                  '0'	=> lang('disabled')
			                );

						echo form_dropdown('product['.$product->id.'][enabled]', $options, set_value('enabled',$product->enabled));
					?>
				</td>
				<td class="gc_cell_right list_buttons">
					<!--<a href="<?php echo  site_url($this->config->item('admin_folder').'/products/delete/'.$product->id);?>" onclick="return areyousure();"><?php echo lang('delete');?></a>-->
					<a href="<?php echo  site_url($this->config->item('admin_folder').'/products/form/'.$product->id);?>"><?php echo lang('edit');?></a>
					<a href="<?php echo  site_url($this->config->item('admin_folder').'/products/form/'.$product->id.'/1');?>"><?php echo lang('copy');?></a>
				</td>
			</tr>
			<?php $quantity += $product->quantity;?>
	<?php endforeach; ?>
		</tbody>
	</table>
</form>
<div class="button_set">
	<a href="#" onclick="$('#bulk_form').submit(); return false;"><?php echo lang('bulk_save');?></a>
	<a href="<?php echo site_url($this->config->item('admin_folder').'/products/form');?>"><?php echo lang('add_new_product');?></a>
</div>

<script type="text/javascript">
$(document).ready(function(){
	$('#prod_qty').html("<?php echo $quantity;?>");
	// set the datepickers individually to specify the alt fields
	$('#start_top').datepicker({dateFormat:'mm-dd-yy', altField: '#start_top_alt', altFormat: 'yy-mm-dd'});
	$('#start_bottom').datepicker({dateFormat:'mm-dd-yy', altField: '#start_bottom_alt', altFormat: 'yy-mm-dd'});
	$('#end_top').datepicker({dateFormat:'mm-dd-yy', altField: '#end_top_alt', altFormat: 'yy-mm-dd'});
	$('#end_bottom').datepicker({dateFormat:'mm-dd-yy', altField: '#end_bottom_alt', altFormat: 'yy-mm-dd'});
});

</script>

<?php include('footer.php'); ?>