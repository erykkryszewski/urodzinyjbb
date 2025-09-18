import $ from 'jquery';

let a = 0;
$(window).scroll(function() {
  if($('.numbers__wrapper').length > 0) {
    let oTop1 = $('.numbers__wrapper').offset().top - window.innerHeight;
    if (a == 0 && $(window).scrollTop() > oTop1) {
      $('.numbers__digit').each(function() {
        let $this = $(this),
          countTo = $this.attr('data-count');
        $({
          countNum: $this.text()
        }).animate({
            countNum: countTo
          },
          {
  
            duration: 1500,
            easing: 'swing',
            step: function() {
              $this.text(Math.floor(this.countNum));
            },
            complete: function() {
              $this.text(this.countNum);
              //alert('finished');
            }
  
          });
          $this.css('opacity', '1');
      });
      a = 1;
    }
  }
});
