<?php

/**
 * Blog shortcode options
 *
 * @package editor
 */


return array(
	'name' => 'Blog',
	'desc' => esc_html__( 'Please note that this element shows already created blog posts. To create one go to the Posts tab in the WordPress main navigation menu on the left - add new. You do not have to go to Settings - Reading to set the blog listing page.' , 'wpv' ),
	'icon' => array(
		'char'    => Vamtam_Editor::get_icon( 'blog' ),
		'size'    => '30px',
		'lheight' => '45px',
		'family'  => 'vamtam-editor-icomoon',
	),
	'value'    => 'blog',
	'controls' => 'size name clone edit delete',
	'options'  => array(
		array(
			'name'    => esc_html__( 'Layout', 'wpv' ),
			'desc'    => wp_kses_post( __( 'Big images - this is the standard layout in one column. <br/> Small images, Small Images - Scrollable, Small images - Masonry - the posts in these layouts come in boxes with image on top and text below. They come in 2,3,4 columns.', 'wpv' ) ),
			'id'      => 'layout',
			'type'    => 'select',
			'default' => 'normal',
			'options' => array(
				'normal'   => esc_html__( 'Big Images', 'wpv' ),
				'small'    => esc_html__( 'Small Images - Normal', 'wpv' ),
				'scroll-x' => esc_html__( 'Small Images - Scrollable', 'wpv' ),
				'mosaic'   => esc_html__( 'Small Images - Mosaic (Masonry)', 'wpv' ),
			),
			'field_filter' => 'fbs',
		),
		array(
			'name'    => esc_html__( 'Columns', 'wpv' ),
			'desc'    => esc_html__( 'Set to 0 for automatic number of columns. ', 'wpv' ),
			'id'      => 'column',
			'default' => 2,
			'min'     => 0,
			'max'     => 4,
			'type'    => 'range',
			'class'   => 'fbs fbs-small fbs-scroll-x fbs-mosaic',
		) ,
		array(
			'name'    => esc_html__( 'Limit', 'wpv' ),
			'desc'    => esc_html__( 'Number of posts to show per page.', 'wpv' ),
			'id'      => 'count',
			'default' => 3,
			'min'     => 1,
			'max'     => 50,
			'type'    => 'range',
		) ,

		array(
			'name'    => esc_html__( 'Display Post Content', 'wpv' ),
			'id'      => 'show_content',
			'desc'    => wp_kses_post( __( 'Big Images Layout: If the option is on, it will display the content of the post, otherwise it will display the excerpt.<br> Small Images - Normal, Scrollable, Masonry: If the option is on, the post excerpt will be shown, otherwise no content will be shown.', 'wpv' ) ),
			'default' => false,
			'type'    => 'toggle',
		) ,
		array(
			'name'    => esc_html__( 'Disable Pagination', 'wpv' ),
			'id'      => 'nopaging',
			'desc'    => esc_html__( 'If the option is on, it will disable pagination. You can set the type of pagination in General Settings - Posts - Pagination Type. ', 'wpv' ),
			'default' => true,
			'type'    => 'toggle',
			'class'   => 'fbs fbs-normal fbs-small fbs-mosaic',
		) ,
		array(
			'name'    => esc_html__( 'Category (optional)', 'wpv' ),
			'desc'    => esc_html__( 'All categories will be shown if none are selected. Please note that if you do not see categories, there are none created most probably. You can use ctr + click to select multiple categories', 'wpv' ),
			'id'      => 'cat',
			'default' => array(),
			'target'  => 'cat',
			'type'    => 'multiselect',
			'layout'  => 'checkbox',
		) ,
		array(
			'name'    => esc_html__( 'Posts (optional)', 'wpv' ),
			'desc'    => esc_html__( 'All posts will be shown if none are selected. If you select any posts here, this option will override the category option above. You can use ctr + click to select multiple posts.', 'wpv' ),
			'id'      => 'posts',
			'default' => array(),
			'target'  => 'post',
			'type'    => 'multiselect',
		) ,


		array(
			'name'    => esc_html__( 'Title (optional)', 'wpv' ),
			'desc'    => esc_html__( 'The title is placed just above the element.', 'wpv' ),
			'id'      => 'column_title',
			'default' => '',
			'type'    => 'text',
		) ,
		array(
			'name'    => esc_html__( 'Title Type (optional)', 'wpv' ),
			'id'      => 'column_title_type',
			'default' => 'single',
			'type'    => 'select',
			'options' => array(
				'single'     => esc_html__( 'Title with divider next to it', 'wpv' ),
				'double'     => esc_html__( 'Title with divider below', 'wpv' ),
				'no-divider' => esc_html__( 'No Divider', 'wpv' ),
			),
		) ,
		array(
			'name'    => esc_html__( 'Entrance Animation (optional)', 'wpv' ),
			'id'      => 'column_animation',
			'default' => 'none',
			'type'    => 'select',
			'options' => array(
				'none'        => esc_html__( 'No animation', 'wpv' ),
				'from-left'   => esc_html__( 'Appear from left', 'wpv' ),
				'from-right'  => esc_html__( 'Appear from right', 'wpv' ),
				'from-top'    => esc_html__( 'Appear from top', 'wpv' ),
				'from-bottom' => esc_html__( 'Appear from bottom', 'wpv' ),
				'fade-in'     => esc_html__( 'Fade in', 'wpv' ),
				'zoom-in'     => esc_html__( 'Zoom in', 'wpv' ),
			),
		) ,
	),
);



