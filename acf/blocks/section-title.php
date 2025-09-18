<?php 

$section_id = get_field('section_id');
$background = get_field('background');
$title = get_field('title');
$subtitle = get_field('subtitle');
$text = get_field('text');
$centered = get_field('centered');
$big = get_field('big');

?>

<div class="section-title <?php if($centered == 'true') { echo 'section-title--centered'; }?> <?php if($background == 'true') { echo 'section-title--background'; }?>">
  <?php if(!empty($section_id)):?>
    <div class="section-id <?php if($background == 'true') { echo 'section-id--background'; }?>" id="<?php echo esc_html($section_id);?>"></div>
  <?php endif;?>
  <div class="container">
    <?php if(!empty($title)):?>
      <?php if($big == 'true'): ?>
        <h1 class="section-title__title"><?php echo apply_filters('the_title', $title);?></h1>
      <?php else: ?>
        <h2><?php echo apply_filters('the_title', $title);?></h2>
      <?php endif; ?>
    <?php endif;?>
    <?php if(!empty($subtitle)):?>
      <?php if($big == 'true'): ?>
        <h2 class="section-title__subtitle"><?php echo apply_filters('the_title', $subtitle);?></h2>
      <?php else: ?>
        <h3><?php echo apply_filters('the_title', $subtitle);?></h3>
      <?php endif; ?>
    <?php endif;?>
    <?php if(!empty($text)):?>
      <?php echo apply_filters('acf_the_content', str_replace('&nbsp;', ' ', $text));?>
    <?php endif;?>
  </div>
</div>
