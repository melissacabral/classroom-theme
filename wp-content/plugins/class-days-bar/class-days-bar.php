<?php
/*
 Plugin Name: Class Days Bar
 Description: 
 */
add_action( 'wp_enqueue_scripts','ra_days_style');
 function ra_days_style(){
 	wp_enqueue_style( 
 		'ra-days-bar-style', 
 		plugins_url( 'class-days-bar.css', __FILE__ ) 
 	);
 }
/**
 * display the 25 days of class in a nifty bar
 * @since 0.1
 */
function ra_days_bar($tag='morning'){
	$taxonomy = 'class_day';

	$args = array(
		'taxonomy'     	=> $taxonomy,
		'orderby'     	=> 'slug',
		'show_count'   	=> 0,
		'pad_counts'  	=> 0,
		'hierarchical' 	=> 0,
		'title_li'     	=> '',
		'hide_empty'	=> 0,

	);
	?>

	<ul class="ra-days-bar">
		<li class="title-li">Day: </li>
	<?php 
	//get all the terms in the taxonomy
	$terms = get_terms($taxonomy, $args);
	$terms_ids = get_terms( 
		$taxonomy, array(
	    'hide_empty' => 0,
	    'fields' => 'ids'
	) );
	//TODO:  add a counter here so the CSS width is based on the number of terms.
	//$posts = get_posts();
	$latest_posts = wp_get_recent_posts( array(
			'numberposts' => 1,
			'post_status' => 'publish',
			'tax_query' => array(
				array(
					'taxonomy' => $taxonomy,
					'field' => 'id',
					'terms' => $terms_ids,
				)
			)
		) );
	//SPECIAL!  grab the latest morning class post (use when 2 classes happen at same time)
	$latest_day_posts = wp_get_recent_posts( array(
			'numberposts' => 1,
			'post_status' => 'publish',
			'tax_query' => array(
				array(
					'taxonomy' => 'post_tag',
					'field' => 'id',
					'terms' => 88,
				)
			)
		) );

	//end SPECIAL morning posts

	//grab the ID of this one latest post
	foreach($latest_posts as $latest_post){
		$latest_post_id = $latest_post['ID'];
	}
	foreach ($latest_day_posts as $latest_day_post){
		$latest_day_post_id = $latest_day_post['ID'];
	}

	//loop through each term (day)		
	foreach ($terms as $term) {

		echo '<li class="bar-item ';
		if(is_tax($taxonomy, $term->slug)){
			echo ' active';
		}
		if( has_term($term->slug, $taxonomy, $latest_post_id) ){
			echo ' current';
		}
		if( has_term($term->slug, $taxonomy, $latest_day_post_id)  ){
			echo ' morning-class';
		}
		echo '">';
		//if the term has posts assigned, link to the archive otherwise, no link necessary
		if($term->count){
			echo '<a href="'.get_term_link( $term->slug, $taxonomy ).'" title="View all posts from Day '. $term->name. '">';
		}
		//show the name
		echo  '<span>'.$term->name.'</span>' ;

		//close the link if needed
		if($term->count){
			echo '</a>';
		}
		echo '</li>';
	}
		
	?>
	</ul>
	<?php
}