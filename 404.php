<?php

get_header();

?>

<main id="main" class="main <?php if(!is_front_page()) { echo 'main--subpage'; }?>">
	<div class="not-found">
		<div class="container text-center">
			<div class="not-found__wrapper">
				<h2 class="mt-5">Nie ma takiej podstrony</h2>
				<a href="/" class="button mt-3">Wróć do strony głównej</a>
			</div>
		</div>
	</div>
</main>
<?php get_footer(); ?>
