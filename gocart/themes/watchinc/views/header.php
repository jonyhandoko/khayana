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
    <script>
		//if(isMobile.any()){
			//document.write('<meta name="viewport" content="width=device-width, initial-scale=1">')
		//} else {
			//document.write('<meta name="viewport" content="width=1170, user-scalable=yes" />')
		//}
		document.write('<meta name="viewport" content="width=1170, user-scalable=yes" />')
	</script>
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="author" content="">

    <title>Watch Inc</title>

    <script>
		if(isMobile.any()){
			document.write('<link href="<?php echo base_url('gocart/themes/'.$this->config->item('theme').'/css/init.css');?>" rel="stylesheet">')
			document.write('<link href="<?php echo base_url('gocart/themes/'.$this->config->item('theme').'/css/devs.css');?>" rel="stylesheet">')
		} else {
			document.write('<link href="<?php echo base_url('gocart/themes/'.$this->config->item('theme').'/css/init.css');?>" rel="stylesheet">')
			document.write('<link href="<?php echo base_url('gocart/themes/'.$this->config->item('theme').'/css/devs.css');?>" rel="stylesheet">')
		}
	</script>
    <link href="<?php echo base_url('gocart/themes/'.$this->config->item('theme').'/css/plug.css');?>" rel="stylesheet">
	<link href="<?php echo base_url('gocart/themes/'.$this->config->item('theme').'/css/style.css');?>" rel="stylesheet">
	<link href="<?php echo base_url('gocart/themes/'.$this->config->item('theme').'/css/colorbox.css');?>" rel="stylesheet">
	<link href="<?php echo base_url('gocart/themes/'.$this->config->item('theme').'/css/yamm.css');?>" rel="stylesheet">
	<link href='http://fonts.googleapis.com/css?family=Oswald:400,700' rel='stylesheet' type='text/css'>
	<script src="<?php echo base_url('gocart/themes/'.$this->config->item('theme').'/js/init.js');?>"></script>
	<script src="<?php echo base_url('gocart/themes/'.$this->config->item('theme').'/js/jquery-ui-1.8.16.custom.min.js');?>"></script>
	<script src="<?php echo base_url('gocart/themes/'.$this->config->item('theme').'/js/jquery.colorbox-min.js');?>"></script>
	<script src="<?php echo base_url('gocart/themes/'.$this->config->item('theme').'/js/jquery.lazyload.min.js');?>"></script>
	<style>
		body{
			min-width: 1170px;
		}
		.container-fluid{
		  max-width: none !important;
		  width: 1170px;
		}
	</style>
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="images/watchinc/ico/apple-touch-icon-144-precomposed.png">
    <link rel="shortcut icon" href="images/watchinc/ico/favicon.ico">
  </head>
  <body>
  
  <div class="def-header">
     
        <div class="container-fluid">
		 <nav class="navbar navbar-default navbar-static-top">
          <div class="navbar-header">
            <button class="navbar-toggle navbar-toggle-left collapsed" data-toggle="collapse" data-target="#category" aria-expanded="false" aria-controls="category">
              <img src="images/watchinc/icon/menu.png">
            </button>
            <button class="navbar-toggle collapsed" data-toggle="collapse" data-target="#advance" aria-expanded="false" aria-controls="advance">
              <img src="images/watchinc/icon/shopping-bag.png">
            </button>
            <a class="navbar-brand" href="<?php echo base_url('/');?>">
              <img alt="Watchinc" src="<?php echo base_url('/images/watchinc/brand.png');?>" class="img-responsive">
            </a>
          </div>
          <div id="advance" class="navbar-collapse collapse">
            <form class="navbar-form" method="post" action="/cart/search">
              <div class="form-group">
                <input type="text" placeholder="Search..." name="term" class="form-control">
              </div>
              <!--<div class="form-group select-category">
                <select class="form-control">
                  <option value="-1">Category</option>
                  <option>Brands</option>
                  <option>Men's Watches</option>
                  <option>Ladies Wathces</option>
                  <option>Strap</option>
                  <option>News</option>
                  <option>Sale</option>
                </select>
              </div>-->
              <button type="submit" class="btn btn-black btn-search">
                <img src="<?php echo base_url('/images/watchinc/icon/white-search.png');?>">
              </button>
            </form>
            <ul class="nav navbar-nav navbar-right navbar-right-in">
              <li class="dropdown">
                <a href="" class="dropdown-toggle cart-anchor" data-toggle="dropdown" role="button" aria-expanded="false">
                  <span>SHOPPING CART</span>
                  <div class="bag-count">
                    <img src="<?php echo base_url('/images/watchinc/icon/shopping-bag.png');?>" class="def-icon">
                    <span class="badge def-badge"><?php echo $this->go_cart->total_items();?></span>
                  </div>
                  <span class="caret"></span>
                </a>
                <ul class="dropdown-menu def-dropdown" role="menu">
				  <?php
					$grandtotal = 0;
					$subtotal = 0;
					//print_r($this->go_cart->contents());

					foreach ($this->go_cart->contents() as $cartkey=>$product_cart):?>
						<li>
						  <a href="">
							<div class="media">
							  <div class="media-left">
								<img class="media-object" width="70" src="<?php echo base_url('uploads/product/thumb/'.$product_cart['images']);?>">
							  </div>
							  <div class="media-body">
								  <h5 class="media-heading"><?php echo $product_cart['name']; ?></h5>
								  <p class="sub-heading"><?php echo $product_cart['quantity'] ?> X <?php echo format_currency($product_cart['base_price']);   ?></p>
								  <!--<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>-->
							  </div>
							</div>
						  </a>
						</li>
						<li class="divider"></li>
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
                    <button type="submit" onclick="window.location='<?php echo base_url('/cart/view_cart');?>';" class="btn btn-orange btn-block">CHECKOUT</button>
                  </li>
                </ul>
              </li>
            </ul>
          </div>
		  <style>
			@media (min-width: 768px) .navbar-nav>li>a{
				padding-top: 6px;
				padding-bottom: 6px;
			}
			li.dropdown{
				padding-top: 5px;
			}
			#category .navbar-nav>.open>a{
				background-color: #f1a744 !important;
				color: #fff !important;
				border-radius: 4px;
			}
			.open .arrow{
				border: solid transparent; border-bottom-color: #f1a744; border-width: 11px;position: absolute; bottom: 0;
			}
			#category .dropdown-menu{
				top: 96%;
			}
			.bottom-column
			{
				float: none;
				display: table-cell;
				vertical-align: bottom;
			}
		  </style>
          <div id="category" class="navbar-collapse yamm collapse">
            <ul class="nav navbar-nav text-center def-list">
              <li style="padding-top: 5px"><a href=""><i class="fa fa-home"></i></a></li>
              <li class="dropdown yamm-fw">
				<a class="dropdown-toggle cart-anchor" data-toggle="dropdown" role="button" aria-expanded="false" href="">WATCHES</a>
				
				<ul class="dropdown-menu def-dropdown" role="menu">
					<li>
						<div class="row">
							<div class="col-sm-8">
								<div class="row">
									<div class="col-sm-12">
										<h3 style="margin-top: 0 !important;">CATEGORIES</h3>
										<hr style="margin-bottom: 0 !important;"/>
									</div>
									<div class="col-sm-6">
										<ul style="list-style: none">
											<li><h5>New in: Mens</h5></li>
											<li><h5>Men's Watch: Classic</h5></li>
											<li><h5>Men's Watch: Casual</h5></li>
											<li><h5>Men's Watch: Dress</h5></li>
											<li><h5>Men's Watch: Sport</h5></li>
										</ul>
									</div>
									<div class="col-sm-6">
										<ul style="list-style: none">
											<li><h5>New in: Ladies</h5></li>
											<li><h5>Ladies' Watch: Classic</h5></li>
											<li><h5>Ladies' Watch: Casual</h5></li>
											<li><h5>Ladies' Watch: Dress</h5></li>
											<li><h5>Ladies' Watch: Sport</h5></li>
										</ul>
									</div>
									<div class="col-sm-12">
										<h3 style="margin-top: 0 !important;">BRANDS</h3>
										<hr style="margin-bottom: 0 !important;"/>
										<div class="col-sm-6">
											<h4><a href="<?php echo base_url('/seiko');?>">SEIKO</a></h4>
										</div>
										<div class="col-sm-6">
											<h4><a href="<?php echo base_url('/seiko');?>">ALBA</a></h4>
										</div>
									</div>
								</div>
							</div>
							<div class="col-sm-4">
								<img width="100%" src="<?php echo base_url('/images/box-menu.jpg');?>"/>
							</div>
							<!--<div class="col-sm-8" style="position: absolute; bottom: 12px;">
								<div class="row">
									<div class="col-sm-6">
										<div style="border: 1px solid #f1a744; padding: 10px;">
											<p>MONEY BACK GUARANTEE</p>
										</div>
									</div>
									<div class="col-sm-6">
										<div style="background-color: #333; padding: 10px;">
											<p>ONLINE SUPPORT</p>
										</div>
									</div>
								</div>
							</div>-->
						</div>
					</li>
				</ul>
				<span class="arrow"></span>
			  </li>
              <!--<li class="dropdown">
				<a class="dropdown-toggle cart-anchor" data-toggle="dropdown" role="button" aria-expanded="false" href="">MEN'S WATCHES</a>
				
				<ul class="dropdown-menu def-dropdown" role="menu" style="min-width: 300px;">
					<!--<li>
						<div class="row">
							<div class="col-sm-8">
								<ul>
									<li>New in: Mens</li>
									<li>Men's Watch: Classic</li>
									<li>Men's Watch: Casual</li>
									<li>Men's Watch: Dress</li>
									<li>Men's Watch: Sport</li>
								</ul>
							</div>
							<div class="col-sm-4">
								wdwqdwqewq
							</div>
						</div>
					</li>-
					<li>New in: Mens</li>
					<li>Men's Watch: Classic</li>
					<li>Men's Watch: Casual</li>
					<li>Men's Watch: Dress</li>
					<li>Men's Watch: Sport</li>
				</ul>
				<span class="arrow"></span>
			  </li>
               <li class="dropdown">
				<a class="dropdown-toggle cart-anchor" data-toggle="dropdown" role="button" aria-expanded="false" href="">LADIES WATCHES</a>
				
				<ul class="dropdown-menu def-dropdown" role="menu">
					<li>asdxx</li>
				</ul>
				<span class="arrow"></span>
			  </li>-->
              <li style="padding-top: 5px"><a href="/strap">STRAP</a></li>
              <li style="padding-top: 5px"><a href="/new">NEWS</a></li>
              <li style="padding-top: 5px"><a href="/sale">SALE</a></li>
              <li style="padding-top: 5px"><a href="/cart/confirmation">CONFIRM PAYMENT</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right text-center def-list">
              <?php if($this->Customer_model->is_logged_in(false, false)):?>
			  <li><a href="<?php echo base_url('/secure/my_account');?>">Welcome, <?php echo $this->customer['firstname'];?>!</a></li>
			  <?php else:?>
			  <li><a href="<?php echo base_url('/secure/login');?>">SIGN IN</a></li>
              <li><a href="">REGISTER</a></li>
			  <?php endif;?>
            </ul>
          </div>
		  </nav>
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