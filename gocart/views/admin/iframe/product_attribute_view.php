<?php include('header.php');?>
<?php echo form_open($this->config->item('admin_folder').'/products/product_attribute_form/'.$product_id.'/'.$id, 'id="product_form " name="attributes"'); ?>
<input type="submit" value="Update"/><br/>
<input type="hidden" name="submit" value="submit"/>
<?php 
	$counter_attr = 0;
	foreach($attributes as $attr): ?>
		<label><?php echo ucfirst($attr->name);?></label>
		<input type="hidden" name="attributes[<?php echo $counter_attr;?>][attr_id]" value="<?php echo $attr->id;?>"/>
		<input type="hidden" name="attributes[<?php echo $counter_attr;?>][product_id]" value="<?php echo $product_id;?>"/>
		<select id="attribute_value_list" name="attributes[<?php echo $counter_attr;?>][attr_val]">
			<option  id="attributes_item_0" value="0">Empty</option>
			<?php foreach($attr->values as $value): ?>
				<option id="attributes_item_<?php echo $value->id;?>" value="<?php echo $value->id; ?>" <?php if($value->id==$attr->value_id) echo 'selected';?>><?php echo ucfirst($value->value);?></option>
			<?php endforeach;?>
		</select>
		<br/><br/>
	<?php 
	$counter_attr++;
	endforeach;
?>
</form>
<?php include('footer.php');