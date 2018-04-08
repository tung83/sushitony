<?php

/**
 * Theme options / Sub-footer
 *
 * @package vip-restaurant
 */

return array(

	array(
		'label'  => esc_html__( 'Layout', 'wpv' ),
		'type'   => 'heading',
		'id'     => 'subfooter-section',
	),

	array(
		'label'     => esc_html__( 'Full Width Sub-footer', 'wpv' ),
		'id'        => 'full-width-subfooter',
		'type'      => 'switch',
		'transport' => 'postMessage',
	),

	array(
		'label'       => esc_html__( 'Text Area in Footer (left)', 'wpv' ),
		'description' => esc_html__( 'You can place text/HTML or any shortcode in this field. The text will appear in the  footer of your website.', 'wpv' ),
		'id'          => 'subfooter-left',
		'type'        => 'textarea',
		'transport'   => 'postMessage',
	),

	array(
		'label'       => esc_html__( 'Text Area in Footer (center)', 'wpv' ),
		'description' => esc_html__( 'You can place text/HTML or any shortcode in this field. The text will appear in the  footer of your website.', 'wpv' ),
		'id'          => 'subfooter-center',
		'type'        => 'textarea',
		'transport'   => 'postMessage',
	),

	array(
		'label'       => esc_html__( 'Text Area in Footer (right)', 'wpv' ),
		'description' => esc_html__( 'You can place text/HTML or any shortcode in this field. The text will appear in the  footer of your website.', 'wpv' ),
		'id'          => 'subfooter-right',
		'type'        => 'textarea',
		'transport'   => 'postMessage',
	),

	array(
		'id'    => 'subfooter-bg-title',
		'label' => esc_html__( 'Backgrounds', 'wpv' ),
		'type'  => 'heading',
	),

	array(
		'label'       => esc_html__( 'Sub-footer Background', 'wpv' ),
		'description' => esc_html__( 'If you want to use an image as a background, enabling the cover button will resize and crop the image so that it will always fit the browser window on any resolution.', 'wpv' ),
		'id'          => 'subfooter-background',
		'type'        => 'background',
		'transport'   => 'postMessage',
		'skin'        => true,
		'show'        => array(
			'background-attachment' => false,
			'background-position'   => false,
		),
	),

	array(
		'id'    => 'subfooter-typography-title',
		'label' => esc_html__( 'Typography', 'wpv' ),
		'type'  => 'heading',
	),

	array(
		'label'       => esc_html__( 'Sub-footer', 'wpv' ),
		'description' => esc_html__( 'You can place your text/HTML in the General Settings option page.', 'wpv' ),
		'id'          => 'sub-footer',
		'type'        => 'typography',
		'compiler'    => true,
		'transport'   => 'postMessage',
		'skin'        => true,
	),

);
