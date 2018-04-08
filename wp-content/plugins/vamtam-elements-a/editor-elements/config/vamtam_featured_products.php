<?php
return array(
	'name' => esc_html__( 'Featured Products', 'wpv' ),
	'icon' => array(
		'char' => Vamtam_Editor::get_icon( 'cart1' ),
		'size' => '26px',
		'lheight' => '39px',
		'family' => 'vamtam-editor-icomoon',
	),
	'value' => 'vamtam_featured_products',
	'controls' => 'size name clone edit delete',
	'options' => array(
		array(
			'name' => esc_html__( 'Columns', 'wpv' ),
			'id' => 'columns',
			'default' => 4,
			'min' => 0,
			'max' => 4,
			'type' => 'range',
		) ,
		array(
			'name' => esc_html__( 'Limit', 'wpv' ),
			'desc' => esc_html__( 'Maximum number of products.', 'wpv' ),
			'id' => 'per_page',
			'default' => 3,
			'min' => 1,
			'max' => 50,
			'type' => 'range',
		) ,

		array(
			'name' => esc_html__( 'Order By', 'wpv' ),
			'id' => 'orderby',
			'default' => 'date',
			'type' => 'radio',
			'options' => array(
				'date' => esc_html__( 'Date', 'wpv' ),
				'menu_order' => esc_html__( 'Menu Order', 'wpv' ),
			),
		) ,

		array(
			'name' => esc_html__( 'Order', 'wpv' ),
			'id' => 'order',
			'default' => 'desc',
			'type' => 'radio',
			'options' => array(
				'desc' => esc_html__( 'Descending', 'wpv' ),
				'asc' => esc_html__( 'Ascending', 'wpv' ),
			),
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
