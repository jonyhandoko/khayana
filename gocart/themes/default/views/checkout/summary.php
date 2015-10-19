<?php include(APPPATH.'themes/'.$this->config->item('theme').'/views/header.php'); ?>
<script>
// some behavior controlling global variables
var logged_in_user = <?php if($this->Customer_model->is_logged_in(false, false)) echo "true"; else echo "false"; ?>;

var shipping_required = <?php echo ($this->go_cart->requires_shipping()) ? 'true' : 'false'; ?>;
var shipping = Array();
var shipping_choice = '<?php $shipping=$this->go_cart->shipping_method(); if($shipping) echo $shipping['method']; ?>';

var addr_context = '';
var ship_to_bill_address = <?php if(isset($customer['ship_to_bill_address'])) { echo $customer['ship_to_bill_address']; } else { echo 'false'; } ?>;
var addresses;
function display_error(panel, message) 
{
	$('#'+panel+'_error_box').html(message).show();
}
$(function() {
	// keep the cart total up to date for other JS functionality
	cart_total = <?php echo $this->go_cart->total(); ?>;
	
	if(cart_total==0)
	{
		$('#payment_section_container').hide();
		$('#no_payment_necessary').show();
	} else {
		$('#payment_section_container').show();
		$('#no_payment_necessary').hide();
	}
});
function clear_errors()
{
	$('.error').hide();
	
	$('.required').each(function(){ 
			$(this).removeClass('require_fail');
	});
	
	$('.pmt_required').each(function(){ 
			$(this).removeClass('require_fail');
	});
}
// Set payment info
function submit_payment_method()
{
	
	clear_errors();
	
	errors = false;
		
	// verify a shipping method is chosen
	if(shipping_required && $('input:radio[name=shipping_input]:checked').val()===undefined && $('input:radio[name=shipping_input]').length > 0)
	{
		display_error('shipping', '<?php echo lang('error_choose_shipping');?>');
		errors = true;
	}
		
	// validate payment method if payment is required
	/*if(cart_total>0)
	{
		// verify a payment option is chosen
		if($('input[name=payment_method]').length > 1)
		{
			if($('input:radio[name=payment_method]:checked').val()===undefined)
			{
				display_error('payment', '<?php echo lang('error_choose_payment');?>');
				errors = true;
			}
		}
		
		// determine if our payment method has a built-in validator
		if(typeof payment_method[chosen_method] == 'function' )
		{
			if(!payment_method[chosen_method]())
			{
				errors = true;
			}
		}
	}*/
	
	// stop here if we have problems
	if(errors)
	{
		return false;
	}

	// send the customer data again and then submit the order
	save_order();
}

