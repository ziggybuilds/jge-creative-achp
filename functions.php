<?php
/**
 * je-starter functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package je-starter
 */

if ( ! function_exists( 'jestarter_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function jestarter_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on je-starter, use a find and replace
	 * to change 'jestarter' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'jestarter', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in two locations.
	register_nav_menus( array(
		'menu-1' => esc_html__( 'Primary', 'jestarter' ),
		'menu-2' => esc_html__( 'Footer', 'jestarter' )
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );
}
endif;
add_action( 'after_setup_theme', 'jestarter_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function jestarter_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'jestarter_content_width', 640 );
}
add_action( 'after_setup_theme', 'jestarter_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function jestarter_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'jestarter' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'jestarter' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'jestarter_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function jestarter_scripts() {
	wp_enqueue_style('font-awesome', 'https://use.fontawesome.com/releases/v5.2.0/css/all.css'); 

	wp_enqueue_script('gsap', 'https://cdnjs.cloudflare.com/ajax/libs/gsap/1.19.1/TweenMax.min.js', true);

	wp_enqueue_style('slick-css', 'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css');

	wp_enqueue_script('ScrollToPlugin', 'https://cdnjs.cloudflare.com/ajax/libs/gsap/1.20.2/plugins/ScrollToPlugin.min.js', true);

	wp_enqueue_script('ScrollMagic', 'https://cdnjs.cloudflare.com/ajax/libs/ScrollMagic/2.0.5/ScrollMagic.min.js', true);

	wp_enqueue_script('ScrollMagicPlugin', 'https://cdnjs.cloudflare.com/ajax/libs/ScrollMagic/2.0.5/plugins/animation.gsap.min.js', true);

	wp_enqueue_script( 'skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), true );

	wp_enqueue_script( 'minified-script', get_template_directory_uri() . '/js/script.min.js', array( 'jquery' ), '1.0.0', true );

	// Localize and expose assets to the JS file for use with REST API
	wp_localize_script( 'minified-script', 'postdata', 
		array(
			'post_id' => get_the_ID(),
			'theme_uri' => get_stylesheet_directory_uri(),
			'rest_url' => rest_url('wp/v2/'),
			)
		);

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'jestarter_scripts' );

function namespace_theme_stylesheets() {
	wp_register_style( 'style-minified', get_template_directory_uri() . '/style.min.css', array(), null, 'all');
	wp_enqueue_style( 'style-minified' );
}
add_action( 'wp_enqueue_scripts', 'namespace_theme_stylesheets' );


// Inserting Custom Fields Options Page
if( function_exists('acf_add_options_page') ) {
	acf_add_options_page('Theme Options');
}

// Functions to help display social
function grabSocial($platform) {
	$page = 'options';
	if( get_field($platform, $page) ):
		$render = '<a href="'  .  get_field($platform, $page) . '"><i class="fab fa-' . $platform . '" aria-hidden="true"></i></a>';
		echo $render;
	endif;
}

// Filter excerpt length
function custom_excerpt_length( $length ) {
	return 80;
}
add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );

/**
 * Filter the excerpt "read more" string.
 *
 * @param string $more "Read more" excerpt string.
 * @return string (Maybe) modified "read more" excerpt string.
 */
function wpdocs_excerpt_more( $more ) {
    return '   . . .';
}
add_filter( 'excerpt_more', 'wpdocs_excerpt_more' );

// Remove the "Category:" from the archive title
function my_theme_archive_title( $title ) {
    if ( is_category() ) {
        $title = single_cat_title( '', false );
    } elseif ( is_tag() ) {
        $title = single_tag_title( '', false );
    } elseif ( is_author() ) {
        $title = '<span class="vcard">' . get_the_author() . '</span>';
    } elseif ( is_post_type_archive() ) {
        $title = post_type_archive_title( '', false );
    } elseif ( is_tax() ) {
        $title = single_term_title( '', false );
    }
  
    return $title;
}
 
add_filter( 'get_the_archive_title', 'my_theme_archive_title' );

// helper function to display post category
function displayCats() {
	$categories = get_the_category();
	if ( ! empty( $categories ) ) {
		return $categories[0]->name;
	}
}

// helper function to display the proper icon
function display_nav_icon($label) {
	$match = strtolower($label); 
	switch ($match) {
		case 'co-creating care':
			$icon = get_template_part('icons/care');
			break;
		case 'data transparency':
			$icon = get_template_part('icons/data');
			break;
		case 'right tools':
			$icon = get_template_part('icons/tools');
			break;
		case 'value':
			$icon = get_template_part('icons/value');
			break;
		default:
			$icon = get_template_part('icons/care');
			break;
	}
	return $icon;
}

if( function_exists('acf_add_local_field_group') ):

acf_add_local_field_group(array(
	'key' => 'group_5bc78ab0a7e1b',
	'title' => 'Post & Page Options, No Homepage',
	'fields' => array(
		array(
			'key' => 'field_5bc78ac2ec2bc',
			'label' => 'Toggle Navigation Display',
			'name' => 'toggle_nav_display',
			'type' => 'true_false',
			'instructions' => 'Toggle navigation icon box display',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'message' => 'Display the navigation icons box?',
			'default_value' => 1,
			'ui' => 1,
			'ui_on_text' => 'Displaying Navigation Icons',
			'ui_off_text' => 'Hiding Navigation Icons',
		),
	),
	'location' => array(
		array(
			array(
				'param' => 'page_type',
				'operator' => '!=',
				'value' => 'front_page',
			),
		),
		array(
			array(
				'param' => 'post_type',
				'operator' => '==',
				'value' => 'post',
			),
		),
		array(
			array(
				'param' => 'page',
				'operator' => '!=',
				'value' => '48',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'acf_after_title',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => array(
		0 => 'the_content',
		1 => 'excerpt',
		2 => 'custom_fields',
		3 => 'discussion',
		4 => 'comments',
		5 => 'revisions',
		6 => 'slug',
		7 => 'author',
		8 => 'format',
		9 => 'page_attributes',
		10 => 'categories',
		11 => 'tags',
		12 => 'send-trackbacks',
	),
	'active' => 1,
	'description' => '',
));

acf_add_local_field_group(array(
	'key' => 'group_5bc78c159bd45',
	'title' => 'Theme Options',
	'fields' => array(
		array(
			'key' => 'field_5bc89d7d5fa60',
			'label' => 'Footer & Branding',
			'name' => '',
			'type' => 'tab',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'placement' => 'top',
			'endpoint' => 0,
		),
		array(
			'key' => 'field_5bc89d8d5fa61',
			'label' => 'Logo',
			'name' => 'logo',
			'type' => 'image',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'return_format' => 'url',
			'preview_size' => 'thumbnail',
			'library' => 'all',
			'min_width' => '',
			'min_height' => '',
			'min_size' => '',
			'max_width' => '',
			'max_height' => '',
			'max_size' => '',
			'mime_types' => '',
		),
		array(
			'key' => 'field_5bc89d975fa62',
			'label' => 'Copyright',
			'name' => 'copyright',
			'type' => 'text',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'maxlength' => '',
		),
		array(
			'key' => 'field_5bc89d9d5fa63',
			'label' => 'Disclaimer',
			'name' => 'disclaimer',
			'type' => 'text',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'maxlength' => '',
		),
		array(
			'key' => 'field_5bc78c1c3af57',
			'label' => 'Navigation Icon Bar',
			'name' => '',
			'type' => 'tab',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'placement' => 'top',
			'endpoint' => 0,
		),
		array(
			'key' => 'field_5bc78c303af58',
			'label' => 'Navigation Bar Fields',
			'name' => 'navigation_bar_fields',
			'type' => 'repeater',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'collapsed' => '',
			'min' => 4,
			'max' => 4,
			'layout' => 'row',
			'button_label' => '',
			'sub_fields' => array(
				array(
					'key' => 'field_5bc78c4a3af59',
					'label' => 'Icon Title',
					'name' => 'icon_title',
					'type' => 'text',
					'instructions' => '',
					'required' => 1,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'default_value' => '',
					'placeholder' => '',
					'prepend' => '',
					'append' => '',
					'maxlength' => '',
				),
				array(
					'key' => 'field_5bc78c943af5a',
					'label' => 'Icon',
					'name' => 'icon',
					'type' => 'select',
					'instructions' => 'Select icon to display',
					'required' => 1,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'choices' => array(
						'co-creating care' => 'co-creating care',
						'value' => 'value',
						'right tools' => 'right tools',
						'data transparency' => 'data transparency',
					),
					'default_value' => array(
					),
					'allow_null' => 0,
					'multiple' => 0,
					'ui' => 1,
					'ajax' => 0,
					'return_format' => 'value',
					'placeholder' => '',
				),
				array(
					'key' => 'field_5bc78d073af5b',
					'label' => 'Link',
					'name' => 'link',
					'type' => 'link',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'return_format' => 'url',
				),
			),
		),
	),
	'location' => array(
		array(
			array(
				'param' => 'options_page',
				'operator' => '==',
				'value' => 'acf-options-theme-options',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'normal',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => 1,
	'description' => '',
));

acf_add_local_field_group(array(
	'key' => 'group_5bc0eff4e81af',
	'title' => 'Universal Post & Page',
	'fields' => array(
		array(
			'key' => 'field_5bc8b7507067a',
			'label' => 'Subtitle',
			'name' => 'hero_subtitle',
			'type' => 'text',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'maxlength' => '',
		),
		array(
			'key' => 'field_5bc8b72aee7a8',
			'label' => 'Hero Image',
			'name' => 'hero_image',
			'type' => 'image',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'return_format' => 'url',
			'preview_size' => 'thumbnail',
			'library' => 'all',
			'min_width' => '',
			'min_height' => '',
			'min_size' => '',
			'max_width' => '',
			'max_height' => '',
			'max_size' => '',
			'mime_types' => '',
		),
		array(
			'key' => 'field_5bc0effd9f074',
			'label' => 'Custom Excerpt',
			'name' => 'custom_excerpt',
			'type' => 'textarea',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => '',
			'maxlength' => 80,
			'rows' => '',
			'new_lines' => '',
		),
	),
	'location' => array(
		array(
			array(
				'param' => 'post_type',
				'operator' => '==',
				'value' => 'post',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'normal',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => array(
		0 => 'the_content',
		1 => 'excerpt',
		2 => 'discussion',
		3 => 'comments',
		4 => 'revisions',
		5 => 'slug',
		6 => 'author',
		7 => 'format',
		8 => 'page_attributes',
		9 => 'categories',
		10 => 'tags',
		11 => 'send-trackbacks',
	),
	'active' => 1,
	'description' => '',
));

acf_add_local_field_group(array(
	'key' => 'group_5bbfa04c01e05',
	'title' => 'Home',
	'fields' => array(
		array(
			'key' => 'field_5bbfb40bc759a',
			'label' => 'Hero',
			'name' => '',
			'type' => 'tab',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'placement' => 'top',
			'endpoint' => 0,
		),
		array(
			'key' => 'field_5bbfb434c759c',
			'label' => 'Title',
			'name' => 'hero_title',
			'type' => 'text',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'maxlength' => '',
		),
		array(
			'key' => 'field_5bbfb41fc759b',
			'label' => 'Hero Video',
			'name' => 'hero_video',
			'type' => 'oembed',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'width' => '',
			'height' => '',
		),
		array(
			'key' => 'field_5bbfb3b1c7597',
			'label' => 'Featured Articles',
			'name' => 'featured_articles',
			'type' => 'repeater',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'collapsed' => '',
			'min' => 2,
			'max' => 2,
			'layout' => 'table',
			'button_label' => '',
			'sub_fields' => array(
				array(
					'key' => 'field_5bbfb3c3c7598',
					'label' => 'Post Object',
					'name' => 'post_object',
					'type' => 'post_object',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'post_type' => '',
					'taxonomy' => '',
					'allow_null' => 0,
					'multiple' => 0,
					'return_format' => 'id',
					'ui' => 1,
				),
			),
		),
		array(
			'key' => 'field_5bbfa077365cc',
			'label' => 'Featured Carousel',
			'name' => '',
			'type' => 'tab',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'placement' => 'left',
			'endpoint' => 0,
		),
		array(
			'key' => 'field_5bbfafbe365ce',
			'label' => 'Carousel',
			'name' => 'carousel',
			'type' => 'repeater',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'collapsed' => 'field_5bc0d38aefc4a',
			'min' => 1,
			'max' => 4,
			'layout' => 'row',
			'button_label' => '',
			'sub_fields' => array(
				array(
					'key' => 'field_5bc0d38aefc4a',
					'label' => 'Icon Title',
					'name' => 'icon_title',
					'type' => 'text',
					'instructions' => '',
					'required' => 1,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'default_value' => '',
					'placeholder' => '',
					'prepend' => '',
					'append' => '',
					'maxlength' => '',
				),
				array(
					'key' => 'field_5bc0d3b2efc4c',
					'label' => 'Featured Post',
					'name' => 'featured_post',
					'type' => 'post_object',
					'instructions' => '',
					'required' => 1,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'post_type' => array(
					),
					'taxonomy' => array(
					),
					'allow_null' => 0,
					'multiple' => 0,
					'return_format' => 'id',
					'ui' => 1,
				),
				array(
					'key' => 'field_5bc89a261c969',
					'label' => 'Icon',
					'name' => 'icon',
					'type' => 'select',
					'instructions' => '',
					'required' => 1,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'choices' => array(
						'value' => 'value',
						'co-creating care' => 'co-creating care',
						'data transparency' => 'data transparency',
						'right tools' => 'right tools',
					),
					'default_value' => array(
					),
					'allow_null' => 0,
					'multiple' => 0,
					'ui' => 1,
					'ajax' => 0,
					'return_format' => 'value',
					'placeholder' => '',
				),
			),
		),
	),
	'location' => array(
		array(
			array(
				'param' => 'page_type',
				'operator' => '==',
				'value' => 'front_page',
			),
		),
	),
	'menu_order' => 1,
	'position' => 'acf_after_title',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => array(
		0 => 'permalink',
		1 => 'the_content',
		2 => 'excerpt',
		3 => 'discussion',
		4 => 'comments',
		5 => 'revisions',
		6 => 'slug',
		7 => 'author',
		8 => 'format',
		9 => 'page_attributes',
		10 => 'featured_image',
		11 => 'categories',
		12 => 'tags',
		13 => 'send-trackbacks',
	),
	'active' => 1,
	'description' => '',
));

acf_add_local_field_group(array(
	'key' => 'group_5bc4c7ee3d793',
	'title' => 'Modular Fields',
	'fields' => array(
		array(
			'key' => 'field_5bc4c812c9407',
			'label' => 'Module Page Builder',
			'name' => 'modules',
			'type' => 'flexible_content',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'layouts' => array(
				'5bc4c82284f56' => array(
					'key' => '5bc4c82284f56',
					'name' => 'large_cards',
					'label' => 'Large Cards',
					'display' => 'block',
					'sub_fields' => array(
						array(
							'key' => 'field_5bc4c831c9408',
							'label' => 'Cards',
							'name' => 'cards',
							'type' => 'repeater',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array(
								'width' => '',
								'class' => '',
								'id' => '',
							),
							'collapsed' => '',
							'min' => 0,
							'max' => 0,
							'layout' => 'row',
							'button_label' => 'Add New Card',
							'sub_fields' => array(
								array(
									'key' => 'field_5bc4c968c9415',
									'label' => 'Post or Custom',
									'name' => 'post_or_custom',
									'type' => 'radio',
									'instructions' => 'Choose if this is a post base card or if you would like to provide custom values',
									'required' => 1,
									'conditional_logic' => 0,
									'wrapper' => array(
										'width' => '',
										'class' => '',
										'id' => '',
									),
									'choices' => array(
										'Post' => 'Post',
										'Custom' => 'Custom',
									),
									'allow_null' => 0,
									'other_choice' => 0,
									'save_other_choice' => 0,
									'default_value' => '',
									'layout' => 'vertical',
									'return_format' => 'value',
								),
								array(
									'key' => 'field_5bc4c84ac9409',
									'label' => 'Card Object',
									'name' => 'card_object',
									'type' => 'post_object',
									'instructions' => 'Content will be populated from post',
									'required' => 0,
									'conditional_logic' => array(
										array(
											array(
												'field' => 'field_5bc4c968c9415',
												'operator' => '==',
												'value' => 'Post',
											),
										),
									),
									'wrapper' => array(
										'width' => '',
										'class' => '',
										'id' => '',
									),
									'post_type' => array(
									),
									'taxonomy' => array(
									),
									'allow_null' => 0,
									'multiple' => 0,
									'return_format' => 'id',
									'ui' => 1,
								),
								array(
									'key' => 'field_5bc4c908c9411',
									'label' => 'Title',
									'name' => 'title',
									'type' => 'text',
									'instructions' => 'Custom Title',
									'required' => 0,
									'conditional_logic' => array(
										array(
											array(
												'field' => 'field_5bc4c968c9415',
												'operator' => '==',
												'value' => 'Custom',
											),
										),
									),
									'wrapper' => array(
										'width' => '',
										'class' => '',
										'id' => '',
									),
									'default_value' => '',
									'placeholder' => '',
									'prepend' => '',
									'append' => '',
									'maxlength' => '',
								),
								array(
									'key' => 'field_5bc4c90ec9412',
									'label' => 'Link',
									'name' => 'link',
									'type' => 'link',
									'instructions' => 'Custom Link',
									'required' => 0,
									'conditional_logic' => array(
										array(
											array(
												'field' => 'field_5bc4c968c9415',
												'operator' => '==',
												'value' => 'Custom',
											),
										),
									),
									'wrapper' => array(
										'width' => '',
										'class' => '',
										'id' => '',
									),
									'return_format' => 'url',
								),
								array(
									'key' => 'field_5bc4c920c9413',
									'label' => 'Image',
									'name' => 'image',
									'type' => 'image',
									'instructions' => 'Custom Image',
									'required' => 0,
									'conditional_logic' => array(
										array(
											array(
												'field' => 'field_5bc4c968c9415',
												'operator' => '==',
												'value' => 'Custom',
											),
										),
									),
									'wrapper' => array(
										'width' => '',
										'class' => '',
										'id' => '',
									),
									'return_format' => 'url',
									'preview_size' => 'thumbnail',
									'library' => 'all',
									'min_width' => '',
									'min_height' => '',
									'min_size' => '',
									'max_width' => '',
									'max_height' => '',
									'max_size' => '',
									'mime_types' => '',
								),
							),
						),
					),
					'min' => '',
					'max' => '',
				),
				'5bc4ca75c9420' => array(
					'key' => '5bc4ca75c9420',
					'name' => 'duotone_cards',
					'label' => 'Duotone Cards',
					'display' => 'block',
					'sub_fields' => array(
						array(
							'key' => 'field_5bc4ca75c9421',
							'label' => 'Cards',
							'name' => 'cards',
							'type' => 'repeater',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array(
								'width' => '',
								'class' => '',
								'id' => '',
							),
							'collapsed' => '',
							'min' => 0,
							'max' => 0,
							'layout' => 'row',
							'button_label' => 'Add New Card',
							'sub_fields' => array(
								array(
									'key' => 'field_5bc4ca75c9422',
									'label' => 'Post or Custom',
									'name' => 'post_or_custom',
									'type' => 'radio',
									'instructions' => 'Choose if this is a post base card or if you would like to provide custom values',
									'required' => 1,
									'conditional_logic' => 0,
									'wrapper' => array(
										'width' => '',
										'class' => '',
										'id' => '',
									),
									'choices' => array(
										'Post' => 'Post',
										'Custom' => 'Custom',
									),
									'allow_null' => 0,
									'other_choice' => 0,
									'save_other_choice' => 0,
									'default_value' => '',
									'layout' => 'horizontal',
									'return_format' => 'value',
								),
								array(
									'key' => 'field_5bc4ca75c9423',
									'label' => 'Card Object',
									'name' => 'card_object',
									'type' => 'post_object',
									'instructions' => 'Content will be populated from post',
									'required' => 0,
									'conditional_logic' => array(
										array(
											array(
												'field' => 'field_5bc4ca75c9422',
												'operator' => '==',
												'value' => 'Post',
											),
										),
									),
									'wrapper' => array(
										'width' => '',
										'class' => '',
										'id' => '',
									),
									'post_type' => array(
									),
									'taxonomy' => array(
									),
									'allow_null' => 0,
									'multiple' => 0,
									'return_format' => 'id',
									'ui' => 1,
								),
								array(
									'key' => 'field_5bc4ca75c9424',
									'label' => 'Title',
									'name' => 'title',
									'type' => 'text',
									'instructions' => 'Custom Title',
									'required' => 0,
									'conditional_logic' => array(
										array(
											array(
												'field' => 'field_5bc4ca75c9422',
												'operator' => '==',
												'value' => 'Custom',
											),
										),
									),
									'wrapper' => array(
										'width' => '',
										'class' => '',
										'id' => '',
									),
									'default_value' => '',
									'placeholder' => '',
									'prepend' => '',
									'append' => '',
									'maxlength' => '',
								),
								array(
									'key' => 'field_5bc4ca88c9427',
									'label' => 'Description',
									'name' => 'description',
									'type' => 'textarea',
									'instructions' => 'Custom Description',
									'required' => 0,
									'conditional_logic' => array(
										array(
											array(
												'field' => 'field_5bc4ca75c9422',
												'operator' => '==',
												'value' => 'Custom',
											),
										),
									),
									'wrapper' => array(
										'width' => '',
										'class' => '',
										'id' => '',
									),
									'default_value' => '',
									'placeholder' => '',
									'maxlength' => 120,
									'rows' => 4,
									'new_lines' => '',
								),
								array(
									'key' => 'field_5bc4ca75c9425',
									'label' => 'Link',
									'name' => 'link',
									'type' => 'link',
									'instructions' => 'Custom Link',
									'required' => 0,
									'conditional_logic' => array(
										array(
											array(
												'field' => 'field_5bc4ca75c9422',
												'operator' => '==',
												'value' => 'Custom',
											),
										),
									),
									'wrapper' => array(
										'width' => '',
										'class' => '',
										'id' => '',
									),
									'return_format' => 'url',
								),
							),
						),
					),
					'min' => '',
					'max' => '',
				),
				'5bc4c8bbc940b' => array(
					'key' => '5bc4c8bbc940b',
					'name' => 'image_callout',
					'label' => 'Image Callout',
					'display' => 'block',
					'sub_fields' => array(
						array(
							'key' => 'field_5bc4c8c4c940c',
							'label' => 'Image',
							'name' => 'image',
							'type' => 'image',
							'instructions' => '',
							'required' => 1,
							'conditional_logic' => 0,
							'wrapper' => array(
								'width' => '',
								'class' => '',
								'id' => '',
							),
							'return_format' => 'url',
							'preview_size' => 'thumbnail',
							'library' => 'all',
							'min_width' => '',
							'min_height' => '',
							'min_size' => '',
							'max_width' => '',
							'max_height' => '',
							'max_size' => '',
							'mime_types' => '',
						),
						array(
							'key' => 'field_5bc4c8d1c940d',
							'label' => 'Title',
							'name' => 'title',
							'type' => 'text',
							'instructions' => '',
							'required' => 1,
							'conditional_logic' => 0,
							'wrapper' => array(
								'width' => '',
								'class' => '',
								'id' => '',
							),
							'default_value' => '',
							'placeholder' => '',
							'prepend' => '',
							'append' => '',
							'maxlength' => '',
						),
						array(
							'key' => 'field_5bc4c8dcc940e',
							'label' => 'Description',
							'name' => 'description',
							'type' => 'text',
							'instructions' => '',
							'required' => 1,
							'conditional_logic' => 0,
							'wrapper' => array(
								'width' => '',
								'class' => '',
								'id' => '',
							),
							'default_value' => '',
							'placeholder' => '',
							'prepend' => '',
							'append' => '',
							'maxlength' => '',
						),
						array(
							'key' => 'field_5bc4c8e8c940f',
							'label' => 'Link',
							'name' => 'link',
							'type' => 'link',
							'instructions' => '',
							'required' => 1,
							'conditional_logic' => 0,
							'wrapper' => array(
								'width' => '',
								'class' => '',
								'id' => '',
							),
							'return_format' => 'url',
						),
					),
					'min' => '',
					'max' => '',
				),
				'5bc4c9f4c9416' => array(
					'key' => '5bc4c9f4c9416',
					'name' => 'text_callout',
					'label' => 'Text Callout',
					'display' => 'block',
					'sub_fields' => array(
						array(
							'key' => 'field_5bc4c9fdc9417',
							'label' => 'Title',
							'name' => 'title',
							'type' => 'text',
							'instructions' => '',
							'required' => 1,
							'conditional_logic' => 0,
							'wrapper' => array(
								'width' => '',
								'class' => '',
								'id' => '',
							),
							'default_value' => '',
							'placeholder' => '',
							'prepend' => '',
							'append' => '',
							'maxlength' => '',
						),
						array(
							'key' => 'field_5bc4ca03c9418',
							'label' => 'Description',
							'name' => 'description',
							'type' => 'wysiwyg',
							'instructions' => '',
							'required' => 1,
							'conditional_logic' => 0,
							'wrapper' => array(
								'width' => '',
								'class' => '',
								'id' => '',
							),
							'default_value' => '',
							'tabs' => 'all',
							'toolbar' => 'full',
							'media_upload' => 0,
							'delay' => 0,
						),
					),
					'min' => '',
					'max' => '',
				),
				'5bc4ca1bc941a' => array(
					'key' => '5bc4ca1bc941a',
					'name' => 'video_callout',
					'label' => 'Video Callout',
					'display' => 'block',
					'sub_fields' => array(
						array(
							'key' => 'field_5bc4ca24c941b',
							'label' => 'Video',
							'name' => 'video',
							'type' => 'oembed',
							'instructions' => 'Paste video url here',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array(
								'width' => '',
								'class' => '',
								'id' => '',
							),
							'width' => '',
							'height' => '',
						),
						array(
							'key' => 'field_5bc4ca39c941c',
							'label' => 'Video Title',
							'name' => 'video_title',
							'type' => 'text',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array(
								'width' => '',
								'class' => '',
								'id' => '',
							),
							'default_value' => '',
							'placeholder' => '',
							'prepend' => '',
							'append' => '',
							'maxlength' => '',
						),
					),
					'min' => '',
					'max' => '',
				),
				'5bc4ca46c941d' => array(
					'key' => '5bc4ca46c941d',
					'name' => 'full_width_content',
					'label' => 'Full-Width Content',
					'display' => 'block',
					'sub_fields' => array(
						array(
							'key' => 'field_5bc4ca52c941e',
							'label' => 'Content',
							'name' => 'content',
							'type' => 'wysiwyg',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array(
								'width' => '',
								'class' => '',
								'id' => '',
							),
							'default_value' => '',
							'tabs' => 'all',
							'toolbar' => 'full',
							'media_upload' => 1,
							'delay' => 0,
						),
					),
					'min' => '',
					'max' => '',
				),
			),
			'button_label' => 'Add New Section',
			'min' => '',
			'max' => '',
		),
	),
	'location' => array(
		array(
			array(
				'param' => 'post_type',
				'operator' => '==',
				'value' => 'post',
			),
		),
		array(
			array(
				'param' => 'page_type',
				'operator' => '==',
				'value' => 'top_level',
			),
		),
	),
	'menu_order' => 2,
	'position' => 'acf_after_title',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => array(
		0 => 'the_content',
		1 => 'excerpt',
		2 => 'custom_fields',
		3 => 'discussion',
		4 => 'comments',
		5 => 'revisions',
		6 => 'slug',
		7 => 'author',
		8 => 'format',
		9 => 'page_attributes',
		10 => 'categories',
		11 => 'tags',
		12 => 'send-trackbacks',
	),
	'active' => 1,
	'description' => '',
));

endif;
