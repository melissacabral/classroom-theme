<?php
/**
* The header for our theme.
*
* Displays all of the <head> section and everything up until <main id="content">
*
* @package Classroom Theme
*/
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
	<header id="masthead" class="site-header" role="banner">
		<div class=
		"wrapper">		

		<div class="site-branding" <?php if ( get_header_image() ) : ?> style="background-size:cover;background-image:url(<?php header_image(); ?>)"<?php endif; // End header image check. ?>>
			<?php classroom_custom_logo(); ?>
			<h1 class="site-title">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
				<h2 class="site-description"><?php bloginfo( 'description' ); ?></h2>
			</div><!-- .site-branding -->

			<nav id="site-navigation" class="main-navigation" role="navigation">
				<button class="menu-toggle" aria-controls="menu" aria-expanded="false"><?php _e( 'Menu', 'classroom-theme' ); ?></button>
				<?php wp_nav_menu( array( 
					'theme_location' => 'primary',
					'menu_class' => 'menu cf',
					) ); ?>
				</nav><!-- #site-navigation -->
			</div><!-- .wrapper -->
		</header><!-- #masthead -->
		<div id="page" class="wrapper">

			<div id="content" class="site-content">
