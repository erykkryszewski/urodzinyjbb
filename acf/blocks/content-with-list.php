<?php 

$section_id = get_field('section_id');
$background = get_field('background');
$image = get_field('image');
$image_class = get_field('image_class');
$title = get_field('title');
$subtitle = get_field('subtitle');
$text = get_field('text');
$list_title = get_field('list_title');
$list = get_field('list');

?>

<div class="content-with-list <?php if($background == 'true') { echo 'content-with-list--background'; }?>">
  <?php if(!empty($section_id)):?>
    <div class="section-id" id="<?php echo esc_html($section_id);?>"></div>
  <?php endif;?>
  <div class="container">
    <div class="row">
      <div class="col-md-6">
        <?php if(!empty($image)):?>
          <div class="content-with-list__image">
            <?php echo wp_get_attachment_image($image, 'full', '', ['class' => $image_class]);?>
          </div>
        <?php endif;?>
        <?php if(!empty($title)):?>
          <h2 class="content-with-list__title"><?php echo apply_filters('the_title', $title);?></h2>
        <?php endif;?>
        <?php if(!empty($subtitle)):?>
          <h3 class="content-with-list__subtitle"><?php echo apply_filters('the_title', $subtitle);?></h3>
        <?php endif;?>
        <?php if(!empty($text)):?>
          <?php echo apply_filters('acf_the_content', str_replace('&nbsp;', ' ', $text));?>
        <?php endif;?>
      </div>
      <?php if(!empty($list)):?>
        <div class="col-md-6 content-with-list__wrapper">
          <?php foreach($list as $key => $item):?>
            <div class="content-with-list__item">
            <?php echo apply_filters('acf_the_content', str_replace('&nbsp;', ' ', $item['text']));?>
            </div>
          <?php endforeach;?>
        </div>
      <?php endif;?>
    </div>
  </div>
</div>