<?php include('header.php'); ?>
<?php 
if($page_title != "Search"){
include('left_content.php'); 
echo '<div id="right-content">';
}
?>


<h1><?php  
if($page_title == "Search"){
	echo 'SEARCH of "'.$term.'"';
	$sort_by = base_url()."cart/search/".$term;
}else{
	echo strtoupper($category->name);
	$sort_by = base_url().$category->slug;
}
?></h1>
<span style="float: right; font:12px Calibri; ">views all | <?php echo $this->pagination->create_links();?></span>
<script>
	function changeLocation(menuObj)
	{
	   var i = menuObj.selectedIndex;
	
	   if(i > 0)
	   {
		  window.location = menuObj.options[i].value;
	   }
	}
</script>
<select class="w300 mbtm10" name="categoryIndex" onChange="javascript:changeLocation(this)">
	<option selected>Compartment</option>
	<option value="<?php echo $sort_by;?>/name/asc">A to Z</option>
	<option value="<?php echo $sort_by;?>/name/desc">Z to A</option>
	<option value="<?php echo $sort_by;?>/price/asc">Price lowest to highest</option>
	<option value="<?php echo $sort_by;?>/price/desc">Price highest to lowest</option>
</select>
<hr/>


<?php if((!isset($subcategories) || count($subcategories)==0) && (count($products) == 0)):?>
	<div class="message">
		<?php echo lang('no_products');?>
	</div>
<?php endif;?>
<?php if(count($products) > 0):?>
	<?php		
	$cat_counter = 1;
	$i = 1;
	foreach($products as $product):
		if($cat_counter == 1):
		
	?>
    <div class="gallery">
	<div class="product-thumbnail">
		<?php
			$photo	= '<img src="'.base_url('images/nopicture.png').'" alt="'.lang('no_image_available').'"/>';
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

				$photo	= '<img width="235" height="297" src="'.base_url('uploads/product/medium/'.$primary->filename).'" alt="'.$product->seo_title.'"/>';
			}
		?>
		<a href="<?php echo site_url($product->slug); ?>">
			<?php echo $photo; ?>
		</a>
	</div>
	<div class="product_name">
		<a href="<?php echo site_url($product->slug); ?>"><?php echo $product->name;?></a>
	</div>
	<div class="price_container">
		<?php if($product->saleprice > 0):
				$date = strtotime(date("Y-m-d"));
				
				if(strtotime($product->sale_enable_on) < $date && strtotime($product->sale_disable_on) > $date):
		?>
			<span class="price_slash"> <?php echo format_currency($product->price); ?></span>
			<span class="price_sale"><?php echo lang('product_sale');?> <?php echo format_currency($product->saleprice); ?></span>
		
		<?php else: ?>
			<span class="price_reg"> <?php echo format_currency($product->price); ?></span>
		<?php endif;
		
		
		else: ?>
			<span class="price_reg"> <?php echo format_currency($product->price); ?></span>
		<?php endif; ?>
	</div>
		<?php if((bool)$product->track_stock && $product->quantity < 1) { ?>
			<div class="stock_msg"><?php echo lang('out_of_stock');?></div>
		<?php } ?>
	</div>

		<?php endif; 
		
			if(($i % 3)== 0){
				echo '<div class="clear"></div>';
				$count= 3;
			}
			$i++;
		endforeach;
	endif; 
		 ?>
	
	
	<script type="text/javascript">
	$(document).ready(function(){
		$('.category_container').each(function(){
			$(this).children().equalHeights();
		});
	});
	</script>
<?php 
if($page_title != "Search"){

echo '</div>';
}
?>
<?php include('footer.php'); ?>