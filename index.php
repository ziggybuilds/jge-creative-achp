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
 <?php 
 $id = get_the_id(); 
 $current_url = get_permalink($id)
 ?>
	<div id="primary" class="content-area">
		<main id="main" class="site-main container indexPost" role="main">
			<div class="inner-wrapper indexPost__innerWrapper">
			<?php 
				// begin page loop
				if ( have_posts() ) : 
					while ( have_posts() ) : the_post();

						// begin nav icon conditional display
						if ( get_field( 'toggle_nav_display' ) ) :
							if ( get_field( 'toggle_nav_display' ) === true ) :
								if ( have_rows( 'navigation_bar_fields', 'options' ) ) :
									$rows = get_field( 'navigation_bar_fields', 'options' );
						?>
								
								<section className="navBar"><!-- start of navIcons section -->
									<div class="inner-wrapper navBar__innerWrapper">
										<div class="navIcons">
										<?php
											foreach($rows as $item) :
												// conditional page highlighting if link matches
												if ( $item['link'] == $current_url ) {
													$active = 'active-nav';
												} else {
													$active = '';
												}
										?>
												<div class="navIcons__item <?php echo $active; ?>">
													<a href="<?php echo $item['link']; ?>">
														<div><?php echo display_nav_icon($item['icon']); ?></div>
														<div><p><?php echo $item['icon_title']; ?></p></div>
													</a>
												</div>
										<?php	
											endforeach;
										?>
										</div>
									</div>
								</section>
				<?php 
				// end conditional if nav icons are toggled on
				endif; endif; endif;
				// begin modular page loop
				get_template_part('inc/modular-page-builder');
				// end page loop
				endwhile;
				endif;
			?>
			</div>
		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();
