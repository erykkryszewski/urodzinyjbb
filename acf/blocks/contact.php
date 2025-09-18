<?php 

$background = get_field('background');
$section_id = get_field('section_id');
$text = get_field('text');
$form_id = get_field('form_id');
$image = get_field('image');
$name = get_field('name');
$second_image = get_field('second_image');
$second_name = get_field('second_name');

$global_phone_number = get_field('global_phone_number', 'options');
$global_phone_number_display = get_field('global_phone_number_display', 'options');
$global_email = get_field('global_email', 'options');
$global_social_media = get_field('global_social_media', 'options');
$global_opening_hours = get_field('global_opening_hours', 'options');

?>

<?php if(!empty($form_id)):?>
  <div class="contact <?php if($background == 'true') { echo 'contact--background'; }?>">
    <?php if(!empty($section_id)):?>
      <div class="section-id" id="<?php echo esc_html($section_id);?>"></div>
    <?php endif;?>
    <div class="container">
      <div class="row">
        <div class="col-lg-3">
          <div class="contact__details">
            <!-- <?php echo apply_filters('acf_the_content', $text);?> -->
            <?php if(!empty($image)):?>
              <div class="contact__image">
                <?php echo wp_get_attachment_image($image, 'medium', '', ['class' => 'object-fit-cover']);?>
              </div>
            <?php endif;?>
            <?php if(!empty($name)):?>
              <span class="contact__name"><?php echo esc_html($name);?></span>
            <?php endif;?>
            <?php if(!empty($global_phone_number)):?>
              <a class="contact__phone" href="tel:<?php echo esc_html($global_phone_number);?>">Tel: <?php echo esc_html($global_phone_number_display);?></a>
              <?php endif;?>
            <?php if(!empty($global_email)):?>
              <a class="contact__email" href="mailto:<?php echo esc_html($global_email);?>">Mail: <?php echo esc_html($global_email);?></a>
            <?php endif;?>
            <?php if(!empty($global_opening_hours)):?>
              <h4 class="contact__subtitle"><?php esc_html_e('Godziny otwarcia:', 'ercodingtheme');?></h4>
              <div class="opening-hours contact__opening-hours">
                <?php echo apply_filters('acf_the_content', $global_opening_hours);?>
              </div>
            <?php endif;?>
          </div>
        </div>
        <div class="col-lg-3">
          <div class="contact__details">
            <!-- <?php echo apply_filters('acf_the_content', $text);?> -->
            <?php if(!empty($second_image)):?>
              <div class="contact__image">
                <?php echo wp_get_attachment_image($second_image, 'medium', '', ['class' => 'object-fit-cover']);?>
              </div>
            <?php endif;?>
            <?php if(!empty($second_name)):?>
              <span class="contact__name"><?php echo esc_html($second_name);?></span>
            <?php endif;?>
            <?php if(!empty($global_phone_number)):?>
              <a class="contact__phone" href="tel:+48455445044">Tel: +48 455 445 044</a>
              <?php endif;?>
            <?php if(!empty($global_email)):?>
              <a class="contact__email" href="mailto:szkolenia@jakubbbaczek.pl">Mail: szkolenia@JakubBBaczek.pl</a>
            <?php endif;?>
            <?php if(!empty($global_opening_hours)):?>
              <h4 class="contact__subtitle"><?php esc_html_e('Godziny otwarcia:', 'ercodingtheme');?></h4>
              <div class="opening-hours contact__opening-hours">
                <?php echo apply_filters('acf_the_content', $global_opening_hours);?>
              </div>
            <?php endif;?>
          </div>
        </div>
        <?php if(!empty($form_id)):?>
          <div class="col-lg-6">
            <div class="contact__form form">
              <?php echo gravity_form($form_id, false, false, false, '', false, 31);?>
            </div>
          </div>
        <?php endif;?>
      </div>
    </div>
  </div>
<?php endif;?>