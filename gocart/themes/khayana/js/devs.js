/* Devs Scripts */

(function() {

    /* Carousel For Banner */
    var owlBannerId = document.getElementById('owl-banner'),
        owlBanner = $(owlBannerId);
        owlBanner.owlCarousel({
          singleItem : true,
          autoPlay : 3000,
          navigation : true,
          navigationText : ['<','>'],
          pagination : false
        });

    /* Carousel For Featured */
    var owlFeaturedId = document.getElementById('owl-featured'),
        owlFeatured = $(owlFeaturedId);
        owlFeatured.owlCarousel({
          items : 4,
          itemsDesktop : [1199,3],
          itemsDesktopSmall : [979,3],
          autoPlay : 3000,
          navigation : true,
          navigationText : ['<','>'],
          pagination : false
        });

  // Carousel Thumbnails
  $('[id^=carousel-selector-]').click( function(){
    var id_selector = $(this).attr("id"),
        id = id_selector.substr(id_selector.length -1),
        id = parseInt(id);

    $('.carousel-thumbnail').carousel(id);
    $('[id^=carousel-selector-]').removeClass('selected');
    $(this).addClass('selected');
  });

  // When the Carousel Slides, Auto Update
  $('.carousel-thumbnail').on('slid.bs.carousel', function (e) {
    var id = $('.item.active').data('slide-number'),
        id = parseInt(id);

    $('[id^=carousel-selector-]').removeClass('selected');
    $('[id^=carousel-selector-'+id+']').addClass('selected');
  });

  $('.star-rating').on('change', 'input:radio', function() {
      $(this).parent().next().text(this.value + ' Stars');
  });

}());
