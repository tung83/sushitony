<?php

/**
 * Theme options / Footer
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
		'label'     => esc_html__( 'Sticky Footer', 'wpv' ),
		'id'        => 'sticky-footer',
		'type'      => 'switch',
		'transport' => 'postMessage',
	),

	array(
		'label'   => esc_html__( 'Show Footer on One Page Template', 'wpv' ),
		'id'      => 'one-page-footer',
		'type'    => 'switch',
	),

	array(
		'label'     => esc_html__( 'Full Width Footer', 'wpv' ),
		'id'        => 'full-width-footer',
		'type'      => 'switch',
		'transport' => 'postMessage',
	),

	array(
		'label'  => esc_html__( 'Widget Areas', 'wpv' ),
		'type'   => 'heading',
		'id'     => 'layout-footer-horizontal-sidebars',
	),

	array(
		'label'     => sprintf( esc_html__( 'Widget Area %d', 'wpv' ), 1 ),
		'id'        => 'footer-sidebars-1-width',
		'type'      => 'select',
		'choices'   => $horizontal_sidebar_widths,
		'transport' => 'postMessage',
	),

	array(
		'label'     => sprintf( esc_html__( 'Widget Area %d', 'wpv' ), 2 ),
		'id'        => 'footer-sidebars-2-width',
		'type'      => 'select',
		'choices'   => $horizontal_sidebar_widths,
		'transport' => 'postMessage',
	),

	array(
		'label'     => sprintf( esc_html__( 'Widget Area %d', 'wpv' ), 3 ),
		'id'        => 'footer-sidebars-3-width',
		'type'      => 'select',
		'choices'   => $horizontal_sidebar_widths,
		'transport' => 'postMessage',
	),

	array(
		'label'     => sprintf( esc_html__( 'Widget Area %d', 'wpv' ), 4 ),
		'id'        => 'footer-sidebars-4-width',
		'type'      => 'select',
		'choices'   => $horizontal_sidebar_widths,
		'transport' => 'postMessage',
	),

	array(
		'label'     => sprintf( esc_html__( 'Widget Area %d', 'wpv' ), 5 ),
		'id'        => 'footer-sidebars-5-width',
		'type'      => 'select',
		'choices'   => $horizontal_sidebar_widths,
		'transport' => 'postMessage',
	),

	array(
		'label'     => sprintf( esc_html__( 'Widget Area %d', 'wpv' ), 6 ),
		'id'        => 'footer-sidebars-6-width',
		'type'      => 'select',
		'choices'   => $horizontal_sidebar_widths,
		'transport' => 'postMessage',
	),

	array(
		'label'     => sprintf( esc_html__( 'Widget Area %d', 'wpv' ), 7 ),
		'id'        => 'footer-sidebars-7-width',
		'type'      => 'select',
		'choices'   => $horizontal_sidebar_widths,
		'transport' => 'postMessage',
	),

	array(
		'label'     => sprintf( esc_html__( 'Widget Area %d', 'wpv' ), 8 ),
		'id'        => 'footer-sidebars-8-width',
		'type'      => 'select',
		'choices'   => $horizontal_sidebar_widths,
		'transport' => 'postMessage',
	),

	array(
		'id'    => 'footer-bg-title',
		'label' => esc_html__( 'Backgrounds', 'wpv' ),
		'type'  => 'heading',
	),

	array(
		'label'       => esc_html__( 'Widget Areas Background', 'wpv' ),
		'description' => esc_html__( 'If you want to use an image as a background, enabling the cover button will resize and crop the image so that it will always fit the browser window on any resolution. If the color opacity  is less than 1 the page background underneath will be visible.', 'wpv' ),
		'id'          => 'footer-background',
		'type'        => 'background',
		'transport'   => 'postMessage',
		'skin'        => true,
	),

	array(
		'label'     => esc_html__( 'Hide the Background Image on Lower Resolutions', 'wpv' ),
		'id'        => 'footer-background-hide-lowres',
		'type'      => 'switch',
		'transport' => 'postMessage',
		'skin'      => true,
	),

	array(
		'id'    => 'footer-typography-title',
		'label' => esc_html__( 'Typography', 'wpv' ),
		'type'  => 'heading',
	),

	array(
		'label'       => esc_html__( 'Widget Areas Text', 'wpv' ),
		'description' => esc_html__( 'This is the general font used for the footer widgets.', 'wpv' ),
		'id'          => 'footer-sidebars-font',
		'type'        => 'typography',
		'compiler'    => true,
		'transport'   => 'postMessage',
		'skin'        => true,
	),

	array(
		'label'       => esc_html__( 'Widget Areas Titles', 'wpv' ),
		'description' => esc_html__( 'Please note that this option will override the general headings style set in the General Typography" tab.', 'wpv' ),
		'id'          => 'footer-sidebars-titles',
		'type'        => 'typography',
		'compiler'    => true,
		'transport'   => 'postMessage',
		'skin'        => true,
	),

	array(
		'label'   => esc_html__( 'Links', 'wpv' ),
		'type'    => 'color-row',
		'id'      => 'footer-link',
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
