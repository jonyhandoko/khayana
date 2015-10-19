<?php include('header.php'); ?>
  <div class="product">
	<div class="container-fluid">
	  <div class="def-temp">
		<div class="head">
		  <div class="row">
			<div class="col-xs-12">
			  <img src="images/watchinc/watch.png" class="img-responsive pull-left">
			  <h3 class="title"><span class="orange">PRODUCT</span> DETAILS</h3>
			  <ol class="breadcrumb pull-right">
				<li><a href="/">Home</a></li>
				<?php foreach($cats as $cat){?>
					<li><a href="<?php echo $cat->slug;?>"><?php echo $cat->name;?></a></li>
				<?php }?>
				<li class="active"><?php echo $product->name;?></li>
			  </ol>
			</div>
		  </div>
		</div>
		<style>
			.message_product{
				background-color: green;
				font-size: 14px;
				color: white;
				font-weight: bold;
				padding: 5px 0;
				margin: 10px 25px;
			}
			.message_product a{
				color: #f1a744;
			}
		</style>
		<div class="content">
		  <div class="row">
			<?php
			  if ($this->session->flashdata('message_product'))
			  {
				echo '<div class="col-sm-12"><center><div class="message_product">'.$this->session->flashdata('message_product').'</center></div></div>';
			  }
			?>
			<div class="col-sm-7">
			  <div class="carousel slide carousel-thumbnail" data-ride="carousel">
				<div class="row">
				  <div class="col-sm-10">
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
							  <img src="<?php echo base_url('uploads/product/original/'.$image->filename);?>">
							</div>
						<?php 
						$img_counter++;
						endforeach;?>
					</div>		
					<?php endif;?>
				  </div>
				  <div class="hidden-xs col-sm-2">
					<div class="carousel-thumbnail-nav">
					  <ul class="list-unstyled">
						<li>
						  <a class="carousel-control left" href=".carousel-thumbnail" data-slide="prev">
							<div class="dark-round">
							  <span class="glyphicon glyphicon-chevron-up"></span>
							</div>
						  </a>
						</li>
						<?php
						$img_counter	= 0;
						
						if(count($product->images) > 0):?>
							<?php foreach($product->images as $image): 
								$primary = '';
								if(isset($image->primary))
								{
									$primary = 'selected';
								}
							?>
							<li>
								<a id="carousel-selector-<?php echo $img_counter;?>" class="<?php echo $primary;?>">
									<img class="img-responsive" src="<?php echo base_url('uploads/product/original/'.$image->filename);?>">
								</a>
							</li>
							<?php 
							$img_counter++;
							endforeach;?>
						<?php endif;?>		
						<li>
						  <a class="carousel-control right" href=".carousel-thumbnail" data-slide="next">
							<div class="dark-round">
							  <span class="glyphicon glyphicon-chevron-down"></span>
							</div>
						  </a>
						</li>
					  </ul>
					</div>
				  </div>
				</div>
			  </div>
			</div>
			
			<div class="col-sm-5">
			  <div class="describe">
				<div class="title">
				  <p><?php if(!empty($brand)) echo strtoupper($brand->brand_name);?></p>
				  <h3 style="font-weight: bold; color: #666;"><?php echo strtoupper($product->name);?></h3>
				</div>
				<div class="description">
				  <div class="row">
					<div class="col-xs-5">
					  <p class="code">Product Code: <b><?php if(!empty($product->sku)) echo $product->sku;?></b></p>
					  <?php if((bool)$product->track_stock && $product->quantity < 1): ?>
						<p class="status-instock">OUT OF STOCK</p>
					  <?php else:?>
						<p class="status-instock">IN STOCK</p>
					  <?php endif;?>
					  <p><a href="javascript:void(0);" id="godetails">See Description</a></p>
					  <br/><br/>
					  <?php if((bool)$product->track_stock && $product->quantity >= 10): ?>
						 <p class="status-count">(Amount stock 10+)</p>
					  <?php else:?>
						 <p class="status-count">Only <?php echo $product->quantity;?> left in stock</p>
					  <?php endif;?>
					 
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
					</div>
					<div class="col-xs-7">
						<script type="text/javascript" async="" src="//staticw2.yotpo.com/PyQd6tQsY2e6Z0TYYW9GE0d8YNbQOb7WTynU6SST/widget.js"></script>
						<div style="pull-right" class="yotpo bottomLine"
						  data-appkey="PyQd6tQsY2e6Z0TYYW9GE0d8YNbQOb7WTynU6SST"
						  data-domain="Domain of the shop"
						  data-product-id="ssc264p1"
						  data-product-models="Products model information"
						  data-name="Product Title"
						  data-url="The url to the page where the product is url escaped"
						  data-image-url="The product image url. Url escaped"
						  data-description="product description"
						  data-bread-crumbs="Product categories">
					  </div>
					  <!--<form class="star-rating pull-right">
						<input type="radio" name="rating" value="1"><i></i>
						<input type="radio" name="rating" value="2"><i></i>
						<input type="radio" name="rating" value="3"><i></i>
						<input type="radio" name="rating" value="4"><i></i>
					  </form>
					  <p class="star-choice"></p>-->
					  <?php if(!empty($brand)):?><img src="<?php echo $brand->box_image;?>" width="100%"/><?php endif;?>
					</div>
					<div class="col-xs-12" style="padding: 20px; background-color: #CCC;">
					  <form class="form-inline form-clean" role="form" action="cart/add_to_cart" method="post" accept-charset="utf-8" name="myform">
						<input type="hidden" name="cartkey" value="<?php echo $this->session->flashdata('cartkey');?>" />
						<input type="hidden" name="id" value="<?php echo $product->id?>"/>
						<div class="form-group">
						  <label for="quantity" class="control-label">JUMLAH</label>
						  <select class="form-control" name="quantity">
							<option value="1">1</option>
							<option value="2">2</option>
							<option value="3">3</option>
							<option value="4">4</option>
							<option value="5">5</option>
						  </select>
						</div>
						<button type="submit" class="btn btn-orange pull-right">ADD TO CART</button>
					  </form>
					</div>
				  </div>
				</div>
				<div class="share">
				  <ol class="breadcrumb">
					<li>SHARE</li>
					<li><a href="" class="facebook"></a></li>
					<li><a href="" class="twitter"></a></li>
					<li><a href="" class="youtube"></a></li>
					<li><a href="" class="instagram"></a></li>
					<li><a href="" class="googleplus"></a></li>
				  </ol>
				</div>
			  </div>
			</div>
		  </div>
		</div>
	  </div>
	  <div class="def-temp">
		<div class="row">
		  <div class="col-sm-9">
			<div role="tabpanel">
			  <div class="head gotab">
				<img src="images/watchinc//watch.png" class="img-responsive pull-left">
				<ul class="nav nav-tabs as-title" role="tablist">
				  <li role="presentation" class="active"><a href="#details" id="detailstab" aria-controls="details" role="tab" data-toggle="tab">DETAILS</a></li>
				  <li role="presentation"><a href="#deliveryandreturns" aria-controls="deliveryandreturns" role="tab" data-toggle="tab">DELIVERY & RETURNS</a></li>
				  <li role="presentation"><a href="#review" aria-controls="review" role="tab" data-toggle="tab">REVIEW</a></li>
				</ul>
			  </div>
			  <div class="content">
				<div class="tab-content as-title-content">
				  <div role="tabpanel" class="tab-pane active" id="details">
					<div class="section">
					  <p>DESCRIPTION</p>
					  <p><?php echo $product->description; ?></p>
					</div>
					<div class="section">
					  <p>SPECIFICATIONS</p>
					  <div class="as-table">
						<?php foreach($specs as $spec):?>
						<div class="row">
						  <div class="col-xs-4">
							<p><?php echo $spec->name;?></p>
						  </div>
						  <div class="col-xs-8">
							<p><?php echo $spec->value;?></p>
						  </div>
						</div>
						<?php endforeach;?>
					  </div>
					</div>
				  </div>
				  <div role="tabpanel" class="tab-pane" id="deliveryandreturns">
					<div class="section">
					  <p>LOREM IPSUM DOLOR SIT AMET</p>
					  <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
					</div>
					<div class="section">
					  <p>LOREM IPSUM DOLOR SIT AMET</p>
					  <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
					</div>
				  </div>
				  <div role="tabpanel" class="tab-pane" id="review">
					<div class="section">
					  <p>Lorem IPSUM DOLOR SIT AMET CONSECTUR</p>
					  <button class="btn btn-orange">WRITE REVIEW</button>
					</div>
					<div class="section">
					  <p>What do yout think of this product?</p>
					</div>
				  </div>
				</div>
			  </div>
			</div>
		  </div>
		  <div class="col-sm-3">
			<div class="head">
			  <div class="row">
				<div class="col-xs-12">
				  <h3 class="title no-img"><span class="orange">OTHER</span> SUGGESTIONS</h3>
				</div>
			  </div>
			</div>
			<div class="thumbs">
			  <div class="row">
				<?php if(!empty($related)):?>
					<?php
					$cat_counter=1;
					foreach($related as $productRelated):
						$photo	= '<img width="70" src="'.base_url('images/nopicture.png').'" alt="'.lang('no_image_available').'"/>';
								$productRelated->images	= array_values($productRelated->images);

								if(!empty($productRelated->images[0]))
								{
									$primary	= $productRelated->images[0];
									foreach($productRelated->images as $photo)
									{
										if(isset($photo->primary))
										{
											$primary	= $photo;
										}
									}

									$photo	= '<img class="img-responsive" src="'.base_url('uploads/product/thumb/'.$primary->filename).'" alt="'.$productRelated->seo_title.'"/>';
								}
					?>
					<div class="col-xs-12">
					  <a href="<?php echo site_url($productRelated->slug); ?>" class="thumb">
						<div class="image">
						  <?php echo $photo;?>
						</div>
						<div class="desc">
						  <p class="name">
							<?php 
							$string = (strlen($productRelated->name) > 40) ? substr($productRelated->name,0,40).'...' : $productRelated->name;
							echo $string;
							?> 
						  </p>
						 <?php if((bool)$productRelated->track_stock && $productRelated->quantity < 1): ?>
							<p class="red italic"><?php echo lang('out_of_stock');?></div>
						 <?php else:?>
							<?php if($productRelated->sale == 1 && $productRelated->saleprice > 0):
								$date = strtotime(date("Y-m-d"));
								
								if(strtotime($productRelated->sale_enable_on) <= $date && strtotime($productRelated->sale_disable_on) > $date):
							?>
								<p class="orange" style="text-decoration: line-through;"><?php echo format_currency($productRelated->price); ?></p>
								<p class="orange price"><?php echo format_currency($productRelated->saleprice); ?></p>
							<?php else: ?>
								<p class="orange price"><?php echo format_currency($productRelated->price); ?></p><br/>
							<?php endif;
							else: ?>
								<p class="orange price"><?php echo format_currency($productRelated->price); ?></p><br/>
							<?php endif;?>
						 <?php endif;?>
						</div>
					  </a>
					</div>
					<?php 
						endforeach; 
					endif;
					?>
			  </div>
			</div>
		  </div>
		</div>
	  </div>
	</div>
  </div>
</div>
<script>
	$(document).ready(function() {  
		$('#godetails').click(function() {  
			var target = $('.gotab'); 
				$('html, body').animate({ scrollTop: target.offset().top - 50 }, 500);  
			$('#detailstab').click();
			return false;  
		});  
	});
</script>
<?php include('footer.php'); ?>