<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package je-starter
 */

get_header(); 
?>
<?php 
	$id = get_the_ID();

	if ( get_field('background', $id) ) {
		$background = 'style="background-image: url('. get_field('background', $id) .')"';
	} else {
		$background = '';
	}
?>
	<div id="primary" class="content-area home-page fadeIn">
		<main id="main" class="site-main" role="main">
			<section class="mainContainer" <?php echo $background; ?>>
				<div class="inner-wrapper mainContainer__innerWrapper">
					<div class="mainContainer__innerWrapper__text">
						<?php if( get_field('title', $id) ) : ?>
							<h1><?php the_field('title', $id); ?></h1>
						<?php endif; ?>
						<?php if( get_field('topper_text', $id) ) : ?>
							<div><?php the_field('topper_text', $id); ?></div>
						<?php endif; ?>
					</div>
					<?php
						if( have_rows('polling_place_cards') ):
					?>
					<h3 class="mainContainer__innerWrapper__cardTitle">Find Your Polling Place</h3>
					<div class="mainContainer__innerWrapper__cards">
					<?php
							// loop through the rows of data
							while ( have_rows('polling_place_cards') ) : the_row();
							// display a sub field value
							$state = get_sub_field('state_name');
							$label = ( get_sub_field('button_label') ? get_sub_field('button_label') : 'Find Your Polling Place');
							$target = get_sub_field('button_href');
					?>
						<div class="mainContainer__innerWrapper__cards__card">
							<h4><?php echo $state; ?></h4>
							<button class="voterLinks" data-href="<?php echo $target; ?>">
								<?php echo $label; ?>
							</button>
						</div>
					<?php
							endwhile;
					?>
					</div>
					<?php
						endif;
					?>
				</div>
			</section>
		</main>
	</div><!-- #primary -->
<?php
get_footer();
