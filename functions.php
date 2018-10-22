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
