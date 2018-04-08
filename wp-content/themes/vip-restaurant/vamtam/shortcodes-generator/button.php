<?php
return array(
	'name'    => esc_html__( 'Buttons', 'wpv' ),
	'value'   => 'button',
	'options' => array(
		array(
			'name'    => esc_html__( 'Text', 'wpv' ),
			'id'      => 'text',
			'default' => '',
			'type'    => 'text',
		) ,
		array(
			'name'    => esc_html__( 'Style', 'wpv' ),
			'id'      => 'style',
			'default' => 'filled',
			'type'    => 'select',
			'options' => array(
				'filled'         => esc_html__( 'Filled', 'wpv' ),
				'border'         => esc_html__( 'Border', 'wpv' ),
				'style-3'        => esc_html__( 'Style 3', 'wpv' ),
			),
		) ,
		array(
			'name'    => esc_html__( 'Font size', 'wpv' ),
			'id'      => 'font',
			'default' => 24,
			'type'    => 'range',
			'min'     => 10,
			'max'     => 64,
		) ,
		array(
			'name'    => esc_html__( 'Background', 'wpv' ),
			'id'      => 'bgcolor',
			'default' => 'accent1',
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
			'name'    => esc_html__( 'Text Color Override', 'wpv' ),
			'id'      => 'text_color',
			'default' => '',
			'type'    => 'color',
		) ,
		array(
			'name'    => esc_html__( 'Hover Background', 'wpv' ),
			'id'      => 'hover_color',
			'default' => 'accent1',
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
			'name'    => esc_html__( 'Alignment', 'wpv' ),
			'id'      => 'align',
			'default' => '',
			'prompt'  => '',
			'type'    => 'select',
			'options' => array(
				'left'   => esc_html__( 'Left', 'wpv' ),
				'right'  => esc_html__( 'Right', 'wpv' ),
				'center' => esc_html__( 'Center', 'wpv' ),
			),
		) ,
		array(
			'name'    => esc_html__( 'Link', 'wpv' ),
			'id'      => 'link',
			'default' => '',
			'type'    => 'text',
		) ,
		array(
			'name'    => esc_html__( 'Link Target', 'wpv' ),
			'id'      => 'linkTarget',
			'default' => '_self',
			'type'    => 'select',
			'options' => array(
				'_blank' => esc_html__( 'Load in a new window', 'wpv' ),
				'_self'  => esc_html__( 'Load in the same frame as it was clicked', 'wpv' ),
			),
		) ,
		array(
			'name'    => esc_html__( 'Icon', 'wpv' ),
			'id'      => 'icon',
			'default' => '',
			'type'    => 'icons',
		) ,
		array(
			'name'    => esc_html__( 'Icon Size', 'wpv' ),
			'id'      => 'icon_size',
			'default' => 0,
			'type'    => 'range',
			'min'     => 0,
			'max'     => 100,
		) ,
		array(
			'name'    => esc_html__( 'Icon Style', 'wpv' ),
			'type'    => 'select-row',
			'selects' => array(
				'icon_color' => array(
					'desc'    => esc_html__( 'Color:', 'wpv' ),
					'default' => '',
					'prompt'  => '',
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
				),
				'icon_placement' => array(
					'desc'    => esc_html__( 'Placement:', 'wpv' ),
					'default' => 'left',
					'options' => array(
						'left'  => esc_html__( 'Left', 'wpv' ),
						'right' => esc_html__( 'Right', 'wpv' ),
					),
				),
			),
		),

		array(
			'name'    => esc_html__( 'ID', 'wpv' ),
			'desc'    => esc_html__( 'ID attribute added to the button element.', 'wpv' ),
			'id'      => 'id',
			'default' => '',
			'type'    => 'text',
		) ,
		array(
			'name'    => esc_html__( 'Class', 'wpv' ),
			'desc'    => esc_html__( 'Class attribute added to the button element.', 'wpv' ),
			'id'      => 'class',
			'default' => '',
			'type'    => 'text',
		) ,
	),
);
