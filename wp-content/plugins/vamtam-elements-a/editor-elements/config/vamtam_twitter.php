<?php
return array(
	'name' => esc_html__( 'Twitter Timeline', 'wpv' ),
	'icon' => array(
		'char' => Vamtam_Editor::get_icon( 'twitter' ),
		'size' => '26px',
		'lheight' => '39px',
		'family' => 'vamtam-editor-icomoon',
	),
	'value' => 'vamtam_twitter',
	'controls' => 'size name clone edit delete',
	'options' => array(

		array(
			'name' => esc_html__( 'Type', 'wpv' ),
			'id' => 'type',
			'default' => 'user',
			'type' => 'select',
			'options' => array(
				'user' => esc_html__( 'Single user', 'wpv' ),
				'search' => esc_html__( 'Search results ', 'wpv' ),
			),
		) ,

		array(
			'name' => esc_html__( 'Username or Search Terms', 'wpv' ),
			'id' => 'param',
			'default' => '',
			'type' => 'text',
		) ,

		array(
			'name' => esc_html__( 'Number of Tweets', 'wpv' ),
			'id' => 'limit',
			'default' => 5,
			'type' => 'range',
			'min' => 1,
			'max' => 20,
		) ,

		array(
			'name' => esc_html__( 'Title (optional)', 'wpv' ),
			'desc' => esc_html__( 'The title is placed just above the element.', 'wpv' ),
			'id' => 'column_title',
			'default' => '',
			'type' => 'text',
		) ,
		array(
			'name' => esc_html__( 'Title Type (optional)', 'wpv' ),
			'id' => 'column_title_type',
			'default' => 'single',
			'type' => 'select',
			'options' => array(
				'single' => esc_html__( 'Title with divider next to it', 'wpv' ),
				'double' => esc_html__( 'Title with divider under it ', 'wpv' ),
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
