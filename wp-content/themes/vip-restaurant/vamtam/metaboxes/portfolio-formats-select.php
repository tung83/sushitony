<?php
/**
 * Vamtam Project Format Selector
 *
 * @package vip-restaurant
 */

return array(

array(
	'name' => esc_html__( 'Project Format', 'wpv' ),
	'type' => 'separator',
),

array(
	'name' => esc_html__( 'Project Data Type', 'wpv' ),
	'desc' => wp_kses_post( __('Image - uses the featured image (default)<br />
				  Gallery - use the featured image as a title image but show additional images too<br />
				  Video/Link - uses the "portfolio data url" setting<br />
				  Document - acts like a normal post<br />
				  HTML - overrides the image with arbitrary HTML when displaying a single project.
				', 'wpv') ),
	'id'      => 'portfolio_type',
	'type'    => 'radio',
	'options' => array(
		'image'    => esc_html__( 'Image', 'wpv' ),
		'gallery'  => esc_html__( 'Gallery', 'wpv' ),
		'video'    => esc_html__( 'Video', 'wpv' ),
		'link'     => esc_html__( 'Link', 'wpv' ),
		'document' => esc_html__( 'Document', 'wpv' ),
		'html'     => esc_html__( 'HTML', 'wpv' ),
	),
	'default' => 'image',
),

array(
	'name'    => esc_html__( 'Featured Project', 'wpv' ),
	'id'      => 'featured-project',
	'type'    => 'checkbox',
	'default' => false,
),

);
