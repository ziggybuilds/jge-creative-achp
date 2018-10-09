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
	<div class="footer__innerWrapper inner-wrapper">
		<?php
		// display logo
		if( get_field('logo', 'options') ) {
			echo '<div class="footer__innerWrapper__logo logo"><img src="' . get_field('logo', 'options') . '" alt="logo" /></div>';
		}
		?>
		<div class="footer__innerWrapper__disclaimer">
			<?php
				// display disclaimer
				if( get_field('disclaimer', 'options') ) {
					echo '<p>' . get_field('disclaimer', 'options') . '</p>';
				}
				if( get_field('copyright', 'options') ) {
					echo '<p>' . get_field('copyright', 'options') . ' &copy; ' . date("Y") . '</p>';
				}
				if( get_field('privacy_policy', 'options') ) {
					echo '<a href="' . get_field('privacy_policy', 'options') . '">Privacy Policy</a>';
				}
			?>
		</div>
	</div>
</footer>

<?php wp_footer(); ?>

</body>
</html>
