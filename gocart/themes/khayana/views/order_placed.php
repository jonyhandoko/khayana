<?php include('header.php'); ?>

<center>
	
	
	<p style="font: bold 16px georgia">Hi <?php echo $customer['firstname'];?> <?php echo $customer['lastname'];?></p>
	<br/><br/>
	
	<p style="font: bold 18px georgia; text-transform: uppercase">
		Payment for your order was successfully processed</strong>
	</p>
    
    <br/><br/>
    
    <p style="font: bold 13px georgia">Your Order Number:  <span style="color: #5b5b5b;"><?php echo $order_id;?></span></p>
    
    <p style="font: bold 13px georgia">Payment Method: <?php echo $payment['details']; ?></p>
    
    <?php 
		if($payment['details'] == "Paypal Express"){
	?>
		<p style="font: bold 13px georgia">Amount: $<?php echo $payment['total']; ?> USD</p>
		
		<br/><br/>
		
		<p style="font: bold 13px georgia">
    	Thankyou for your shopping with Scarlet
		</p>
		<br/><br/>
		<p style="font: italic 13px georgia">
			You can review this order and download your invoice from the "<span style="color: #5b5b5b;">Order history</span>" section of your account 
by clicking "<a href="<?php echo base_url('secure/my_account');?>" style="color: #5b5b5b;">My account</a>" on our Website
		</p>
	<?php		
		}else{
	?>
		<p style="font: bold 13px georgia">Amount: <?php echo format_currency($this->go_cart->total()); ?></p>
		<br/><br/>
		<p style="font: bold 13px georgia">
    	Please transfer your payment to:  <br/><br/>
        <span style="color: #5b5b5b;"> BCA -  5810332893</span> <br/>
        <span style="color: #5b5b5b;">Mandiri -  1680000137669</span>
		</p>
		<br/><br/>
		<p style="font: italic 13px georgia" class="red">
			You have a maximum of 2 days to pay and confirm your payment. <br/>
			Automatic cancellation will take place if no payment confirmation received
		</p>
	<?php
		}
	?>
</center>

<?php include('footer.php');