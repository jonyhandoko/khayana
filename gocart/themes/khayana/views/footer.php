	</div>
	
    <div class="def-footer" style="position: relative; background-color: #46C4DD; min-height: 450px;">
		<div class="container-fluid">
			<div class="row">
				<div class="col-xs-3"></div>
				<div class="col-xs-6">
					<span style="letter-spacing: 8px; top: -45px; position: absolute; font-size: 60px; color: white;">
						<center>
						<img width="100%" src="<?php echo base_url('gocart/themes/'.$this->config->item('theme').'/img/newsletter-img.png');?>" />
						</center>
					</span>
				</div>
				<div class="col-xs-3"></div>
			</div>
			<center>
				<p style="padding-top: 50px; color: white; width: 50%; clear: both;">
					Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum
				</p>
				
				<div style="width:200px; padding-top: 80px;">
					<a style="border: 1px solid white; padding: 18px; color: white;">
						SUBSCRIBE
					</a>
				</div>
				
				<div style="width:50%; padding-top: 80px;">
					SOCIAL MEDIA
				</div>
				<div style="width:50%; padding-top: 30px;">
					<p>FAQ | Terms & Conditions | Confirm Payment | Order History | Contact</p>
					<p>Copyright 2015 Khayana. All Rights Reserved.</p>
				</div>
			</center>
		</div>
	</div>
	
	
	<script>
		$(document).ready(function() {
			var owl = $(".owl-carousel");
			$('.owl-carousel').owlCarousel({
				rtl:false,
				loop:false,
				margin:10,
				responsiveClass:true,
				responsive:{
					0:{
						items:2
					},
					600:{
						items:3
					},
					1000:{
						items:3
					}
				}
			})
			
			// Custom Navigation Events
			$(".owl-carousel-arrows-next").click(function() {
				owl.trigger('next.owl.carousel');
			});
			
			$(".owl-carousel-arrows-prev").click(function() {
				owl.trigger('prev.owl.carousel');
			});
			
			$("img").bind('load', function() {
				$('.owl-carousel-arrows').height($('.owl-stage-outer img').height());
			});			
			
			$('#ex1').slider({
				tooltip: 'always',
				tooltip_split: true,
				tooltip_position: 'bottom',
				formatter: function(value) {
					return value;
				}
			});
			
			$( ".product-box" ).hover(
				function(){
                    $(this).find(".product-info-container").css("display", "block");
                },
                function(){
                    $(this).find(".product-info-container").css("display", "none");
                }
			);
			
			$('#faq-list .faq-detail').click(function() {
				$(".answer").slideUp(200);
				$(this).next('.answer').slideToggle(400);
				$(this).toggleClass('closed');
				$('#faq-list .faq-detail').removeClass('light-blue');
				$(this).addClass('light-blue');
			});
		});
	</script>

  </body>
</html>