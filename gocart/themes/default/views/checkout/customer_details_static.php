<script type="text/javascript">
//if this page is loaded, it means that we can load payment and shipping info too.
$('#shipping_payment_container').show();
$('#submit_button_container').show();

$.post('<?php echo site_url('checkout/shipping_payment_methods');?>', function(data){
	$('#shipping_payment_container').html(data);
});

<?php if(isset($address_update)&& $address_update==1):?>
	$('.shipping').html("<?php echo format_currency($this->go_cart->shipping_cost());?>");
<?php endif;?>


</script>
<?php
//$bill	= $customer['bill_address'];
$ship	= $customer['ship_address'];
?>

<div id="shipping_address" style="margin: 0 auto; font-family:Verdana, Geneva, sans-serif; width: 325px; font-size: 13px;  color: #000 !important;">
    <div class="form_wrap" style="text-align: center; line-height: 22px !important;">
        <h3><?php echo /*($ship != $bill)?*/ "Address"/*:lang('shipping_and_billing')*/;?></h3>
        <strong><?php echo (!empty($ship['company']))?$ship['company'].'<br/>':'';?></strong>
        <?php echo $ship['firstname'].' '.$ship['lastname'];?> <br/>
        <?php echo $ship['address1'];?><br>
        <?php echo (!empty($ship['address2']))?$ship['address2'].'<br/>':'';?>
        <?php echo $ship['province'].', '.$ship['city'].' '.$ship['zip'];?><br/>
        
        <?php echo $ship['email'];?><br/>
        <?php echo $ship['phone'];?><br/><br/>
		<input type="button"  value="Edit Information" onclick="get_customer_form();"/>
        <img id="save_customer_loader" alt="loading" src="<?php echo base_url('images/ajax-loader.gif');?>" style="display:none;"/>
    </div>
</div>
<?php $shipping_cost = $this->Place_model->get_cost($ship['province_id'], $ship['city_id']); ?>
<input type="hidden" name="shipping_cost" value="<?php echo $shipping_cost->reg;?>"/>

<div class="shipping_cost" style="position: absolute; top: 80px; right: 40px; width:150px; background-color: #333333; text-align: center; color: #FFFFFF; -webkit-border-radius: 4px;
	-moz-border-radius: 4px;
	border-radius: 4px; font-size: 12px; padding: 10px;">
    <span style="color: #FFFFFF">SHIPPING PRICE</span><hr/>
    JNE REG : <?php echo format_currency($shipping_cost->reg); ?>
</div>

<?php /*
<?php if($ship != $bill):?>
<div id="billing_address">
    <div class="form_wrap">
        <h3><?php echo lang('billing_address');?></h3>
        <strong><?php echo (!empty($bill['company']))?$bill['company'].'<br/>':'';?>
        <?php echo $bill['firstname'].' '.$bill['lastname'];?> <br/>
        <?php echo $bill['address1'];?><br>
        <?php echo (!empty($bill['address2']))?$bill['address2'].'<br/>':'';?>
        <?php echo $bill['city'].', '.$bill['zone'].' '.$bill['zip'];?><br/>
        <?php echo $bill['country'];?></strong><br/>
        
        <?php echo $bill['email'];?><br/>
        <?php echo $bill['phone'];?>
    </div>
</div>
<?php endif;?>*/?>
<br style="clear:both;"/>	

<table style="margin-top:10px;">
    <tr>
        <td></td>
        <td></td>
    </tr>
</table>
        
