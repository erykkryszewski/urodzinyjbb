<?php

// change sale to okazja

add_filter('woocommerce_sale_flash', 'ercodingtheme_change_sale_text');

function ercodingtheme_change_sale_text() {
  return '<span class="onsale">Okazja</span>';
}



// change number of products that are displayed per page (shop page)

add_filter('loop_shop_per_page', 'new_loop_shop_per_page', 20);

function new_loop_shop_per_page($cols) {
  // $cols contains the current number of products per page based on the value stored on Options –> Reading
  // Return the number of products you wanna show per page.
  $cols = 15;
  return $cols;
}



// change woocommerce thumbnail image size

add_filter( 'woocommerce_get_image_size_thumbnail', function( $size ) {
  return array(
      'width'  => 9999,
      'height' => 9999,
      'crop'   => false,
  );
});

add_filter( 'woocommerce_get_image_size_single', function( $size ) {
  return array(
      'width'  => 9999,
      'height' => 9999,
      'crop'   => false,
  );
});

add_filter( 'woocommerce_get_image_size_gallery_thumbnail', function( $size ) {
  return array(
      'width'  => 9999,
      'height' => 9999,
      'crop'   => false,
  );
});


// fix related products

add_filter( 'woocommerce_get_related_product_cat_terms', function ( $terms, $product_id ) {
  $product_terms = get_the_terms( $product_id, 'product_cat' );
  if ( ! empty ( $product_terms ) ) {
    $last_term = end( $product_terms );
    return (array) $last_term;
  }

  return $terms;
}, 20, 2 );


// birthday promotion

function get_product_pairs() {
  return [
    3974 => 4043,
    4037 => 4035,
    4051 => 4045, 
    4047 => 4049, 
    4076 => 4107, 
    4080 => 4107, 
    4081 => 4107, 
    4082 => 4107, 
    4092 => 4110, 
    4094 => 4110, 
    4096 => 4110, 
    4099 => 4110, 
    4083 => 4109, 
    4086 => 4111, 
    4088 => 4109, 
    4090 => 4111
  ];
}

// Add free product when a trigger product is added
add_action('woocommerce_before_calculate_totals', 'add_free_product_for_trigger');

function add_free_product_for_trigger($cart) {
  if (is_admin() && !defined('DOING_AJAX')) {
    return;
  }

  $product_pairs = get_product_pairs();
  $trigger_products_in_cart = [];

  // Track the trigger products and their free products in the cart
  foreach ($cart->get_cart() as $cart_item_key => $cart_item) {
    $product_id = $cart_item['product_id'];
    if (isset($product_pairs[$product_id])) {
      $trigger_products_in_cart[$product_id] = $product_pairs[$product_id];
    }
  }

  // Add free products if not already in the cart
  foreach ($trigger_products_in_cart as $trigger_product_id => $free_product_id) {
    $free_product_in_cart = false;

    foreach ($cart->get_cart() as $cart_item_key => $cart_item) {
      if ($cart_item['product_id'] == $free_product_id) {
        $free_product_in_cart = true;
        break;
      }
    }

    if (!$free_product_in_cart) {
      $free_cart_item_key = $cart->add_to_cart($free_product_id);
      if ($free_cart_item_key) {
        WC()->cart->cart_contents[$free_cart_item_key]['free_for_product'] = $trigger_product_id;
      }
    }
  }

  // Set the price of the free products to 0
  foreach ($cart->get_cart() as $cart_item_key => $cart_item) {
    if (isset($cart_item['free_for_product'])) {
      $cart_item['data']->set_price(0);
    }
  }
}

// Remove free product when the trigger product is removed
add_action('woocommerce_before_cart_item_quantity_zero', 'remove_free_product_when_trigger_removed', 10, 1);

