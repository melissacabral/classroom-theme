<?php
/*
Plugin Name: Custom Post Types - Links
Description: Adds Products to the site
Author: Melissa Cabral
Plugin URI: http://wordpress.melissacabral.com
Author URI: http://melissacabral.com
Version: 0.1
License: GPLv3
 */

/**
 * Create "Products" post type
 * @since  0.1
 */
add_action( 'init', 'rad_setup_products' );
function rad_setup_products(){
	register_post_type( 'resource-link', array(
			'public' 		=> true,
			'has_archive' 	=> true,			
			'menu_icon'		=> 'dashicons-admin-links',
			'supports' 		=> array( 'title', 'thumbnail'),
			'labels' 		=> array(
				'name' => 'Resource Links',
				'singular_name' => 'Resource Link',
				'add_new_item' 	=> 'Add New link',
				'not_found'		=> 'No resource-links found',
				),
		) );
	//add the Brand taxonomy to resource-linkss
	register_taxonomy( 'link-category', 'resource-link', array(
		'hierarchical' 	=> true,  //checklist interface, can have parent/child terms
		'labels' 		=> array(
				'name' 			=> 'link-categorys',
				'singular_name' => 'link-category',
				'search_items'	=> 'Search link-categorys',
				'add_new_item' 	=> 'Add New link-category',
			),
	) );
	
}

/**
 * Fix permalink 404 errors when the plugin activates
 * @since  0.1
 */
function rad_rewrite_flush(){
	rad_setup_products(); //call the func that registers CPT/Taxos
	flush_rewrite_rules(); //re-create the .htaccess rules
}
register_activation_hook( __FILE__, 'rad_rewrite_flush' );