<?php include('header.php');?>
<script type="text/javascript">
if (top.location != location) {
	top.location.href = document.location.href;
}	
</script>

<h1> SHOPPING BAG </h1><?php echo $this->session->flashdata('redirect');?>
<hr/>
<div class="shopping-cart">
<?php if ($this->go_cart->total_items()==0):?>
	<div class="message">There are no products in your cart!</div>
<?php else: ?>
	<?php echo form_open('cart/update_cart', array('id'=>'update_cart_form'));?>
	<div class="shoppingbagHead">
		<div class="BTcontinueshopping fleft margin10sx"><a href="javascript:history.go(-1)">Continue Shopping</a></div>
		<!--<div class="BTproceed floatright"><img src="images/layout/bott_procedi_IT.gif" alt="Procedi" width="130" height="25" /></div>-->
		<div class="clear"></div>
	</div>
    <?php
	$subtotal = 0;
	
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
                <div class="shoppingbag-dett140"><a href="<?php echo site_url('cart/remove_item/'.$cartkey);?>">Delete product</a></div>
                <div class="shoppingbag-dett140">&nbsp;</div>
                <div class="shoppingbag-dett140">&nbsp;</div>
                <div class="shoppingbag-dett140"><a href="javascript:void(0)" class="SB-upp" onclick="updateVariante(3220);">Update product</a></div>
                <div class="shoppingbag-dett140 last">&nbsp;</div>
            </div>
            <div class="clear"></div>
        </div>
    <?php endforeach; ?>
<div class="linegrey2"></div>
<div style="height: 45px; padding-top: 10px;">
	<?php echo "Discount Code: ";?><input type="text" name="coupon_code">&nbsp;<input type="submit" class="button1" style="font-size: 11px;height: 20px; padding: 0 15px 0 15px !important; font-weight: bold; " value="<?php echo "ESTIMATE";?>"/>
    <br style="height: 14px;"/>
    
</div>   
<div class="linegrey2"></div> 
<div class="shoppingbagTot margin10px bold" id="idTotChart">TOTAL: 40.00 EUR</div>
<div class="shoppingbagFoot">
    <div class="BTproceed fright">
    <input id="redirect_path" type="hidden" name="redirect" value=""/>
    <?php if ($this->Customer_model->is_logged_in(false,false) || !$this->config->item('require_login')): ?>	
        <input style="padding:10px 15px; font-size:16px;" type="submit" onclick="$('#redirect_path').val('checkout/order_summary');" value="Checkout &raquo;"/>
    <?php else:?>
    	<input style="padding:10px 15px; font-size:16px;" type="submit" onclick="$('#redirect_path').val('checkout/order_summary');" value="Checkout &raquo;"/>
    <?php endif;?>
    </div>
    <div class="clear"></div>
</div>
</form>
<?php endif; ?>
</div>
<script type="text/javascript">
	//$('.buttonset').buttonset();
</script>
<?php include('footer.php'); ?>