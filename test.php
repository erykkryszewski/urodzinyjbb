<?php if(!empty($button)):?>
<?php endif;?>

<?php if(!empty($image)):?>
  <?php echo wp_get_attachment_image($image, 'full', '', ['class' => 'object-fit-cover']);?>
<?php endif;?>

<?php echo apply_filters('the_title', $title);?>

<?php echo apply_filters('acf_the_content', $text);?>



<?php foreach($team as $key => $item):?>
<?php endforeach;?>

<?php echo apply_filters('the_title', $item['title']);?>
<?php echo apply_filters('acf_the_content', str_replace('&nbsp;', ' ', $item['text']));?>



