<?php

global $vamtam_theme_customizer;

$thispath = VAMTAM_OPTIONS . 'general/';

$vamtam_theme_customizer->add_section( array(
	'title'       => esc_html__( 'General', 'wpv' ),
	'description' => '',
	'id'          => 'general',
) );

$vamtam_theme_customizer->add_section( array(
	'title'       => esc_html__( 'General', 'wpv' ),
	'description' => '',
	'id'          => 'general-general',
	'subsection'  => true,
	'fields'      => include $thispath . 'general.php',
) );

$vamtam_theme_customizer->add_section( array(
	'title'       => esc_html__( 'Posts', 'wpv' ),
	'description' => '',
	'id'          => 'general-posts',
	'subsection'  => true,
	'fields'      => include $thispath . 'posts.php',
) );

$vamtam_theme_customizer->add_section( array(
	'title'       => esc_html__( 'Projects', 'wpv' ),
	'description' => '',
	'id'          => 'general-projects',
	'subsection'  => true,
	'fields'      => include $thispath . 'projects.php',
) );

$vamtam_theme_customizer->add_section( array(
	'title'       => esc_html__( 'Skins', 'wpv' ),
	'description' => wp_kses_post( __( "You can import one of the theme's skins or create your own.<br> Please not that the options in General and Layout will not be saved and they will be the same for every skin.", 'wpv' ) ),
	'id'          => 'styles-skins',
	'subsection'  => true,
	'fields'      => include $thispath . 'skins.php',
) );
