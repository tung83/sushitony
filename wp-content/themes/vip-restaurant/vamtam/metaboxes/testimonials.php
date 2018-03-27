<?php
/**
 * Vamtam Post Options
 *
 * @package vip-restaurant
 */

return array(

array(
	'name' => esc_html__( 'General', 'wpv' ),
	'type' => 'separator',
),

array(
	'name'    => esc_html__( 'Cite', 'wpv' ),
	'id'      => 'testimonial-author',
	'default' => '',
	'type'    => 'text',
) ,

array(
	'name'    => esc_html__( 'Link', 'wpv' ),
	'id'      => 'testimonial-link',
	'default' => '',
	'type'    => 'text',
) ,

array(
	'name'    => esc_html__( 'Rating', 'wpv' ),
	'id'      => 'testimonial-rating',
	'default' => 5,
	'type'    => 'range',
	'min'     => 0,
	'max'     => 5,
) ,

array(
	'name'    => esc_html__( 'Summary', 'wpv' ),
	'id'      => 'testimonial-summary',
	'default' => '',
	'type'    => 'text',
) ,

);
