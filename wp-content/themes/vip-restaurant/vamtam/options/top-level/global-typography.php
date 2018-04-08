<?php
/**
 * Theme options / Styles / General Typography
 *
 * @package vip-restaurant
 */

return array(

array(
	'label'  => esc_html__( 'Headlines', 'wpv' ),
	'type'   => 'heading',
	'id'     => 'styles-typography-headlines',
),

array(
	'label'      => esc_html__( 'H1', 'wpv' ),
	'id'         => 'h1',
	'type'       => 'typography',
	'compiler'   => true,
	'transport'  => 'postMessage',
	'skin'       => true,
),

array(
	'label'      => esc_html__( 'H2', 'wpv' ),
	'id'         => 'h2',
	'type'       => 'typography',
	'compiler'   => true,
	'transport'  => 'postMessage',
	'skin'       => true,
),

array(
	'label'      => esc_html__( 'H3', 'wpv' ),
	'id'         => 'h3',
	'type'       => 'typography',
	'compiler'   => true,
	'transport'  => 'postMessage',
	'skin'       => true,
),

array(
	'label'      => esc_html__( 'H4', 'wpv' ),
	'id'         => 'h4',
	'type'       => 'typography',
	'compiler'   => true,
	'transport'  => 'postMessage',
	'skin'       => true,
),

array(
	'label'      => esc_html__( 'H5', 'wpv' ),
	'id'         => 'h5',
	'type'       => 'typography',
	'compiler'   => true,
	'transport'  => 'postMessage',
	'skin'       => true,
),

array(
	'label'      => esc_html__( 'H6', 'wpv' ),
	'id'         => 'h6',
	'type'       => 'typography',
	'compiler'   => true,
	'transport'  => 'postMessage',
	'skin'       => true,
),

array(
	'label'  => esc_html__( 'Additional Fonts', 'wpv' ),
	'type'   => 'heading',
	'id'     => 'styles-typography-additional',
),

array(
	'label'      => esc_html__( 'Emphasis Font', 'wpv' ),
	'id'         => 'em',
	'type'       => 'typography',
	'compiler'   => true,
	'transport'  => 'postMessage',
	'skin'       => true,
),

array(
	'label'      => esc_html__( 'Style 1', 'wpv' ),
	'id'         => 'additional-font-1',
	'type'       => 'typography',
	'compiler'   => true,
	'transport'  => 'postMessage',
	'skin'       => true,
),

array(
	'label'      => esc_html__( 'Style 2', 'wpv' ),
	'id'         => 'additional-font-2',
	'type'       => 'typography',
	'compiler'   => true,
	'transport'  => 'postMessage',
	'skin'       => true,
),

array(
	'label'  => esc_html__( 'Google Fonts Options', 'wpv' ),
	'type'   => 'heading',
	'id'     => 'styles-typography-gfonts',
),

array(
	'label'      => esc_html__( 'Style 2', 'wpv' ),
	'id'         => 'gfont-subsets',
	'type'       => 'multicheck',
	'transport'  => 'postMessage',
	'choices'    => vamtam_get_google_fonts_subsets(),
	'skin'       => true,
),

);
