import $ from 'jquery';

$(document).ready(function(){
  if($('.cta-hero__wrapper')) {
    $('.cta-hero__wrapper').slick({
      dots: false,
      arrows: false,
      infinite: false,
      speed: 850,
      slidesToShow: 1,
      slidesToScroll: 1,
      autoplay: true,
      autoplaySpeed: 5000,
      infinite: true,
      swipe: false,
      pauseOnHover: false,
      pauseOnFocus: false,
      draggable: false,
      cssEase: 'ease-out',
      fade: true,
      responsive: [
        {
          breakpoint: 1100,
          settings: {
            slidesToShow: 1
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

    // initial animations when window loads
    if($('.slick-current.slick-active .cta-hero__title').length > 0) {
      setTimeout(function(){
        $('.slick-current.slick-active .cta-hero__title').addClass('cta-hero__title--animated');
      }, 1000);
    }

    if($('.slick-current.slick-active .cta-hero__content > p').length > 0) {
      setTimeout(function(){
        $('.slick-current.slick-active .cta-hero__content > p').addClass('animated');
      }, 1200);
    }

    if($('.slick-current.slick-active .cta-hero__button').length > 0) {
      setTimeout(function(){
        $('.slick-current.slick-active .cta-hero__button').addClass('cta-hero__button--animated');
      }, 1400);
    }

    // animations on every slide when slider changes
    $('.cta-hero__wrapper').on('afterChange', function(event, slick, currentSlide, nextSlide){  

      // reset everything to allow animations start from scratch
      setTimeout(function(){
        if($('.slick-slide .cta-hero__title').length > 0) {
          $('.slick-slide .cta-hero__title').removeClass('cta-hero__title--animated');
        }

        if($('.slick-slide .cta-hero__content > p').length > 0) {
          $('.slick-slide .cta-hero__content > p').removeClass('animated');
        }

        if($('.slick-slide .cta-hero__button').length > 0) {
          $('.slick-slide .cta-hero__button').removeClass('cta-hero__button--animated');
        }
      }, 100);

      // title animation
      if($('.slick-current.slick-active .cta-hero__title').length > 0) {
        setTimeout(function(){
          $('.slick-current.slick-active .cta-hero__title').addClass('cta-hero__title--animated');
        }, 300);
      }
  
      // text animation
      if($('.slick-current.slick-active .cta-hero__content > p').length > 0) {
        setTimeout(function(){
          $('.slick-current.slick-active .cta-hero__content > p').addClass('animated');
        }, 500);
      }
  
      // button animation
      if($('.slick-current.slick-active .cta-hero__button').length > 0) {
        setTimeout(function(){
          $('.slick-current.slick-active .cta-hero__button').addClass('cta-hero__button--animated');
        }, 700);
      }
    });
  
    // reset buttons text
    $(".slick-prev").text("");
    $(".slick-next").text("");
    $("ul.slick-dots > li > button").text("");


    // parallax function

    let heroImage = document.querySelector('.cta-hero__image img');

    if (heroImage) {
      $(window).scroll(function() {
        var scrollPosition = $(this).scrollTop();
        if (scrollPosition > 50) {
          $(heroImage).addClass('scrolled');
        } else {
          $(heroImage).removeClass('scrolled');
        }
      });
    }
  }
});