<?php
/**
 * @package Classroom Theme
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
	<?php the_post_thumbnail('medium' ); ?>
	<?php if ( 'post' == get_post_type() ) : ?>
		
	<?php endif; ?>
		<?php the_title( sprintf( '<h1 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h1>' ); ?>

	</header><!-- .entry-header -->

	<div class="entry-content">
		
		<?php
			the_excerpt();
		?>

		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . __( 'Pages:', 'classroom-theme' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->
	

	<footer class="entry-footer">
		<?php classroom_theme_entry_footer(); ?>
	</footer><!-- .entry-footer -->
	
	
</article><!-- #post-## -->