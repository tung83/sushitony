<?php

/**
 * Controls attached to core sections
 *
 * @package vip-restaurant
 */


return array(
	array(
		'label'     => esc_html__( 'Header Logo Type', 'wpv' ),
		'id'        => 'header-logo-type',
		'type'      => 'switch',
		'transport' => 'postMessage',
		'section'   => 'title_tagline',
		'choices'   => array(
			'image'      => esc_html__( 'Image', 'wpv' ),
			'site-title' => esc_html__( 'Site Title', 'wpv' ),
		),
	),

	array(
		'label'       => esc_html__( 'Custom Logo Picture', 'wpv' ),
		'description' => esc_html__( 'Please Put a logo which exactly twice the width and height of the space that you want the logo to occupy. The real image size is used for retina displays.', 'wpv' ),
		'id'          => 'custom-header-logo',
		'type'        => 'image',
		'transport'   => 'postMessage',
		'section'     => 'title_tagline',
	),

	array(
		'label'       => esc_html__( 'Alternative Logo', 'wpv' ),
		'description' => esc_html__( 'This logo is used when you are using the transparent sticky header. It must be the same size as the main logo.', 'wpv' ),
		'id'          => 'custom-header-logo-transparent',
		'type'        => 'image',
		'transport'   => 'postMessage',
		'section'     => 'title_tagline',
	),

	array(
		'label'       => esc_html__( 'Show Splash Screen', 'wpv' ),
		'description' => esc_html__( 'This option is useful if you have video backgrounds, featured slider, galleries or other elements that may load slowly. You may override this setting for a specific page using the local options.', 'wpv' ),
		'id'          => 'show-splash-screen',
		'type'        => 'switch',
		'transport'   => 'postMessage',
		'section'     => 'title_tagline',
	),

	array(
		'label'     => esc_html__( 'Splash Screen Logo', 'wpv' ),
		'id'        => 'splash-screen-logo',
		'type'      => 'image',
		'transport' => 'postMessage',
		'section'   => 'title_tagline',
	),
);