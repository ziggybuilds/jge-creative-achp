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
?>
	<div id="primary" class="content-area home-page fadeIn">
		<main id="main" class="site-main" role="main">
			<?php // begin modular builder
				get_template_part('inc/carousel');
				get_template_part('inc/modular-page-builder'); 
			?>
		</main>
	</div><!-- #primary -->
<?php
get_footer();
