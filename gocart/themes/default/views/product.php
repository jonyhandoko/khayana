<?php include('header.php'); ?>
<?php include('left_content.php'); ?>
<div id="right-content">
	<link type="text/css" href="<?php echo base_url('js/jquery/jquery.jqzoom.css');?>" rel="stylesheet" />
	<script type="text/javascript" src="<?php echo base_url('js/jquery/jquery.jqzoom-core.js');?>"></script>
	<script type="application/javascript">
		$(document).ready(function(){
			$('.jqzoom').jqzoom({
				zoomType: 'standard',
				lens:false,
				zoomWidth: 425,
				title: false,
				zoomHeight: 403,  
				preloadImages: false,
				alwaysOn:false
			});
			
			
			$('.size').change(function(){
				var qty = $(this).find(':selected')[0].id;

				$(".quantity").empty();
				$('.quantity').fadeIn('fast');
				$(".quantity").append("<div id='loading'></div>");
				$('.quantity').load('<?php echo base_url();?>/gocart/themes/default/views/dropdownAJAX.php?check='+qty);
						
			});
		});
	</script>
	<style>
		a img,:link img,:visited img { border: none; }
		a { text-decoration: none; color: #666; display: block; }
		table { border-collapse: collapse; border-spacing: 0; }
		:focus { outline: none; }
		*{margin:0;padding:0;}
		p, blockquote, dd, dt{margin:0 0 8px 0;line-height:1.5em;}
		fieldset {padding:0px;padding-left:7px;padding-right:7px;padding-bottom:7px;}
		fieldset legend{margin-left:15px;padding-left:3px;padding-right:3px;color:#333;}
		dl dd{margin:0px;}
		dl dt{}
		
		.clearfix:after{clear:both;content:".";display:block;font-size:0;height:0;line-height:0;visibility:hidden;}
		.clearfix{display:block;zoom:1}
		
		
		ul#thumblist{display:block;}
		ul#thumblist li{float:left;margin-right:2px;list-style:none;}
		ul#thumblist li a{display:block;border:1px solid #CCC; height:88px;}
		ul#thumblist li a.zoomThumbActive{
			border:1px solid #333;
		}
	</style>
    
    <h1><?php echo strtoupper($parent);?> / <?php echo $child;?></h1> 
	
    <hr/>
    
    <div class="product-image clearfix" >
    	<div  class="clearfix" >
		<?php
            //get the primary photo for the product
            $photo	= '<img src="'.base_url('images/nopicture.png').'" alt="'.lang('no_image_available').'"/>';
    
            if(count($product->images) > 0 )
            {	
                $primary	= $product->images[0];
                foreach($product->images as $image)
                {
                    if(isset($image->primary))
                    {
                        $primary	= $image;
                    }
                }
    
                $photo	= '<a href="'.base_url('uploads/product/original/'.$primary->filename).'" class="jqzoom" rel="gal1" title="'.$primary->caption.'"><img src="'.base_url('uploads/product/medium/'.$primary->filename).'" alt="'.$product->slug.'"/></a>';
            }
            echo $photo;
        
        
            if(!empty($primary->caption)):?>
            <div id="product_caption">
                <?php echo $primary->caption;?>
            </div>
            <?php endif;?>
        </div>
    </div>
    
	<?php echo form_open('cart/add_to_cart');?>
    <input type="hidden" name="cartkey" value="<?php echo $this->session->flashdata('cartkey');?>" />
	<input type="hidden" name="id" value="<?php echo $product->id?>"/>
    
    <div class="product-detail" >
        <p><strong style="font-size:18px"><?php echo $product->name;?></strong></p>
        <p class="bold black">
        	<?php 
				
				if($product->saleprice > 0 && $product->sale != 0):
					$date = strtotime(date("Y-m-d"));
					if(strtotime($product->sale_enable_on) < $date && strtotime($product->sale_disable_on) > $date):
			?>
				<span class="price_slash"><?php echo format_currency($product->price); ?></span>
				<span class="price_sale"><?php echo format_currency($product->saleprice); ?></span>
			<?php 
					else:
			?>
					<span class="price_reg"><?php echo format_currency($product->price); ?></span>
			 <?php
					endif;
			
				else: ?>
				<span class="price_reg"><?php echo format_currency($product->price); ?></span>
			<?php endif;?>
        
        	<img src="img/new.jpg" style="float: right;" />
        </p>
        <br/>
        
        <?php

		$img_counter	= 1;
		if(count($product->images) > 0):?>
        <ul id="thumblist" class="clearfix" style="height: 100px;" >
        	<?php foreach($product->images as $image): 
			if($image != $primary):
			?>
                <li>
                    <a href='javascript:void(0);' rel="{gallery: 'gal1', smallimage: '<?php echo base_url('uploads/product/medium/'.$image->filename);?>', largeimage: '<?php echo base_url('uploads/product/original/'.$image->filename);?>'}" title="<?php echo $image->caption;?>"><img src="<?php echo base_url('uploads/product/thumb/'.$image->filename);?>"/></a>
                </li>
            <?php endif;
            endforeach;?>
    
        </ul>
        <?php endif;?>
        <?php if((bool)$product->track_stock && $product->quantity <= 0):?>
			<div class="red"><small><?php echo lang('out_of_stock');?></small></div>
        <?php else: ?>
		
            <div id="description_tab" class="details">
                <?php echo $product->description; ?>
            </div>
            <p style="margin: 0; padding: 0; font-size: 10px !important">
            - We cannot guarantee that the colour are 100% accurate on your screen, it depends on your monitor display settings
            </p>
            <hr/>
            <p>
            <?php if(count($options) > 0): ?>
                <div class="product_section" style="float: left;">
                <?php	
                foreach($options as $option):
                    $required	= '';
                    if($option->required)
                    {
                        $required = ' <span class="red">*</span>';
                    }
                    ?>
                    <div class="option_container">
                        <div class="option_name"><?php echo $option->name.$required;?></div>
                        <?php
                        /*
                        this is where we generate the options and either use default values, or previously posted variables
                        that we either returned for errors, or in some other releases of Go Cart the user may be editing
                        and entry in their cart.
                        */
                                
                        //if we're dealing with a textfield or text area, grab the option value and store it in value
                        if($option->type == 'checklist')
                        {
                            $value	= array();
                            if($posted_options && isset($posted_options[$option->id]))
                            {
                                $value	= $posted_options[$option->id];
                            }
                        }
                        else
                        {
                            $value	= $option->values[0]->value;
                            if($posted_options && isset($posted_options[$option->id]))
                            {
                                $value	= $posted_options[$option->id];
                            }
                        }
                                
                        if($option->type == 'textfield'):?>
                        
                            <input type="textfield" id="input_<?php echo $option->id;?>" name="option[<?php echo $option->id;?>]" value="<?php echo $value;?>" />
                        
                        <?php elseif($option->type == 'textarea'):?>
                            
                            <textarea id="input_<?php echo $option->id;?>" name="option[<?php echo $option->id;?>]"><?php echo $value;?></textarea>
                        
                        <?php elseif($option->type == 'droplist'):?>
                            <select name="option[<?php echo $option->id;?>]" class="size">
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
                        <?php elseif($option->type == 'radiolist'):
                                foreach ($option->values as $values):
        
                                    $checked = '';
                                    if($value == $values->id)
                                    {
                                        $checked = ' checked="checked"';
                                    }?>
                                    
                                    <div>
                                    <input<?php echo $checked;?> type="radio" name="option[<?php echo $option->id;?>]" value="<?php echo $values->id;?>"/>
                                    <?php echo($values->price != 0)?'('.format_currency($values->price).') ':''; echo $values->name;?>
                                    </div>
                                <?php endforeach;?>
                        
                        <?php elseif($option->type == 'checklist'):
                            foreach ($option->values as $values):
        
                                $checked = '';
                                if(in_array($values->id, $value))
                                {
                                    $checked = ' checked="checked"';
                                }?>
                                <div class="gc_option_list">
                                <input<?php echo $checked;?> type="checkbox" name="option[<?php echo $option->id;?>][]" value="<?php echo $values->id;?>"/>
                                <?php echo($values->price != 0)?'('.format_currency($values->price).') ':''; echo $values->name;?>
                                </div>
                            <?php endforeach ?>
                        <?php endif;?>
                        </div>
                <?php endforeach;?>
            </div>
        <?php endif; ?>      	
            <div class="product-quantity fleft">
                <label><strong>Qty </strong></label>
                 <div class="quantity" style="display: inline;">
                <?php if(count($options) > 0){?>
                    <select class="quantity" name="quantity" disabled>
                        <option value="">0</option>
                    </select>
                <?php }else{?>
                    <select class="quantity last" name="quantity">
                        <?php
                            if($product->quantity > 10)
                                $val = 10;
                            else
                                $val = $product->quantity;
                            for($i=1;$i<=$val;$i++){
                                echo '<option value="'.$i.'">'.$i.'</option>';
                            }
                        ?>
                    </select>
                <?php } ?>
                </div>
            </div>
            <div class="clear"></div>
            <input type="submit" class="button1" value="ADD TO BAG" />
            <input type="submit" class="button1" value="CHECKOUT" />
            
        <?php endif; ?>
       	<hr/>
        <p style="margin: 0; padding: 0; font-size: 12px !important; color: #000"">Share</p>
       <!-- AddThis Button BEGIN -->
        <div class="addthis_toolbox addthis_default_style ">
        <a class="addthis_button_facebook_like" fb:like:layout="button_count"></a>
        <a class="addthis_button_tweet"></a>
        <a class="addthis_counter addthis_pill_style"></a>
        </div>
        <script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#pubid=xa-4faddad360cabbc9"></script>
        <!-- AddThis Button END -->
    </div>
    </form>
    
    <div class="clear"></div>
    <div class="related" style="height: 162px;">
        <h1 class="italic">You Might Also Like</h1><hr/>
        <?php if(!empty($related)):?>
			
			<?php
			$cat_counter=1;
			foreach($related as $product):
				
				if($cat_counter == 1):?>


				<?php endif;?>
                <div style="float: left; width: 100px; text-align: center">
						<?php
						$photo	= '<img width="70" src="'.base_url('images/nopicture.png').'" alt="'.lang('no_image_available').'"/>';
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

							$photo	= '<img width="70" src="'.base_url('uploads/product/thumb/'.$primary->filename).'" alt="'.$product->seo_title.'"/>';
						}
						?>
                        <div style="height: 100px;">
						<a href="<?php echo site_url($product->slug); ?>">
							<?php echo $photo; ?>
						</a>
                        </div>
						<p>
						<a href="<?php echo site_url($product->slug); ?>"><?php echo $product->name;?></a>
						</p>
                        <!--<p>
						<?php if($product->saleprice > 0):?>
							<span class="gc_price_slash"><?php echo format_currency($product->price); ?></span>
							<span class="gc_price_sale"><?php echo format_currency($product->saleprice); ?></span>
						<?php else: ?>
							<span class="gc_price_reg"><?php echo format_currency($product->price); ?></span>
						<?php endif; ?>
	                    <?php if((bool)$product->track_stock && $product->quantity < 1) { ?>
							<span class="gc_stock_msg"><?php echo lang('out_of_stock');?></span>
						<?php } ?>
                        </p>-->
						</div>
				<?php 
				$cat_counter++;
				if($cat_counter == 5):?>
			
				
				

				<?php 
				$cat_counter = 1;
				endif;
			endforeach;
		 endif;?>
                
        <!--<div style="float: left; width: 80px; text-align: center">
            <img src="img/scaret_detail_thumb.jpg" width="70" title="PAISLY PRINT CHIFFON DRESS" >
            <p>Dress1</p>
        </div>
        <div style="float: left; width: 80px; text-align: center">
            <img src="img/scaret_detail2_thumb.jpg" width="70" title="PAISLY PRINT CHIFFON DRESS" >
            <p>Dress2</p>
        </div>
        <div style="float: left; width: 80px; text-align: center">
            <img src="img/scaret_detail3_thumb.jpg" width="70" title="PAISLY PRINT CHIFFON DRESS" >
            <p>Dress3</p>
        </div>
        <div style="float: left; width: 80px; text-align: center">
            <img src="img/scaret_detail4_thumb.jpg" width="70" title="PAISLY PRINT CHIFFON DRESS" >
            <p>Dress4</p>
        </div>-->
    </div><hr/>

<?php include('footer.php'); ?>