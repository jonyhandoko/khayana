<?php include('header.php'); ?>
<div class="cart-content">
	<div class="col-xs-12" style="height: 80px; background-color: #282828;"></div>
	<div class="container-fluid" style="padding-left: 44px; padding-right: 44px; padding-bottom: 200px;">
		<div class="row">
			<div class="col-xs-12">
				<br/>
				<p style="letter-spacing: 3px; font-size: 18px; color: white;">SHOPPING BAG</p>
			</div>
			<div class="col-xs-12" style="color: white;">
				<?php echo form_open('cart/update_cart', array('id'=>'update_cart_form'));?>
					<?php if ($this->go_cart->total_items()==0):?>
						<div class="message">There are no products in your cart!</div>
					<?php else: ?>
					<div class="panel panel-as-table" style="margin-bottom: 0; border-radius: 0; background-color: transparent;">
						<div class="panel-heading" style="border-bottom: 1px solid #353526;">
							<div class="row">
								<div class="col-sm-2">
									<p>PRODUCT</p>
								</div>
								<div class="col-sm-2">
									<p>DESCRIPTION</p>
								</div>
								<div class="col-sm-2">
									<p>SIZE</p>
								</div>
								<div class="col-sm-2">
									<p>PRICE</p>
								</div>
								<div class="col-sm-2">
									<p>QUANTITY</p>
								</div>
								<div class="col-sm-2" style="text-align: center">
									<p>AMOUNT</p>
								</div>
							</div>
						</div>
						<div class="panel-body" style="border-bottom: 1px solid #353526;">
							<input id="redirect_path" type="hidden" name="redirect" value=""/>
							<?php
								$grandtotal = 0;
								$subtotal = 0;
								//print_r($this->go_cart->contents());
								
								foreach ($this->go_cart->contents() as $cartkey=>$product):
							?>
							<div class="row">
								<div class="col-sm-2">
									<div class="media">
										<div class="pull-left">
											<img class="media-object" width="100" src="<?php echo base_url('uploads/product/thumb/'.$product['images']);?>" alt="cart-2.jpg">
										</div>
									</div>
								</div>
								<div class="col-sm-2">
									<p><?php echo $product['name']; ?></p>
									<a href="<?php echo site_url('cart/remove_item/'.$cartkey);?>" class="red-text">Delete</a>
								</div>
								<div class="col-sm-2">
									<p>M</p>
								</div>
								<div class="col-sm-2">
									<div class="row">
										<div class="col-xs-6 col-sm-12">
											<p class="price"><?php echo format_currency($product['base_price']);?></p>
										</div>
									</div>
								</div>
								<div class="col-sm-2">
									<div class="row">
										<div class="col-xs-6 col-sm-12">
											<input type="text" class="form-control number" name="cartkey[<?php echo $cartkey;?>]" placeholder="quantity" value="<?php echo $product['quantity'] ?>">
										</div>
									</div>
								</div>
								<div class="col-sm-2" style="text-align: right">
									<div class="row">
										<div class="col-xs-6 col-sm-12">
											<p class="price"><?php $subtotal = $product['base_price'] * $product['quantity']; echo format_currency($subtotal); $grandtotal += $subtotal;   ?></p>
										</div>
									</div>
								</div>
							</div>
							<?php endforeach;?>
						</div>
						<div class="panel-footer" style="border: 0; background-color: transparent; border-bottom: 1px solid #353526;">
							<div class="row">
								<div class="col-xs-8" style="text-align: left;">
									<!--<input type="text" placeholder="Enter Promo Code"/>-->
								</div>
								<div class="col-xs-4" style="text-align: right">
									<div class="row">
										<div class="col-xs-6">
											<p>SUBTOTAL</p>
										</div>
										<div class="col-xs-6">
											<p><?php echo format_currency($this->go_cart->subtotal());?></p>
										</div>
										<!--<div class="col-xs-6">
											<p>DELIVERY<br/>
												<span style="font-size: 10px"><i>to be selected at checkout</i></span>
											</p>
										</div>
										<div class="col-xs-6">
											<p>IDR 610.000</p>
										</div>-->
										<div class="col-xs-6"style="clear: both">
											<p>TOTAL BEFORE DELIVERY</p>
										</div>
										<div class="col-xs-6">
											<p><?php echo format_currency($this->go_cart->total());?></p>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-xs-12" style="text-align: right; padding-top: 20px;">
							<button type="submit" onclick="$('#redirect_path').val('checkout');" class="btn" style="padding:10px 15px; border-radius: 0; background-color: #00C4E0; color: white; font-size: 12px; letter-spacing: 1px;font-family: CenturyGothicStd;">CHECKOUT</button>
							<button type="submit" class="btn" style="padding:10px 15px; border-radius: 0; background-color: #D6B797; color: white; font-size: 12px; letter-spacing: 1px;font-family: CenturyGothicStd;">UDPATE CART</button>
						</div>
					</div>
				<?php endif;?>
				</form>
			</div>
		</div>
	</div>
</div>
<?php include('footer.php'); ?>