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
		'default'   		  	=> '',	
		'sanitize_callback'		=> 'classroom_theme_setting_sanitize',
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
		'default'     		=> '',
		'sanitize_callback' => 'classroom_theme_setting_sanitize',
	));
	//add the UI control. this is a color picker control. Attach it to the setting. 
	$wp_customize->add_control(	
		new WP_Customize_Color_Control( $wp_customize, 'text_color', array(
			'label'      => 'Body Text Color',
		'section'    => 'colors', 
		'settings'   => 'classroom_theme_text_color', //the setting from above that this control controls!
		)
	));
	//Option - Show or hide logo?
	$wp_customize->add_section( 'classroom_theme_layout_section' , array(
		'title'      => 'Layout',
		'priority'   => 30,) );

	
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
	//Option - Light or dark color scheme?
	$wp_customize->add_setting( 'classroom_theme_colorscheme', array( 
		'default' => 'light',
		'sanitize_callback' => 'classroom_theme_setting_sanitize',
		 ) );
	$wp_customize->add_control(
		new WP_Customize_Control( $wp_customize, 'sidebar_layout', array(
			'label'          => 'Base Color Scheme',
			'section'        => 'colors',
			'settings'       => 'classroom_theme_colorscheme',
			'type'           => 'radio',
			'choices'        => array(
					'light'   	=> 'Light',
					'dark'  	=> 'Dark',
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
		<?php if( get_theme_mod( 'classroom_theme_colorscheme' ) == 'dark' ): ?>
			body{
				background-color: #434343;
				color:white;
			}

			.hentry,
			aside .widget{
				background-color: rgba(0,0,0,.6);
			}
			
		<?php else: ?>
			body{
				background-color: #D8E1E4;
				color:black;
			}
			.hentry,
			aside .widget{
				background-color: rgba(255,255,255,.9);
			}
		<?php endif; ?>
		a { color: <?php echo get_theme_mod( 'classroom_theme_link_color' ); ?>;  }
		body{color: <?php echo get_theme_mod( 'classroom_theme_text_color' ); ?>; }
		header[role="banner"] .site-title a, 
		header[role="banner"],
		header[role="banner"] .site-description{
			color: #<?php echo get_header_textcolor(); ?>;
		}
		<?php if(get_theme_mod('classroom_theme_header_display' ) == false): ?>
		.site-title,site-description{
			display: none;
		}
		<?php endif; ?>
		@media only screen and (min-width : 700px) {
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