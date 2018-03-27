<?php

/**
 * Theme options / Layout / Body
 *
 * @package vip-restaurant
 */

$horizontal_sidebar_widths = array(
	'cell-1-1' => esc_html__( 'Full', 'wpv' ),
	'cell-1-2' => '1/2',
	'cell-1-3' => '1/3',
	'cell-1-4' => '1/4',
	'cell-1-5' => '1/5',
	'cell-1-6' => '1/6',
	'cell-2-3' => '2/3',
	'cell-3-4' => '3/4',
	'cell-2-5' => '2/5',
	'cell-3-5' => '3/5',
	'cell-4-5' => '4/5',
	'cell-5-6' => '5/6',
);

return array(

	array(
		'label'  => esc_html__( 'Top Widget Areas', 'wpv' ),
		'type'   => 'heading',
		'id'     => 'layout-body-horizontal-sidebars',
	),

	array(
		'label'     => sprintf( esc_html__( 'Widget Area %d', 'wpv' ), 1 ),
		'id'        => 'header-sidebars-1-width',
		'type'      => 'select',
		'choices'   => $horizontal_sidebar_widths,
		'transport' => 'postMessage',
	),

	array(
		'label'     => sprintf( esc_html__( 'Widget Area %d', 'wpv' ), 2 ),
		'id'        => 'header-sidebars-2-width',
		'type'      => 'select',
		'choices'   => $horizontal_sidebar_widths,
		'transport' => 'postMessage',
	),

	array(
		'label'     => sprintf( esc_html__( 'Widget Area %d', 'wpv' ), 3 ),
		'id'        => 'header-sidebars-3-width',
		'type'      => 'select',
		'choices'   => $horizontal_sidebar_widths,
		'transport' => 'postMessage',
	),

	array(
		'label'     => sprintf( esc_html__( 'Widget Area %d', 'wpv' ), 4 ),
		'id'        => 'header-sidebars-4-width',
		'type'      => 'select',
		'choices'   => $horizontal_sidebar_widths,
		'transport' => 'postMessage',
	),

	array(
		'label'     => sprintf( esc_html__( 'Widget Area %d', 'wpv' ), 5 ),
		'id'        => 'header-sidebars-5-width',
		'type'      => 'select',
		'choices'   => $horizontal_sidebar_widths,
		'transport' => 'postMessage',
	),

	array(
		'label'     => sprintf( esc_html__( 'Widget Area %d', 'wpv' ), 6 ),
		'id'        => 'header-sidebars-6-width',
		'type'      => 'select',
		'choices'   => $horizontal_sidebar_widths,
		'transport' => 'postMessage',
	),

	array(
		'label'     => sprintf( esc_html__( 'Widget Area %d', 'wpv' ), 7 ),
		'id'        => 'header-sidebars-7-width',
		'type'      => 'select',
		'choices'   => $horizontal_sidebar_widths,
		'transport' => 'postMessage',
	),

	array(
		'label'     => sprintf( esc_html__( 'Widget Area %d', 'wpv' ), 8 ),
		'id'        => 'header-sidebars-8-width',
		'type'      => 'select',
		'choices'   => $horizontal_sidebar_widths,
		'transport' => 'postMessage',
	),

	array(
		'label'  => esc_html__( 'Side Widget Areas', 'wpv' ),
		'type'   => 'heading',
		'id'     => 'layout-body-regular-sidebars',
	),

	array(
		'label'   => esc_html__( 'Left', 'wpv' ),
		'id'      => 'left-sidebar-width',
		'type'    => 'select',
		'choices' => array(
			'33.333333' => '1/3',
			'20' => '1/5',
			'25' => '1/4',
		),
		'compiler'  => true,
		'transport' => 'postMessage',
	),

	array(
		'label'       => esc_html__( 'Right', 'wpv' ),
		'description' => wp_kses_post( sprintf( __( 'The width of the sidebars is a percentage of the website width. If you have changed this option, please use the <a href="%s" title="Regenerate thumbnails" target="_blank">Regenerate thumbnails</a> plugin in order to update your images.', 'wpv' ), 'http://wordpress.org/extend/plugins/regenerate-thumbnails/' ) ),
		'id'          => 'right-sidebar-width',
		'type'        => 'select',
		'choices'     => array(
			'33.333333' => '1/3',
			'20'        => '1/5',
			'25'        => '1/4',
		),
		'compiler'  => true,
		'transport' => 'postMessage',
	),

	array(
		'label'  => esc_html__( 'Styles', 'wpv' ),
		'type'   => 'heading',
		'id'     => 'body-styles',
	),

	array(
		'label'       => esc_html__( 'Body Background', 'wpv' ),
		'description' => esc_html__( 'If you want to use an image as a background, enabling the cover button will resize and crop the image so that it will always fit the browser window on any resolution. If the color opacity  is less than 1 the page background underneath will be visible.', 'wpv' ),
		'id'          => 'main-background',
		'type'        => 'background',
		'compiler'    => true,
		'transport'   => 'postMessage',
		'skin'        => true,
	),

	array(
		'label'     => esc_html__( 'Hide the Background Image on Lower Resolutions', 'wpv' ),
		'id'        => 'main-background-hide-lowres',
		'type'      => 'switch',
		'transport' => 'postMessage',
		'skin'      => true,
	),

	array(
		'label'       => esc_html__( 'Body Font', 'wpv' ),
		'description' => esc_html__( 'This is the general font used in the body and the sidebars. Please note that the styles of the heading fonts are located in the general typography tab.', 'wpv' ),
		'id'          => 'primary-font',
		'type'        => 'typography',
		'compiler'    => true,
		'transport'   => 'postMessage',
		'skin'        => true,
	),

	array(
		'label'   => esc_html__( 'Links', 'wpv' ),
		'type'    => 'color-row',
		'id'      => 'body-link',
		'choices' => array(
			'regular' => esc_html__( 'Regular:', 'wpv' ),
			'hover'   => esc_html__( 'Hover:', 'wpv' ),
			'visited' => esc_html__( 'Visited:', 'wpv' ),
			'active'  => esc_html__( 'Active:', 'wpv' ),
		),
		'compiler'  => true,
		'transport' => 'postMessage',
		'skin'      => true,
	),

);
