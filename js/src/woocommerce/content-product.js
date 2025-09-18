import $ from 'jquery';

$(document).ready(function(){
  $('.products > li > a > img').each(function(){
    $(this).wrap('<div class="product__image"></div>');
  });
  
  $('.products > li > a.button.product__button').each(function(){
    $(this).wrap('<div class="product__button-wrapper"></div>');
  });


  // wrap all texts with + in span
  const items = $('.woocommerce-loop-product__title');
  if (items.length > 0) {
    items.each(function() {
      let content = $(this).html();
      let plusIndex = content.indexOf("+");
      if (plusIndex !== -1) {
        let beforePlus = content.substring(0, plusIndex);
        let afterPlus = content.substring(plusIndex);
        let newContent = `${beforePlus}<span>${afterPlus}</span>`;
        $(this).html(newContent);
      }
    });
  }

});

