<?php

return array(
	array(
		'label'     => esc_html__( 'Layout', 'wpv' ),
		'id'        => 'top-bar-layout',
		'type'      => 'select',
		'transport' => 'postMessage',
		'choices'   => array(
			''            => esc_html__( 'Disabled', 'wpv' ),
			'menu-social' => esc_html__( 'Left: Menu, Right: Social Icons', 'wpv' ),
			'social-menu' => esc_html__( 'Left: Social Icons, Right: Menu', 'wpv' ),
			'text-menu'   => esc_html__( 'Left: Text, Right: Menu', 'wpv' ),
			'menu-text'   => esc_html__( 'Left: Menu, Right: Text', 'wpv' ),
			'social-text' => esc_html__( 'Left: Social Icons, Right: Text', 'wpv' ),
			'text-social' => esc_html__( 'Left: Text, Right: Social Icons', 'wpv' ),
			'fulltext'    => esc_html__( 'Text only', 'wpv' ),
		),
	),

	array(
		'label'       => esc_html__( 'Text', 'wpv' ),
		'description' => esc_html__( 'You can place plain text, HTML and shortcodes.', 'wpv' ),
		'id'          => 'top-bar-text',
		'type'        => 'textarea',
		'transport'   => 'postMessage',
	),

	array(
		'label'     => esc_html__( 'Social Text Lead', 'wpv' ),
		'id'        => 'top-bar-social-lead',
		'type'      => 'text',
		'transport' => 'postMessage',
	),

	array(
		'label'     => esc_html__( 'Facebook Link', 'wpv' ),
		'id'        => 'top-bar-social-fb',
		'type'      => 'text',
		'transport' => 'postMessage',
	),

	array(
		'label'     => esc_html__( 'Twitter Link', 'wpv' ),
		'id'        => 'top-bar-social-twitter',
		'type'      => 'text',
		'transport' => 'postMessage',
	),

	array(
		'label'     => esc_html__( 'LinkedIn Link', 'wpv' ),
		'id'        => 'top-bar-social-linkedin',
		'type'      => 'text',
		'transport' => 'postMessage',
	),

	array(
		'label'     => esc_html__( 'Google+ Link', 'wpv' ),
		'id'        => 'top-bar-social-gplus',
		'type'      => 'text',
		'transport' => 'postMessage',
	),

	array(
		'label'     => esc_html__( 'Flickr Link', 'wpv' ),
		'id'        => 'top-bar-social-flickr',
		'type'      => 'text',
		'transport' => 'postMessage',
	),

	array(
		'label'     => esc_html__( 'Pinterest Link', 'wpv' ),
		'id'        => 'top-bar-social-pinterest',
		'type'      => 'text',
		'transport' => 'postMessage',
	),

	array(
		'label'     => esc_html__( 'Dribbble Link', 'wpv' ),
		'id'        => 'top-bar-social-dribbble',
		'type'      => 'text',
		'transport' => 'postMessage',
	),

	array(
		'label'     => esc_html__( 'Instagram Link', 'wpv' ),
		'id'        => 'top-bar-social-instagram',
		'type'      => 'text',
		'transport' => 'postMessage',
	),

	array(
		'label'     => esc_html__( 'YouTube Link', 'wpv' ),
		'id'        => 'top-bar-social-youtube',
		'type'      => 'text',
		'transport' => 'postMessage',
	),

	array(
		'label'     => esc_html__( 'Vimeo Link', 'wpv' ),
		'id'        => 'top-bar-social-vimeo',
		'type'      => 'text',
		'transport' => 'postMessage',
	),

	array(
		'label'       => esc_html__( 'Background', 'wpv' ),
		'description' => wp_kses_post( __( 'If you want to use an image as a background, enabling the cover button will resize and crop the image so that it will always fit the browser window on any resolution.<br> If the color opacity is less than 1 the page background underneath will be visible.', 'wpv' ) ),
		'id'          => 'top-nav-background',
		'type'        => 'background',
		'transport'   => 'postMessage',
		'skin'        => true,
		'show'        => array(
			'background-attachment' => false,
			'background-position'   => false,
		),
	),

	array(
		'label'   => esc_html__( 'Colors', 'wpv' ),
		'type'    => 'color-row',
		'id'      => 'css-tophead',
		'choices' => array(
			'text-color'       => esc_html__( 'Text Color:', 'wpv' ),
			'link-color'       => esc_html__( 'Link Color:', 'wpv' ),
			'link-hover-color' => esc_html__( 'Link Hover Color:', 'wpv' ),
		),
		'compiler'  => true,
		'transport' => 'postMessage',
		'skin'      => true,
	),

	array(
		'label'   => esc_html__( 'Sub-Menus', 'wpv' ),
		'type'    => 'color-row',
		'id'      => 'submenu',
		'choices' => array(
			'background'  => esc_html__( 'Background:', 'wpv' ),
			'color'       => esc_html__( 'Text Normal Color:', 'wpv' ),
			'hover-color' => esc_html__( 'Text Hover Color:', 'wpv' ),
		),
		'compiler'  => true,
		'transport' => 'postMessage',
		'skin'      => true,
	),
);