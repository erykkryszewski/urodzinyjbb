/**
 * External dependencies
 */
import $ from 'jquery';
import 'slick-carousel';
import '@fancyapps/fancybox';
// import AOS from 'aos';
// import { gsap } from "gsap";
// import { ScrollTrigger } from 'gsap/ScrollTrigger';
// import 'parallax-js';

// AOS.init();

// $(window).on('load', function() {
//   var currentUrl = window.location.href;

//   // Check if the current URL is the homepage or a subpage
//   if (currentUrl === window.location.origin + "/" || currentUrl === window.location.origin) {
//     // Homepage logic
//     setTimeout(function(){
//       $('.preloader').fadeOut(700);
//     }, 1000);
//   } else {
//     // Subpage logic
//     setTimeout(function(){
//       $('.preloader').fadeOut(300);
//     }, 300);
//   }
// });


$(document).on('click', 'a[href^="#"]', function (event) {
  event.preventDefault();

  if (window.location.href.indexOf('produkt') === -1 && window.location.href.indexOf('product') === -1) {
    $('html, body').animate({
      scrollTop: $($.attr(this, 'href')).offset().top
    }, 650);
  }
});

$(document).ready(function($) {
  $("img[title]").removeAttr("title");
  $('p:empty').remove();
});

/* imports */

import './global/recaptcha';

import './blocks/hero-slider';
import './blocks/cta-hero';
import './blocks/numbers';
import './blocks/testimonials';
import './blocks/cta';
import './blocks/program';
import './blocks/faq';
import './blocks/counter';
import './blocks/iframe';
import './blocks/gallery';
import './blocks/map-snazzy';
import './blocks/logos';

import './sections/header';
import './sections/navigation';
import './sections/main';

import './components/cookies';
import './components/spacer';

import './woocommerce/archive-product';
import './woocommerce/single-product';
import './woocommerce/content-product';
import './woocommerce/cart';
import './woocommerce/checkout';

