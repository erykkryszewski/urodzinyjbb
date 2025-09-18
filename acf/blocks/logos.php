<?php 

/**
 * ACF Block: Logos
 *
 *
 * @package murcom
 * @license GPL-3.0-or-later
 */

$logos = get_field('logos');
$section_id = get_field('section_id');

?>

<?php if(!empty($logos)):?>
  <div class="logos">
    <?php if(!empty($section_id)):?>
      <div class="section-id" id="<?php echo esc_html($section_id);?>"></div>
    <?php endif;?>
    <div class="container">
      <div class="logos__wrapper">
        <div class="logos__items">
          <?php foreach($logos as $key => $item):?>
            <?php if(!empty($item['image'])):?>
              <div class="logos__image">
                <?php echo wp_get_attachment_image($item['image'], 'full', '', ['class' => '']);?>
              </div>
            <?php endif;?>
          <?php endforeach;?>
        </div>
      </div>
    </div>
  </div>
<?php endif;?>