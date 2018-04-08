<?php

/**
 * Theme options /Header
 *
 * @package vip-restaurant
 */

return array(

	array(
		'label'     => esc_html__( 'Header Layout', 'wpv' ),
		'type'      => 'image-select',
		'id'        => 'header-layout',
		'transport' => 'postMessage',
		'choices'   => array(
			'logo-menu' => array(
				'alt'  => esc_html__( 'One row, left logo, menu on the right', 'wpv' ),
				'img'  => VAMTAM_ADMIN_ASSETS_URI . 'images/header-layout-1.png',
			),
			'logo-text-menu' => array(
				'alt' => esc_html__( 'Two rows; left-aligned logo on top, right-aligned text and search', 'wpv' ),
				'img' => VAMTAM_ADMIN_ASSETS_URI . 'images/header-layout-2.png',
			),
			'standard' => array(
				'alt' => esc_html__( 'Two rows; centered logo on top', 'wpv' ),
				'img' => VAMTAM_ADMIN_ASSETS_URI . 'images/header-layout-3.png',
			),
		),
	),

	array(
		'label'       => esc_html__( 'Page Title Layout', 'wpv' ),
		'id'          => 'page-title-layout',
		'description' => esc_html__( 'The first row is the Title, the second row is the Description. The description can be added in the local option panel just below the editor.', 'wpv' ),
		'type'        => 'select',
		'transport'   => 'postMessage',
		'choices'     => array(
			'centered'      => esc_html__( 'Two rows, Centered', 'wpv' ),
			'one-row-left'  => esc_html__( 'One row, title on the left', 'wpv' ),
			'one-row-right' => esc_html__( 'One row, title on the right', 'wpv' ),
			'left-align'    => esc_html__( 'Two rows, left-aligned', 'wpv' ),
			'right-align'   => esc_html__( 'Two rows, right-aligned', 'wpv' ),
		),
	),

	array(
		'label'       => esc_html__( 'Header Height', 'wpv' ),
		'description' => esc_html__( 'This is the area above the slider. Includes the height of the menu for two line header layouts.', 'wpv' ),
		'id'          => 'header-height',
		'type'        => 'number',
		'compiler'    => true,
		'transport'   => 'postMessage',
		'input_attrs' => array(
			'min' => 30,
			'max' => 300,
		)
	),
	array(
		'label'       => esc_html__( 'Sticky Header', 'wpv' ),
		'description' => esc_html__( 'This option is switched off automatically for mobile devices because the animation is not well supported by the majority of the mobile devices.', 'wpv' ),
		'id'          => 'sticky-header',
		'type'        => 'switch',
		'transport'   => 'postMessage',
	),

	array(
		'label'     => esc_html__( 'Enable Header Search', 'wpv' ),
		'id'        => 'enable-header-search',
		'type'      => 'switch',
		'transport' => 'postMessage',
	),

	array(
		'label'       => esc_html__( 'Full Width Header', 'wpv' ),
		'description' => esc_html__( 'One row header only', 'wpv' ),
		'id'          => 'full-width-header',
		'type'        => 'switch',
		'transport'   => 'postMessage',
	),

	array(
		'label'       => esc_html__( 'Header Text Area', 'wpv' ),
		'description' => esc_html__( 'You can place text/HTML or any shortcode in this field. The text will appear in the header on the left hand side.', 'wpv' ),
		'id'          => 'header-text-main',
		'type'        => 'textarea',
		'transport'   => 'postMessage',
	),

	array(
		'label'       => esc_html__( 'Header Background', 'wpv' ),
		'description' => wp_kses_post( __( 'If you want to use an image as a background, enabling the cover button will resize and crop the image so that it will always fit the browser window on any resolution.', 'wpv' ) ),
		'id'          => 'header-background',
		'type'        => 'background',
		'compiler'    => true,
		'transport'   => 'postMessage',
		'skin'        => true,
		'show'        => array(
			'background-position' => false,
		),
	),

	array(
		'label'       => esc_html__( 'Sub-Header Background', 'wpv' ),
		'id'          => 'sub-header-background',
		'type'        => 'background',
		'compiler'    => true,
		'transport'   => 'postMessage',
		'skin'        => true,
		'show'        => array(
			'background-attachment' => false,
			'background-position'   => false,
		),
	),

	array(
		'label'     => esc_html__( 'Page Title Background', 'wpv' ),
		'id'        => 'page-title-background',
		'type'      => 'background',
		'compiler'  => true,
		'transport' => 'postMessage',
		'skin'      => true,
		'show'      => array(
			'background-attachment' => false,
			'background-position'   => false,
		),
	),

	array(
		'label'     => esc_html__( 'Hide Page Title Background Image on Lower Resolutions', 'wpv' ),
		'id'        => 'page-title-background-hide-lowres',
		'type'      => 'switch',
		'transport' => 'postMessage',
		'skin'      => true,
	),

	array(
		'label'       => esc_html__( 'Site Title', 'wpv' ),
		'id'          => 'logo',
		'type'        => 'typography',
		'compiler'    => true,
		'transport'   => 'postMessage',
		'skin'        => true,
	),

	array(
		'label'     => esc_html__( 'Text Color for Transparent Header', 'wpv' ),
		'type'      => 'color',
		'id'        => 'main-menu-text-sticky-color',
		'compiler'  => true,
		'transport' => 'postMessage',
		'skin'      => true,
	),

	array(
		'id'          => 'info-menu-styles',
		'type'        => 'info',
		'label'       => esc_html__( 'Menu Styles', 'wpv' ),
		'description' => wp_kses_post( sprintf( __( 'Menu styling options are available <a href="%s" title="Max Mega Menu" target="_blank">here</a> if you have the Max Mega Menu plugin installed.', 'wpv' ), admin_url( 'admin.php?page=maxmegamenu_theme_editor' ) ) ),
	),

	array(
		'id'   => 'info-mobile-header-layout',
		'type' => 'info',
		'description' => wp_kses_post( sprintf( __( 'Mobile header layout options are available <a href="%s" title="Max Mega Menu" target="_blank">here</a> if you have Max Mega Menu installed.', 'wpv' ), admin_url( 'admin.php?page=maxmegamenu' ) ) ),
	),

);
