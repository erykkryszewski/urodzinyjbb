import $ from 'jquery';

$(document).ready(function(){
  if ($('body').hasClass('woocommerce-cart')) {
    const shopHeroHTML = `
      <div class="shop-hero">
        <div class="container">
          <h1 class="shop-hero__title">Koszyk</h1>
        </div>
      </div>
    `;

    $('main#main').prepend(shopHeroHTML);
  }
});
