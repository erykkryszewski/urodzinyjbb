<?php 

$background = get_field('background');
$section_id = get_field('section_id');
$faq = get_field('faq');

?>

<?php if(!empty($faq)):?>
  <div class="faq <?php if($background == 'true') { echo 'faq--background'; }?>">
    <?php if(!empty($section_id)):?>
      <div class="section-id" id="<?php echo esc_html($section_id);?>"></div>
    <?php endif;?>
    <div class="container">
      <div class="faq__wrapper">
        <?php foreach($faq as $key => $item):?>
          <div class="faq__item <?php if($key === 0) { echo 'faq__item--open'; } ?>">
            <span class="faq__number"><?php echo $key === 0 ? '-' : '+'; ?></span>
            <div class="faq__content">
              <button class="faq__question"><?php echo apply_filters('the_title', $item['question']);?></button>
              <div class="faq__answer"><?php echo apply_filters('acf_the_content', str_replace('&nbsp;', ' ', $item['answer']));?></div>
            </div>
          </div>
        <?php endforeach;?>
      </div>
    </div>
  </div>
<?php endif;?>