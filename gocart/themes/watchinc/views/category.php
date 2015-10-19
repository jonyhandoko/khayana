<?php
include('header.php');
 ?>

	<div class="category">
		<div class="container-fluid">
			<div class="col-sm-3">
				<div class="head-filter">
					<img src="<?php echo base_url('images/watchinc/watch.png');?>" class="img-responsive pull-left">
					<h4 class="title" style="margin-bottom: 35px; margin-left: 60px; padding: 8px 0; border-bottom: 1px solid #dedede;"><span class="orange">FILTER</span> BY</h4>
				</div>
				<div class="context-filter">
					<div style="padding: 8px; background-color: #F5F5F5; border: 1px solid #CCC; text-alignment: left;">
						<span>SUBCATEGORY</span>
					</div>
					<style>
						.content-filter{
							padding-left: 10px;
							margin: 30px 0;
						}
						.content-filter ul{
							list-style: none;
						}
						.content-filter li a{
							color: #666;
						}
						.content-filter li a:hover{
							color: #f1a744;
						}
					</style>
					<div class="content-filter">
						<?php if(!empty($subcategories)):?>
						<ul>
							<?php foreach($subcategories as $a):?>
								<li style="margin-bottom: 5px">
									<a href="<?php echo base_url($a->slug);?>"><?php echo strtoupper($a->name);?></a>
								</li>
							<?php endforeach;?>
						</ul>
						<?php else: ?>
							<span>No Subcategories</span>
							<br/><br/>
							<?php if(isset($parent_category)):?>
							back to <a class="orange" href="/<?php echo $parent_category->slug;?>"><?php echo $parent_category->name;?></a>
							<?php endif;?>
						<?php endif; ?>
					</div>
				</div>
				
				<div class="context-filter">
					<div style="padding: 8px; background-color: #F5F5F5; border: 1px solid #CCC; text-alignment: left;">
						<span>PRICE RANGE</span>
					</div>
					<div class="content-filter">
						<ul>
							<li style="margin-bottom: 5px">
								<a href="#" class="priceFilter" price-filter="0.1000000">
								Under 1.000.000 IDR
								</a>
							</li>
							<li style="margin-bottom: 5px">
								<a href="#" class="priceFilter" price-filter="1000000.3000000">
								1.000.000 IDR - 3.000.000 IDR
								</a>
							</li>
							<li style="margin-bottom: 5px">
								<a href="#" class="priceFilter" price-filter="3000000.5000000">
								3.000.000 IDR - 5.000.000 IDR
								</a>
							</li>
							<li style="margin-bottom: 5px">
								<a href="#" class="priceFilter" price-filter="5000000.9000000">
								5.000.000 IDR - 9.000.000 IDR
								</a>
							</li>
							<li style="margin-bottom: 5px">
								<a href="#" class="priceFilter" price-filter="9000000.20000000">
								9.000.000 IDR - 20.000.000 IDR
								</a>
							</li>
						</ul>
					</div>
				</div>
				
				<div class="head-filter">
					<img src="<?php echo base_url('images/watchinc/watch.png');?>" class="img-responsive pull-left">
					<h4 class="title" style="margin-bottom: 35px; margin-left: 60px; padding: 8px 0; border-bottom: 1px solid #dedede;"><span class="orange">PROMO</span> WATCHES</h4>
				</div>
				<div class="context-filter">
					<div style="padding: 8px; background-color: #F5F5F5; border: 1px solid #CCC; text-alignment: left;">
						<span>EXTRA PROMO</span>
					</div>
					<div class="content-filter">
						<ul>
							<li style="margin-bottom: 5px">
								Disc 50%
							</li>
							<li style="margin-bottom: 5px">
								Mega Clearance SEIKO
							</li>
							<li style="margin-bottom: 5px">
								Free Strap
							</li>
						</ul>
					</div>
				</div>
			</div>
			
			<div class="col-sm-9">
				<div class="head-temp">
					<div class="col-sm-12">
						<img src="<?php echo base_url('images/watchinc/watch.png');?>" class="img-responsive pull-left">
						<?php if($page_title=="Search" || $page_title=="New Arrivals" || $page_title=="Sale"):?>
							<h4 class="title" style="margin-left: 60px; padding: 8px 0;"><span class="orange">PRODUCT</span> WATCHES</h4>
							
						<?php else:?>
							<h4 class="title" style="margin-left: 60px; padding: 8px 0; border-bottom: 1px solid #dedede;"><span class="orange">PRODUCT</span> WATCHES  - <span><?php echo $category->seo_title;?></span></h4>
							<div>
								<?php if(!empty($category->image)):?>
									<img width="100%" src="<?php echo base_url('uploads/category/'.$category->image);?>"/>
								<?php endif;?>
							</div>
							<?php $counter=0; foreach($data_filter as $key => $df):	$counter++;?>
							<div id="dd" class="drops wrapper-dropdown-1" tabindex="<?php echo $counter;?>">
								<span class="filter-name" data-filter-code="filter<?php echo ucfirst($key);?>" data-filter-name="<?php echo $key;?>"><?php echo $key;?></span>
								<ul class="dropdown" tabindex="<?php echo $counter;?>">
									<?php foreach($df as $dfvalue):?>
										<li class="coll-filter"><a href="#"><?php echo strtoupper($dfvalue);?></a></li>
									<?php endforeach;?>
								</ul>
							</div>
							<?php endforeach;?>
						<?php endif;?>
					</div>
					<div class="col-sm-12 filter-product" style="border-bottom: 2px solid #efefef; padding-bottom: 5px; padding-left: 0;">
					<!--<?php foreach($data_filter as $key => $df):	?>
						<select name="<?php echo $key;?>" id="filter<?php echo ucfirst($key);?>" class="coll-filter" style="border: none; font-size: 16px; margin-right: 15px;">
							<option value=""><?php echo strtoupper($key);?></option>
							<?php foreach($df as $dfvalue):?>
								<option value="<?php echo $dfvalue;?>"><?php echo strtoupper($dfvalue);?></option>
							<?php endforeach;?>
						</select>
					<?php endforeach;?>-->
					
					
					</div>
					<style>
						.filter-list{display: inline;}
						.filter-box{border: 1px solid #666; color: black; padding: 5px 10px; margin: 0 5px;}
					</style>
					<div class="col-sm-12 filter-container" style="border-bottom: 2px solid #efefef; padding: 15px; padding-left: 5px;">
						<?php
						$current_url = explode("?", $_SERVER['REQUEST_URI']);
						?>
						<a href="<?php echo $current_url[0] ;?>" class="filter-box">Clear All</a>
						<div class="filter-list">
							
						</div>
					</div>
				</div>
				<div class="def-temp">
					<div class="thumbs">
						<div class="row" id="product-content">
							<?php if(count($products) > 0):?>
								<?php for($j=0;$j<1;$j++){?>
								<?php
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
							
										$photo	= '<img class="img-responsive lazy" src="'.base_url('gocart/themes/'.$this->config->item('theme').'/img/clock-gif.gif').'" data-original="'.base_url('uploads/product/thumb/'.$primary->filename).'" alt="'.$product->seo_title.'"/>';
									}
								?>   
								<div class="col-sm-3">
									<a href="<?php echo base_url($product->slug);?>" class="thumb">
									  <div class="image">
										<?php echo $photo; ?>
									  </div>
									  <div class="desc">
										<?php if(!empty($product->brand['brand_name'])):?><p class="brand-name" style="font-weight: bold;"><?php echo strtoupper($product->brand['brand_name']);?></p><?php endif;?>
										<p class="name" style="height: 45px"><?php echo $product->name;?></p>
										<?php if($product->sale == 1 && $product->saleprice > 0):
											$date = strtotime(date("Y-m-d"));
											
											if(strtotime($product->sale_enable_on) <= $date && strtotime($product->sale_disable_on) > $date):
										?>
											<p class="" style="text-decoration: line-through;"><?php echo format_currency($product->price); ?></p>
											<p class="orange price"><?php echo format_currency($product->saleprice); ?></p>
										<?php else: ?>
											<p class="orange price"><?php echo format_currency($product->price); ?></p><br/>
										<?php endif;
										else: ?>
											<p class="orange price"><?php echo format_currency($product->price); ?></p><br/>
										<?php endif;?>
									  </div>
									</a>
								</div>
								<?php endforeach; ?>
								<?php };?>
							<?php endif; ?>
							<span style="font:12px Calibri; margin-left: 275px; display: none;" class="pagination"><?php echo $this->pagination->create_view_all_links();?></span>
						</div>
						<div class="col-sm-12">
							<button type="submit" class="btn btn-orange btn-block more">LOAD MORE</button>
							<br/><br/>
						</div>
					</div>
					<script>
						$(function() {
							$("img.lazy").lazyload({effect: "fadeIn"});
						});
					</script>
				</div>
			</div>
		</div>
	</div>
	<script>
		$(function() {
			$('.more').on("click",function() {
				var next_url = $('.next-pagination').attr('href');
				if(next_url != null){
					$.ajax({
					url: next_url,
					cache: false,
					success: function(data){
							$(".pagination").remove();
							$("div#product-content").append($( data ).find( '#product-content' ).html());
							$("img.lazy").lazyload({effect: "fadeIn"});
						}
					});
				}else{
					$(".more").remove();
				}
			});
		});
	</script>
<?php
include('footer.php');
 ?>