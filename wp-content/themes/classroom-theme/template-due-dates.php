<?php
//Template Name: Assignments by Due Date
/**
 * List of all posts by the due date field
 *
 * @package Classroom Theme
 */

get_header(); ?>

<div id="primary" class="content-area">
	<main id="main" class="site-main" role="main">

		<?php if ( have_posts() ) : ?>

		<?php /* Start the Loop */ ?>
		<?php while ( have_posts() ) : the_post(); ?>

		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<?php the_post_thumbnail('large' ); ?>

			<h1 class="entry-title">Assignments by Due Date</h1>

			<div class="entry-content">
				<?php the_content();?>

				<?php 
				$today = current_time( 'Ymd' , 0);

				$args = array (
					'post_type' => array('post','page'),
					'ignore_sticky_posts' => 1,
					'order' => 'ASC',
					'orderby'   => 'meta_value_num',
					'meta_key'  => 'due_date',
					'meta_query' => array(
						array(
							'key'		=> 'due_date',
							'compare'	=> '>=',
							'value'		=> $today,
							),
						),
					);
				$q = new WP_Query($args);

				 //begin custom loop
				if( $q->have_posts() ): ?>
				<table>
					<tr>
						<th>Date Due</th>
						<th>&nbsp;</th>
						<th>Assignment</th>


					</tr>
					<?php while( $q->have_posts() ): $q->the_post(); ?>
					<tr>
						<td>

							<?php echo classroom_get_duedate(); ?>
						</td>
						<td>

							
								<?php echo  classroom_count_days( classroom_get_duedate(), $today ); ?> 
							</td>
						<td>
							<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>				
								</td>
						
						
					</tr>

				<?php endwhile; ?>
			</table>
		<?php else: ?>
		<h2>There are no upcoming Assignments</h2>
	<?php endif;  //end THE LOOP ?>



</div><!-- .entry-content -->

<footer class="entry-footer">
	<?php classroom_theme_entry_footer(); ?>
</footer>

</article><!-- #post-## -->

<?php endwhile; ?>



<?php else : ?>

	<?php get_template_part( 'content', 'none' ); ?>

<?php endif; ?>

</main><!-- #main -->
</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
