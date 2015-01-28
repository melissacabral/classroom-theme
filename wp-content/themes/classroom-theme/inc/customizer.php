<?php
/**
 * Classroom Theme  Customizer - colors and layout
 *
 * @package Classroom Theme
 */



add_action( 'customize_register', 'classroom_theme_theme_customizer' );

function classroom_theme_theme_customizer( $wp_customize ) {
	//Link color
	//create the setting and its defaults
	$wp_customize->add_setting(	'classroom_theme_link_color', array( 
		'default'     => '#429CA4',	
		'sanitize_callback' => 'classroom_theme_setting_sanitize',
	));
	//add the UI control. this is a color picker control. Attach it to the setting. 
	$wp_customize->add_control(	new WP_Customize_Color_Control( $wp_customize, 'link_color', array(
		'label'      => 'Link Color',
		'section'    => 'colors', //this is one of the panels that is given to you. you can make your own, too. 
		'settings'   => 'classroom_theme_link_color', //the setting from above that this control controls!
		)
	));
	//Text Color
	$wp_customize->add_setting(	'classroom_theme_text_color', array(
		'default'     		=> '#3B3B3B',
		'sanitize_callback' => 'classroom_theme_setting_sanitize',
	));
	//add the UI control. this is a color picker control. Attach it to the setting. 
	$wp_customize->add_control(	
		new WP_Customize_Color_Control( $wp_customize, 'text_color', array(
			'label'      => 'Body Text Color',
		'section'    => 'colors', //this is one of the panels that is given to you. you can make your own, too. 
		'settings'   => 'classroom_theme_text_color', //the setting from above that this control controls!
		)
	));
	//Option - Show or hide logo?
	$wp_customize->add_section( 'classroom_theme_layout_section' , array(
		'title'      => 'Layout',
		'priority'   => 30,) );
	$wp_customize->add_setting( 'classroom_theme_header_display', array( 
		'default' => true,
		'sanitize_callback' => 'classroom_theme_setting_sanitize',
		 ) );
	$wp_customize->add_control(
		new WP_Customize_Control( $wp_customize, 'header_display', array(
			'label'          => 'Display Header Text',
			'section'        => 'classroom_theme_layout_section',
			'settings'       => 'classroom_theme_header_display',
			'type'           => 'radio',
			'choices'        => array(
				true  => 'Display the Header Text',
				false  => 'Hide the Header Text',
				)
			)
		)
	);
	//Option - Right or left hand sidebar?
	$wp_customize->add_setting( 'classroom_theme_layout', array( 
		'default' => 'right',
		'sanitize_callback' => 'classroom_theme_setting_sanitize',
		 ) );
	$wp_customize->add_control(
		new WP_Customize_Control( $wp_customize, 'sidebar_layout', array(
			'label'          => 'Sidebar Position',
			'section'        => 'classroom_theme_layout_section',
			'settings'       => 'classroom_theme_layout',
			'type'           => 'radio',
			'choices'        => array(
				'left'   => 'Left',
				'right'  => 'Right',
				)
			)
		)
	);

}	

function classroom_theme_setting_sanitize($input){
	return wp_kses_post( force_balance_tags( $input ) );
}
function classroom_theme_customizer_css() {
	?>
	<style type="text/css">
		a { color: <?php echo get_theme_mod( 'classroom_theme_link_color' ); ?>;  }
		body{color: <?php echo get_theme_mod( 'classroom_theme_text_color' ); ?>; }
		<?php if(get_theme_mod('classroom_theme_header_display' ) == false): ?>
		.site-title,site-description{
			display: none;
		}
		<?php endif; ?>
		@media only screen and (min-width : 650px) {
		<?php if(get_theme_mod('classroom_theme_layout') == 'right'): ?>
			aside[role=complementary]{float:right;}
			main{float:left;}
		<?php else: ?>
			aside[role=complementary]{float:left;}
			main{float:right;}
		<?php endif; ?>
		}

</style>
<?php
}
add_action( 'wp_head', 'classroom_theme_customizer_css' );
//no close PHP