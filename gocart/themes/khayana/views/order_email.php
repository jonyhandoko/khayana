<?php 
	if($payment['details'] == "Paypal Express"){
?>
<table class="summary" width="660" cellpadding="0" cellspacing="0">
<tr>
    <tr>
			<th style="background: #e9e9e9;
		font-size: 13px;
		height: 30px;
		border-bottom: 1px solid #ababab;
		border-top: 1px solid #ababab;" width="250">Product Name</th>
			<th style="background: #e9e9e9;
		font-size: 13px;
		height: 30px;
		border-bottom: 1px solid #ababab;
		border-top: 1px solid #ababab;" width="80">Unit Price</th>
			<th style="background: #e9e9e9;
		font-size: 13px;
		height: 30px;
		border-bottom: 1px solid #ababab;
		border-top: 1px solid #ababab;" width="60">Qty</th>
			<th style="background: #e9e9e9;
		font-size: 13px;
		height: 30px;
		border-bottom: 1px solid #ababab;
		border-top: 1px solid #ababab;">Total Price</th>
		</tr>
</tr>
<?php
$subtotal = 0;
foreach ($this->go_cart->contents() as $cartkey=>$product):?>	
<tr>
    <td style="padding: 20px 0;
		font: 13px georgia;
		text-align: center;
		border-bottom: 1px solid #ababab;"><?php echo $product['name']; ?>
    	<?php echo $product['excerpt'];
			if(isset($product['options'])) {
				echo '<br/>';
				foreach ($product['options'] as $name=>$value)
				{
					if(is_array($value))
					{
						echo '<strong>'.$name.':</strong>';
						foreach($value as $item)
						{
							echo $item;
						}
					} 
					else 
					{
						echo '<strong>'.$name.':</strong>'.$value;
					}
				}
			}
		?>
    </td>
    <td style="padding: 20px 0;
		font: 13px georgia;
		text-align: center;
		border-bottom: 1px solid #ababab;">$<?php echo $product['conversion_price']; ?> USD</td>
    <td style="padding: 20px 0;
		font: 13px georgia;
		text-align: center;
		border-bottom: 1px solid #ababab;"> <?php echo $product['quantity'];?></td>
    <td style="padding: 20px 0;
		font: 13px georgia;
		text-align: center;
		border-bottom: 1px solid #ababab;">$<?php echo $product['conversion_price']*$product['quantity']; ?> USD</td>
</tr>
<?php endforeach;?>
<?php if($this->go_cart->group_discount() > 0)  : ?>
<tr>
    <td></td>
    <td></td>
    <td style="padding: 5px 0;
		font: 13px georgia;
		text-align: center;
		border-bottom: 1px solid #ababab;">Member Discount - <?php echo $this->go_cart->group_discount_percentage();?>%</td>
    <td style="padding: 5px 0;
		font: 13px georgia;
		text-align: center;
		border-bottom: 1px solid #ababab;">$<?php echo 0-$this->go_cart->conversion_group_discount();?> USD</td>
</tr>
<?php endif; ?>
<tr>
    <td></td>
    <td></td>
    <td style="padding: 5px 0;
		font: 13px georgia;
		text-align: center;
		border-bottom: 1px solid #ababab;">SubTotal</td>
    <td style="padding: 5px 0;
		font: 13px georgia;
		text-align: center;
		border-bottom: 1px solid #ababab;">$<?php echo $this->go_cart->conversion_subtotal();?> USD</td>
</tr>
<tr>
    <td></td>
    <td></td>
    <td style="padding: 5px 0;
		font: 13px georgia;
		text-align: center;
		border-bottom: 1px solid #ababab;">Shipping</td>
    <td style="padding: 5px 0;
		font: 13px georgia;
		text-align: center;
		border-bottom: 1px solid #ababab;">$<?php echo $this->go_cart->conversion_shipping_cost();?> USD</td>
</tr>
<tr>
    <td></td>
    <td></td>
    <td style="padding: 5px 0;
		font: 13px georgia;
		text-align: center;
		border-bottom: 1px solid #ababab;">Grand Total</td>
    <td style="padding: 5px 0;
		font: 13px georgia;
		text-align: center;
		border-bottom: 1px solid #ababab;">$<?php echo $this->go_cart->conversion_total();?> USD</td>
</tr>
</table>

<p style="font: bold 16px arial">Delivery address</p>
<p style="color: black;">
	<?php 		$ship = $customer['ship_address'];
             
             echo $ship['firstname'].' '.$ship['lastname'].' &lt;'.$ship['email'].'&gt;<br>';
             echo $ship['phone'].'<br>';
             echo $ship['address1'].'<br>';
             if(!empty($ship['address2'])) echo $ship['address2'].'<br>';
             echo $ship['province'].', '.$ship['zip'];
    ?>
</p>

<?php
	}else{
?>
<table class="summary" width="660" cellpadding="0" cellspacing="0">
<tr>
    <tr>
			<th style="background: #e9e9e9;
		font-size: 13px;
		height: 30px;
		border-bottom: 1px solid #ababab;
		border-top: 1px solid #ababab;" width="250">Product Name</th>
			<th style="background: #e9e9e9;
		font-size: 13px;
		height: 30px;
		border-bottom: 1px solid #ababab;
		border-top: 1px solid #ababab;" width="80">Unit Price</th>
			<th style="background: #e9e9e9;
		font-size: 13px;
		height: 30px;
		border-bottom: 1px solid #ababab;
		border-top: 1px solid #ababab;" width="60">Qty</th>
			<th style="background: #e9e9e9;
		font-size: 13px;
		height: 30px;
		border-bottom: 1px solid #ababab;
		border-top: 1px solid #ababab;">Total Price</th>
		</tr>
</tr>
<?php
$subtotal = 0;
foreach ($this->go_cart->contents() as $cartkey=>$product):?>	
<tr>
    <td style="padding: 20px 0;
		font: 13px georgia;
		text-align: center;
		border-bottom: 1px solid #ababab;"><?php echo $product['name']; ?>
    	<?php echo $product['excerpt'];
			if(isset($product['options'])) {
				echo '<br/>';
				foreach ($product['options'] as $name=>$value)
				{
					if(is_array($value))
					{
						echo '<strong>'.$name.':</strong>';
						foreach($value as $item)
						{
							echo $item;
						}
					} 
					else 
					{
						echo '<strong>'.$name.':</strong>'.$value;
					}
				}
			}
		?>
    </td>
    <td style="padding: 20px 0;
		font: 13px georgia;
		text-align: center;
		border-bottom: 1px solid #ababab;"><?php echo format_currency($product['price']);   ?></td>
    <td style="padding: 20px 0;
		font: 13px georgia;
		text-align: center;
		border-bottom: 1px solid #ababab;"> <?php echo $product['quantity'];?></td>
    <td style="padding: 20px 0;
		font: 13px georgia;
		text-align: center;
		border-bottom: 1px solid #ababab;"><?php echo format_currency($product['price']*$product['quantity']); ?></td>
</tr>
<?php endforeach;?>
<?php if($this->go_cart->group_discount() > 0)  : ?>
<tr>
    <td></td>
    <td></td>
    <td style="padding: 5px 0;
		font: 13px georgia;
		text-align: center;
		border-bottom: 1px solid #ababab;">Member Discount - <?php echo $this->go_cart->group_discount_percentage();?>%</td>
    <td style="padding: 5px 0;
		font: 13px georgia;
		text-align: center;
		border-bottom: 1px solid #ababab;"><?php echo format_currency(0-$this->go_cart->group_discount());?></td>
</tr>
<?php endif; ?>
<tr>
    <td></td>
    <td></td>
    <td style="padding: 5px 0;
		font: 13px georgia;
		text-align: center;
		border-bottom: 1px solid #ababab;">SubTotal</td>
    <td style="padding: 5px 0;
		font: 13px georgia;
		text-align: center;
		border-bottom: 1px solid #ababab;"><?php echo format_currency($this->go_cart->subtotal());?></td>
</tr>
<tr>
    <td></td>
    <td></td>
    <td style="padding: 5px 0;
		font: 13px georgia;
		text-align: center;
		border-bottom: 1px solid #ababab;">Shipping</td>
    <td style="padding: 5px 0;
		font: 13px georgia;
		text-align: center;
		border-bottom: 1px solid #ababab;"><?php echo format_currency($this->go_cart->shipping_cost());?></td>
</tr>
<tr>
    <td></td>
    <td></td>
    <td style="padding: 5px 0;
		font: 13px georgia;
		text-align: center;
		border-bottom: 1px solid #ababab;">Grand Total</td>
    <td style="padding: 5px 0;
		font: 13px georgia;
		text-align: center;
		border-bottom: 1px solid #ababab;"><?php echo format_currency($this->go_cart->total());?></td>
</tr>
</table>

<p style="font: bold 16px arial">Delivery address</p>
<p style="color: black;">
	<?php 		$ship = $customer['ship_address'];
             
             echo $ship['firstname'].' '.$ship['lastname'].' &lt;'.$ship['email'].'&gt;<br>';
             echo $ship['phone'].'<br>';
             echo $ship['address1'].'<br>';
             if(!empty($ship['address2'])) echo $ship['address2'].'<br>';
             echo $ship['province'].', '.$ship['zip'];
    ?>
</p>
<?php
	}
?>