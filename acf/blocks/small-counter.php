<?php

$background = get_field('background');
$section_id = get_field('section_id');
 
/* cuntdown function */
$counter_date = get_field('counter_date');
$counter_hour = get_field('counter_hour');

$final_time = $counter_date.' '.$counter_hour;

?>

<?php if(time() < strtotime($final_time)):?>
  <h3 class="text-center mb-5">Promocja kończy się za</h3>
  <div class="counter <?php if($background == 'true') { echo 'counter--background'; }?> counter--small">
    <?php if(!empty($section_id)):?>
      <div class="section-id" id="<?php echo esc_html($section_id);?>"></div>
    <?php endif;?>
    <div class="container">
      <div class="counter__time-wrapper counter__time-wrapper--small" id="<?php echo esc_html($final_time);?>">
        <div class="counter__item counter__item--small counter__day counter__day--small">99</div>
        <div class="counter__item counter__item--small counter__hour counter__hour--small">99</div>
        <div class="counter__item counter__item--small counter__minute counter__minute--small">99</div>
        <div class="counter__item counter__item--small counter__second counter__second--small">99</div>
      </div>
    </div>
  </div>
<?php endif;?>



