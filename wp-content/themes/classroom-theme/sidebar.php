<?php
/**
 * The sidebar containing the main widget area.
 *
 * @package Classroom Theme
 */

if ( ! is_active_sidebar( 'global-sidebar' ) ) {
	return;
}
?>

<aside id="secondary" class="widget-area" role="complementary">
	<?php dynamic_sidebar( 'global-sidebar' ); ?>
</aside><!-- #secondary -->
