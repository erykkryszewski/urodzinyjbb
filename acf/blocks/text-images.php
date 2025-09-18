<?php 

$section_id = get_field('section_id');
$background = get_field('background');
$title = get_field('title');
$text = get_field('text');
$button = get_field('button');

$left_image = get_field('left_image');
$right_image = get_field('right_image');
// $top_image = get_field('top_image');

?>

<div class="text-images <?php if($background == 'true') { echo 'text-images--background'; }?>">
  <?php if(!empty($section_id)):?>
    <div class="section-id" id="<?php echo esc_html($section_id);?>"></div>
  <?php endif;?>
  <div class="container">
    <div class="row text-images__row">
      <div class="col-md-6">
        <div class="text-images__content">
          <h2 class="text-images__title"><?php echo apply_filters('the_title', $title);?></h2>
          <?php echo apply_filters('acf_the_content', str_replace('&nbsp;', ' ', $text));?>
          <?php if(!empty($button)):?>
            <a href="<?php echo esc_html($button['url']);?>" class="button text-images__button"><?php echo esc_html($button['title']);?></a>
          <?php endif;?>
        </div>
      </div>
      <div class="col-md-6">
        <div class="text-images__pictures-wrapper">
          <?php if(!empty($left_image)):?>
            <div class="text-images__left-picture">
              <?php echo wp_get_attachment_image($left_image, 'text-images-left', '', ['class' => 'object-fit-cover']);?>
            </div>
          <?php endif;?>
          <?php if(!empty($right_image)):?>
            <div class="text-images__right-picture">
              <?php echo wp_get_attachment_image($right_image, 'text-images-right', '', ['class' => 'object-fit-cover']);?>
            </div>
          <?php endif;?>
          <?php if(!empty($top_image)):?>
            <div class="text-images__top-picture">
              <?php echo wp_get_attachment_image($top_image, 'text-images-top', '', ['class' => 'object-fit-cover']);?>
            </div>
          <?php endif;?>
        </div>
      </div>
    </div>
  </div>
</div>