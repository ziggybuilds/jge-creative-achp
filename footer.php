<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package je-starter
 */

?>
	</div><!-- #content -->
</div><!-- #page -->
<footer class="footer container">
	<div class="inner-wrapper footer__innerWrapper">
		<div class="footer__innerWrapper__menu">
			<?php wp_nav_menu( array(
					'menu' => 'menu-2',
					'menu_class' => 'footerMenu'
				) );
			?>
		</div>
		<?php
		if( get_field('logo_link', 'options') ) :
			$logo_link = get_field('logo_link', 'options');
		else : 
			$logo_link = '';
		endif;
		if( get_field('logo', 'options') ) :
				echo '<div class="footer__innerWrapper__logo">' .
						'<a href="' . $logo_link . '"><img src="' . get_field('logo', 'options') . '"></a>' .
					'</div>';
		endif;
		?>
		<div class="footer__innerWrapper__disclaimer">
			<?php 
			if( get_field('copyright', 'options') ) :
				echo '<p>' .  get_field('copyright', 'options') . ' &copy; ' . date("Y") . '</p>';
			endif;
			if( get_field('disclaimer', 'options') ) :
				echo '<p>' .  get_field('disclaimer', 'options') . '</p>';
			endif;
			?>
		</div>
	</div>
</footer>
<?php wp_footer(); ?>
</body>
</html>
