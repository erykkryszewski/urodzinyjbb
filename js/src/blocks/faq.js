import $ from 'jquery';

$(document).ready(function(){
  if ($('.faq__question').length > 0) {
    $('.faq__question').on('click', function() {
      const $answer = $(this).next('.faq__answer');
      const $number = $(this).closest('.faq__item').find('.faq__number');
      
      if ($answer.is(':visible')) {
        $number.text('+');
      } else {
        $number.text('-');
      }
      
      $answer.slideToggle();
    });
  }
});
