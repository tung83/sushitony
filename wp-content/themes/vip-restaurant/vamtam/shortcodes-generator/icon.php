<?php

return array(
	'name'    => esc_html__( 'Icon', 'wpv' ),
	'value'   => 'icon',
	'options' => array(
		array(
			'name'    => esc_html__( 'Name', 'wpv' ),
			'id'      => 'name',
			'default' => '',
			'type'    => 'icons',
		) ,
		array(
			'name'    => esc_html__( 'Color (optional)', 'wpv' ),
			'id'      => 'color',
			'default' => '',
			'prompt'  => '',
			'type'    => 'select',
			'options' => array(
				'accent1' => esc_html__( 'Accent 1', 'wpv' ),
				'accent2' => esc_html__( 'Accent 2', 'wpv' ),
				'accent3' => esc_html__( 'Accent 3', 'wpv' ),
				'accent4' => esc_html__( 'Accent 4', 'wpv' ),
				'accent5' => esc_html__( 'Accent 5', 'wpv' ),
				'accent6' => esc_html__( 'Accent 6', 'wpv' ),
				'accent7' => esc_html__( 'Accent 7', 'wpv' ),
				'accent8' => esc_html__( 'Accent 8', 'wpv' ),
			),
		) ,
		array(
			'name'    => esc_html__( 'Size', 'wpv' ),
			'id'      => 'size',
			'type'    => 'range',
			'default' => 16,
			'min'     => 8,
			'max'     => 100,
		),
		array(
			'name'    => esc_html__( 'Style', 'wpv' ),
			'id'      => 'style',
			'default' => '',
			'prompt'  => esc_html__( 'Default', 'wpv' ),
			'type' => 'select',
			'options' => array(
				'border' => esc_html__( 'Border', 'wpv' ),
			),
		) ,
	),
);
