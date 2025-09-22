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
    4303 => 4043,
    4305 => 4043,
    4306 => 4322,
    4310 => 4322,
    4313 => 4324,
    4316 => 4326,
    4314 => 4326,
  ];
}

function ercoding_build_inverse_pairs() {
  $pairs = get_product_pairs();
  $inverse = [];
  foreach ($pairs as $triggerId => $bonusId) {
    if (!isset($inverse[$bonusId])) {
      $inverse[$bonusId] = [];
    }
    $inverse[$bonusId][] = $triggerId;
  }
  return $inverse;
}

function ercoding_collect_cart_snapshot($cart) {
  $items = $cart->get_cart();
  $snapshot = [
    'triggers' => [],       // triggerId => [ ['key'=>..., 'qty'=>...], ... ]
    'bonuses'  => [],       // bonusId   => ['key'=>..., 'qty'=>...]
  ];
  $inverse = ercoding_build_inverse_pairs();
  foreach ($items as $key => $item) {
    $pid = isset($item['product_id']) ? $item['product_id'] : 0;
    $qty = isset($item['quantity']) ? intval($item['quantity']) : 0;
    $isFree = isset($item['is_birthday_free']) ? intval($item['is_birthday_free']) : 0;

    if ($isFree === 1) {
      if (!isset($snapshot['bonuses'][$pid])) {
        $snapshot['bonuses'][$pid] = ['key' => $key, 'qty' => 0];
      }
      $snapshot['bonuses'][$pid]['qty'] = $snapshot['bonuses'][$pid]['qty'] + $qty;
      continue;
    }

    $pairs = get_product_pairs();
    if (isset($pairs[$pid])) {
      if (!isset($snapshot['triggers'][$pid])) {
        $snapshot['triggers'][$pid] = [];
      }
      $snapshot['triggers'][$pid][] = ['key' => $key, 'qty' => $qty];
    }
  }
  return $snapshot;
}

function ercoding_get_needed_bonus_counts($cart) {
  $pairs = get_product_pairs();
  $needed = [];
  foreach ($cart->get_cart() as $key => $item) {
    $pid = isset($item['product_id']) ? $item['product_id'] : 0;
    $qty = isset($item['quantity']) ? intval($item['quantity']) : 0;
    if ($qty < 1) { continue; }
    if (isset($pairs[$pid])) {
      $bonusId = $pairs[$pid];
      if (!isset($needed[$bonusId])) {
        $needed[$bonusId] = 0;
      }
      $needed[$bonusId] = $needed[$bonusId] + $qty;
    }
  }
  return $needed;
}

function ercoding_reconcile_bonuses_to_needed($cart) {
  static $running = false;
  if ($running) { return; }
  if (!$cart) { return; }
  $running = true;

  $needed = ercoding_get_needed_bonus_counts($cart);
  $snapshot = ercoding_collect_cart_snapshot($cart);

  foreach ($needed as $bonusId => $needQty) {
    $existing = isset($snapshot['bonuses'][$bonusId]) ? $snapshot['bonuses'][$bonusId] : null;

    if ($existing) {
      $haveQty = intval($existing['qty']);
      if ($haveQty !== $needQty) {
        WC()->cart->set_quantity($existing['key'], max(0, $needQty), false);
      }
    } else {
      if ($needQty > 0) {
        $key = $cart->add_to_cart($bonusId, max(1, $needQty), 0, [], ['is_birthday_free' => 1]);
        if ($key && isset(WC()->cart->cart_contents[$key])) {
          WC()->cart->cart_contents[$key]['is_birthday_free'] = 1;
        }
      }
    }
  }

  if (!empty($snapshot['bonuses'])) {
    foreach ($snapshot['bonuses'] as $bonusId => $data) {
      if (!isset($needed[$bonusId]) || $needed[$bonusId] < 1) {
        WC()->cart->remove_cart_item($data['key']);
      }
    }
  }

  $running = false;
}

add_action('woocommerce_cart_loaded_from_session', function ($cart) {
  ercoding_reconcile_bonuses_to_needed($cart);
}, 20, 1);

add_action('woocommerce_add_to_cart', function () {
  ercoding_reconcile_bonuses_to_needed(WC()->cart);
}, 20, 0);

add_action('woocommerce_after_cart_item_quantity_update', function ($cart_item_key, $new_qty, $old_qty, $cart) {
  $item = isset($cart->cart_contents[$cart_item_key]) ? $cart->cart_contents[$cart_item_key] : null;
  if (!$item) { return; }

  $isFree = isset($item['is_birthday_free']) ? intval($item['is_birthday_free']) : 0;
  if ($isFree !== 1) {
    ercoding_reconcile_bonuses_to_needed($cart);
    return;
  }

  $bonusId = isset($item['product_id']) ? intval($item['product_id']) : 0;
  $desiredBonusQty = max(0, intval($new_qty));

  $pairsInverse = ercoding_build_inverse_pairs();
  $triggerIdsForBonus = isset($pairsInverse[$bonusId]) ? $pairsInverse[$bonusId] : [];

  $snapshot = ercoding_collect_cart_snapshot($cart);
  $currentTriggersQty = 0;
  foreach ($triggerIdsForBonus as $triggerId) {
    if (isset($snapshot['triggers'][$triggerId])) {
      foreach ($snapshot['triggers'][$triggerId] as $row) {
        $currentTriggersQty = $currentTriggersQty + intval($row['qty']);
      }
    }
  }

  if ($desiredBonusQty === $currentTriggersQty) {
    ercoding_reconcile_bonuses_to_needed($cart);
    return;
  }

  $diff = $desiredBonusQty - $currentTriggersQty;

  if ($diff > 0) {
    foreach ($triggerIdsForBonus as $triggerId) {
      if (!isset($snapshot['triggers'][$triggerId])) {
        continue;
      }
      foreach ($snapshot['triggers'][$triggerId] as $row) {
        $add = $diff;
        $newTriggerQty = intval($row['qty']) + $add;
        WC()->cart->set_quantity($row['key'], $newTriggerQty, false);
        $diff = 0;
        break 2;
      }
    }
  } else {
    $toReduce = abs($diff);
    foreach ($triggerIdsForBonus as $triggerId) {
      if (!isset($snapshot['triggers'][$triggerId]) || $toReduce === 0) {
        continue;
      }
      foreach ($snapshot['triggers'][$triggerId] as $row) {
        if ($toReduce === 0) { break; }
        $cur = intval($row['qty']);
        if ($cur <= 0) { continue; }
        $reduceBy = min($cur, $toReduce);
        WC()->cart->set_quantity($row['key'], max(0, $cur - $reduceBy), false);
        $toReduce = $toReduce - $reduceBy;
        if ($toReduce === 0) { break; }
      }
      if ($toReduce === 0) { break; }
    }
  }

  ercoding_reconcile_bonuses_to_needed($cart);
}, 10, 4);

