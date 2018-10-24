<?php 
/**
*
* @package je-starter
* archive.php
*/
?>

<?php get_header(); ?>

<div id="primary" class="content-area">
	<main id="main" class="site-main" role="main">
		<section class="container archive">
			<div class="archive__InnerWrapper inner-wrapper">
				<?php
					/* Start the Loop */
					while ( have_posts() ) : the_post();
						
						get_template_part( 'template-parts/archive-loop');


					endwhile; // End of the loop.

					the_posts_navigation();
					wp_reset_postdata();
				?>
			</div>
		</section>
	</main><!-- #main -->
</div><!-- #primary -->

<?php
get_footer();