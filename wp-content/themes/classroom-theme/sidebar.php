<?php
/**
 * The sidebar containing the main widget area.
 *
 * @package Classroom Theme
 */
?>



<aside id="secondary" class="widget-area" role="complementary">
		<?php classroom_due_today() ?>
	<?php dynamic_sidebar( 'global-sidebar' ); ?>
</aside><!-- #secondary -->
