<?php

/**
 * This file contains single post content
 *
 * @package ercodingtheme
 * @license GPL-3.0-or-later
 */

get_header();
global $post;

$post = get_post();
$page_id = $post->ID;

$prev_post = get_previous_post();
$next_post = get_next_post();

?>

<main id="main" class="main main--subpage">
  <?php if(have_posts()):?>
    <?php while(have_posts()): the_post();?>
      <div class="single-blog-post">
        <div class="container">
          <div class="row">
            <div class="col-12 col-lg-10 offset-lg-1">
              <div class="single-blog-post__content">
                <div class="single-blog-post__image">
                  <?php echo wp_get_attachment_image(get_post_thumbnail_id($post->ID), 'full', '', ["class" => "object-fit-cover"]); ?>
                </div>
                <h2><?php the_title();?></h2>
                <p><?php the_content(); ?></p>
              </div>
              <div class="prev-and-next-posts <?php if (empty($prev_post)) {echo 'prev-and-next-posts--no-prev';}?> <?php if (empty($next_post)) {echo 'prev-and-next-posts--no-next';}?>">
                <div class="prev-and-next-posts__item <?php if (empty($prev_post)) {echo 'prev-and-next-posts__item--blank';}?>">
                  <?php if (!empty($prev_post)): ?>
                    <div class="prev-and-next-posts__wrapper">
                      <div class="prev-and-next-posts__image">
                        <img src="<?php echo has_post_thumbnail($prev_post) ? get_the_post_thumbnail_url($prev_post) : get_template_directory_uri()."/images/blog-placeholder.jpg"?>" alt="prev-and-next-posts image" class="object-fit-cover">
                        <a href="<?php echo get_permalink($prev_post->ID); ?>" class="prev-and-next-posts__image-link"></a>
                      </div>
                      <div class="prev-and-next-posts__content">
                        <a href="<?php echo get_permalink($prev_post->ID); ?>" class="prev-and-next-posts__title"><?php echo $prev_post->post_title; ?></a>
                        <a href="<?php echo get_permalink($prev_post->ID); ?>" class="button button--single mt-4">Poprzedni wpis</a>
                      </div>
                    </div>
                  <?php endif; ?>
                </div>
                <div class="prev-and-next-posts__item <?php if (empty($next_post)) {echo 'prev-and-next-posts__item--blank';}?>">
                  <?php if (!empty($next_post)): ?>
                    <div class="prev-and-next-posts__wrapper">
                      <div class="prev-and-next-posts__image">
                        <img src="<?php echo has_post_thumbnail($next_post) ? get_the_post_thumbnail_url($next_post) : get_template_directory_uri()."/images/blog-placeholder.jpg"?>" alt="prev-and-next-posts image" class="object-fit-cover">
                        <a href="<?php echo get_permalink($next_post->ID); ?>" class="prev-and-next-posts__image-link"></a>
                      </div>
                      <div class="prev-and-next-posts__content">
                        <a href="<?php echo get_permalink($next_post->ID); ?>" class="prev-and-next-posts__title"><?php echo $next_post->post_title; ?></a>
                        <a href="<?php echo get_permalink($next_post->ID); ?>" class="button button--single mt-4">Następny wpis</a>
                      </div>
                    </div>
                  <?php endif; ?>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    <?php endwhile;?>
  <?php endif;?>
</main>
<?php get_footer(); ?>
