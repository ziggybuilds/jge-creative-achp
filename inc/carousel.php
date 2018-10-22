<?php
/**
* The template for displaying the carousel
*
* @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
*
* @package je-starter
*/

?>
<?php
	if ( have_rows('carousel') ) :
?>
<section className="carousel"><!-- start of carousel section -->
	<div class="inner-wrapper carousel__innerWrapper">
			<?php
					$nav_items = array();
					$slides = array(); 
					$rows = get_field('carousel');

					foreach($rows as $row) {
						// push icon title
						$icon = array(
							'title' => $row['icon_title'],
							'icon' => $row['icon']
						);
						array_push($nav_items, $icon);
						// push post object into slides array
						array_push($slides, $row['featured_post']);
					}
		?>
		<div class="navIcons">
		<?php
			foreach($nav_items as $item) :
		?>
				<div class="navIcons__item">
					<a href="" class="carousel__navIcons">
						<?php echo display_nav_icon($item['icon']);	?>
						<p><?php echo $item['title']; ?></p>
					</a>
				</div>
		<?php	
			endforeach;
		?>
		</div>
		<div class="carousel__innerWrapper__dots"></div>
		<div class="carousel__innerWrapper__slider">
		<?php
			foreach($slides as $slide) {
				$new_post = get_post($post = $slide, $output = OBJECT);
				if ( get_field('custom_excerpt', $slide) ) {
					$excerpt = get_field('custom_excerpt', $slide);
				} else {
					$excerpt = '';
				}
				
				echo '<div class="carousel__innerWrapper__slider__slide">' .
						'<div class="carousel__innerWrapper__slider__slide__inner">' .
							'<div class="carousel__innerWrapper__slider__slide__inner__image"><img src="' . get_the_post_thumbnail_url($slide) . '" alt="feature"/></div>' .
							'<div class="carousel__innerWrapper__slider__slide__inner__text">' .
								'<div class="carousel__innerWrapper__slider__slide__inner__text__content">' .
										'<h3>' . $new_post->post_title . '</h3>' .
										'<p>' . $excerpt . '</p>' .
								'</div>' .
								'<div class="carousel__innerWrapper__slider__slide__inner__text__button">' .
									'<button data-href="'. get_permalink($slide) . '" class="primary carouselButton">Learn More</button>' .
								'</div>' .
							'</div>' .
						'</div>' .
					'</div>';
			wp_reset_postdata();
			}
		?>			
		</div>
	</div>
<?php
endif;
?>
</section><!-- end of carousel section -->