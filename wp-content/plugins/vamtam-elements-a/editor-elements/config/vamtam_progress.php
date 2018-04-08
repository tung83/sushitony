<?php
return array(
	'name' => esc_html__( 'Progress Indicator', 'wpv' ),
	'desc' => esc_html__( 'You can choose from % indicator or animated number.' , 'wpv' ),
	'icon' => array(
		'char'    => Vamtam_Editor::get_icon( 'meter-medium' ),
		'size'    => '26px',
		'lheight' => '39px',
		'family'  => 'vamtam-editor-icomoon',
	),
	'value'    => 'vamtam_progress',
	'controls' => 'size name clone edit delete',
	'options'  => array(
		array(
			'name'    => esc_html__( 'Type', 'wpv' ),
			'id'      => 'type',
			'type'    => 'select',
			'default' => 'percentage',
			'options' => array(
				'percentage' => esc_html__( 'Percentage', 'wpv' ),
				'number'     => esc_html__( 'Number', 'wpv' ),
			),
			'field_filter' => 'fpis',
		),

		array(
			'name'    => esc_html__( 'Percentage', 'wpv' ),
			'id'      => 'percentage',
			'default' => 0,
			'type'    => 'range',
			'min'     => 0,
			'max'     => 100,
			'unit'    => '%',
			'class'   => 'fpis fpis-percentage',
		) ,

		array(
			'name'    => esc_html__( 'Icon', 'wpv' ),
			'id'      => 'icon',
			'default' => '',
			'type'    => 'icons',
			'class'   => 'fpis fpis-number',
		) ,

		array(
			'name'    => esc_html__( 'Value', 'wpv' ),
			'id'      => 'value',
			'default' => 0,
			'type'    => 'range',
			'min'     => 0,
			'max'     => 100000,
			'class'   => 'fpis fpis-number',
		) ,

		array(
			'name'    => esc_html__( 'Before Value', 'wpv' ),
			'id'      => 'before_value',
			'default' => '',
			'type'    => 'text',
			'class'   => 'fpis fpis-number',
		) ,

		array(
			'name'    => esc_html__( 'After Value', 'wpv' ),
			'id'      => 'after_value',
			'default' => '',
			'type'    => 'text',
			'class'   => 'fpis fpis-number',
		) ,

		array(
			'name'    => esc_html__( 'Track Color', 'wpv' ),
			'id'      => 'bar_color',
			'default' => 'accent1',
			'type'    => 'color',
			'class'   => 'fpis fpis-percentage',
		) ,

		array(
			'name'    => esc_html__( 'Bar Color', 'wpv' ),
			'id'      => 'track_color',
			'default' => 'accent7',
			'type'    => 'color',
			'class'   => 'fpis fpis-percentage',
		) ,

		array(
			'name'    => esc_html__( 'Value Color', 'wpv' ),
			'id'      => 'value_color',
			'default' => 'accent2',
			'type'    => 'color',
		) ,

		array(
			'name'    => esc_html__( 'Content', 'wpv' ),
			'id'      => 'html-content',
			'default' => '',
			'type'    => 'editor',
			'holder'  => 'textarea',
		) ,

	),
);
