<?php require('header.php'); 

function sort_url($by, $sort, $sorder, $code, $admin_folder)
{
	if ($sort == $by)
	{
		if ($sorder == 'asc')
		{
			$sort	= 'desc';
		}
		else
		{
			$sort	= 'asc';
		}
	}
	else
	{
		$sort	= 'asc';
	}
	$return = site_url($admin_folder.'/orders/index/'.$by.'/'.$sort.'/'.$code);
	return $return;
}

?>

<style>
	#page_content{position: absolute !important; min-width: 876px; margin-left: 164px;}	
</style>

<?php echo form_open($this->config->item('admin_folder').'/orders', array('id'=>'search_form')); ?>
	<input type="hidden" name="term" id="search_term" value=""/>
	<input type="hidden" name="start_date" id="start_date" value=""/>
	<input type="hidden" name="end_date" id="end_date" value=""/>
</form>

<script>
	function changeLocation(menuObj)
	{
	   var i = menuObj.selectedIndex;
	
	   if(i >= 0)
	   {
		  window.location = menuObj.options[i].value;
	   }
	}
</script>
<select name="statusIndex" onChange="javascript:changeLocation(this)">
    <option value="<?php echo site_url($this->config->item('admin_folder').'/payment_transfer/index/ALL');?>" <?php if($status=="") echo "selected"?>>All Status</option>
    <option value="<?php echo site_url($this->config->item('admin_folder').'/payment_transfer/index/CONFIRMATION');?>" <?php if($status=="CONFIRMATION") echo "selected";?>>Confirmation</option>
    <option value="<?php echo site_url($this->config->item('admin_folder').'/payment_transfer/index/PAID');?>" <?php if($status=="PAID") echo "selected";?>>Paid</option>
</select>


<table class="gc_table" cellspacing="0" cellpadding="0">
    <thead>
		<tr>
			<th class="gc_cell_left"><a href="<?php echo sort_url('order_number', $sort_by, $sortorder, $code, $this->config->item('admin_folder')); ?>">Order Number</a></th>
			<th><a href="<?php echo sort_url('transfer_to', $sort_by, $sortorder, $code, $this->config->item('admin_folder')); ?>">Transfer To</a></th>
			<th><a href="<?php echo sort_url('transfer_from', $sort_by, $sortorder, $code, $this->config->item('admin_folder')); ?>">Transfer From</a></th>
			<th><a href="<?php echo sort_url('account_holder', $sort_by, $sortorder, $code, $this->config->item('admin_folder')); ?>">Account Holder</a></th>
            <th><a href="<?php echo sort_url('account_number', $sort_by, $sortorder, $code, $this->config->item('admin_folder')); ?>">Account Number</a></th>
			<th><a href="<?php echo sort_url('phone', $sort_by, $sortorder, $code, $this->config->item('admin_folder')); ?>">Phone</a></th>
            <th><a href="<?php echo sort_url('amount_paid', $sort_by, $sortorder, $code, $this->config->item('admin_folder')); ?>">Payment Date</a></th>
            <th><a href="<?php echo sort_url('payment_date', $sort_by, $sortorder, $code, $this->config->item('admin_folder')); ?>">Amount</a></th>
            <th>Notes</th>
            <th><a href="<?php echo sort_url('status', $sort_by, $sortorder, $code, $this->config->item('admin_folder')); ?>">Status</a></th>
			<th class="gc_cell_right"></th>
	    </tr>
	</thead>
 	<tfoot>
	</tfoot>
    <tbody>
	<?php echo (count($payment_transfers) < 1)?'<tr><td style="text-align:center;" colspan="8">'.lang('no_orders') .'</td></tr>':''?>
    <?php foreach($payment_transfers as $payment_transfer): ?>
	<tr>
    	<?php //$order_id	= $this->Order_model->get_order_by_number($payment_transfer->order_number);?>
		<td><a href="<?php echo site_url($this->config->item('admin_folder').'/orders/view/'.$payment_transfer->orderid);?>"><?php echo $payment_transfer->order_number; ?></a></td>
        <?php $customer = $this->Customer_model->get_customer($payment_transfer->customer_id);?>
        
		<td style="white-space:nowrap"><?php echo $payment_transfer->transfer_to; ?></td>
		
		<td style="white-space:nowrap"><?php echo $payment_transfer->transfer_from; ?></td>
        <td style="white-space:nowrap"><?php echo $payment_transfer->account_holder; ?></td>
        <td style="white-space:nowrap"><?php echo $payment_transfer->account_number; ?></td>
        <td style="white-space:nowrap"><?php echo $payment_transfer->phone; ?></td>
         <td style="white-space:nowrap"><?php echo date('d/m/Y', strtotime($payment_transfer->payment_date)); ?></td>
        <td style="white-space:nowrap"><?php echo format_currency($payment_transfer->amount_paid); ?></td>
		
       
        <td><div class="MainTableNotes"><?php echo $payment_transfer->notes; ?></div></td>
        
      	<td style="white-space:nowrap"><?php echo $payment_transfer->status; ?></td>
        
        <td class="gc_cell_right list_buttons" width="180">
			<!--<a href=""><?php echo lang('form_view');?></a>-->
            <a href="<?php echo site_url($this->config->item('admin_folder').'/payment_transfer/paid/'.$payment_transfer->id);?>">Paid</a>
             <br/>
            <a href="<?php echo site_url($this->config->item('admin_folder').'/payment_transfer/delete/'.$payment_transfer->id);?>">Delete</a>
            <!--<a href="">Expired</a>-->
		</td>
	</tr>
    <?php endforeach; ?>
    </tbody>
</table>

<script type="text/javascript">
$(document).ready(function(){
	$('#gc_check_all').click(function(){
		if(this.checked)
		{
			$('.gc_check').attr('checked', 'checked');
		}
		else
		{
			 $(".gc_check").removeAttr("checked"); 
		}
	});
	
	// set the datepickers individually to specify the alt fields
	$('#start_top').datepicker({dateFormat:'mm-dd-yy', altField: '#start_top_alt', altFormat: 'yy-mm-dd'});
	$('#start_bottom').datepicker({dateFormat:'mm-dd-yy', altField: '#start_bottom_alt', altFormat: 'yy-mm-dd'});
	$('#end_top').datepicker({dateFormat:'mm-dd-yy', altField: '#end_top_alt', altFormat: 'yy-mm-dd'});
	$('#end_bottom').datepicker({dateFormat:'mm-dd-yy', altField: '#end_bottom_alt', altFormat: 'yy-mm-dd'});
});

function do_search(val)
{
	$('#search_term').val($('#'+val).val());
	$('#start_date').val($('#start_'+val+'_alt').val());
	$('#end_date').val($('#end_'+val+'_alt').val());
	$('#search_form').submit();
}


function edit_status(id)
{
	$('#status_container_'+id).hide();
	$('#edit_status_'+id).show();
}

function save_status(id)
{
	$.post("<?php echo site_url($this->config->item('admin_folder').'/orders/edit_status'); ?>", { id: id, status: $('#status_form_'+id).val()}, function(data){
		$('#status_'+id).html('<span class="'+data+'">'+$('#status_form_'+id).val()+'</span>');
	});
	
	$('#status_container_'+id).show();
	$('#edit_status_'+id).hide();	
}
</script>


<?php include('footer.php'); ?>