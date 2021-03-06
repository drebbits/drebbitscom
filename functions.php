<?php
/**
 * drebbits functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package drebbits
 */

define( 'DBX_THEME', '1.1' );

/**
 * Load theme functions.
 */
require get_template_directory() . '/inc/hooks/posts.php';

if ( ! function_exists( 'dbx_paper_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function dbx_paper_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on drebbits, use a find and replace
	 * to change 'drebbits' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'drebbits', get_template_directory() . '/languages' );

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

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => esc_html__( 'Primary', 'drebbits' ),
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

	/*
	 * Enable support for Post Formats.
	 * See https://developer.wordpress.org/themes/functionality/post-formats/
	 */
	add_theme_support( 'post-formats', array(
		'aside',
		'image',
		'video',
		'quote',
		'link',
	) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'dbx_paper_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );
}
endif;
add_action( 'after_setup_theme', 'dbx_paper_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function dbx_paper_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'dbx_paper_content_width', 640 );
}
add_action( 'after_setup_theme', 'dbx_paper_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function dbx_paper_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'drebbits' ),
		'id'            => 'sidebar-1',
		'description'   => '',
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'dbx_paper_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function dbx_paper_scripts( $hook = '' ) {
	$min = defined( 'WP_DEBUG' ) && WP_DEBUG ? '': '.min';

	wp_enqueue_style( 'dbx-paper-fonts', 'https://fonts.googleapis.com/css?family=Roboto:400,400i,700' );
	wp_enqueue_style( 'dbx-paper-style', get_template_directory_uri() . '/assets/css/style'. $min .'.css', array( 'dbx-paper-fonts' ), DBX_THEME );

	wp_enqueue_script( 'dbx-paper-navigation', get_template_directory_uri() . '/assets/js/navigation.js', array(), DBX_THEME, true );

	wp_enqueue_script( 'dbx-paper-skip-link-focus-fix', get_template_directory_uri() . '/assets/js/skip-link-focus-fix.js', array(), DBX_THEME, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'dbx_paper_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';

/**
 * Custom comment walker
 */
require get_template_directory() . '/inc/classes/dbx-paper-comment-walker.php';

/**
 * Add Image Sizes
 */
add_image_size( 'logo', 9999, 40 );

/**
 * Filter post classes
 *
 * @param $classes
 * @param $class
 * @param $post_ID
 *
 * @return array
 */
function dbx_paper_post_class( $classes, $class, $post_ID ) {
	$classes = [ 'hentry', 'clear' ];

	return $classes;
}
add_filter( 'post_class', 'dbx_paper_post_class', 10, 3 );

/**
 * Filter the except length to 20 characters.
 *
 * @param int $length Excerpt length.
 * @return int (Maybe) modified excerpt length.
 */
function dbx_paper_excerpt_length( $length ) {

	if ( ! has_post_thumbnail() ) {
		$length = 80;
	}

	return $length;
}
add_filter( 'excerpt_length', 'dbx_paper_excerpt_length', 999 );

/**
 * Are we on the very home of the site? Like not paged.
 *
 * @return bool
 */
function dbx_is_home() {
	return is_front_page() && ( is_home() && ! is_paged() );
}

function remove_nav_menu_css_class( $class_css, $item ) {
	return array_filter( $class_css, function( $class ) {
		return  0 !== strpos( $class, 'menu-item' );
	} );
}
add_filter( 'nav_menu_css_class', 'remove_nav_menu_css_class', 10, 2 );

