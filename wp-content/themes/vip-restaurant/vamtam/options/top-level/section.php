<?php

/**
 * Top level sections without panels
 *
 * @package vip-restaurant
 */

global $vamtam_theme_customizer;

$thispath = VAMTAM_OPTIONS . 'top-level/';

$vamtam_theme_customizer->add_section( array(
	'title'       => esc_html__( 'Global Layout', 'wpv' ),
	'id'          => 'global-layout',
	'description' => '',
	'fields'      => include $thispath . 'global-layout.php',
) );

$vamtam_theme_customizer->add_section( array(
	'title'       => esc_html__( 'Global Styles', 'wpv' ),
	'id'          => 'global-styles',
	'description' => '',
	'fields'      => include $thispath . 'global-styles.php',
) );

$vamtam_theme_customizer->add_section( array(
	'title'       => esc_html__( 'Global Typography', 'wpv' ),
	'id'          => 'global-typography',
	'description' => wp_kses_post( __( 'The options bellow are used for headings, titles and emphasizing text in different parts of the website.<br> Please note that some of the options for styling text are present in header, body and footer tabs as they are specific only to each area - for example, main menu, body general text, footer widget titles, etc.', 'wpv' ) ),
	'fields'      => include $thispath . 'global-typography.php',
) );

$vamtam_theme_customizer->add_section( array(
	'title'       => esc_html__( 'Top Bar', 'wpv' ),
	'id'          => 'top-bar',
	'description' => '',
	'fields'      => include $thispath . 'top-bar.php',
) );

$vamtam_theme_customizer->add_section( array(
	'title'       => esc_html__( 'Header', 'wpv' ),
	'id'          => 'header',
	'description' => '',
	'fields'      => include $thispath . 'header.php',
) );

$vamtam_theme_customizer->add_section( array(
	'title'       => esc_html__( 'Body', 'wpv' ),
	'id'          => 'body',
	'description' => '',
	'fields'      => include $thispath . 'body.php',
) );

$vamtam_theme_customizer->add_section( array(
	'title'       => esc_html__( 'Footer', 'wpv' ),
	'id'          => 'footer',
	'description' => '',
	'fields'      => include $thispath . 'footer.php',
) );

$vamtam_theme_customizer->add_section( array(
	'title'       => esc_html__( 'Sub-footer', 'wpv' ),
	'id'          => 'subfooter',
	'description' => '',
	'fields'      => include $thispath . 'subfooter.php',
) );
