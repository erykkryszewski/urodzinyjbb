<?php

$section_id = get_field("section_id");
$background = get_field("background");
$title = get_field("title");
$hide_section = get_field("hide_section");
$products_category_slug = get_field("products_category_slug");

$args = [
    "post_type" => "product",
    "posts_per_page" => 4,
];

// Add category filter if products_category_slug is not empty
if (!empty($products_category_slug)) {
    $args["tax_query"] = [
        [
            "taxonomy" => "product_cat",
            "field" => "slug",
            "terms" => $products_category_slug,
        ],
    ];
}

$loop = new WP_Query($args);

?>

<?php if ($loop->have_posts()):?>
  <div class="popular-products <?php if($hide_section == true) { echo 'display-none'; }?> <?php if($background == 'true') { echo 'popular-products--background'; }?>">
    <?php if(!empty($section_id)):?>
      <div class="section-id" id="<?php echo esc_html($section_id);?>"></div>
    <?php endif;?>
    <?php if (!empty($title)): ?>
      <span class="popular-products__decoration-title">
        <?php $cleanTitle = preg_replace('/<span[^>]*>.*?<\/span>/si', '', $title); echo apply_filters('the_title', $cleanTitle); ?>
      </span>
    <?php endif; ?>
    <div class="container">
      <?php if(!empty($title)):?>
        <h2 class="section-title"><?php echo apply_filters('the_title', $title);?></h2>
      <?php endif;?>
      <div class="popular-products__wrapper">
        <div class="row popular-products__row popular-products__row--<?php echo esc_html($section_id);?>">
          <?php while ($loop->have_posts()): $loop->the_post(); $product = wc_get_product(get_the_ID()); $product_categories = wp_get_post_terms(get_the_ID(), 'product_cat', array('fields' => 'slugs')); $product_advance = get_field('zaliczka', get_the_ID()); ?>
            <li class="popular-products__item product <?php if (in_array('ksiazki', $product_categories)) { echo 'product--ksiazki'; } ?>">
              <a href="<?php echo get_the_permalink();?>" class="woocommerce-LoopProduct-link woocommerce-loop-product__link <?php if ($product->is_on_sale()) { echo 'woocommerce-loop-product__link--shorter'; }?>">
                <div class="product__image">
                  <?php echo wp_get_attachment_image(get_post_thumbnail_id(), 'full', false, ["class" => 'object-fit-contain']);?>
                </div>
                <h2 class="woocommerce-loop-product__title"><?php the_title();?></h2>
                <?php woocommerce_template_single_price(); ?>
              </a>
              <div class="product__button-wrapper">
                <?php // Check if the product is on sale if ($product->is_on_sale()) { // Get the sale price $sale_price = $product->get_sale_price(); // Display the message with the formatted sale price echo '<div class="product__omnibus"><p>Najniższa cena z ostatnich 30 dni: <span>' . wc_price($sale_price) . '</span></p></div>'; } ?>
                <?php woocommerce_template_loop_add_to_cart(); ?>

                <?php if (!empty($product_advance)): ?>
                  <a href="<?php echo esc_html($product_advance);?>" class="button product__advance">Wpłać 1 ratę</a>
                <?php endif; ?>
              </div>
              <!-- <a href="<?php echo get_the_permalink();?>" class="product__link">Zobacz produkt</a> -->
            </li>
          <?php endwhile;?>
        </div>
      </div>
    </div>
  </div>
<?php endif;?>
<?php wp_reset_postdata(); ?>
