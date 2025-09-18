<?php 

$section_id = get_field('section_id');
$background = get_field('background');
$boxes = get_field('boxes');

?>

<?php if(!empty($boxes)):?>
  <div class="three-boxes <?php if($background == 'true') { echo 'three-boxes--background'; }?>">
    <?php if(!empty($section_id)):?>
      <div class="section-id" id="<?php echo esc_html($section_id);?>"></div>
    <?php endif;?>
    <div class="container">
      <div class="row">
        <?php foreach($boxes as $key => $item):?>
          <div class="col-sm-6 col-lg-4">
            <div class="three-boxes__item">
              <?php if(!empty($item['image'])):?>
                <div class="three-boxes__image">
                  <?php echo wp_get_attachment_image($item['image'], 'full', '', ['class' => 'object-fit-cover']);?>
                </div>
              <?php endif;?>
              <h3 class="three-boxes__title"><?php echo apply_filters('the_title', $item['title']);?></h3>
              <a href="<?php echo esc_html($item['link']['url']);?>" class="cover"></a>
            </div>
          </div>
        <?php endforeach;?>
      </div>
    </div>
  </div>
<?php endif;?>