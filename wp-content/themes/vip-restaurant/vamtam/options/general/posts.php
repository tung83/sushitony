<?php

/**
 * Theme options / General / Posts
 *
 * @package vip-restaurant
 */

return array(

	array(
		'label'       => esc_html__( 'Pagination Type', 'wpv' ),
		'description' => esc_html__( 'Also used for portfolio', 'wpv' ),
		'id'          => 'pagination-type',
		'type'        => 'select',
		'choices'     => array(
			'paged'              => esc_html__( 'Paged', 'wpv' ),
			'load-more'          => esc_html__( 'Load more button', 'wpv' ),
			'infinite-scrolling' => esc_html__( 'Infinite scrolling', 'wpv' ),
		),
	),

	array(
		'label'       => esc_html__( 'Show "Related Posts" in Single Post View', 'wpv' ),
		'description' => esc_html__( 'Enabling this option will show more posts from the same category when viewing a single post.', 'wpv' ),
		'id'          => 'show-related-posts',
		'type'        => 'switch',
		'transport'   => 'postMessage',
	),

	array(
		'label'     => esc_html__( '"Related Posts" title', 'wpv' ),
		'id'        => 'related-posts-title',
		'type'      => 'text',
		'transport' => 'postMessage',
	),

	array(
		'label'     => esc_html__( 'Meta Information', 'wpv' ),
		'id'        => 'post-meta',
		'type'      => 'multicheck',
		'transport' => 'postMessage',
		'choices'   => array(
			'author'   => esc_html__( 'Post Author', 'wpv' ),
			'tax'      => esc_html__( 'Categories and Tags', 'wpv' ),
			'date'     => esc_html__( 'Timestamp', 'wpv' ),
			'comments' => esc_html__( 'Comment Count', 'wpv' ),
		),
	),

	array(
		'label'       => esc_html__( 'Show Featured Image on Single Posts', 'wpv' ),
		'id'          => 'show-single-post-image',
		'description' => esc_html__( 'Please note, that this option works only for Blog Post Format Image.', 'wpv' ),
		'type'        => 'switch',
		'transport'   => 'postMessage',
	),

	array(
		'label'       => esc_html__( 'Post Archive Layout', 'wpv' ),
		'description' => '',
		'id'          => 'archive-layout',
		'type'        => 'radio',
		'choices'     => array(
			'normal' => esc_html__( 'Large', 'wpv' ),
			'mosaic' => esc_html__( 'Small', 'wpv' ),
		),
	),

);