add_action('woocommerce_before_calculate_totals', function ($cart) {
  if (!$cart) { return; }
  foreach ($cart->get_cart() as $k => $item) {
    $isFree = isset($item['is_birthday_free']) ? intval($item['is_birthday_free']) : 0;
    if ($isFree === 1 && isset($item['data'])) {
      $item['data']->set_price(0);
    }
  }
}, 20, 1);

add_filter('woocommerce_cart_item_class', function ($classString, $cartItem) {
  $isFree = isset($cartItem['is_birthday_free']) ? intval($cartItem['is_birthday_free']) : 0;
  if ($isFree === 1) {
    $classString .= ' surprise';
  }
  return $classString;
}, 10, 2);

add_filter('woocommerce_cart_redirect_after_add', function () { return true; }, 10, 0);
add_filter('woocommerce_add_to_cart_redirect', function ($url) { return wc_get_cart_url(); }, 10, 1);

function ercoding_cart_all_electronic() {
  if (!WC()->cart) {
    return false;
  }
  foreach (WC()->cart->get_cart() as $cartItem) {
    $productId = isset($cartItem['product_id']) ? intval($cartItem['product_id']) : 0;
    if (!has_term('elektroniczny', 'product_cat', $productId)) {
      return false;
    }
  }
  return true;
}

add_filter('woocommerce_cart_needs_shipping', function ($needsShipping) {
  if (ercoding_cart_all_electronic()) {
    return false;
  }
  return $needsShipping;
}, 10, 1);

add_filter('woocommerce_cart_needs_shipping_address', function ($needsAddress) {
  if (ercoding_cart_all_electronic()) {
    return false;
  }
  return $needsAddress;
}, 10, 1);

add_filter('woocommerce_package_rates', function ($rates, $package) {
  if (ercoding_cart_all_electronic()) {
    return [];
  }
  return $rates;
}, 10, 2);


add_action('wp_footer', function () {
  $cartUrl = wc_get_cart_url();
  if (!is_cart()) {
    ?>
    <script>
      document.addEventListener('DOMContentLoaded', function () {
        if (!window.jQuery) { return; }
        jQuery(document.body).on('added_to_cart', function () {
          window.location.href = <?php echo json_encode($cartUrl);?>;
        });
      });
    </script>
    <?php
    return;
  }
  ?>
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const cartFormElement = document.querySelector('form.woocommerce-cart-form');
      if (!cartFormElement) { return; }
      let debounceTimeoutId = null;
      let isSubmittingCartUpdate = false;

      function submitCartFormWithFetch() {
        if (isSubmittingCartUpdate) { return; }
        isSubmittingCartUpdate = true;
        const formDataObject = new FormData(cartFormElement);
        formDataObject.set('update_cart', 'Update cart');
        fetch(cartFormElement.getAttribute('action') || window.location.href, {
          method: 'POST',
          body: formDataObject,
          credentials: 'same-origin'
        }).then(function (responseObject) {
          return responseObject.text();
        }).then(function () {
          window.location.reload();
        }).catch(function () {
          cartFormElement.submit();
        }).finally(function () {
          isSubmittingCartUpdate = false;
        });
      }

      function scheduleCartUpdate(delayMs) {
        if (debounceTimeoutId) {
          clearTimeout(debounceTimeoutId);
        }
        debounceTimeoutId = setTimeout(function () {
          submitCartFormWithFetch();
        }, delayMs);
      }

      document.addEventListener('input', function (eventObject) {
        const targetElement = eventObject.target;
        if (!targetElement) { return; }
        if (!cartFormElement.contains(targetElement)) { return; }
        if (targetElement.classList.contains('qty')) {
          scheduleCartUpdate(1500);
        }
      });

      document.addEventListener('change', function (eventObject) {
        const targetElement = eventObject.target;
        if (!targetElement) { return; }
        if (!cartFormElement.contains(targetElement)) { return; }
        if (targetElement.classList.contains('qty')) {
          scheduleCartUpdate(200);
        }
      });

      const updateButtons = cartFormElement.querySelectorAll('button[name="update_cart"], input[name="update_cart"]');
      updateButtons.forEach(function (buttonElement) {
        buttonElement.addEventListener('click', function (e) {
          e.preventDefault();
          submitCartFormWithFetch();
        });
      });
    });
  </script>
  <?php
});


