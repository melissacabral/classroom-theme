<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package Classroom Theme
 */
?>

	</div><!-- #content -->

	<footer id="colophon" class="site-footer" role="contentinfo">
		<?php dynamic_sidebar( 'footer-widgets' ); ?>
		<div class="site-info">Classroom theme developed by <a href="http://melissacabral.com">Melissa Cabral</a></div>
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
