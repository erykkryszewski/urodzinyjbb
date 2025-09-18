<?php 

$post_category = get_field('post_category');
$posts_number = get_field('posts_number');

$column_classes = 'col-12 col-md-6 col-lg-4';

if($posts_number == 2) {
  $column_classes = 'col-12 col-md-6';
} elseif ($posts_number == 4) {
  $column_classes = 'col-12 col-md-6 col-xl-3';
}

$args = array(
  'post_type' => $post_category,
  'posts_per_page' => (int)$posts_number
);
$posts = new WP_Query($args);

$background = get_field('background');
$section_id = get_field('section_id');

?>

<?php if($posts->have_posts()):?>
  <div class="theme-blog <?php if($background == 'true') { echo 'theme-blog--background'; }?>">
    <?php if(!empty($section_id)):?>
      <div class="section-id" id="<?php echo esc_html($section_id);?>"></div>
    <?php endif;?>
    <div class="container">
      <div class="theme-blog__wrapper">
        <div class="row">
          <?php while ($posts->have_posts()): $posts->the_post(); ?>
            <div class="<?php echo esc_html($column_classes);?>">
              <div class="theme-blog__item">
                <div class="theme-blog__image <?php if($posts_number == 2) { echo 'theme-blog__image--bigger'; } ?>">
                  <a href="<?php the_permalink();?>" class="cover"></a>
                  <?php echo wp_get_attachment_image(get_post_thumbnail_id(), 'full', '', ["class" => "object-fit-cover"]); ?>
                </div>
                <div class="theme-blog__content">
                  <div>
                    <a href="<?php the_permalink(); ?>" class="theme-blog__title"><?php the_title(); ?></a>
                    <span class="theme-blog__time"><time><?php the_time('F j, Y'); ?></time></span>
                    <p>
                      <?php 
                        $excerpt = get_the_excerpt();
                        if (empty($excerpt)) {
                          echo substr(get_content_excerpt(), 0, 150) . '...';
                        } else {
                          echo substr($excerpt, 0, 150) . '...';
                        }
                      ?>
                    </p>
                  </div>
                    <a href="<?php the_permalink(); ?>" class="theme-blog__button"><?php _e('Czytaj więcej', 'ercodingtheme'); ?></a>
                </div>
              </div>
            </div>
          <?php endwhile; ?>
        </div>
      </div>
      <?php wp_reset_postdata(); ?>
      <?php wp_reset_query(); ?>
    </div>
  </div>
<?php endif;?>