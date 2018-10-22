<?php
/**
 * The template for displaying the page hero
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package je-starter
 */

?>
<div class="header__innerWrapper__pageContent">
	<div class="header__innerWrapper__pageContent__title">	
		<h1><?php the_title(); ?></h1>
		<?php
			if ( get_field('hero_subtitle') ) {
				echo '<p>'. get_field('hero_subtitle') .'</p>';
			}
		?>
	</div>
</div>