function save_order()
{
	//submit additional order details
	
	$.post('<?php echo site_url('checkout/save_additional_details');?>', $('#additional_details_form').serialize(), function(){
		$('#order_submit_form').trigger('submit');
		//thus must be a callback, otherwise there is a risk of the form submitting without the additional details saved
		// if we need to save a payment method
		/*if(cart_total>0) {

			frm_data = $('#pmnt_form_'+chosen_method).serialize();

			$.post('<?php echo site_url('checkout/save_payment_method');?>', frm_data, function(response)
			{
				alert(response);
				if(typeof response != "object")
				{
					display_error('payment', '<?php echo lang('error_save_payment') ?>');

					return;
				}

				if(response.status=='success')
				{
					alert("aa");
					// send them on to place the order
					//$('#order_submit_form').trigger('submit');
				}
				else if(response.status=='error')
				{
					alert("cc");
					display_error('payment', response.error);
				}

			}, 'json');
		} else {
			alert("bb");
			//$('#order_submit_form').trigger('submit');	
		}*/
	});
}	 
</script>
<h1>SUMMARY</h1>
<hr/>
<div class="shopping-cart">
	<?php
	$subtotal = 0;
	print_r($customer);
	foreach ($this->go_cart->contents() as $cartkey=>$product):?>
    	<?php //print_r($this->go_cart->contents());
		?>
    	
        <div class="shoppingbagBox" id="idMainVariante_3220" style="border 2px solid #FC0;">
            <div class="shoppingbag-imgCont">
                <span class="padding10sx">
                    <img src="<?php echo base_url('uploads/product/thumb/'.$product['images']);?>" alt="Blue Striped Braces" height="63" />
                </span>
            </div>
            <div class="shoppingbag-dettCont">
                <div class="shoppingbag-dett290">
                    <span class="SB-title bold">
                        <a href="<?php echo base_url($product['slug']);?>" id="idNomeVariante_3220"><?php echo $product['name']; ?></a>
                    </span>
                    <span class="SB-item">Item #1586013-01</span>
                    <span class="SB-price"><?php echo format_currency($product['base_price']);   ?></span>
                </div>
                <div class="shoppingbag-dett140">
                    <span class="SB-upp">Size</span><br>
                    <span class="SB-taglia">
						<?php 
						if(isset($product['options'])) {
                            foreach ($product['options'] as $name=>$value)
                            {
                                if(is_array($value))
                                {
                                    echo 'One size';
                                } 
                                else 
                                {
                                    echo $value;
                                }
                            }
                        }
                        ?>
                    </span>
                </div>
                <div class="shoppingbag-dett140">
                    <span class="SB-upp">Quantity</span><br>
                    <label><input name="cartkey[<?php echo $cartkey;?>]" type="text" id="qty_3220" size="2" maxlength="2" value="<?php echo $product['quantity'] ?>" class="SB-outOfStockProduct"></label>
                </div>
                <div class="shoppingbag-dett180 last">
                    <div class="SB-subtotal1 SB-upp">Subtotal</div>
                    <div class="SB-subtotal2" id="idSubtotalVariante_3220"><?php echo format_currency($product['price']*$product['quantity']); ?></div>
                </div>
                <div class="clear"></div>
                <div class="shoppingbag-dett140">&nbsp;</div>
                <div class="shoppingbag-dett140">&nbsp;</div>
                <div class="shoppingbag-dett140 last">&nbsp;</div>
            </div>
            <div class="clear"></div>
        </div>
    <?php endforeach; ?>
    <div class="linegrey2"></div>
    <?php
		/**************************************************************
		Subtotal Calculations
		**************************************************************/
		?>
		<?php if($this->go_cart->group_discount() > 0)  : ?> 
			<div class="shoppingbagTot margin10px " id="idTotChart"><?php echo lang('group_discount')." : ".format_currency(0-$this->go_cart->group_discount());?></div>
		<?php endif; ?>
        	<div class="shoppingbagTot margin10px " id="idTotChart"><?php echo lang('subtotal')." : ".format_currency($this->go_cart->subtotal());?></div>
			
		<?php if($this->go_cart->coupon_discount() > 0) {?>
			<div class="shoppingbagTot margin10px " id="idTotChart"><?php echo lang('coupon_discount')." : ".format_currency($this->go_cart->coupon_discount());?></div>
			<?php if($this->go_cart->order_tax() != 0) { // Only show a discount subtotal if we still have taxes to add (to show what the tax is calculated from)?> 
			<tr>
				<td colspan="5"><?php echo lang('discounted_subtotal');?></td>
				<td id="gc_coupon_discount"><?php echo format_currency($this->go_cart->discounted_subtotal());?></td>
			</tr>
			<?php
			}
		} 
		/**************************************************************
		 Custom charges
		**************************************************************/
		$charges = $this->go_cart->get_custom_charges();
		if(!empty($charges))
		{
			foreach($charges as $name=>$price) : ?>
				
		<tr>
			<td colspan="5"><?php echo $name?></td>
			<td><?php echo format_currency($price); ?></td>
		</tr>	
				
		<?php endforeach;
		}	
		
		/**************************************************************
		Order Taxes
		**************************************************************/
		 // Show shipping cost if added before taxes
		if($this->config->item('tax_shipping') && $this->go_cart->shipping_cost()>0) : ?>
			<div class="shoppingbagTot margin10px " id="idTotChart"><?php echo lang('shipping')." : ".format_currency($this->go_cart->shipping_cost());?></div>
		<?php endif;
		if($this->go_cart->order_tax() > 0) :  ?>
		<tr>
			<td colspan="5" colspan="3"><?php echo lang('tax');?></td>
			<td id="gc_tax_price"><?php echo format_currency($this->go_cart->order_tax());?></td>
		</tr>
		<?php endif; 
		// Show shipping cost if added after taxes
		if(!$this->config->item('tax_shipping') && $this->go_cart->shipping_cost()>0) : ?>
			<div class="shoppingbagTot margin10px " id="idTotChart"><?php echo lang('shipping')." : ".format_currency($this->go_cart->shipping_cost());?></div>
		<?php endif ?>

		<?php
		/**************************************************************
		Gift Cards
		**************************************************************/
		if($this->go_cart->gift_card_discount() > 0) : ?>
		<tr>
			<td colspan="5"><?php echo lang('gift_card_discount');?></td>
			<td id="gc_gift_discount">-<?php echo format_currency($this->go_cart->gift_card_discount()); ?></td>
		</tr>
		<?php endif; ?>
    <div class="clear h20"></div>
    <div class="linegrey2"></div> 
    <div class="shoppingbagTot margin10px " id="idTotChart">Total: <?php echo format_currency($this->go_cart->total()); ?></div>
    
    <div class="checkout_block" >
	<div id="additional_order_details">
		<?php if($this->session->flashdata('additional_details_message'))
		{
			echo '<div class="message">'.$this->session->flashdata('additional_details_message').'</div>';
		}
		?>
		<h3><?php echo lang('additional_order_details');?></h3>
		<?php //additional order details ?>
		<form id="additional_details_form" method="post" action="<?php echo site_url('checkout/save_additional_details');?>">
			<div class="form_wrap">
				<div>
					<?php echo lang('heard_about');?><br/>
					<?php echo form_input(array('name'=>'referral', 'class'=>'input', 'value'=>''));?>
				</div>
			</div>
			<div class="form_wrap">
				<div>
					<?php echo lang('shipping_instructions');?><br/>
					<?php echo form_textarea(array('name'=>'shipping_notes', 'class'=>'checkout_textarea', 'value'=>''))?>
				</div>
			</div>
		</form>
	</div>
	<div class="clear"></div>
</div>
    
    <div class="shoppingbagFoot">
        <div class="BTproceed fright">
        <input id="redirect_path" type="hidden" name="redirect" value=""/>
        <?php if ($this->Customer_model->is_logged_in(false,false) || !$this->config->item('require_login')): ?>	
            <!--<input style="padding:10px 15px; font-size:16px;" type="submit" class="button1" onclick="$('#redirect_path').val('checkout');" value="Checkout &raquo;"/>-->
        <form id="order_submit_form" action="<?php echo site_url('checkout/place_order'); ?>" method="post">
            <input type="hidden" name="process_order" value="true">
			<input type="button" class="button1" onclick="submit_payment_method()"  value="Checkout &raquo;" />
        <?php else:?>
        <form id="order_submit_form" action="<?php echo site_url('checkout/place_order'); ?>" method="post">
            <input type="hidden" name="process_order" value="true">
			<input type="button" class="button1" onclick="submit_payment_method()"  value="Checkout &raquo;" /><!--onclick="submit_payment_method()"-->
        <?php endif;?>
        </div>
        <div class="clear"></div>
    </div>
    </form>
</div>
<?php include(APPPATH.'themes/'.$this->config->item('theme').'/views/footer.php'); ?>