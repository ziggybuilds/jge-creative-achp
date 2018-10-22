<?php
/**
 * The template for displaying the home hero
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package je-starter
 */

?>

<div class="header__innerWrapper__content">
	<div class="header__innerWrapper__content__title">	
		<?php
			if ( get_field('hero_title', $pageID) ) {
				echo '<h1>'. get_field('hero_title', $pageID) .'</h1>';
			}
		
			if ( get_field('hero_subtitle', $pageID) ) {
				echo '<p>'. get_field('hero_subtitle', $pageID) .'</p>';
			}
		?>
	</div>
	<?php
		if ( get_field('hero_video', $pageID) ) :
			echo '<div class="header__innerWrapper__content__video">' .
					'<div class="responsive-video">' . get_field('hero_video', $pageID) . '</div>' .
				'</div>';
		endif;
	?>
</div>
<div class="header__innerWrapper__featured">
	<?php
		if ( have_rows('featured_articles', $pageID ) ) :
			while ( have_rows('featured_articles', $pageID ) ) : the_row();
				$article = get_sub_field('post_object');
				$feature_post = get_post($post = $article, $output = OBJECT);
				$title = $feature_post->post_title;
				$date = $feature_post->post_date;
				$url = get_permalink($card['card_object']);
				$image = get_the_post_thumbnail_url($card['card_object']);
	?>
	<div class="header__innerWrapper__featured__card">
		<a href="<?php echo $url; ?>">
			<div class="header__innerWrapper__featured__card__img"><img src="<?php echo $image; ?>"></div>
			<div class="header__innerWrapper__featured__card__text">
				<p class="header__innerWrapper__featured__card__text__date"><?php echo $date; ?></p>
				<p class="header__innerWrapper__featured__card__text__title"><?php echo $title; ?></p>
			</div>
		</a>
	</div>
<?php
	wp_reset_postdata();
	endwhile;
endif;
?>
</div>
