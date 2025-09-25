<?php remove_action("woocommerce_single_product_summary", "woocommerce_template_single_price", 10);
remove_action("woocommerce_single_product_summary", "woocommerce_template_single_excerpt", 20);
add_action("woocommerce_single_product_summary", "woocommerce_template_single_excerpt", 10);
add_action("woocommerce_single_product_summary", "woocommerce_template_single_price", 20);
add_filter("body_class", "add_category_to_body_class");
function add_category_to_body_class($classes)
{
    if (is_product()) {
        $product_cats = wp_get_post_terms(get_the_ID(), "product_cat");
        if (!empty($product_cats)) {
            $product_cat = array_shift($product_cats);
            $classes[] = "product-category-" . $product_cat->
slug; } } return $classes; } add_filter("woocommerce_gallery_thumbnail_size", function () { return "medium"; }); function display_lowest_price_message() { global $product; if (!$product) { return; } if ($product->is_on_sale()) { $sale_price
= $product->get_sale_price(); echo '
<div class="product__omnibus"><p>Najniższa cena z ostatnich 30 dni: ' . wc_price($sale_price) . "</p></div>
"; } } add_action("woocommerce_single_product_summary", "display_lowest_price_message", 25); function display_advance_payment_button() { global $product; $product_categories = wp_get_post_terms($product->get_id(), "product_cat", [ "fields"
=> "slugs", ]); $product_advance = get_field("zaliczka", $product->get_id()); if (in_array("akademia", $product_categories) && !empty($product_advance)) { echo '
<a href="' . esc_url($product_advance) . '" class="button product__advance product__advance--single">Wpłać 1 ratę</a>
'; } } add_action("woocommerce_after_add_to_cart_button", "display_advance_payment_button");
