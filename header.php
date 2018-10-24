<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package je-starter
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">

<?php wp_head(); ?>

</head>

<body <?php body_class(); ?>>
<?php

//check page context
if ( is_home() || is_front_page() ) {
	$pageStyle = "home-header";
} elseif ( !is_home() || !is_front_page()) {
	$pageStyle = "page-header";
}

$pageID = get_the_ID();

if( get_field('hero_image', $pageID) && !is_archive() ) {
	$heroImage = 'style="background-image: url(' . get_field('hero_image', $pageID) . ')"';
}
?>
<div id="page" class="site">
	<header id="masthead" <?php echo $heroImage ?> class="header container <?php echo $pageStyle; ?>" role="banner">
		<?php get_template_part('inc/header-menu'); ?>
		<div class="header__innerWrapper inner-wrapper">
			<?php
				if ( is_home() || is_front_page() ) {
					get_template_part('inc/home-hero');
				} elseif ( !is_home() && !is_front_page() ) {
					get_template_part('inc/page-hero');
				}
			?>
		</div>
	</header><!-- #masthead -->
<div id="content" class="site-content">
