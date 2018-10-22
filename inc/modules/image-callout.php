<?php
/**
 * The template for displaying the image callout
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package je-starter
 */
?>
<section class="container image-callout">
	<div class="inner-wrapper image-callout__innerWrapper">
		<div class="image-callout__innerWrapper__image">
			<img src="<?php the_sub_field('image'); ?>" alt="callout" />
		</div>
		<div class="image-callout__innerWrapper__content">
			<h3 class="image-callout__innerWrapper__content__title"><?php the_sub_field('title'); ?></h3>
			<div class="image-callout__innerWrapper__content__desc"><p><?php the_sub_field('description'); ?></p></div>
			<button class="image-callout__innerWrapper__content__link primary imageCalloutButton" data-href="<?php the_sub_field('link'); ?>">More</button>
		</div>
	</div>
</section>
