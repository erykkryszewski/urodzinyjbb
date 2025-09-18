<?php

$background = get_field('background');
$section_id = get_field('section_id');
$title = get_field('title');
$text = get_field('text');
$image_decorator_one = get_field('image_decorator_one');
$image_decorator_two = get_field('image_decorator_two');
$video_placeholder_image = get_field('video_placeholder_image');
$video_url = get_field('video_url');

?>

<?php if(!empty($slider_content)):?>

<?php endif;?>
<?php if(!is_front_page()):?>
  <div id="subpage-hero-scroll-to"></div>
<?php endif;?>
