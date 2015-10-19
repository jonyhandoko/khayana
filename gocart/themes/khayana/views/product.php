<?php include('header.php'); ?>
<style>
	.message_product{
		background-color: #00C4E0;
		font-size: 14px;
		color: black;
		font-weight: bold;
		padding: 5px 0;
		margin: 10px 25px;
	}
	.message_product a{
		color: white;
	}
</style>
<div class="product-content">
	<div class="container-fluid" style="padding-left: 44px; padding-right: 44px; padding-bottom: 200px;">
		<div class="row">
			<?php
			  if ($this->session->flashdata('message_product'))
			  {
				echo '<div class="col-sm-12"><center><div class="message_product">'.$this->session->flashdata('message_product').'</center></div></div>';
			  }
			?>
			<div class="col-sm-1"></div>
			<div class="col-sm-5 product-detail-image" style="padding: 0 50px 0px 50px;">
				<div class="carousel slide carousel-thumbnail" data-ride="carousel">
					<div class="row">
						<div class="col-sm-12">
							<?php
							$img_counter	= 0;
							if(count($product->images) > 0):?>
							<div class="carousel-inner">
								<?php foreach($product->images as $image): 
									$primary = '';
									if(isset($image->primary))
									{
										$primary = 'active';
									}
								?>
								<div class="<?php echo $primary;?> item" data-slide-number="<?php echo $img_counter;?>">
									<img width="100%" src="<?php echo base_url('uploads/product/original/'.$image->filename);?>"/>
								</div>
								<?php 
								$img_counter++;
								endforeach;?>
							</div>
							<?php endif;?>
						</div>
					</div>
					<div class="col-sm-12" style="padding-bottom: 10px; margin-top: 10px;">
						<a class="carousel-control left owl-carousel-arrows-prev" href=".carousel-thumbnail" data-slide="prev" style="z-index: 9999">
							<div class="dark-round">
								<span class="glyphicon glyphicon-chevron-left"></span>
							</div>
						</a>
						<div class="owl-carousel">	
							<?php
							$img_counter	= 0;
							
							if(count($product->images) > 0):
								foreach($product->images as $image): 
									$primary = '';
									if(isset($image->primary))
									{
										$primary = 'selected';
									}
							?>
								<a id="carousel-selector-<?php echo $img_counter;?>" class="item <?php echo $primary;?>">
									<img class="img-responsive" src="<?php echo base_url('uploads/product/original/'.$image->filename);?>" alt="detail-small-1">
								</a>
							<?php 
								$img_counter++;
								endforeach;?>
							<?php endif;?>
						</div>
						<a class="carousel-control right owl-carousel-arrows-next" href=".carousel-thumbnail" data-slide="next" style="z-index: 9999">
							<div class="dark-round">
								<span class="glyphicon glyphicon-chevron-right"></span>
							</div>
						</a>
					</div>
				</div>
				<p>
					<center>
						<span style="color: white; letter-spacing: 3px; font-size: 13px;">SHARE TO FRIENDS</span>
						<i class="fa fa-facebook-f" style="color: white; margin-left: 30px;"></i>
						<i class="fa fa-twitter" style="color: white; margin-left: 10px;"></i>
						<i class="fa fa-google-plus" style="color: white; margin-left: 10px;"></i>
					</center>
				</p>
			</div>
			
			<div class="col-sm-5 product-detail-info">
				<form class="form-inline form-clean" role="form" action="cart/add_to_cart" method="post" accept-charset="utf-8" name="myform">
				<input type="hidden" name="cartkey" value="<?php echo $this->session->flashdata('cartkey');?>" />
				<input type="hidden" name="id" value="<?php echo $product->id?>"/>
				<p class="product-code"><?php if(!empty($product->sku)) echo $product->sku;?></p>
				<p class="product-name" style="font-size: 22px;"><?php echo strtoupper($product->name);?></p>
				<hr/>
				<!-- Sale Price -->
				<?php if($product->sale == 1 && $product->saleprice > 0):
					$date = strtotime(date("Y-m-d"));

					if(strtotime($product->sale_enable_on) <= $date && strtotime($product->sale_disable_on) > $date):
				?>
					<p class="price" style="text-decoration: line-through; color: black !important;"><?php echo format_currency($product->price); ?></p>
					<p class="price"><?php echo format_currency($product->saleprice); ?></p>
				<?php else:?>
					<p class="price"><?php echo format_currency($product->price); ?></p>
				<?php endif;?>
				<?php else:?>
					<p class="price"><?php echo format_currency($product->price); ?></p>
				<?php endif;?>
				<div class="quantity">
					 <?php if((bool)$product->track_stock && $product->quantity < 1): ?>
						<p class="status-instock">OUT OF STOCK</p>
					  <?php else:?>
					  <?php
						if(count($options) > 0): 
							foreach($options as $option):
								$required	= '';
								if($option->required)
								{
								$required = ' <span class="red">*</span>';
								}
					  ?>
					   <span><?php echo $option->name.$required;?> :</span>
							<?php if($option->type == 'droplist'):?>
								<span class="mright25">
								<select name="option[<?php echo $option->id;?>]" class="size" style="width: 110px;">
								<option value="" selected><?php echo "SELECT";?></option>
								
								<?php foreach ($option->values as $values):
									$selected	= '';
									if($value == $values->id)
									{
										$selected	= ' selected="selected"';
									}
									
									if($values->qty != 0){
									?>                     
									<option <?php echo $selected;?> id="<?php echo $values->qty;?>" value="<?php echo $values->id;?>">
										<?php echo($values->price != 0)?'('.format_currency($values->price).') ':''; echo $values->name;?>
									</option>
									<?php }?>
								
								<?php endforeach;?>
								</select>
								</span>
							<?php endif;?>
							<?php endforeach;?>
					   <?php endif;?>
						Quantity &nbsp;
						<select name="quantity">
							<option>1</option>
							<option>2</option>
							<option>3</option>
							<option>4</option>
							<option>5</option>
						</select>
					  <?php endif;?>
					
					<br/><br/><br/>
					<button type="submit" class="btn" style="padding:10px 15px; border-radius: 0; background-color: #00C4E0; color: white; font-size: 12px; letter-spacing: 1px;font-family: CenturyGothicStd;">ADD TO CART</button>
				</div>
				<section id="faq-list">
					<br/><br/>
					<p class="faq-detail light-blue">+ &nbsp;&nbsp; DETAILS</p>
					<div class="answer">
						<p><?php echo $product->description; ?></p>
					</div>
					
					<p class="faq-detail">+ &nbsp;&nbsp; SIZE GUIDE</p>
					<div class="answer" style="display: none;">
						<p>You must be 16 or older, if you`re under 16 years old must be accompanied with adult.</p>
					</div>
					<p class="faq-detail">+ &nbsp;&nbsp; SHIPPING</p>
					<div class="answer" style="display: none;">
						<p>You must be 16 or older, if you`re under 16 years old must be accompanied with adult.</p>
					</div>
				</section>
			</div>
			<div class="col-sm-1"></div>
			</form>
		</div>
		<div class="row">
			<div class="col-sm-12">
				<center>
					<hr style="border-color: #222222"/>
					<br/>
					<p style="color: white; letter-spacing: 3px; font-size: 13px;">OTHER PRODUCTS</p>
					<br/><br/>
				</center>
			</div>
			<div class="col-sm-12" style="padding: 0 120px;">
				<div class="col-sm-3">
					<img width="100%" src="img/product1.jpg"/>
				</div>
				<div class="col-sm-3">
					<img width="100%" src="img/product1.jpg"/>
				</div>
				<div class="col-sm-3">
					<img width="100%" src="img/product1.jpg"/>
				</div>
				<div class="col-sm-3">
					<img width="100%" src="img/product1.jpg"/>
				</div>
			</div>
		</div>
	</div>
</div>
<?php include('footer.php'); ?>