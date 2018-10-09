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

get_header(); ?>
 <?php $id = get_the_id(); ?>
	<div id="primary" class="content-area">
		<main id="main" class="site-main container indexPost" role="main">
			<div class="inner-wrapper indexPost__innerWrapper">
			<?php 
				if ( have_posts() ) : 
					while ( have_posts() ) : the_post();
			?>
			<div class="indexPost__innerWrapper__title">
				<h1><?php the_title(); ?></h1>
			</div>
			<div class="indexPost__innerWrapper__content">
				<?php the_content(); ?>
			</div>
			<?php
					endwhile; 
				endif;
			?>
			</div>
		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();
