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
		'default-color' => '',
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
 * ACF integration
 * Adds custom fields to various post types
 */
if(function_exists("register_field_group"))
{
	register_field_group(array (
		'id' => 'acf_attention-box',
		'title' => 'Attention Box',
		'fields' => array (
			array (
				'key' => 'field_5500e7a8e6a60',
				'label' => 'Important',
				'name' => 'important',
				'type' => 'wysiwyg',
				'instructions' => 'Any text you write here will be emphasized in a callout box when viewing the post. ',
				'default_value' => '',
				'toolbar' => 'full',
				'media_upload' => 'yes',
			),
		),
		'location' => array (
			array (
				array (
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'post',
					'order_no' => 0,
					'group_no' => 0,
				),
			),
			array (
				array (
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'page',
					'order_no' => 0,
					'group_no' => 1,
				),
			),
		),
		'options' => array (
			'position' => 'normal',
			'layout' => 'no_box',
			'hide_on_screen' => array (
			),
		),
		'menu_order' => 0,
	));
	register_field_group(array (
		'id' => 'acf_optional-settings',
		'title' => 'Optional Settings',
		'fields' => array (
			array (
				'key' => 'field_54d4f0055e486',
				'label' => 'Due Date',
				'name' => 'due_date',
				'type' => 'date_picker',
				'date_format' => 'yymmdd',
				'display_format' => 'dd/mm/yy',
				'first_day' => 0,
			),
			array (
				'key' => 'field_54d4f0265e487',
				'label' => 'File Attachment',
				'name' => 'file_attachment',
				'type' => 'file',
				'instructions' => 'Attach a file to this post for your students to download. If you need more than one file attachment, use the "Add Media" button. ',
				'save_format' => 'object',
				'library' => 'all',
			),
			array (
				'key' => 'field_5500f5538b3e3',
				'label' => 'Related Reading',
				'name' => 'related_reading',
				'type' => 'textarea',
				'default_value' => '',
				'placeholder' => '',
				'maxlength' => '',
				'rows' => 5,
				'formatting' => 'html',
			),
		),
		'location' => array (
			array (
				array (
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'post',
					'order_no' => 0,
					'group_no' => 0,
				),
			),
			array (
				array (
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'page',
					'order_no' => 0,
					'group_no' => 1,
				),
			),
		),
		'options' => array (
			'position' => 'side',
			'layout' => 'default',
			'hide_on_screen' => array (
			),
		),
		'menu_order' => 0,
	));
	register_field_group(array (
		'id' => 'acf_resource-link-url',
		'title' => 'Resource Link URL',
		'fields' => array (
			array (
				'key' => 'field_54ffc3733fff4',
				'label' => 'Link Address',
				'name' => 'link_address',
				'type' => 'text',
				'required' => 1,
				'default_value' => '',
				'placeholder' => '',
				'prepend' => 'http://',
				'append' => '',
				'formatting' => 'none',
				'maxlength' => '',
			),
		),
		'location' => array (
			array (
				array (
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'resource-link',
					'order_no' => 0,
					'group_no' => 0,
				),
			),
		),
		'options' => array (
			'position' => 'acf_after_title',
			'layout' => 'no_box',
			'hide_on_screen' => array (
			),
		),
		'menu_order' => 0,
	));
}

