<?php
/**
 * The template for displaying the modular page builder
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package je-starter
 */

// function to render layout
// not included in ACF loop in order to limit scope of each template render
function render_layout($module) {
	switch($module) {
		case 'large_cards':
			include( locate_template( 'inc/modules/large-cards.php', false, false ) );
			break;
		case 'duotone_cards':
			include( locate_template( 'inc/modules/duotone-cards.php', false, false ) );
			break;
		case 'text_callout':
			include( locate_template( 'inc/modules/text-callout.php', false, false ) );
			break;
		case 'image_callout':
			include( locate_template( 'inc/modules/image-callout.php', false, false ) );
			break;
		case 'video_callout':
			include( locate_template( 'inc/modules/video-callout.php', false, false ) );
			break;
		case 'full_width_content':
			include( locate_template( 'inc/modules/full-width-content.php', false, false ) );
			break;
		default:
			break;
	}
}

if( have_rows('modules') ) :
	while ( have_rows('modules') ) : the_row();
		$layout = get_row_layout();
		render_layout($layout);
	endwhile;
endif;
?>
