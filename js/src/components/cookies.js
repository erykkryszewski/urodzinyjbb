import $ from 'jquery';

$('.cookies__button').on('click', function(){
  $('.cookies').removeClass('show');
  localStorage.setItem('cookies', true);
});

$(document).ready(function(){
  if('cookies' in localStorage) {
      $('.cookies').removeClass('show');
  } else {
      $('.cookies').addClass('show');
  }
})