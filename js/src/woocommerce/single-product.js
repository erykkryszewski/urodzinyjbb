import $ from 'jquery';

$(document).ready(function(){
  $('.woocommerce-product-gallery, .summary').wrapAll('<div class="single-product-content"></div>');
});