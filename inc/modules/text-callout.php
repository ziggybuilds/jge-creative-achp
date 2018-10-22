<?php
/**
 * The template for displaying the text callout
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package je-starter
 */
?>
<section class="container text-callout">
	<div class="inner-wrapper text-callout__innerWrapper">
		<div class="text-callout__innerWrapper__content">
			<h3 class="text-callout__innerWrapper__content__title"><?php the_sub_field('title'); ?></h3>
			<div class="text-callout__innerWrapper__content__desc"><?php the_sub_field('description'); ?></div>
		</div>
	</div>
</section>