function remove_free_product_when_trigger_removed($cart_item_key) {
  $product_pairs = get_product_pairs();
  $removed_product_id = WC()->cart->cart_contents[$cart_item_key]['product_id'];

  // Check if the removed product is a trigger product
  if (isset($product_pairs[$removed_product_id])) {
    $free_product_id = $product_pairs[$removed_product_id];

    // Remove the corresponding free product from the cart
    foreach (WC()->cart->get_cart() as $key => $cart_item) {
      if (isset($cart_item['free_for_product']) && $cart_item['free_for_product'] == $removed_product_id) {
        WC()->cart->remove_cart_item($key);
        break;
      }
    }
  }
}

// Remove the free product if the trigger product is no longer in the cart
add_action('woocommerce_check_cart_items', 'ensure_free_products_linked_to_triggers');

function ensure_free_products_linked_to_triggers() {
  $product_pairs = get_product_pairs();
  $trigger_products_in_cart = [];
  $free_product_keys = [];

  // Track which trigger products and free products are in the cart
  foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {
    $product_id = $cart_item['product_id'];
    if (isset($product_pairs[$product_id])) {
      $trigger_products_in_cart[$product_id] = $product_pairs[$product_id];
    }

    if (isset($cart_item['free_for_product'])) {
      $free_product_keys[$cart_item['product_id']] = $cart_item_key;
    }
  }

  // Ensure each free product has a corresponding trigger product in the cart
  foreach ($product_pairs as $trigger_product_id => $free_product_id) {
    if (!array_key_exists($trigger_product_id, $trigger_products_in_cart)) {
      if (array_key_exists($free_product_id, $free_product_keys)) {
        WC()->cart->remove_cart_item($free_product_keys[$free_product_id]);
      }
    }
  }
}

// Add a "surprise" class to the free product in the cart for styling
add_filter('woocommerce_cart_item_class', 'add_surprise_class_to_free_product', 10, 3);

function add_surprise_class_to_free_product($class, $cart_item, $cart_item_key) {
  $product_pairs = get_product_pairs();
  $free_product_ids = array_values($product_pairs);

  if (in_array($cart_item['product_id'], $free_product_ids)) {
    $class .= ' surprise';
  }

  return $class;
}







// Enable free shipping when all products in cart are in 'electronic' category
add_filter( 'woocommerce_shipping_free_shipping_is_available', 'enable_free_shipping_for_electronic', 10, 3 );

function enable_free_shipping_for_electronic( $is_available, $package, $shipping_method ) {
    // Check if all products in cart are in the 'electronic' category
    $all_electronic = true;
    foreach ( WC()->cart->get_cart() as $cart_item ) {
        $product_id = $cart_item['product_id'];
        if ( ! has_term( 'elektroniczny', 'product_cat', $product_id ) ) {
            $all_electronic = false;
            break; // No need to check further
        }
    }
    if ( $all_electronic ) {
        // Make free shipping available regardless of minimum amount
        $is_available = true;
    }
    return $is_available;
}

// Restrict shipping methods to only free shipping when all products are in 'electronic' category
add_filter( 'woocommerce_package_rates', 'adjust_shipping_methods_for_electronic_category', 10, 2 );

function adjust_shipping_methods_for_electronic_category( $rates, $package ) {
    // Check if all products in cart are in the 'electronic' category
    $all_electronic = true;
    foreach ( WC()->cart->get_cart() as $cart_item ) {
        $product_id = $cart_item['product_id'];
        if ( ! has_term( 'elektroniczny', 'product_cat', $product_id ) ) {
            $all_electronic = false;
            break; // No need to check further
        }
    }
    if ( $all_electronic ) {
        // Only allow free shipping
        $free_shipping_rates = array();
        foreach ( $rates as $rate_id => $rate ) {
            if ( 'free_shipping' === $rate->method_id ) {
                $free_shipping_rates[ $rate_id ] = $rate;
                break; // Free shipping found, stop checking
            }
        }
        if ( ! empty( $free_shipping_rates ) ) {
            return $free_shipping_rates; // Return only free shipping
        }
    }
    return $rates; // Return all rates if condition not met
}
