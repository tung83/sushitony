<?php
return array(
	'name' => esc_html__( 'Price Box', 'wpv' ),
	'icon' => array(
		'char' => Vamtam_Editor::get_icon( 'basket1' ),
		'size' => '30px',
		'lheight' => '45px',
		'family' => 'vamtam-editor-icomoon',
	),
	'value' => 'price',
	'controls' => 'size name clone edit delete',
	'options' => array(

		array(
			'name' => esc_html__( 'Title', 'wpv' ),
			'id' => 'title',
			'default' => esc_html__( 'Title', 'wpv' ),
			'type' => 'text',
			'holder' => 'h5',
		) ,
		array(
			'name' => esc_html__( 'Price', 'wpv' ),
			'id' => 'price',
			'default' => '69',
			'type' => 'text',
		) ,
		array(
			'name' => esc_html__( 'Currency', 'wpv' ),
			'id' => 'currency',
			'default' => '$',
			'type' => 'text',
		) ,
		array(
			'name' => esc_html__( 'Duration', 'wpv' ),
			'id' => 'duration',
			'default' => 'per month',
			'type' => 'text',
		) ,
		array(
			'name' => esc_html__( 'Summary', 'wpv' ),
			'id' => 'summary',
			'default' => '',
			'type' => 'text',
		) ,
		array(
			'name' => esc_html__( 'Description', 'wpv' ),
			'id' => 'html-content',
			'default' => '',
			'type' => 'editor',
			'holder' => 'textarea',
		) ,
		array(
			'name' => esc_html__( 'Button Text', 'wpv' ),
			'id' => 'button_text',
			'default' => 'Buy',
			'type' => 'text',
		) ,
		array(
			'name' => esc_html__( 'Button Link', 'wpv' ),
			'id' => 'button_link',
			'default' => '',
			'type' => 'text',
		) ,
		array(
			'name' => esc_html__( 'Featured', 'wpv' ),
			'id' => 'featured',
			'default' => 'false',
			'type' => 'toggle',
		) ,


		array(
			'name' => esc_html__( 'Title', 'wpv' ),
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
				'double' => esc_html__( 'Title with divider below', 'wpv' ),
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
