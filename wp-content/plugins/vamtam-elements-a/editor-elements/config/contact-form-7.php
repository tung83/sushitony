<?php
return array(
	'name' => esc_html__( 'Contact Form 7', 'wpv' ),
	'desc' => esc_html__( 'Please note that the theme uses the Contact Form 7 plugin for building forms and its option panel is found in the WordPress navigation menu on the left. ' , 'wpv' ),
	'icon' => array(
		'char' => Vamtam_Editor::get_icon( 'pencil1' ),
		'size' => '26px',
		'lheight' => '39px',
		'family' => 'vamtam-editor-icomoon',
	),
	'value' => 'contact-form-7',
	'controls' => 'size name clone edit delete',
	'options' => array(
		array(
			'name' => esc_html__( 'Choose By ID', 'wpv' ),
			'id' => 'id',
			'default' => '',
			'prompt' => '',
			'options' => Vamtam_Elements_A::get_wpcf7_posts( 'ID' ),
			'type' => 'select',
		) ,

		array(
			'name' => esc_html__( 'Choose By Title', 'wpv' ),
			'id' => 'title',
			'default' => '',
			'prompt' => '',
			'options' => Vamtam_Elements_A::get_wpcf7_posts( 'post_title' ),
			'type' => 'select',
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
