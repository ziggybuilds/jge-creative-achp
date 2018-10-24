<?php
/**
 * The template for displaying the duotone cards
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package je-starter
 */
?>
<section class="container duotone-cards">
	<div class="inner-wrapper duotone-cards__innerWrapper">
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
					if ( get_field('custom_excerpt', $card['card_object'] ) ) {
						$desc = get_field('custom_excerpt', $card['card_object']);
					} else {
						$desc = '';
					}
				} elseif ( $card['post_or_custom'] === 'Custom' ) {
					$title = $card['title'];
					$url = $card['link'];
					$desc = $card['description'];
				}
				$desc = wp_trim_words($desc, $num_words = 20, $more = '...');
		?>
		<div class="duotone-cards__innerWrapper__card" data-href="<?php echo $url; ?>">
			<div class="duotone-cards__innerWrapper__card__title">
				<h5><?php echo $title; ?></h5>
			</div>
			<div class="duotone-cards__innerWrapper__card__content">
				<p><?php echo $desc; ?></p>
				<a href="<?php echo $url; ?>">More</a>
			</div>
		</div>
		<?php 
		wp_reset_postdata();
		endforeach; 
		?>
	</div>
</section>
