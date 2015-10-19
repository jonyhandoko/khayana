<?php
include('header.php');
 ?>
	<style>.def-content{background-color: #131313 !important;}</style>
	<div class="category-content">
		<div class="container-fluid" style="padding-left: 44px; padding-right: 44px; padding-bottom: 200px;">
			<div class="row">
				<div class="col-sm-3 left-side">
					<img src="<?php echo base_url('gocart/themes/'.$this->config->item('theme').'/img/summer-collection.jpg');?>"/>
					<hr style="border-color: #E7E7E7;"/>
					<ul>
						<li>NEW ARRIVALS</li>
						<li>WOMAN
							<ul class="sub-cat" style="padding-left: 10px; font-size: 12px;">
								<li>Dresses</li>
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
						foreach($subcategories as $subcategory):
						?>
						<div class="col-xs-6 col-sm-4 product-box">
							<a href="<?php echo base_url($subcategory->slug);?>"/>
								<img src="<?php echo base_url('uploads/category/'.$subcategory->image);?>" width="100%"/>
							</a>
						</div>
						<?php endforeach;?>
					</div>
				</div>
			</div>
		</div>
	</div>

<?php
include('footer.php');
 ?>