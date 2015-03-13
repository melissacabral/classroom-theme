<?php 
/**
 * Template Name: Links by Category
 * 
 * The template for displaying archives of the "link" Custom Post Type, sorted by term
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package Classroom Theme
 */

$post_type = 'link';
$taxonomy = 'link-category';

get_header(); ?>

<div id="primary" class="content-area">
    <main id="main" class="site-main" role="main">
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

        <?php         

// Gets every term in this taxonomy
        $terms = get_terms( $taxonomy );

//go through each term in this taxonomy one at a time
        foreach( $terms as $term ) : 

    //get ONE post assigned to this term
            $custom_loop = new WP_Query( array(
                'post_type' => $post_type,
                'taxonomy' => $taxonomy,
                'term' => $term->slug,

                ) );

    //LOOP
        if( $custom_loop->have_posts() ): ?>
          <h1 class="entry-title"><?php echo  $term->name;  ?></h1>
          <ul>
     <?php  while( $custom_loop->have_posts() ) : $custom_loop->the_post(); ?>




        <li><a href="http://<?php echo get_post_meta($post->ID, 'link_address', 'true' ); ?>"><?php the_title(); ?></a></li>

        


 

    <?php 
    endwhile; ?>
</ul>
    <?php
    endif;
    endforeach;
    ?>
       </article>
   </main><!-- #main -->
</div><!-- #primary -->
<?php get_sidebar() ?>
<?php get_footer() ?>