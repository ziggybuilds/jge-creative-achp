<?php
/*
* Archive-loop template
*
* @package je-starter
*
*/
?>
<article class="article">
			<a href="<?php echo get_permalink(); ?>">
				<?php
					if ( get_field('hero_image') ) {
						$image = get_field('hero_image');
					} elseif ( get_the_post_thumbnail_url() != undefined ) {
						$image = get_the_post_thumbnail_url();
					}

					if ( $image ) :
				?>
				<div class="article__image">
					<img src="<?php echo $image; ?>">
				</div>
				<?php endif; ?>
				<div class="article__content">
					<p class="article__content__postDate"><?php the_date(); ?></p>
					<h3 class="article__content__title"><?php the_title(); ?></h3>
					<div class="article__content__excerpt">
						<?php 
						if ( get_field('custom_excerpt') ) {
							$desc = get_field('custom_excerpt');
							$desc = wp_trim_words($desc, $num_words = 30, $more = '...');
							echo $desc;
						}
						?>
					</div>
					<p class="article__content__link">Read More</p>
				</div>
			</a>
</article>