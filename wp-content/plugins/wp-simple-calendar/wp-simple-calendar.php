<?php
/*
Plugin Name: Classroom Simple Calendar
Plugin URI: http://wordpress/melissacabral.com
Description: Adds a calendar view to handle classroom posts for homework, tests, and events
Version: 1.1.1
Requires at least: WordPress 
Tested up to: WordPress 4
License: GPLv2 or later
Author: Melissa Cabral

------------------------------------------------------------------------

Copyright 2013
John Hawkins (email : john@9seeds.com)
Toby Cryns  (email : toby@themightymo.com)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307 USA
*/

/**
 * @since  1.0
 * Include the core file
 */
add_action( 'init', 'wpsimplecalendar_init' );
function wpsimplecalendar_init() {
	wp_register_style( 'wpsimplecalendarcolorboxcss', plugins_url('includes/js/colorbox/colorbox.css', __FILE__) );
	wp_register_style( 'wpsimplecalendarcss', plugins_url('includes/css/screen.css', __FILE__), array( 'wpsimplecalendarcolorboxcss') );


	require_once( 'includes/core.php');
}

/**
 * @since  1.0
 * Enqueue front end style sheets
 */
add_action('wp_enqueue_scripts', 'wpsimplecalendar_stylesheet');
function wpsimplecalendar_stylesheet() {
	if( ! is_admin() ) :
		wp_enqueue_style( 'wpsimplecalendarcss' );
	endif;
}


/**
 * @since 1.0
 * Define Shortcode for list view
 * Format: [wpsclist quantity="5" category="category-slug"]
 */

add_shortcode( 'classroom_calendar_list', 'wpsimplecalendar_list_shortcode' );
function wpsimplecalendar_list_shortcode( $atts ) {
	extract( shortcode_atts( array (
		'category' => '',
		'quantity'  => '',
	), $atts ) );

	ob_start();

	// wpsimplecalendar_list( $category=$category_att, $quantity=$quantity_att );
	wpsimplecalendar_events_list( $category, $quantity );

	$make_my_calendar_content = ob_get_clean();

	return $make_my_calendar_content;
}

/**
 * @since  1.0
 * Function to display the events in list format
 *
 * To include a list of upcoming events in your template:
 * <?php if(function_exists('wpsimplecalendar_list')) { wpsimplecalendar_list(); } ?>
 */

function wpsimplecalendar_events_list( $category='', $quantity='' ) {
	include( 'includes/list-template.php' );
}

/**
 * @since  1.0
 * Define shortcode for grid view
 * Format: [classroom_calendar]
 */

add_shortcode( 'classroom_calendar', 'wpsimplecalendar_grid_shortcode' );
function wpsimplecalendar_grid_shortcode( $atts ) {
	extract( shortcode_atts( array (		
	), $atts ) );

	// $category_att = $category;

	ob_start();

	// wpsimplecalendar_grid( $category=$category_att );
	wpsimplecalendar_grid( );

	$wpsimplecalendar_content = ob_get_clean();

	return $wpsimplecalendar_content;
}

/**
 * @since  1.0
 * Funciton to display the events in a grid format
 *
 * To include the calendar using a grid format in your template:
 * <?php if(function_exists('wpsimplecalendar_grid')) { wpsimplecalendar_grid(); } ?>
 */

function wpsimplecalendar_grid( $category='', $location='' ) {
	include( 'includes/grid-template.php' );
}

/**
 * @since  1.0
 * redirect template for single events pop-up
 */

add_action( 'template_redirect', 'wpsimplecalendar_template_redirect' );
function wpsimplecalendar_template_redirect()
{
    if( is_singular( 'wpscevents' ) )
    {
        include( plugin_dir_path( __FILE__).'/includes/single-wpscevents.php' );
        exit();
    }
}

add_action( 'wp_ajax_wpsimplecalendar-next', 'wpsimplecalendar_handle_next_ajax' );
add_action( 'wp_ajax_nopriv_wpsimplecalendar-next', 'wpsimplecalendar_handle_next_ajax' );
function wpsimplecalendar_handle_next_ajax() {
	// die( print_r( $_POST ) );

	$next_month = (int) $_POST['month'];
	$year		= (int) $_POST['year'];
	$category	= $_POST['category'];
	$location	= $_POST['location'];
	die( json_encode( array( 'title' => date( 'F Y', strtotime( $next_month.'/1/'.$year ) ), 'grid' => wpsimplecalendar_setup_grid( $next_month, $year, $category, $location ) ) ) );
	die(0);
}


add_action( 'wp_ajax_wpsimplecalendar-last', 'wpsimplecalendar_handle_last_ajax' );
add_action( 'wp_ajax_nopriv_wpsimplecalendar-last', 'wpsimplecalendar_handle_last_ajax' );
function wpsimplecalendar_handle_last_ajax() {
	// die( print_r( $_POST ) );

	$last_month = (int) $_POST['month'];
	$year		= (int) $_POST['year'];
	$category	= $_POST['category'];
	$location	= $_POST['location'];
	die( json_encode( array( 'title' => date( 'F Y', strtotime( $last_month.'/1/'.$year ) ), 'grid' => wpsimplecalendar_setup_grid( $last_month, $year, $category, $location ) ) ) );
	die(0);
}

