<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title><?php echo $this->config->item('company_name'); if(!empty($page_title)) echo " - ".$page_title; ?></title>

<?php if(isset($meta)):?>
	<?php echo $meta;?>
<?php else:?>
<meta name="Keywords" content="Shopping Cart, eCommerce, Code Igniter">
<meta name="Description" content="Go Cart is an open source shopping cart built on the Code Igniter framework">
<?php endif;?>

<link href="<?php echo base_url('gocart/themes/'.$this->config->item('theme').'/css/styles2.css');?>" type="text/css" rel="stylesheet"/> 

<link type="text/css" href="<?php echo base_url('js/jquery/theme/smoothness/jquery-ui-1.8.16.custom.css');?>" rel="stylesheet" />
<script type="text/javascript" src="<?php echo base_url('js/jquery/jquery-1.7.1.min.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('js/jquery/jquery-ui-1.8.16.custom.min.js');?>"></script>

<link type="text/css" href="<?php echo base_url('js/jquery/colorbox/colorbox.css');?>" rel="stylesheet" />
<script type="text/javascript" src="<?php echo base_url('js/jquery/colorbox/jquery.colorbox-min.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('js/jquery/equal_heights.js');?>"></script>

<script type="application/javascript">
	$(document).ready(function(){
		$(window).bind("load", function() {
			$("#left-content").height($("#right-content").height()+20);
			
		});
		jQuery.event.add(window, "load", resizeFrame);
		jQuery.event.add(window, "resize", resizeFrame);
		
	});
	function resizeFrame() 
	{
		var w = $(window).width();

		if(w>963){
				$('div.header-left-nav').css({'width' : (w/2)-93});
				$('div.header-right-nav').css({'width' : (w/2)-93});

		}else{
			$('div.header-left-nav').css({'width' : 397});
				$('div.header-right-nav').css({'width' : 397});
		}
	}
</script>
<!--<script type="text/javascript"> 
var $buoop = {} 
$buoop.ol = window.onload; 
window.onload=function(){ 
 try {if ($buoop.ol) $buoop.ol();}catch (e) {} 
 var e = document.createElement("script"); 
 e.setAttribute("type", "text/javascript"); 
 e.setAttribute("src", "https://browser-update.org/update.js"); 
 document.body.appendChild(e); 
} 
</script> -->

<?php
//with this I can put header data in the header instead of in the body.
if(isset($additional_header_info))
{
	echo $additional_header_info;
}

?>
</head>

<body>
<div class="top-nav">
    <div class="top-nav-inside">
   		<!--<div class="search">
			<?php  echo form_open('cart/search');?>
        	<div class="garis">
                <span style="font-size: 10px; font-weight: bold;">search</span>
                <input type="text" class="input-search" name="term"/>
            </div>
            <img src="<?php echo base_url('images/search.png');?>" class="search-button"/>
			</form>
        </div>-->
        <ul>
            <li>
            
            
            <a href="<?php echo site_url('cart/view_cart');?>">
			Shopping Bag
			<?php
			//if ($this->go_cart->total_items()==0)
			//{
			//	echo lang('empty_cart');
			//}
			//else
			//{
				echo "(".$this->go_cart->total_items().")";
			//}
			?>
			</a>
            </li>
            <li>Track Order</li>
            <li><a href="<?php echo  site_url('cart/confirmation_payment');?>"> Confirm Payment </a></li>
            <?php if($this->Customer_model->is_logged_in(false, false)):?>
			<li class="bold begin_user_menu"><a href="<?php echo site_url('secure/logout');?>"><?php echo lang('logout');?></a></li>
			<li class="bold">Welcome,<a href="<?php echo  site_url('secure/my_account');?>"> <?php echo $this->customer['firstname'];?>!</a></li>
		<?php else: ?>
			<li class="bold begin_user_menu"><a href="<?php echo site_url('secure/login');?>"><?php echo lang('login');?></a></li>
		<?php endif; ?>
        </ul>        
    </div>

</div>
    
    <div class="clear"></div>
    <div id="header" class="italic">
        
        <div class="header-left-nav">
            <ul>
                <li><a href="#">New Arrival</a></li>
                <li><a href="#">Sales</a></li>
                <li><a href="#">Dress</a></li>
                <li><a href=".">Home</a></li>
            </ul>
        </div>
        <img src="<?php echo base_url('images/logo.png');?>" alt="Scarlet" height="110"/>
        <div class="search" style="position: absolute; top: 0; right: 60px;">
            <?php //echo form_open('cart/search');?>
            <form method="post" accept-charset="utf-8" action="<?php echo base_url();?>cart/search" />
            <div class="garis">
                <span style="font-size: 10px; font-weight: bold;">search</span>
                <input type="text" class="input-search" name="term"/>
                <img src="<?php echo base_url('images/search.png');?>" class="search-button"/>
            </div>
            </form>
        </div>
        <div class="header-right-nav">
            <ul>
                <li><a href="#">New Arrival</a></li>
                <li><a href="#">Sales</a></li>
                <li><a href="#">Dress</a></li>
                <li><a href="#">Home</a></li>
            </ul>
        </div>
    </div>
    
    <div class="clear"></div>
    
    <div id="container">

    	<div id="content">
            
		<?php //if (!empty($page_title)):?><?php //echo $page_title; ?><?php //endif;?>
	
		<?php
		if ($this->session->flashdata('message'))
		{
			echo '<div class="gmessage">'.$this->session->flashdata('message').'</div>';
		}
		if ($this->session->flashdata('error'))
		{
			echo '<div class="error">'.$this->session->flashdata('error').'</div>';
		}
		if (!empty($error))
		{
			echo '<div class="error">'.$error.'</div>';
		}
     		
        	