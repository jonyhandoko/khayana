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
		if(isMobile.any()){
			document.write('<meta name="viewport" content="width=device-width, initial-scale=1">')
		} else {
			document.write('<meta name="viewport" content="width=1170, user-scalable=yes" />')
		}
	</script>
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="author" content="">

    <title>Watch Inc</title>

    <script>
		if(isMobile.any()){
			document.write('<?php echo base_url('gocart/themes/'.$this->config->item('theme').'/css/init.css');?>')
			document.write('<?php echo base_url('gocart/themes/'.$this->config->item('theme').'/css/devs.css');?>')
		} else {
			document.write('<?php echo base_url('gocart/themes/'.$this->config->item('theme').'/css/init-desktop.css');?>')
			document.write('<?php echo base_url('gocart/themes/'.$this->config->item('theme').'/css/devs-desktop.css');?>')
		}
	</script>
    <link href="styles/plug.css" rel="stylesheet">

    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="images/ico/apple-touch-icon-144-precomposed.png">
    <link rel="shortcut icon" href="images/ico/favicon.ico">
  </head>
  <body>
  <style>
		body{
			min-width: 1170px;
		}
		.container-fluid{
		  max-width: none !important;
		  width: 1170px;
		}
	</style>

    <div class="def-header">
      <nav class="navbar navbar-default navbar-static-top">
        <div class="container-fluid">
          <div class="navbar-header">
            <button class="navbar-toggle navbar-toggle-left collapsed" data-toggle="collapse" data-target="#category" aria-expanded="false" aria-controls="category">
              <img src="images/icon/menu.png">
            </button>
            <button class="navbar-toggle collapsed" data-toggle="collapse" data-target="#advance" aria-expanded="false" aria-controls="advance">
              <img src="images/icon/shopping-bag.png">
            </button>
            <a class="navbar-brand" href="">
              <img alt="Watchinc" src="images/brand.png" class="img-responsive">
            </a>
          </div>
          <div id="advance" class="navbar-collapse collapse">
            <form class="navbar-form">
              <div class="form-group">
                <input type="text" placeholder="Search..." class="form-control">
              </div>
              <div class="form-group select-category">
                <select class="form-control">
                  <option value="-1">Category</option>
                  <option>Brands</option>
                  <option>Men's Watches</option>
                  <option>Ladies Wathces</option>
                  <option>Strap</option>
                  <option>News</option>
                  <option>Sale</option>
                </select>
              </div>
              <button type="submit" class="btn btn-black btn-search">
                <img src="images/icon/white-search.png">
              </button>
            </form>
            <ul class="nav navbar-nav navbar-right navbar-right-in">
              <li class="dropdown">
                <a href="" class="dropdown-toggle cart-anchor" data-toggle="dropdown" role="button" aria-expanded="false">
                  <span>SHOPPING CART</span>
                  <div class="bag-count">
                    <img src="images/icon/shopping-bag.png" class="def-icon">
                    <span class="badge def-badge">2</span>
                  </div>
                  <span class="caret"></span>
                </a>
                <ul class="dropdown-menu def-dropdown" role="menu">
                  <li class="item">
                    <a href="">
                      <div class="media">
                        <div class="media-left">
                          <img class="media-object" src="images/icon/orange-shopping-bag.png" alt="...">
                        </div>
                        <div class="media-body">
                          <h5 class="media-heading">LOREM IPSUM DOLOR</h5>
                          <p class="sub-heading">1 X IDR 300.000</p>
                          <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                        </div>
                      </div>
                    </a>
                  </li>
                  <li class="item">
                    <a href="">
                      <div class="media">
                        <div class="media-left">
                          <img class="media-object" src="images/icon/orange-shopping-bag.png" alt="...">
                        </div>
                        <div class="media-body">
                          <h5 class="media-heading">LOREM IPSUM DOLOR</h5>
                          <p class="sub-heading">1 X IDR 300.000</p>
                          <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                        </div>
                      </div>
                    </a>
                  </li>
                  <li class="total">
                    <div class="separator">
                      <div class="row">
                        <div class="col-xs-6">
                          <p>SUBTOTAL</p>
                        </div>
                        <div class="col-xs-6">
                          <p class="text-right"><b>IDR 600.000</b></p>
                        </div>
                      </div>
                    </div>
                    <button type="submit" class="btn btn-orange btn-block">CHECKOUT</button>
                  </li>
                </ul>
              </li>
            </ul>
          </div>
          <div id="category" class="navbar-collapse collapse">
            <ul class="nav navbar-nav text-center def-list">
              <li><a href=""><i class="fa fa-home"></i></a></li>
              <li><a href="">BRANDS</a></li>
              <li><a href="">MEN'S WATCHES</a></li>
              <li><a href="">LADIES WATCHES</a></li>
              <li><a href="">STRAP</a></li>
              <li><a href="">NEWS</a></li>
              <li><a href="">SALE</a></li>
              <li><a href="">CONFIRM PAYMENT</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right text-center def-list">
              <li><a href="">SIGN IN</a></li>
              <li><a href="">REGISTER</a></li>
            </ul>
          </div>
        </div>
      </nav>
    </div>

    <div class="def-content">
      <div class="banners">
        <div class="container-fluid">
          <div class="banner-big">
            <div class="row">
              <div class="col-sm-7">
                <div class="owl-banner">
                  <div id="owl-banner" class="owl-carousel">
                    <div class="item">
                      <img src="images/banner/big-1.jpg" class="img-responsive">
                    </div>
                    <div class="item">
                      <img src="images/banner/big-1.jpg" class="img-responsive">
                    </div>
                    <div class="item">
                      <img src="images/banner/big-1.jpg" class="img-responsive">
                    </div>
                    <div class="item">
                      <img src="images/banner/big-1.jpg" class="img-responsive">
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-sm-5">
                <div class="owl-follow">
                 <img src="images/banner/big-2.jpg" class="img-responsive">
                </div>
              </div>
            </div>
          </div>
          <div class="banner-small">
            <div class="row">
              <div class="col-sm-6">
                <img src="images/banner/small-1.jpg" class="img-responsive">
              </div>
              <div class="col-sm-3">
                <img src="images/banner/small-2.jpg" class="img-responsive">
              </div>
              <div class="col-sm-3">
                <img src="images/banner/small-3.jpg" class="img-responsive">
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="featured">
        <div class="container-fluid">
          <div class="def-temp">
            <div class="head">
              <div class="row">
                <div class="col-xs-12">
                  <img src="images/watch.png" class="img-responsive pull-left">
                  <h3 class="title"><span class="orange">FEATURED</span> PRODUCTS</h3>
                </div>
              </div>
            </div>
            <div class="thumbs owl-featured">
              <div id="owl-featured" class="row owl-carousel">
                <div class="thumb">
                  <div class="image">
                    <img src="images/product/product-1.jpg" class="img-responsive">
                  </div>
                  <div class="desc">
                    <p class="name">LOREM IPSUM DOLOR</p>
                    <p class="orange">IDR 300.000</p>
                  </div>
                </div>
                <div class="thumb">
                  <div class="image">
                    <img src="images/product/product-2.jpg" class="img-responsive">
                  </div>
                  <div class="desc">
                    <p class="name">LOREM IPSUM DOLOR</p>
                    <p class="orange">IDR 300.000</p>
                  </div>
                </div>
                <div class="thumb">
                  <div class="image">
                    <img src="images/product/product-1.jpg" class="img-responsive">
                  </div>
                  <div class="desc">
                    <p class="name">LOREM IPSUM DOLOR</p>
                    <p class="orange">IDR 300.000</p>
                  </div>
                </div>
                <div class="thumb">
                  <div class="image">
                    <img src="images/product/product-2.jpg" class="img-responsive">
                  </div>
                  <div class="desc">
                    <p class="name">LOREM IPSUM DOLOR</p>
                    <p class="orange">IDR 300.000</p>
                  </div>
                </div>
                <div class="thumb">
                  <div class="image">
                    <img src="images/product/product-1.jpg" class="img-responsive">
                  </div>
                  <div class="desc">
                    <p class="name">LOREM IPSUM DOLOR</p>
                    <p class="orange">IDR 300.000</p>
                  </div>
                </div>
                <div class="thumb">
                  <div class="image">
                    <img src="images/product/product-2.jpg" class="img-responsive">
                  </div>
                  <div class="desc">
                    <p class="name">LOREM IPSUM DOLOR</p>
                    <p class="orange">IDR 300.000</p>
                  </div>
                </div>
                <div class="thumb">
                  <div class="image">
                    <img src="images/product/product-1.jpg" class="img-responsive">
                  </div>
                  <div class="desc">
                    <p class="name">LOREM IPSUM DOLOR</p>
                    <p class="orange">IDR 300.000</p>
                  </div>
                </div>
                <div class="thumb">
                  <div class="image">
                    <img src="images/product/product-2.jpg" class="img-responsive">
                  </div>
                  <div class="desc">
                    <p class="name">LOREM IPSUM DOLOR</p>
                    <p class="orange">IDR 300.000</p>
                  </div>
                </div>
                <div class="thumb">
                  <div class="image">
                    <img src="images/product/product-1.jpg" class="img-responsive">
                  </div>
                  <div class="desc">
                    <p class="name">LOREM IPSUM DOLOR</p>
                    <p class="orange">IDR 300.000</p>
                  </div>
                </div>
                <div class="thumb">
                  <div class="image">
                    <img src="images/product/product-2.jpg" class="img-responsive">
                  </div>
                  <div class="desc">
                    <p class="name">LOREM IPSUM DOLOR</p>
                    <p class="orange">IDR 300.000</p>
                  </div>
                </div>
                <div class="thumb">
                  <div class="image">
                    <img src="images/product/product-1.jpg" class="img-responsive">
                  </div>
                  <div class="desc">
                    <p class="name">LOREM IPSUM DOLOR</p>
                    <p class="orange">IDR 300.000</p>
                  </div>
                </div>
                <div class="thumb">
                  <div class="image">
                    <img src="images/product/product-2.jpg" class="img-responsive">
                  </div>
                  <div class="desc">
                    <p class="name">LOREM IPSUM DOLOR</p>
                    <p class="orange">IDR 300.000</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="featured-tabs">
        <div class="container-fluid">
          <div class="def-temp">
            <div class="head">
              <div class="row">
                <div class="col-xs-12">
                  <img src="images/watch.png" class="img-responsive pull-left">
                  <h3 class="title"><span class="orange">MEN</span> WATCHES</h3>
                </div>
              </div>
            </div>
            <div class="thumbs">
              <div class="row">
                <div class="col-sm-15 col-xs-6 col-xx">
                  <a href="" class="thumb">
                    <div class="image">
                      <img src="images/product/product-1.jpg" class="img-responsive">
                    </div>
                    <div class="desc">
                      <p class="name">LOREM IPSUM DOLOR</p>
                      <p class="orange">IDR 300.000</p>
                    </div>
                  </a>
                </div>
                <div class="col-sm-15 col-xs-6 col-xx">
                  <a href="" class="thumb">
                    <div class="image">
                      <img src="images/product/product-1.jpg" class="img-responsive">
                    </div>
                    <div class="desc">
                      <p class="name">LOREM IPSUM DOLOR</p>
                      <p class="orange">IDR 300.000</p>
                    </div>
                  </a>
                </div>
                <div class="col-sm-15 col-xs-6 col-xx">
                  <a href="" class="thumb">
                    <div class="image">
                      <img src="images/product/product-1.jpg" class="img-responsive">
                    </div>
                    <div class="desc">
                      <p class="name">LOREM IPSUM DOLOR</p>
                      <p class="orange">IDR 300.000</p>
                    </div>
                  </a>
                </div>
                <div class="col-sm-15 col-xs-6 col-xx">
                  <a href="" class="thumb">
                    <div class="image">
                      <img src="images/product/product-1.jpg" class="img-responsive">
                    </div>
                    <div class="desc">
                      <p class="name">LOREM IPSUM DOLOR</p>
                      <p class="orange">IDR 300.000</p>
                    </div>
                  </a>
                </div>
                <div class="col-sm-15 col-xs-6 col-xx">
                  <a href="" class="thumb">
                    <div class="image">
                      <img src="images/product/product-1.jpg" class="img-responsive">
                    </div>
                    <div class="desc">
                      <p class="name">LOREM IPSUM DOLOR</p>
                      <p class="orange">IDR 300.000</p>
                    </div>
                  </a>
                </div>
                <div class="col-sm-15 col-xs-6 col-xx">
                  <a href="" class="thumb">
                    <div class="image">
                      <img src="images/product/product-1.jpg" class="img-responsive">
                    </div>
                    <div class="desc">
                      <p class="name">LOREM IPSUM DOLOR</p>
                      <p class="orange">IDR 300.000</p>
                    </div>
                  </a>
                </div>
                <div class="col-sm-15 col-xs-6 col-xx">
                  <a href="" class="thumb">
                    <div class="image">
                      <img src="images/product/product-1.jpg" class="img-responsive">
                    </div>
                    <div class="desc">
                      <p class="name">LOREM IPSUM DOLOR</p>
                      <p class="orange">IDR 300.000</p>
                    </div>
                  </a>
                </div>
                <div class="col-sm-15 col-xs-6 col-xx">
                  <a href="" class="thumb">
                    <div class="image">
                      <img src="images/product/product-1.jpg" class="img-responsive">
                    </div>
                    <div class="desc">
                      <p class="name">LOREM IPSUM DOLOR</p>
                      <p class="orange">IDR 300.000</p>
                    </div>
                  </a>
                </div>
                <div class="col-sm-15 col-xs-6 col-xx">
                  <a href="" class="thumb">
                    <div class="image">
                      <img src="images/product/product-1.jpg" class="img-responsive">
                    </div>
                    <div class="desc">
                      <p class="name">LOREM IPSUM DOLOR</p>
                      <p class="orange">IDR 300.000</p>
                    </div>
                  </a>
                </div>
                <div class="col-sm-15 col-xs-6 col-xx">
                  <a href="" class="thumb">
                    <div class="image">
                      <img src="images/product/product-1.jpg" class="img-responsive">
                    </div>
                    <div class="desc">
                      <p class="name">LOREM IPSUM DOLOR</p>
                      <p class="orange">IDR 300.000</p>
                    </div>
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="banner-fluid">
        <img src="images/banner/fluid.jpg" class="img-responsive">
      </div>
      <div class="news">
        <div class="container-fluid">
          <div class="def-temp">
            <div class="head">
              <div class="row">
                <div class="col-xs-12">
                  <img src="images/watch.png" class="img-responsive pull-left">
                  <h3 class="title"><span class="orange">LATEST</span> NEWS</h3>
                </div>
              </div>
            </div>
            <div class="thumbs">
              <div class="row">
                <div class="col-sm-3 col-xs-6 col-xx">
                  <a href="" class="thumb">
                    <div class="image">
                      <img src="images/news.jpg" class="img-responsive">
                    </div>
                    <div class="desc">
                      <p class="name">LOREM IPSUM DOLOR</p>
                      <p class="orange">IDR 300.000</p>
                      <p class="detail">Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcoper suscipit lobortis...</p>
                    </div>
                  </a>
                </div>
                <div class="col-sm-3 col-xs-6 col-xx">
                  <a href="" class="thumb">
                    <div class="image">
                      <img src="images/news.jpg" class="img-responsive">
                    </div>
                    <div class="desc">
                      <p class="name">LOREM IPSUM DOLOR</p>
                      <p class="orange">IDR 300.000</p>
                      <p class="detail">Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcoper suscipit lobortis...</p>
                    </div>
                  </a>
                </div>
                <div class="col-sm-3 col-xs-6 col-xx">
                  <a href="" class="thumb">
                    <div class="image">
                      <img src="images/news.jpg" class="img-responsive">
                    </div>
                    <div class="desc">
                      <p class="name">LOREM IPSUM DOLOR</p>
                      <p class="orange">IDR 300.000</p>
                      <p class="detail">Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcoper suscipit lobortis...</p>
                    </div>
                  </a>
                </div>
                <div class="col-sm-3 col-xs-6 col-xx">
                  <a href="" class="thumb">
                    <div class="image">
                      <img src="images/news.jpg" class="img-responsive">
                    </div>
                    <div class="desc">
                      <p class="name">LOREM IPSUM DOLOR</p>
                      <p class="orange">IDR 300.000</p>
                      <p class="detail">Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcoper suscipit lobortis...</p>
                    </div>
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="def-footer">
      <footer class="footer">
        <div class="sitemap">
          <div class="container-fluid">
            <div class="row">
              <div class="col-sm-2">
                <img src="images/brand-small.png" class="img-responsive brand">
              </div>
              <div class="col-sm-2">
                <p class="lead">ABOUT WATCH INC</p>
                <ul class="list-unstyled def-list">
                  <li><p><a href="">NEW COLLECTIONS</a></p></li>
                  <li><p><a href="">MEN'S WATCHES</a></p></li>
                  <li><p><a href="">WOMAN WATCHES</a></p></li>
                  <li><p><a href="">SALE</a></p></li>
                  <li><p><a href="">CONFIRM PAYMENT</a></p></li>
                </ul>
              </div>
              <div class="col-sm-2">
                <p class="lead">OTHER INFORMATION</p>
                <ul class="list-unstyled def-list">
                  <li><p><a href="">RETURN & SHIPPING</a></p></li>
                  <li><p><a href="">FAQ</a></p></li>
                  <li><p><a href="">HOW TO BUY</a></p></li>
                  <li><p><a href="">WATCH INC NEWS</a></p></li>
                </ul>
              </div>
              <div class="col-sm-2">
                <p class="lead">CONTACT</p>
                <ul class="list-unstyled">
                  <li><p class="text-icon"><img src="images/icon/iphone.png"> (+62)85779555903</p></li>
                  <li><p class="text-icon"><img src="images/icon/qrcode.png"> 12345</p></li>
                  <li><p class="text-icon"><img src="images/icon/topic.png"> Watchnic</p></li>
                  <li><p class="text-icon"><img src="images/icon/message.png"> info@watchnic.com</p></li>
                </ul>
              </div>
              <div class="col-sm-4">
                <p class="lead">NEWSLETTER</p>
                <p>SIGN UP FOR UPDATES AND SPECIAL OFFERS</p>
                <form class="form-inline footer-form">
                  <div class="form-group">
                    <input type="email" class="form-control">
                  </div>
                  <button type="submit" class="btn btn-black">SIGN UP</button>
                </form>
              </div>
            </div>
          </div>
        </div>
        <div class="rights">
          <div class="container-fluid">
            <div class="row">
              <div class="col-sm-6">
                <p>Copyright 2015 Watch Inc. All Rights Reserved.</p>
              </div>
              <div class="col-sm-6">
                <ul class="list-inline socials">
                  <li><a href=""><i class="fa fa-facebook"></i></a></li>
                  <li><a href=""><i class="fa fa-twitter"></i></a></li>
                  <li><a href=""><i class="fa fa-instagram"></i></a></li>
                  <li><a href=""><i class="fa fa-youtube"></i></a></li>
                  <li><a href=""><i class="fa fa-google-plus"></i></a></li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </footer>
    </div>

    <script src="<?php echo base_url('gocart/themes/'.$this->config->item('theme').'/js/init.js');?>"></script>
    <script src="<?php echo base_url('gocart/themes/'.$this->config->item('theme').'/js/plug.js');?>"></script>
    <script src="<?php echo base_url('gocart/themes/'.$this->config->item('theme').'/js/script.js');?>"></script>

  </body>
</html>