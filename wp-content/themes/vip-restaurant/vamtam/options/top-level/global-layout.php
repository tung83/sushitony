<?php

/**
 * Theme options / Layout / General
 *
 * @package vip-restaurant
 */

return array(

	array(
		'label'       => esc_html__( 'Layout Type', 'wpv' ),
		'description' => esc_html__( 'Please note that in full width layout mode, the body background option found in Styles - Body, acts as page background.', 'wpv' ),
		'id'          => 'site-layout-type',
		'type'        => 'radio',
		'choices'     => array(
			'boxed' => esc_html__( 'Boxed', 'wpv' ),
			'full'  => esc_html__( 'Full width', 'wpv' ),
		),
	),

	array(
		'label'       => esc_html__( 'Maximum Page Width', 'wpv' ),
		'description' => wp_kses_post( sprintf( __( 'If you have changed this option, please use the <a href="%s" title="Regenerate thumbnails" target="_blank">Regenerate thumbnails</a> plugin in order to update your images.', 'wpv' ), 'http://wordpress.org/extend/plugins/regenerate-thumbnails/' ) ),
		'id'          => 'site-max-width',
		'type'        => 'radio',
		'choices'     => array(
			960  => '960px',
			1140 => '1140px',
			1260 => '1260px',
			1400 => '1400px',
		),
		'compiler'  => true,
		'transport' => 'postMessage',
	),

);
