$(document).ready(function() {
  $('.product').each(function(i, el) {
    // Lift card and show stats on Mouseover
    $(el).find('.make3D').hover(function() {
      $(this).parent().css('z-index', "20");
      $(this).addClass('animate');
      $(this).find('div.carouselNext, div.carouselPrev').addClass('visible');
    },  function() {
      $(this).removeClass('animate');
      $(this).parent().css('z-index', "1");
      $(this).find('div.carouselNext, div.carouselPrev').removeClass('visible');
    });
    makeCarousel(el);
  });
  /* ----  Image Gallery Carousel   ---- */
  function makeCarousel(el) {
    var carousel = $(el).find('.carousel ul');
    var carouselSlideWidth = 315;
    var carouselWidth = 0;
    var isAnimating = false;
    var currSlide = 0;
    $(carousel).attr('rel', currSlide);
    // building the width of the casousel
    $(carousel).find('li').each(function() {
      carouselWidth += carouselSlideWidth;
    });
    $(carousel).css('width', carouselWidth);
  }
  $('.sizes a span, .categories a span').each(function(i, el) {
    $(el).append('<span class="x"></span><span class="y"></span>');
  });
});
