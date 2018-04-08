<?php
return array(
	'name' => esc_html__( 'Text Divider', 'wpv' ),
	'icon' => array(
		'char' => Vamtam_Editor::get_icon( 'minus' ),
		'size' => '30px',
		'lheight' => '45px',
		'family' => 'vamtam-editor-icomoon',
	),
	'value' => 'text_divider',
	'controls' => 'name clone edit delete',
	'options' => array(
		array(
			'name' => esc_html__( 'Type', 'wpv' ),
			'id' => 'type',
			'default' => 'single',
			'options' => array(
				'single' => esc_html__( 'Title in the middle', 'wpv' ),
				'double' => esc_html__( 'Title above divider', 'wpv' ),
			),
			'type' => 'select',
			'class' => 'add-to-container',
			'field_filter' => 'ftds',
		) ,

		array(
			'name' => esc_html__( 'Text', 'wpv' ),
			'id' => 'html-content',
			'default' => esc_html__( 'Text Divider', 'wpv' ),
			'type' => 'editor',
			'class' => 'ftds ftds-single ftds-double',
		) ,

		array(
			'name'    => esc_html__( 'Subtitle', 'wpv' ),
			'id'      => 'subtitle',
			'type'    => 'text',
			'class'   => 'ftds ftds-single ftds-double',
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
