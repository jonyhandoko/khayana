<?php 
	if($payment['details'] == "Paypal Express"){
?>
<div style="font-size:12px; font-family:arial, verdana, sans-serif;">
	<?php if ($this->config->item('site_logo')) :?>
	<div>
		<img src="<?php echo base_url($this->config->item('site_logo'));?>" />
	</div>
	<?php endif; ?>
    
    <?php
	$ship = $customer['ship_address'];
	//$bill = $customer['bill_address'];
	?>
	
	<table style="border:1px solid #000; width:100%; font-size:13px;" cellpadding="5" cellspacing="0">
		<tr>
			<td style="width:20%; vertical-align:top;" class="packing">
				<h2 style="margin:0px">Order No. #<?php echo $order_id;?></h2>
				<br/>
				<p>Invoice Date: 
				<?php 
					// Change the line below to your timezone!
					date_default_timezone_set('Asia/Jakarta');
					$date = date('m/d/Y h:i:s a', time());
					echo $date;
				?></p>
			</td>
			<td style="width:40%; vertical-align:top;">
				<strong><?php echo 'Bill to Address';?></strong><br/>
				<?php echo $ship['firstname'].' '.$ship['lastname'];?> <br/>
				<?php echo $ship['address1'];?><br>
				<?php echo (!empty($ship['address2']))?$ship['address2'].'<br/>':'';?>
				<?php echo $ship['province'].', '.$ship['zip'];?><br/>
				<?php echo 'Indonesia';?><br/>

				<?php echo $ship['email'];?><br/>
				<?php echo $ship['phone'];?>

			</td>
			<td style="width:40%; vertical-align:top;" class="packing">
				<strong><?php echo lang('ship_to_address');?></strong><br/>		
				<?php echo $ship['firstname'].' '.$ship['lastname'];?> <br/>
				<?php echo $ship['address1'];?><br>
				<?php echo (!empty($ship['address2']))?$ship['address2'].'<br/>':'';?>
				<?php echo $ship['province'].', '.$ship['zip'];?><br/>
				<?php echo 'Indonesia';?><br/>

				<?php echo $ship['email'];?><br/>
				<?php echo $ship['phone'];?>

			<br/>
			</td>
		</tr>
		
		<tr>
			<td style="border-top:1px solid #000;"></td>
			<td style="border-top:1px solid #000;">
				<strong><?php echo lang('payment_method').":";?></strong>
				<?php echo $payment['details']; ?>
			</td>
			<td style="border-top:1px solid #000;">
				<strong><?php echo 'Shipping Details: ';?></strong>
				<?php echo $shipping; ?>
			</td>
		</tr>
        
		<?php if(!empty($shipping_notes)):?>
			<tr>
				<td colspan="3" style="border-top:1px solid #000;">
					<strong><?php echo lang('shipping_notes');?></strong><br/><?php echo $shipping_notes;?>
				</td>
			</tr>
		<?php endif;?>
	</table>
	
	<table border="1" style="width:100%; margin-top:10px; border-color:#000; font-size:13px; border-collapse:collapse;" cellpadding="5" cellspacing="0">
		<thead>
			<tr>
				<th width="20%" class="packing">
					<?php echo lang('name');?>
				</th>
                <th class="packing" >
					<?php echo lang('description');?>
				</th>
                <th width="5%" class="packing">
					<?php echo 'Qty';?>
				</th>
                <th width="25%" class="packing" >
					Subtotal
				</th>
			</tr>
		</thead>


<?php 
		$subtotal = 0;
		foreach($this->go_cart->contents() as $cartkey=>$product):
		$img_count = 1;
?>
		<tr>
			<td class="packing">
				<?php echo $product['name'];?>
			</td>
			<td class="packing">
				<?php
				if(isset($product['options']))
				{
					foreach($product['options'] as $name=>$value)
					{
						$name = explode('-', $name);
						$name = trim($name[0]);
						if(is_array($value))
						{
							echo '<div>'.$name.':<br/>';
							foreach($value as $item)
							{
								echo '- '.$item.'<br/>';
							}	
							echo "</div>";
						}
						else
						{
							echo '<div>'.$name.': '.$value.'</div>';
						}
					}
				}

				?>
			</td>
            <td class="packing" style="font-size:16px;">
				<?php echo $product['quantity'];?>
			</td>
            <td class="packing" align="center">
                <p class="times13">$<?php echo $product['conversion_price']*$product['quantity']; ?> USD</p>	
            </td>
		</tr>
<?php	endforeach;?>

		 <?php if($this->go_cart->group_discount() > 0)  : ?> 
            
        <tr>
            <td align="right" colspan="3">
                <p>Member Discount - <?php echo $this->go_cart->group_discount_percentage();?>%</p>
            </td>
            <td align="center">
                <p class="times13">$<?php echo 0-$this->go_cart->conversion_group_discount();?> USD</p>	
            </td>
        </tr>
        <?php endif; ?>
        
        <tr>
            <td align="right" colspan="3">
                <p>Subtotal</p>
            </td>
            <td align="center">
                <p class="times13">$<?php echo $this->go_cart->conversion_subtotal();?> USD</p>	
            </td>
        </tr>
        
        <?php
        if($this->go_cart->shipping_cost()>0) : ?>
        <tr>
           <td align="right" colspan="3">
                <p>Shipping</p>
            </td>
            <td align="center">
                <p class="times13"><?php echo "<span class='shipping'>$".$this->go_cart->conversion_shipping_cost()." USD</span>";?></p>	
            </td>
        </tr>
        <?php endif ?>
        
        <tr>
           <td align="right" colspan="3">
                <p>Grand Total</p>
            </td>
            <td align="center">
                <p class="times13 bold"><?php echo "<span class='grandtotal'>$".$this->go_cart->conversion_total()." USD</span>"; ?></p>	
            </td>
        </tr>
	</table>
</div>

<br class="break"/>
<?php
	}else{
?>
<div style="font-size:12px; font-family:arial, verdana, sans-serif;">
	<?php if ($this->config->item('site_logo')) :?>
	<div>
		<!--<img src="<?php echo base_url($this->config->item('site_logo'));?>" />-->
	</div>
	<?php endif; ?>
    
    <?php
	$ship = $customer['ship_address'];
	//$bill = $customer['bill_address'];
	?>
	
	<table style="border:1px solid #000; width:100%; font-size:13px;" cellpadding="5" cellspacing="0">
		<tr>
			<td style="width:20%; vertical-align:top;" class="packing">
				<h2 style="margin:0px">Order No. #<?php echo $order_id;?></h2>
				<p>Invoice Date: 
				<?php 
					// Change the line below to your timezone!
					date_default_timezone_set('Asia/Jakarta');
					$date = date('m/d/Y h:i:s a', time());
					echo $date;
				?></p>
			</td>
			<td style="width:40%; vertical-align:top;">
				<strong><?php echo 'Bill to Address';?></strong><br/>
				<?php echo $ship['firstname'].' '.$ship['lastname'];?> <br/>
				<?php echo $ship['address1'];?><br>
				<?php echo (!empty($ship['address2']))?$ship['address2'].'<br/>':'';?>
				<?php echo $ship['province'].', '.$ship['zip'];?><br/>
				<?php echo 'Indonesia';?><br/>

				<?php echo $ship['email'];?><br/>
				<?php echo $ship['phone'];?>

			</td>
			<td style="width:40%; vertical-align:top;" class="packing">
				<strong><?php echo lang('ship_to_address');?></strong><br/>		
				<?php echo $ship['firstname'].' '.$ship['lastname'];?> <br/>
				<?php echo $ship['address1'];?><br>
				<?php echo (!empty($ship['address2']))?$ship['address2'].'<br/>':'';?>
				<?php echo $ship['province'].', '.$ship['zip'];?><br/>
				<?php echo 'Indonesia';?><br/>

				<?php echo $ship['email'];?><br/>
				<?php echo $ship['phone'];?>

			<br/>
			</td>
		</tr>
		
		<tr>
			<td style="border-top:1px solid #000;"></td>
			<td style="border-top:1px solid #000;">
				<strong><?php echo lang('payment_method').":";?></strong>
				<?php echo $payment['details']; ?>
			</td>
			<td style="border-top:1px solid #000;">
				<strong><?php echo 'Shipping Details: ';?></strong>
				<?php echo $shipping; ?>
			</td>
		</tr>
        
		<?php if(!empty($shipping_notes)):?>
			<tr>
				<td colspan="3" style="border-top:1px solid #000;">
					<strong><?php echo lang('shipping_notes');?></strong><br/><?php echo $shipping_notes;?>
				</td>
			</tr>
		<?php endif;?>
	</table>
	
	<table border="1" style="width:100%; margin-top:10px; border-color:#000; font-size:13px; border-collapse:collapse;" cellpadding="5" cellspacing="0">
		<thead>
			<tr>
				<th width="20%" class="packing">
					<?php echo lang('name');?>
				</th>
                <th class="packing" >
					<?php echo lang('description');?>
				</th>
                <th width="5%" class="packing">
					<?php echo 'Qty';?>
				</th>
                <th width="25%" class="packing" >
					Subtotal
				</th>
			</tr>
		</thead>


<?php 
		$subtotal = 0;
		foreach($this->go_cart->contents() as $cartkey=>$product):
		$img_count = 1;
?>
		<tr>
			<td class="packing">
				<?php echo $product['name'];?>
			</td>
			<td class="packing">
				<?php
				if(isset($product['options']))
				{
					foreach($product['options'] as $name=>$value)
					{
						$name = explode('-', $name);
						$name = trim($name[0]);
						if(is_array($value))
						{
							echo '<div>'.$name.':<br/>';
							foreach($value as $item)
							{
								echo '- '.$item.'<br/>';
							}	
							echo "</div>";
						}
						else
						{
							echo '<div>'.$name.': '.$value.'</div>';
						}
					}
				}

				?>
			</td>
            <td class="packing" style="font-size:16px;">
				<?php echo $product['quantity'];?>
			</td>
            <td class="packing" align="center">
                <p class="times13"><?php echo format_currency($product['price']*$product['quantity']); ?></p>	
            </td>
		</tr>
<?php	endforeach;?>

		 <?php if($this->go_cart->group_discount() > 0)  : ?> 
            
        <tr>
            <td align="right" colspan="3">
                <p>Member Discount - <?php echo $this->go_cart->group_discount_percentage();?>%</p>
            </td>
            <td align="center">
                <p class="times13"><?php echo format_currency(0-$this->go_cart->group_discount());?></p>	
            </td>
        </tr>
        <?php endif; ?>
        
        <tr>
            <td align="right" colspan="3">
                <p>Subtotal</p>
            </td>
            <td align="center">
                <p class="times13"><?php echo format_currency($this->go_cart->subtotal());?></p>	
            </td>
        </tr>
        
        <?php
        if($this->go_cart->shipping_cost()>0) : ?>
        <tr>
           <td align="right" colspan="3">
                <p>Shipping</p>
            </td>
            <td align="center">
                <p class="times13"><?php echo "<span class='shipping'>".format_currency($this->go_cart->shipping_cost())."</span>";?></p>	
            </td>
        </tr>
        <?php endif; ?>
        
        <tr>
           <td align="right" colspan="3">
                <p>Grand Total</p>
            </td>
            <td align="center">
                <p class="times13 bold"><?php echo "<span class='grandtotal'>".format_currency($this->go_cart->total())."</span>"; ?></p>	
            </td>
        </tr>
	</table>
</div>

<br class="break"/>
<?php } ?>