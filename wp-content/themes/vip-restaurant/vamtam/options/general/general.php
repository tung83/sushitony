<?php

/**
 * Theme options / General / Media
 *
 * @package vip-restaurant
 */


return array(
	array(
		'label'       => esc_html__( '"Scroll to Top" Button', 'wpv' ),
		'description' => esc_html__( 'It is found in the bottom right side. It is sole purpose is help the user scroll a long page quickly to the top.', 'wpv' ),
		'id'          => 'show-scroll-to-top',
		'type'        => 'switch',
		'transport'   => 'postMessage',
	),

	array(
		'label'       => esc_html__( 'Custom JavaScript', 'wpv' ),
		'description' => wp_kses_post( __( 'If the hundreds of options in the Theme Options Panel are not enough and you need customisation that is outside of the scope of the Theme Option Panel please place your javascript in this field. The contents of this field are placed near the <strong>&lt;/body&gt;</strong> tag, which improves the load times of the page.', 'wpv' ) ),
		'id'          => 'custom-js',
		'type'        => 'textarea',
	),
);
