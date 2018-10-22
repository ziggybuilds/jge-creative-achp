<?php
/**
 * The template for displaying the video callout
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package je-starter
 */
?>
<section class="container video-callout">
	<div class="inner-wrapper video-callout__innerWrapper">
		<div class="video-callout__innerWrapper__video responsive-video">
			<?php the_sub_field('video'); ?>
		</div>
		<div class="video-callout__innerWrapper__content">
			<h5 class="video-callout__innerWrapper__content__title"><?php the_sub_field('video_title'); ?></h5>
		</div>
	</div>
</section>
