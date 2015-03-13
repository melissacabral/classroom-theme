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

	add_editor_style();
	
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
		'before_widget' => '<section id="%1$s" class="widget %2$s"><div class="widget-content">',
		'after_widget'  => '</div></section>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
	register_sidebar( array(
		'name'          => __( 'Footer Widgets', 'classroom-theme' ),
		'id'            => 'footer-widgets',
		'description'   => 'These Widgets appear at the bottom of every page',
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
	wp_enqueue_style( 'classroom-theme-style', get_stylesheet_uri(), array('dashicons'), '1.0.0' );
	wp_enqueue_script( 'jquery' );	
	wp_enqueue_script( 'classroom-theme-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20120206', true );
	wp_enqueue_script( 'classroom-theme-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20130115', true );
	wp_enqueue_script( 'classroom-theme-freewall', get_template_directory_uri() . '/js/freewall.js', 'jquery', '1.05', true );
	wp_enqueue_script( 'classroom-theme-main', get_template_directory_uri() . '/js/main.js', 'jquery', '0.1', true );


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
require get_template_directory() . '/inc/custom-header.php';

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


/**
* Registers a new post type
* @uses $wp_post_types Inserts new post type object into the list
*
* @param string  Post type key, must not exceed 20 characters
* @param array|string  See optional args description above.
* @return object|WP_Error the registered post type object, or an error object
*/
function classroom_register_links() {

	$labels = array(
		'name'                => __( 'Resource Links', 'classroom_theme' ),
		'singular_name'       => __( 'Resource Link', 'classroom_theme' ),
		'add_new'             => _x( 'Add New Resource Link', 'classroom_theme', 'classroom_theme' ),
		'add_new_item'        => __( 'Add New Resource Link', 'classroom_theme' ),
		'edit_item'           => __( 'Edit Resource Link', 'classroom_theme' ),
		'new_item'            => __( 'New Resource Link', 'classroom_theme' ),
		'view_item'           => __( 'View Resource Link', 'classroom_theme' ),
		'search_items'        => __( 'Search Resource Links', 'classroom_theme' ),
		'not_found'           => __( 'No Resource Links found', 'classroom_theme' ),
		'not_found_in_trash'  => __( 'No Resource Links found in Trash', 'classroom_theme' ),
		'menu_name'           => __( 'Resource Links', 'classroom_theme' ),
	);

	$args = array(
		'labels'                   => $labels,
	
		'description'         => 'For Sharing helpful links with your users',
		'taxonomies'          => array(),
		'public'              => true,
		'menu_icon'           => 'dashicons-admin-links',
		'show_in_nav_menus'   => true,
		'has_archive'		=> true,
		'publicly_queryable'  => true,
		'exclude_from_search' => true,
		
		'supports'            => array(	'title',  'thumbnail' )
	);

	register_post_type( 'link', $args );

	/*Taxonomy*/
	$labels = array(
		'name'					=> _x( 'Link Categories', 'Taxonomy Link Categories', 'classroom-theme' ),
		'singular_name'			=> _x( 'Link Category', 'Taxonomy Link Category', 'classroom-theme' ),
		'search_items'			=> __( 'Search Link Categories', 'classroom-theme' ),
		'popular_items'			=> __( 'Popular Link Categories', 'classroom-theme' ),
		'all_items'				=> __( 'All Link Categories', 'classroom-theme' ),
		'parent_item'			=> __( 'Parent Link Category', 'classroom-theme' ),
		'parent_item_colon'		=> __( 'Parent Link Category', 'classroom-theme' ),
		'edit_item'				=> __( 'Edit Link Category', 'classroom-theme' ),
		'update_item'			=> __( 'Update Link Category', 'classroom-theme' ),
		'add_new_item'			=> __( 'Add New Link Category', 'classroom-theme' ),
		'new_item_name'			=> __( 'New Link Category Name', 'classroom-theme' ),
		'add_or_remove_items'	=> __( 'Add or remove Link Categories', 'classroom-theme' ),
		'choose_from_most_used'	=> __( 'Choose from most used classroom-theme', 'classroom-theme' ),
		'menu_name'				=> __( 'Link Category', 'classroom-theme' ),
	);

	$args = array(
		'labels'            => $labels,
		'public'            => true,
		'show_in_nav_menus' => true,
		'show_admin_column' => true,
		'hierarchical'      => true,
		'capabilities' => array(),
	);

	register_taxonomy( 'link-category', array( 'link' ), $args );
	
}

add_action( 'init', 'classroom_register_links' );