/**
 * @since  1.1.0
 * Function to setup the calendar grid
 */

function wpsimplecalendar_setup_grid( $month, $year, $eventcategory = '', $eventlocation = '' ) {
	 $time = current_time( 'timestamp', $gmt = 0 );
	
	
	$running_day       = date( 'w', mktime( 0, 0, 0, $month, 1, $year ) );
	$days_in_month     = date( 't', mktime( 0, 0, 0, $month, 1, $year ) );
	$days_in_this_week = 1;
	$day_counter       = 0;
	$currentday        = date( 'j', $time );
	$dates_array       = array();

	// Tables do have their uses...
	$calendar = '<table cellpadding="0" cellspacing="0" class="wpsc-grid" data-month="'.esc_attr( $month ).'" data-year="'.esc_attr( $year ).'" data-category="'.esc_attr( $eventcategory ).'" data-location="'.esc_attr( $eventlocation ).'">';

	// Table headings
	$headings = array(
		'Sun',
		'Mon',
		'Tue',
		'Wed',
		'Thu',
		'Fri',
		'Sat'
	);

	$calendar.= '<tr class="wpsc-grid-row"><td class="wpsc-grid-day-head">' . implode( '</td><td class="wpsc-grid-day-head">', $headings ) . '</td></tr>';

	// Row for week one
	$calendar.= '<tr class="wpsc-grid-row">';

	// Print "blank" days until the first of the current week
	for( $x = 0; $x < $running_day; $x++ ) {
		$calendar.= '<td class="wpsc-grid-day-np">&nbsp;</td>';
		$days_in_this_week++;
	}

	// Keep going with days...
	for( $list_day = 1; $list_day <= $days_in_month; $list_day++ ) {
		if( ( $list_day == $currentday) && ($month == date( 'm' ) ) ) {
			$calendar.= '<td class="wpsc-grid-day current-day">';
		} else {
			$calendar.= '<td class="wpsc-grid-day">';
		}

		// Add in the day number
		$calendar.= '<div class="wpsc-date">' . $list_day . '</div><div class="clear"></div>';

		// Daily events loop
		global $post;

		if ( strlen( $list_day ) == 1 )
			$list_day = '0'.$list_day;

		if ( strlen( $month ) == 1 )
			$month = '0'.$month;

		$cal_args = array(
			'post_type'			=> array('post', 'page'),
			'posts_per_page'	=> -1,
			'orderby'			=> 'meta_value',
			'ignore_sticky_posts' => 1,
			'meta_key'			=> 'due_date',
			'order'				=> 'ASC',
			'meta_query' => array(
				// array(
				// 	'key' => 'wpsc_start_date',
				// 	'value' => $month.'/'.$list_day.'/'.$year,
				// 	'compare' => '=',
    //    			),
       			array(
       				'key' => 'due_date',
       						//yymmdd
       				'value' => $year.$month.$list_day,
       				'compare' => '=',
       			)
   			)
		);

		

		$eventsloop = new WP_Query( $cal_args );
		// event posts loop
		$calendar.= '<ul class="simple-cal-list">';
		while ( $eventsloop->have_posts() ) : $eventsloop->the_post();
			
			 $due_date  = get_post_meta( $post->ID, "due_date",  true )  ;

			$startstring = strtotime($due_date);
			$startdate = date('Y-m-d', $startstring);	


			$list_month = date('m',mktime(0,0,0,$month,1,$year));
			$listdate = $year . '-' . $list_month . '-' . $list_day;

			if ( $listdate == $startdate ) {
				$classes = '';
				$calendar.= '<li class="' . $classes . '" ><a href="'. get_permalink( $post->ID ) .'" title="' . get_the_title( $post->ID ) . '">' . get_the_title( $post->ID ) . '</a></li>';
			}
			
		endwhile;
		$calendar.= '</ul>';

		wp_reset_postdata();

		$calendar.= '</td>';

		if($running_day == 6) {
			$calendar.= '</tr>';
			if( ( $day_counter+1 ) != $days_in_month ) {
				$calendar.= '<tr class="wpsc-grid-row">';
			}

			$running_day       = -1;
			$days_in_this_week = 0;
		}

		$days_in_this_week++; $running_day++; $day_counter++;
	}

	// Finish the rest of the days in the week
	if( $days_in_this_week < 8 ) {
		for( $x = 1; $x <= ( 8 - $days_in_this_week ); $x++ ) {
			$calendar.= '<td class="wpsc-grid-day-np">&nbsp;</td>';
		}
	}

	// Final row
	$calendar.= '</tr>';	// End the table, finally!
	$calendar.= '</table>';	// All done, return result
	$jscode = "<script>
   		jQuery('a.cboxElement').colorbox({height:'400', width:'400', rel:'nofollow'});
		</script>";

	return $calendar . $jscode;
}
