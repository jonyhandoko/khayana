<?php 

$additional_header_info = '<style type="text/css">#page_title {text-align:center;}</style>';
include('header.php'); ?>
<!-- Container -->
<div class="container">
<div class="thing">
  <div class="row">
	<div class="col-sm-2">
	  <div class="list-group list-clean regular">
		<a href="profile.html" class="list-group-item">PROFILE</a>
		<a href="/tokita/secure/my_orders" class="list-group-item">ORDERS</a>
		<a href="/tokita/cart/confirmation_payment" class="list-group-item active">PAYMENT</a>
	  </div>
	</div>
	<div class="col-sm-10">
	  <div class="greet">
		<h3 class="text-left">CONFIRMATION PAYMENT</h3>
	  </div>
	  <div class="panel panel-as-table panel-lite">
		<?php if($orders != NULL): ?>
			<p class="bold up">Send your payment information</p>
			
			<form action="<?php echo base_url();?>cart/payment_process" class="std" enctype="multipart/form-data" method="post">
				<table width="800" class="confirmation">
					<tr>
						<td width="300" align="left">*Order Number</td>
						<td width="5" align="center">:</td>
						<td align="left">
							<select class="selorder" name="order_number">
								<option value="">Please select your order number</option>
								<?php
									foreach($orders as $order){
										echo '<option value="'.$order->order_number.'">'.$order->order_number.'</option>';
									}
								?>
							</select> 

						</td>
					</tr>
					
					<tr>
						<td>*Payment was Transferred to</td>
						<td>:</td>
						<td>
							<select name="bank" class="selbank">
								<option value="">Select account</option>
								<option value="BCA">BCA - Ekaputri Wiharja/5810332893</option>
								<option value="Mandiri">Mandiri - Ekaputri Wiharja/1680000137669</option>
							</select>
						</td>
					</tr>
					
					<tr>
						<td>*From Bank</td>
						<td>:</td>
						<td>
							<input type="text" name="paymentmethod" class="selpaymentmethod" />
						</td>
					</tr>
					
					<tr>
						<td>*Account Name</td>
						<td>:</td>
						<td><input type="text" name="name" class="input1"></td>
					</tr>
					
					<tr>
						<td>Account Number &nbsp; <span style="color:gray">(optional)</span></td>
						<td>:</td>
						<td><input type="text" name="number" class="input1"> &nbsp; <span style="color:gray">(optional)</span></td>
					</tr>
					
					<tr>
						<td>*Telephone</td>
						<td>:</td>
						<td><input type="text" name="telephone" class="input1"></td>
					</tr>
					
					<script>
					$(function() {
						$( "#datepicker" ).datepicker({gotoCurrent: true});
						
					});
					
					function checkAmount(){
						if ($('#amount').val().indexOf(',') !== -1)
						{
						  alert('Cannot have comma "," in amount field');
						  return false;
						}	
						
						if ($('#amount').val().indexOf('.') !== -1)
						{
						  alert('Cannot have fullstop "." in amount field');
						  return false;
						}
					}
					</script>
					<tr>
						<td>*Paid Ammount</td>
						<td>:</td>
						<td><input type="text" name="amount" class="input1" id="amount"> <label>(e.g: 180000 - without "," and ".")</label></td>
					</tr>
					
					<tr>
						<td>*Payment Date</td>
						<td>:</td>
						<td><input type="text" name="date" id="datepicker" class="input1" autocomplete="off"></td>
					</tr>
					
					<tr>
						<td colspan="3"><input type="submit" value="submit" class="button2" onclick="return checkAmount();"></td>
					</tr>
				</table>
			</form>
			<?php else:
					echo "There are no order";
				endif;
			?>
	  </div>
	</div>
  </div>
</div>
</div>
<!-- ./Container -->
<?php include('footer.php'); ?>