<?php 

$additional_header_info = '<style type="text/css">#page_title {text-align:center;}</style>';
include('header.php'); ?>
	
    <div class="payment">
    	<p>Confirmation Payment Form</p>
        
        <?php if($orders != NULL): ?>
        <form action="<?php echo base_url();?>cart/payment_process" class="std" enctype="multipart/form-data" method="post">
            <fieldset style="margin-bottom: 0;"><h3>Send your payment information</h3><p class="text"> 
            <label for="id_order">Order Number:</label> 
            	<select class="selorder" name="order_number">
                	<option value="">Please select your order number</option>
                    <?php
						foreach($orders as $order){
							echo '<option value="'.$order->order_number.'">'.$order->order_number.'</option>';
						}
					?>
                </select> 
            <input type="text" name="id_order" value="" class="txtorder" style="display:none;" disabled="true"><sup> * </sup></p>
            
            <p class="text"> <label for="bank">Payment was Transferred to:</label> <select class="selbank" name="bank"><option value="">Select LeBijou's account</option><option value="BCA">BCA</option><option value="Mandiri">Mandiri</option><option value="BNI">BNI</option> </select> <input type="text" name="bank" value="" class="txtbank" style="display:none;" disabled="true"><sup> * </sup></p>
           
            <p class="text"> <label for="paymentmethod">From:</label> <select class="selpaymentmethod" name="paymentmethod" style="display: inline-block; "><option value="">Select your payment method</option><option value="BCA">BCA</option><option value="Mandiri">Mandiri</option><option value="BNI">BNI</option><option value="ATM Bersama">ATM Bersama</option> </select> <input type="text" name="paymentmethod" value="" class="txtpaymentmethod" style="display: none; " disabled=""><sup> * </sup> <a class="aselpaymentmethod" style="margin-left: 5px; cursor: pointer; display: inline; " onclick="switchInput('paymentmethod', true);">Other Payment</a> <a class="atxtpaymentmethod" style="margin-left: 5px; cursor: pointer; display: none; " onclick="switchInput('paymentmethod', false);">Back</a></p>
            
            <p class="text"> <label for="name">Account Holder:</label> <input type="text" id="name" name="name" value=""><sup> * </sup></p>
            
            <p class="text"> <label for="telephone">Telephone:</label> <input type="text" id="telephone" name="telephone" value=""> <sup> * </sup></p><p class="text"> <label for="amount">Paid Amount:</label> <input type="text" id="amount" name="amount" value=""> <sup> * </sup></p>
            
            <p class="text"> <label for="date">Payment Date:</label> <input type="text" id="date" name="date" value="2012-07-04" class="hasDatepicker"> <sup> * </sup></p>
            
            <p class="submit"> <input type="submit" name="submitPaidForm" id="submitMessage" value="Send" class="exclusive"></p>
            <p></p>
            </fieldset>
        </form>
        <?php else:
				echo "There are no order";
			endif;
		?>
    </div>

<?php include('footer.php'); ?>