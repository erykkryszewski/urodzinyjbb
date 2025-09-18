import $ from 'jquery';

$(document).ready(function(){
  if($('.testimonials__slider')) {
    $('.testimonials__slider').slick({
      dots: true,
      arrows: false,
      infinite: false,
      speed: 800,
      slidesToShow: 2,
      slidesToScroll: 1,
      autoplay: false,
      autoplaySpeed: 4000,
      cssEase: 'ease-out',
      infinite: true,
      responsive: [
        {
          breakpoint: 1100,
          settings: {
            slidesToShow: 2
          }
        },
        {
          breakpoint: 700,
          settings: {
            slidesToShow: 1
          }
        }
      ]
    });
  
    $(".slick-prev").text("");
    $(".slick-next").text("");
    $("ul.slick-dots > li > button").text("");
  }
});