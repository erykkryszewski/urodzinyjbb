<?php

// single product content order change

remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_price', 10);
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20);

add_action('woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 10);
add_action('woocommerce_single_product_summary', 'woocommerce_template_single_price', 20);



// replace product short description with product description, then hide short description

// add_filter('woocommerce_short_description', 'custom_wc_short_description', 10, 1);
// add_filter('woocommerce_product_excerpt', 'custom_wc_short_description', 10, 1);

// function custom_wc_short_description($short_description) {
//   global $post;
//   $product = wc_get_product($post->ID);
//   if ($product && !is_wp_error($product)) {
//     $description = $product->get_description();
//     if (!empty($description)) {
//       $short_description = wpautop(do_shortcode($description));
//     }
//   }
//   return $short_description;
// }

// add_action('admin_head', 'custom_hide_short_description_field');
// function custom_hide_short_description_field() {
//   global $pagenow;
//   if ($pagenow === 'post.php' && get_post_type() === 'product') {
//     echo '<style>#postexcerpt { display: none; }</style>';
//   }
// }




// add product category slug to body classes

add_filter('body_class', 'add_category_to_body_class');

function add_category_to_body_class($classes) {
  if (is_product()) {
    $product_cats = wp_get_post_terms(get_the_ID(), 'product_cat');
    if (!empty($product_cats)) {
      $product_cat = array_shift($product_cats);
      $classes[] = 'product-category-' . $product_cat->slug;
    }
  }
  return $classes;
}



// change gallery image size

add_filter( 'woocommerce_gallery_thumbnail_size', function() {
  return 'medium';
} );


// custom omnibus

function display_lowest_price_message() {
  global $product;

  if ( ! $product ) {
      return;
  }

  // Check if the product is on sale
  if ( $product->is_on_sale() ) {
      // Get the sale price
      $sale_price = $product->get_sale_price();

      // Display the message with the formatted sale price
      echo '<div class="product__omnibus"><p>Najniższa cena z ostatnich 30 dni: ' . wc_price( $sale_price ) . '</p></div>';
  }
}
// Hook the function to display the message above the add-to-cart button
add_action( 'woocommerce_single_product_summary', 'display_lowest_price_message', 25 );


// advance payment

function display_advance_payment_button() {
  global $product;

  // Get the product categories
  $product_categories = wp_get_post_terms($product->get_id(), 'product_cat', array('fields' => 'slugs'));

  // Get the custom field value for the advance payment link
  $product_advance = get_field('zaliczka', $product->get_id());

  // Check if the product is in the "akademia" category and has a non-empty advance payment link
  if (in_array('akademia', $product_categories) && !empty($product_advance)) {
    echo '<a href="' . esc_url($product_advance) . '" class="button product__advance product__advance--single">Wpłać zaliczkę</a>';
  }
}

// Hook into the appropriate action to display the button below the Add to Cart button on the single product page
add_action('woocommerce_after_add_to_cart_button', 'display_advance_payment_button');
