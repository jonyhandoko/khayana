<!DOCTYPE html>
<html lang="en">
  <head>
	<script>
		var isMobile = {
			Android: function() {
				return navigator.userAgent.match(/Android/i);
			},
			BlackBerry: function() {
				return navigator.userAgent.match(/BlackBerry/i);
			},
			iOS: function() {
				return navigator.userAgent.match(/iPhone|iPad|iPod/i);
			},
			Opera: function() {
				return navigator.userAgent.match(/Opera Mini/i);
			},
			Windows: function() {
				return navigator.userAgent.match(/IEMobile/i);
			},
			any: function() {
				return (isMobile.Android() || isMobile.BlackBerry() || isMobile.iOS() || isMobile.Opera() || isMobile.Windows());
			}
		};
	</script>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="author" content="">

    <title>Khayana <?php if(isset($page_title)): echo ' - '.$page_title; endif;?></title>

    <link href="<?php echo base_url('gocart/themes/'.$this->config->item('theme').'/css/bootstrap.css');?>" rel="stylesheet">
	<link href="<?php echo base_url('gocart/themes/'.$this->config->item('theme').'/css/devs.css');?>" rel="stylesheet">
	<link href="<?php echo base_url('gocart/themes/'.$this->config->item('theme').'/css/fonts.css');?>" rel="stylesheet">
	<link href="<?php echo base_url('gocart/themes/'.$this->config->item('theme').'/css/font-awesome.css');?>" rel="stylesheet">
	<link href="<?php echo base_url('gocart/themes/'.$this->config->item('theme').'/css/owl.carousel.css');?>" rel="stylesheet">
	<link href="<?php echo base_url('gocart/themes/'.$this->config->item('theme').'/css/bootstrap-slider.css');?>" rel="stylesheet">
	<link href='http://fonts.googleapis.com/css?family=Roboto:300' rel='stylesheet' type='text/css'>
	
	<script src="<?php echo base_url('gocart/themes/'.$this->config->item('theme').'/js/init.js');?>"></script>
	<script src="<?php echo base_url('gocart/themes/'.$this->config->item('theme').'/js/plug.js');?>"></script>
	<script src="<?php echo base_url('gocart/themes/'.$this->config->item('theme').'/js/devs.js');?>"></script>
	<script src="<?php echo base_url('gocart/themes/'.$this->config->item('theme').'/js/bootstrap-slider.js');?>"></script>
	<script src="<?php echo base_url('gocart/themes/'.$this->config->item('theme').'/js/jquery.colorbox-min.js');?>"></script>
	<script src="<?php echo base_url('gocart/themes/'.$this->config->item('theme').'/js/owl.carousel.min.js');?>"></script>
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="images/watchinc/ico/apple-touch-icon-144-precomposed.png">
    <link rel="shortcut icon" href="<?php echo base_url('images/khayana/ico/favicon.ico');?>">
  </head>
  <body>
	<div class="def-header">
		<nav class="navbar navbar-default navbar-static-top">
			<div class="container-fluid">
				<div class="navbar-header col-sm-12">
					<center class="hidden-xs">
						<a href=""><img src="<?php echo base_url('gocart/themes/'.$this->config->item('theme').'/img/logo_header.jpg');?>" /></a>
					</center>
					<a href="" class="visible-xs" style="float: left"><img src="<?php echo base_url('gocart/themes/'.$this->config->item('theme').'/img/logo_header.jpg');?>" /></a>
					<button class="navbar-toggle navbar-toggle-left collapsed" data-toggle="collapse" data-target="#category" aria-expanded="false" aria-controls="category">
						<img width="50%" src="<?php echo base_url('/images/khayana/icon/menu.png');?>">
					</button>
				</div>
				
			</div>
		</nav>
	</div>
	
	<div class="def-menu">
		<div class="container-fluid">
			<div id="category" class="category navbar-collapse collapse">
				<div class="row">
					<div class="col-sm-4">
						<ul class="nav navbar-nav text-center def-list">
						  <li><a class="blue small">FREE SHIPPING ALL JABOTABEK</a></li>
						</ul>
					</div>
					<div class="col-sm-5">
						<ul class="nav navbar-nav text-center def-list">
						  <li><a href="<?php echo base_url("cart/collection");?>" class="white">COLLECTIONS</a></li>
						  <li><a href="<?php echo base_url("blog");?>" class="white">JOURNAL</a></li>
						  <li><a href="" class="white">OUR STORY</a></li>
						</ul>
					</div>
					<div class="col-sm-3">
						<ul class="nav navbar-nav text-center def-list">
							<li><a class="white" href='<?php echo base_url("secure/login");?>'><i class="fa fa-user"></i></a></li>
							<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" style="color: white;"><i class="fa fa-search"></i></a>
								<ul class="dropdown-menu search-box" style="padding:12px; background-color: black; left: -50px; width: 200px; border: none;">
									<form class="form-inline" method="post" action="<?php echo base_url('cart/search'); ?>">
										<div class="left-inner-addon">
											<i class="fa fa-search"></i>
											<input type="text" value="" id="email" name="term" class="search-input" placeholder="search here" style="width: 80%"/>
										</div>
									</form>
								</ul>
							</li>
							<li  class="dropdown">
								<a class="white" data-toggle="dropdown" role="button" aria-expanded="false" href="">
									<i class="fa fa-shopping-cart"></i> CART [<?php echo $this->go_cart->total_items();?>]
									<span class="caret"></span>
								</a>
								<ul class="dropdown-menu def-dropdown cart-down" role="menu" style= "right: -1px; left: auto;">
									<center>
										<h6>BAG ITEMS</h6>
										<hr/>
									</center>
									<?php
										$grandtotal = 0;
										$subtotal = 0;
										//print_r($this->go_cart->contents());

										foreach ($this->go_cart->contents() as $cartkey=>$product_cart):?>
											<li class="item">
												<a href="">
												  <div class="media">
													<div class="media-left">
													  <img class="media-object" src="<?php echo base_url('uploads/product/thumb/'.$product_cart['images']);?>" alt="...">
													</div>
													<div class="media-body">
													  <h5 class="media-heading"><?php echo $product_cart['name']; ?></h5>
													  <p class="sub-heading" style="font-size: 11px; color: black;"><?php echo $product_cart['quantity'] ?> X <?php echo format_currency($product_cart['base_price']);   ?></p>
													  <!--<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>-->
													</div>
												  </div>
												</a>
											</li>
									  <?php endforeach; ?>
									<li class="total">
										<div class="separator">
										  <div class="row">
											<div class="col-xs-6">
											  <p>SUBTOTAL</p>
											</div>
											<div class="col-xs-6">
											  <p class="text-right"><b><?php echo format_currency($this->go_cart->subtotal());?></b></p>
											</div>
										  </div>
										</div>
										<div style="background-color: #FDDCB7; padding: 20px;">
											<a href="<?php echo base_url('cart/view_cart');?>" style="background-color: white; color: #263647; border-radius: 0;" class="btn btn-orange btn-block">CHECKOUT</a>
										</div>
									</li>
								</ul>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<div class="def-content">
<style>
	.error{
		text-align: center;
		color: red;
	}
</style>
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
     		
?>