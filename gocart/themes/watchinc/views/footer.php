	</div>
	
    <div class="def-footer">
      <footer class="footer">
        <div class="sitemap">
          <div class="container-fluid">
            <div class="row">
              <div class="col-sm-2">
                <img src="images/watchinc/brand-small.png" class="img-responsive brand">
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
                  <li><p class="text-icon"><img src="images/watchinc/icon/iphone.png"> (+62)85779555903</p></li>
                  <li><p class="text-icon"><img src="images/watchinc/icon/qrcode.png"> 12345</p></li>
                  <li><p class="text-icon"><img src="images/watchinc/icon/topic.png"> Watchnic</p></li>
                  <li><p class="text-icon"><img src="images/watchinc/icon/message.png"> info@watchnic.com</p></li>
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

    <script src="<?php echo base_url('gocart/themes/'.$this->config->item('theme').'/js/plug.js');?>"></script>
    <script src="<?php echo base_url('gocart/themes/'.$this->config->item('theme').'/js/devs.js');?>"></script>
	<script src="<?php echo base_url('gocart/themes/'.$this->config->item('theme').'/js/modernizr.custom.79639.js');?>"></script>
	<script type="text/javascript">
			
		function DropDown(el) {
			this.dd = el;
			this.placeholder = this.dd.children('span');
			this.opts = this.dd.find('ul.dropdown > li');
			this.val = '';
			this.index = -1;
			this.initEvents();
		}
		DropDown.prototype = {
			initEvents : function() {
				var obj = this;

				obj.dd.on('click', function(event){
					if($(this).hasClass('active')){
						$('.wrapper-dropdown-1').removeClass('active');
					}else{
						$('.wrapper-dropdown-1').removeClass('active');
						$(this).toggleClass('active');
					}
					return false;
				});
				
				obj.opts.on('click',function(){
					var opt = $(this);
					obj.val = opt.text();
					obj.index = opt.index();
					/*var filtername = opt.parent().parent().find('span').attr('data-filter-name');
					if(obj.val=='NO FILTER'){
						opt.parent().parent().find('span').text(filtername);
					}else{
						opt.parent().parent().find('span').text(filtername+': ' + obj.val);
					}*/
				});
			},
			getValue : function() {
				return this.val;
			},
			getIndex : function() {
				return this.index;
			}
		}

		$(function() {

			var dd = new DropDown( $('.drops') );

			$(document).click(function() {
				// all dropdowns
				$('.wrapper-dropdown-1').removeClass('active');
			});

		});
		
	</script>
	<script>
		$( document ).ready(function() {
			var Watchinc = {};
			Watchinc.queryParams = {};
			if (location.search.length) {
				for (var aKeyValue, i = 0, aCouples = location.search.substr(1).split('&'); i < aCouples.length; i++) {
					aKeyValue = aCouples[i].split('=');
					if (aKeyValue.length > 1) {
						if(decodeURIComponent(aKeyValue[1]).length > 0){
							Watchinc.queryParams[decodeURIComponent(aKeyValue[0])] = decodeURIComponent(aKeyValue[1].replace('+',' ').replace('%2B',' '));
							$("#"+decodeURIComponent(aKeyValue[0])+" option[value='"+decodeURIComponent(aKeyValue[1]).replace('+',' ')+"']").attr('selected','selected');
							$(".filter-list").append("<a href='javascript:void(0);' class='filter-box' data-filter='"+decodeURIComponent(aKeyValue[0])+"'>"+decodeURIComponent(aKeyValue[1].replace('+',' ').replace('%2B',' '))+" <i class='fa fa-remove'></i></a>");
						}
					}
				}
				$(".filter-container").show();
			}else{
				$(".filter-container").hide();
			}
			//alert(JSON.stringify(Watchinc.queryParams));
			var collFilters = jQuery('.coll-filter a');
			collFilters.click(function() {
				if($(this).text() != ''){
					Watchinc.queryParams[$(this).parent().parent().parent().find('span').attr("data-filter-code")] = $(this).text();
				}else{
					delete Watchinc.queryParams[$(this).parent().parent().parent().find('span').attr("data-filter-code")];
				}
				location.search = jQuery.param(Watchinc.queryParams);
			});
			// Price Filters
			var priceFilters = jQuery('.priceFilter');
			var priceCheck = false;
			priceFilters.click(function() {
				var Watchinc = {};
				Watchinc.queryParams = {};
				if (location.search.length) {
					for (var aKeyValue, i = 0, aCouples = location.search.substr(1).split('&'); i < aCouples.length; i++) {
						aKeyValue = aCouples[i].split('=');
						if (aKeyValue.length > 1) {
							if(decodeURIComponent(aKeyValue[1]).length > 0){
								if(aKeyValue[0]=="filterPrice"){
									aKeyValue[1]=$(this).attr("price-filter");
									priceCheck = true;
								}
								Watchinc.queryParams[decodeURIComponent(aKeyValue[0])] = decodeURIComponent(aKeyValue[1].replace('+',' ').replace('%2B',' '));
							}
						}
					}
				}
				if(!priceCheck){
					Watchinc.queryParams["filterPrice"] = $(this).attr("price-filter");
				}
				location.search = jQuery.param(Watchinc.queryParams);
			});

			var removeFilter = jQuery('.filter-box');
			removeFilter.click(function() {
				delete Watchinc.queryParams[$(this).attr('data-filter')];
				location.search = jQuery.param(Watchinc.queryParams);
			});
		});
	</script>

  </body>
</html>