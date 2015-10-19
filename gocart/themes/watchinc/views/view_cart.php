<?php include('header.php'); ?>

  <div class="product">
	<div class="container-fluid">
		<div class="def-temp">
			<div class="head">
			  <div class="row">
				<div class="col-xs-12">
				  <img src="images/watch.png" class="img-responsive pull-left">
				  <h3 class="title"><span class="orange">SHOPPING</span> CART</h3>
				  <ol class="breadcrumb pull-right">
					<li><a href="">Home</a></li>
					<li><a href="">Brands</a></li>
					<li><a href="">DKNY</a></li>
					<li class="active">Lorem Ipsum Dolor</li>
				  </ol>
				</div>
			  </div>
			</div>
		</div>
		<div class="content">
			<div class="row" style="margin-bottom: 30px;">
				<div class="col-xs-12">
					<?php echo form_open('cart/update_cart', array('id'=>'update_cart_form'));?>
					<?php if ($this->go_cart->total_items()==0):?>
						<div class="message">There are no products in your cart!</div>
					<?php else: ?>
					<div class="panel panel-as-table" style="margin-bottom: 0; border: 1px solid #CCC; border-top: 2px solid #000; border-radius: 0;">
						<div class="panel-heading">
						  <div class="row">
							<div class="col-sm-6">
							  <p>PRODUCT</p>
							</div>
							<div class="col-sm-2">
							  <p>PRICE</p>
							</div>
							<div class="col-sm-2">
							  <p>QUANTITY</p>
							</div>
							<div class="col-sm-2">
							  <p>TOTAL</p>
							</div>
						  </div>
						</div>
						<div class="panel-body">
						  <?php
							$grandtotal = 0;
							$subtotal = 0;
							//print_r($this->go_cart->contents());

							foreach ($this->go_cart->contents() as $cartkey=>$product):
						  ?>
						  <div class="row">
							<div class="col-sm-6">
							  <div class="media">
								<div class="pull-left">
								  <img class="media-object" width="100" src="<?php echo base_url('uploads/product/thumb/'.$product['images']);?>" alt="cart-2.jpg">
								</div>
								<div class="media-body">
								  <p><?php echo $product['name']; ?></p>
								  <!--<p><i>Perspiciatis unde omnis iste natus errorsit voluptatem</i></p>-->
								  <a href="<?php echo site_url('cart/remove_item/'.$cartkey);?>" class="red-text">Delete</a>
								</div>
							  </div>
							</div>
							<div class="col-sm-2">
							  <div class="row">
								<div class="col-xs-6 col-sm-12">
								  <p class="price"><?php echo format_currency($product['base_price']);   ?></p>
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
							<div class="col-sm-2">
							  <div class="row">
								<div class="col-xs-6 col-sm-12">
								  <p class="price"><?php $subtotal = $product['base_price'] * $product['quantity']; echo format_currency($subtotal); $grandtotal += $subtotal;   ?></p>
								</div>
							  </div>
							</div>
						  </div>
						  <?php endforeach;?>
						  <div style="clear:both; margin: 10px auto;"></div>
						</div>
						<div class="panel-footer" style="background-color: #fff;">
							<div class="row">
								<div class="col-xs-12" style="text-align: right;">
									<button class="btn btn-orange" style="padding: 6px 30px;">KEEP SHOPPING</button>
									<button class="btn btn-black" style="border-radius: 0px; padding:6px 30px;">UPDATE CART</button>
								</div>
						</div>
					</div>
				  </div>
				  <?php endif;?>
				</div>
				<div class="col-sm-5">
					<div class="def-temp">
						<div class="panel panel-as-table" style="margin-top: 20px; border: 1px solid #CCC; border-radius: 0; padding: 30px;">
							<h3 class="title" style="margin-top: 0;"><span class="orange">HAVE</span> A COUPON?</h3>
							
							
						</div>
					</div>
				</div>
				
				<div class="col-sm-1"></div>
				
				<div class="col-sm-6">
					<div class="def-temp">
						<div class="panel panel-as-table" style="margin-top: 20px; border: 1px solid #CCC; border-radius: 0; padding: 30px;">
							<h3 class="title" style="margin-top: 0;"><span class="orange">CART</span> TOTAL</h3>
							<div class="row">
								<div class="col-sm-6">
									<span>CART SUBTOTAL</span>
								</div>
								<div class="col-sm-6" style="text-align: right;">
									<?php echo format_currency($this->go_cart->subtotal());?>
								</div>
								<div class="col-sm-6">
									<span>SHIPPING</span>
								</div>
								<div class="col-sm-6" style="text-align: right;">
									<?php echo format_currency($this->go_cart->shipping_cost());?>
								</div>
								<div class="col-sm-6">
									<span>ORDER TOTAL</span>
								</div>
								<div class="col-sm-6" style="text-align: right;">
									<?php echo format_currency($this->go_cart->total());?>
								</div>
								<div class="col-sm-12" style="text-align: right;">
									<input id="redirect_path" type="hidden" name="redirect" value=""/>
									<br/><button class="btn btn-black" onClick="$('#redirect_path').val('checkout');" style="border-radius: 0px; padding:6px 30px;">PROCEED TO CHECKOUT</button>
								</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			  </div>
			</div>
		</div>
	</div>

<?php include('footer.php'); ?>