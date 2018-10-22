<?php
/**
 * The template for displaying the large cards
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package je-starter
 */
?>
<section class="container large-cards">
	<div class="inner-wrapper large-cards__innerWrapper">
		<?php
			// values stored under repeater var
			$repeater = get_sub_field('cards');
			foreach( $repeater as $card ) :
				// check if post or custom
				if ( $card['post_or_custom'] === 'Post' ) {
					// initialize new post object
					$new_post = get_post($post = $card['card_object'], $output = OBJECT);
					$title = $new_post->post_title;
					$url = get_permalink($card['card_object']);
					$image = get_the_post_thumbnail_url($card['card_object']);
				} elseif ( $card['post_or_custom'] === 'Custom' ) {
					$title = $card['title'];
					$url = $card['link'];
					$image = $card['image'];
				}
		?>
		<div class="large-cards__innerWrapper__card">
			<div class="large-cards__innerWrapper__card__img">
				<img src="<?php echo $image; ?>">
			</div>
			<div class="large-cards__innerWrapper__card__content">
				<button class="primary largeCardButton" data-href="<?php echo $url; ?>">More</button>
				<h5><?php echo $title; ?></h5>
			</div>
		</div>
		<?php 
		wp_reset_postdata(); 
		endforeach; 
		?>
	</div>
</section>
