<?php
/**
 * Classroom Theme functions and definitions
 *
 * @package Classroom Theme
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) ) {
	$content_width = 640; /* pixels */
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 */
add_action( 'after_setup_theme', 'classroom_theme_setup' );
function classroom_theme_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 */
	load_theme_textdomain( 'classroom-theme', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'comment-list', 'gallery', 'caption',
	) );
	add_theme_support( 'post-formats', array(
		'aside', 'image', 'video', 'quote', 'link',
	) );
	add_theme_support( 'custom-background', apply_filters( 'classroom_theme_custom_background_args', array(
		'default-color' => 'CED8DB',
		'default-image' => get_template_directory_uri() . '/images/default-bg.png',
	) ) );
	add_theme_support( 'custom-header',  array(
		'default-image' => get_template_directory_uri() . '/images/default-header.jpg',
		'uploads' 		=> true,
		'width'         => 1000,
		'height'        => 250,
		'flex-height'   => true,
	) );
	
	// This theme uses wp_nav_menu() in two locations.
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'classroom-theme' ),
		'utilities' => __( 'Utility Menu', 'classroom-theme' ),
	) );
		
}
 // classroom_theme_setup

/**
 * Register widget area.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_sidebar
 */
add_action( 'widgets_init', 'classroom_theme_widgets_init' );
function classroom_theme_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Global Sidebar', 'classroom-theme' ),
		'id'            => 'global-sidebar',
		'description'   => 'These Widgets appear on every page',
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
}

/**
 * Enqueue scripts and styles.
 */
function classroom_theme_scripts() {
	wp_enqueue_style( 'classroom-theme-style', get_stylesheet_uri() );
	wp_enqueue_script( 'classroom-theme-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20120206', true );
	wp_enqueue_script( 'classroom-theme-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20130115', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'classroom_theme_scripts' );


/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
// require get_template_directory() . '/inc/extras.php';
/**
 * Now Button in admin panel.
 */
require get_template_directory() . '/inc/now-button.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
// require get_template_directory() . '/inc/jetpack.php';

/**
 * Improve Excerpts
 * @since  0.1
 */
function classroom_theme_ex_length(){
	return 35; /*words*/
}
add_filter('excerpt_length', 'classroom_theme_ex_length' );
function classroom_theme_ex_more(){
	return '&hellip; <a class="read-more button" href="'.get_permalink().'">Continue Reading</a>';
}
add_filter( 'excerpt_more', 'classroom_theme_ex_more' );
