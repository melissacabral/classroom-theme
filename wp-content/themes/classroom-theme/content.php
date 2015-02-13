<?php
/**
 * @package Classroom Theme
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php the_post_thumbnail('large' ); ?>

	<?php the_title( sprintf( '<h1 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h1>' ); ?>


	<?php classroom_theme_entry_meta(); ?>
	

	<div class="entry-content">
		<?php the_excerpt();?>
	</div><!-- .entry-content -->

	<footer class="entry-footer">
		<?php classroom_theme_entry_footer(); ?>
	</footer>

</article><!-- #post-## -->