<?php
include('header.php');
 ?>
	<style>.def-content{background-color: #131313 !important;} .nav-category a{color: white;}</style>
	<div class="category-content">
		<div class="container-fluid" style="padding-left: 44px; padding-right: 44px; padding-bottom: 200px;">
			<div class="row">
				<div class="col-sm-3 left-side">
					<img src="<?php echo base_url('gocart/themes/'.$this->config->item('theme').'/img/summer-collection.jpg');?>"/>
					<hr style="border-color: #E7E7E7;"/>
					<ul class="nav-category">
						<li>NEW ARRIVALS</li>
						<li><a href="<?php echo base_url('woman');?>">WOMAN</a>
							<ul class="sub-cat" style="padding-left: 10px; font-size: 12px;">
								<li><a href="<?php echo base_url('dresses');?>">Dresses</a></li>
								<li>Outwear</li>
								<li>Dresses</li>
								<li>Outwear</li>
							</ul>
						</li>
						<li>MAN</li>
						<li>SALE</li>
					</ul>
					<!--<hr style="border-color: #E7E7E7;"/>
					<ul>
						<li>SIZES</li>
						<li><input type="checkbox"/> &nbsp;S</li>
						<li><input type="checkbox"/> &nbsp;M</li>
					</ul>-->
					<hr style="border-color: #E7E7E7;"/>
					<ul>
						<li>PRICES</li>
						<li>
							<input id="ex1" data-slider-id="ex1Slider" type="text" data-slider-min="0" data-slider-max="1000000" data-slider-step="1000" data-slider-value="[200000,600000]"/><br/><br/>
						<li>
					</ul>
				</div>
				<!-- Category Producys -->
				<div class="col-sm-9">
					<div class="row">
						<?php 
							if(count($products) > 0):
								//for($j=0;$j<5;$j++):
									$cat_counter = 1;
									$i = 1;
									
									foreach($products as $product):
									$photo	= '<img class="img-responsive lazy" style="background-image: url("../img/clock-gif.gif")" src="'.base_url('images/nopicture.png').'" alt="'.lang('no_image_available').'"/>';
									$product->images	= array_values($product->images);
									
									if(!empty($product->images[0]))
									{
										$primary	= $product->images[0];
										foreach($product->images as $photo)
										{
											if(isset($photo->primary))
											{
												$primary	= $photo;
											}
										}
							
										$photo	= '<img src="'.base_url('uploads/product/thumb/'.$primary->filename).'" alt="'.$product->seo_title.'"/>';
									}
							?>
										<div class="col-xs-6 col-sm-3 product-box">
											<div class="product-detail">
												<?php echo $photo;?>
												<a href="<?php echo base_url($product->slug);?>">
													<div class="product-info-container" style="display: none;">
														<center>
														<div class="product-info" style="background-color: #405164 !important; opacity: 0.7 !important; color: white; display: block">
															
														</div>
														<span style="
															position: absolute;
															top: 38%;
															width: 80%;
															left: 10%;
															color: white;
															font-weight: bold;
														">
															<?php echo $product->name;?>
															<br/>
															<?php echo format_currency($product->price); ?>
														</span>
														</center>
													</div>
												</a>
											</div>
										</div>
						<?php
									endforeach;
								//endfor;
							endif;
						?>
					</div>
					<span style="font:12px Calibri; margin-left: 275px; color: white;" class="pagination"><?php echo $this->pagination->create_view_all_links();?></span>
					<script>
						$(document).ready(function() {
							$('.pagination a').first().remove();
						});
					</script>
				</div>
			</div>
		</div>
	</div>

<?php
include('footer.php');
 ?>