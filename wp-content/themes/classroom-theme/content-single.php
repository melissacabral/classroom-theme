<?php
/**
 * @package Classroom Theme
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	
	<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
	<?php classroom_theme_entry_meta(); ?>

	<div class="entry-content">
		<?php classroom_important_text(); ?>
		<?php the_content(); ?>
		
		<div class="entry-asides">
			<?php classroom_file_attachments(); ?>
			<?php classroom_related_reading(); ?>
		</div>

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
