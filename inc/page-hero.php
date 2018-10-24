<?php
/**
 * The template for displaying the page hero
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package je-starter
 */

$id = get_the_ID();

?>
<div class="header__innerWrapper__pageContent">
	<div class="header__innerWrapper__pageContent__title">	
		<h1><?php
		if ( is_404() ) {
			echo 'Looks like you got lost.';
		} elseif ( !is_archive() && !is_404() ) {
			the_title();
		} elseif ( is_archive() ) {
			the_archive_title();
		}
		?></h1>
		<?php
			if ( get_field('hero_subtitle', $id) && !is_archive() ) {
				echo '<p>'. get_field('hero_subtitle', $id) .'</p>';
			}
		?>
	</div>
</div>
