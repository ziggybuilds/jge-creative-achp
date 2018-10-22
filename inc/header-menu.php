<?php
/**
 * The template for displaying the header menu
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package je-starter
 */

?>
<div class="headerMenu container">
	<div class="headerMenu__innerWrapper inner-wrapper">
		<div class="headerMenu__logo">
			<?php if ( get_field('logo', 'options') ):
				echo '<a href="' . get_home_url() . '"><img src="' . get_field("logo", "options") . '" alt="logo" /></a>';
			endif; ?>
		</div>
		<div class="header-menu-control">
			<button id="menuBtn" class=""><i class="fas fa-bars"></i>
</button>
		</div>
		<?php
		// displaying the nav menu
			wp_nav_menu( array(
				'menu' => 'Primary',
				'menu_class' => 'headerMenu__menuInner',
				) );
		?>
	</div>
</div>
