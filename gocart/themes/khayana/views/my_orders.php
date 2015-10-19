<?php include('header.php');?>
<link type="text/css" href="<?php echo base_url('js/jquery/colorbox/colorbox.css');?>" rel="stylesheet" />
<script type="text/javascript" src="<?php echo base_url('js/jquery/colorbox/jquery.colorbox-min.js');?>"></script>
<?php
if(validation_errors())
{
	echo '<div class="error">'.validation_errors().'</div>';
}
?>

<script>
$(document).ready(function(){
	$('.delete_address').click(function(){
		if($('.delete_address').length > 1)
		{
			if(confirm('<?php echo lang('delete_address_confirmation');?>'))
			{
				$.post("<?php echo site_url('secure/delete_address');?>", { id: $(this).attr('rel') },
					function(data){
						$('#address_'+data).remove();
						$('#address_list .my_account_address').removeClass('address_bg');
						$('#address_list .my_account_address:even').addClass('address_bg');
					});
			}
		}
		else
		{
			alert('<?php echo lang('error_must_have_address');?>');
		}	
	});
	
	$('.edit_address').click(function(){
		$.fn.colorbox({	href: '<?php echo site_url('secure/address_form'); ?>/'+$(this).attr('rel'), width:'600px', height:'500px'}, function(){
			//$('input:submit, input:button, button').button();
		});
	});
	
	if ($.browser.webkit) {
	    $('input:password').attr('autocomplete', 'off');
	}
});


function set_default(address_id, type)
{
	$('.create_dialog_style').show();
	$.post('<?php echo site_url('secure/set_default_address') ?>/',{id:address_id, type:type}, function(data){
		$('.create_dialog_style').hide();
	});
}


</script>
<!-- Container -->
<div class="container">
<div class="thing">
  <div class="row">
	<div class="col-sm-2">
	  <div class="list-group list-clean regular">
		<a href="profile.html" class="list-group-item">PROFILE</a>
		<a href="/tokita/secure/my_orders" class="list-group-item active">ORDERS</a>
		<a href="/tokita/cart/confirmation_payment" class="list-group-item">PAYMENT</a>
	  </div>
	</div>
	<div class="col-sm-10">
	  <div class="greet">
		<h3 class="text-left">RECENT ORDERS</h3>
	  </div>
	  <div class="panel panel-as-table panel-lite">
		<div class="panel-heading maroon-text">
		  <div class="row">
			<div class="col-sm-2">
			  <p class="text-center">Date</p>
			</div>
			<div class="col-sm-2">
			  <p>Order</p>
			</div>
			<div class="col-sm-2">
			  <p class="text-center">Ship To</p>
			</div>
			<div class="col-sm-2">
			  <p class="text-center">Total</p>
			</div>
			<div class="col-sm-2">
			  <p class="text-center">Status</p>
			</div>
			<div class="col-sm-2">
			  <p class="text-center">Confirm</p>
			</div>
		  </div>
		</div>
		<div class="panel-body">
			  <?php
				if($orders):
					foreach($orders as $order): 
			  ?>
				 <div class="row seperator">
					<div class="col-sm-2">
					  <div class="row">
						<div class="col-xs-6">
						  <p class="lill-show">Date : </p>
						</div>
						<div class="col-xs-6 col-sm-12">
						  <p class="text-center">
							<?php $d = format_date($order->ordered_on); 
							
							$d = explode(' ', $d);
							echo $d[0].' '.$d[1].', '.$d[3];
							
							?>
						  </p>
						</div>
					  </div>
					</div>
					<div class="col-sm-2">
					  <div class="media">
						<?php echo $order->order_number; ?>
					  </div>
					</div>
					<div class="col-sm-2">
					  <div class="row">
						<div class="col-xs-6">
						  <p class="lill-show">Ship To : </p>
						</div>
						<div class="col-xs-6 col-sm-12">
						  <p class="text-center">Shipping Address</p>
						</div>
					  </div>
					</div>
					<div class="col-sm-2">
					  <div class="row">
						<div class="col-xs-6">
						  <p class="lill-show">Total : </p>
						</div>
						<div class="col-xs-6 col-sm-12">
						  <p class="text-center"><?php echo format_currency($order->total);?></p>
						</div>
					  </div>
					</div>
					<div class="col-sm-2">
					  <div class="row">
						<div class="col-xs-6">
						  <p class="lill-show">Status : </p>
						</div>
						<div class="col-xs-6 col-sm-12">
						  <p class="text-center"><?php echo $order->status;?></p>
						</div>
					  </div>
					</div>
					<div class="col-sm-2">
					  <button class="btn btn-block btn-grey btn-radius">CONFIRMED</button>
					</div>
				  </div>
			  <?php
				endforeach;
					echo $orders_pagination;
				endif;
			  ?>
		</div>
	  </div>
	</div>
  </div>
</div>
</div>
<!-- ./Container -->

<?php include('footer.php');?>