<script type="text/javascript" src="<?php echo base_url('js/jquery.dataTables.min.js');?>"></script>
<script>
	$(document).ready(function(){
		var oTable = $('#bestSellers').dataTable();
		// Sort immediately with columns 0 and 1
  		oTable.fnSort( [ [1,'desc'] ] );
	});
</script>
<table class="gc_table" id="bestSellers" cellspacing="0" cellpadding="0">
	<thead>
		<tr>
			<?php /*<th>ID</th> uncomment this if you want it*/ ?>
			<?php /*<th class="gc_cell_left"><?php echo lang('sku');?></th>*/ ?>
			<th><?php echo lang('name');?></th>
			<th class="gc_cell_right"><?php echo lang('quantity');?></th>
		</tr>
	</thead>
	<tbody>
		<?php $total_quantity=0; ?>
		<?php foreach($best_sellers as $b):?>
		<tr class="gc_row">
			<?php /*<td style="width:16px;"><?php echo  $customer->id; ?></td>*/?>
			<?php /*<td class="gc_cell_left"><?php echo  $b->sku; ?></td>*/ ?>
			<td><?php echo  $b['name']; if($b['option']!="") echo ' - '.$b['option']; ?></td>
			<?php $total_quantity += $b['quantity'];?>
			<td class="gc_cell_right"><?php echo $b['quantity']; ?></a></td>
		</tr>
		<?php endforeach;?>
		
	</tbody>
	<tfoot>
		<tr>
			<td style="font-weight: bold; background-color: #333; color:white; padding: 5px;">Total Quantity</td>
			<td style="font-weight: bold; background-color: #333; color:white; padding: 5px;"><?php echo $total_quantity;?></td>
		</tr>
	</tfoot>
</table>