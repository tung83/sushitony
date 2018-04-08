<?php
return array(
	'name' => esc_html__( 'IFrame', 'wpv' ),
	'desc' => esc_html__( 'You can embed a website using this element.' , 'wpv' ),
	'icon' => array(
		'char' => Vamtam_Editor::get_icon( 'tablet' ),
		'size' => '30px',
		'lheight' => '45px',
		'family' => 'vamtam-editor-icomoon',
	),
	'value' => 'iframe',
	'controls' => 'size name clone edit delete',
	'options' => array(

		array(
			'name' => esc_html__( 'Source', 'wpv' ),
			'desc' => esc_html__( 'The URL of the page you want to display. Please note that the link should be in this format: http://www.google.com', 'wpv' ),
			'id' => 'src',
			'size' => 30,
			'default' => 'http://apple.com',
			'type' => 'text',
			'holder' => 'div',
			'placeholder' => esc_html__( 'Click edit to set iframe source url', 'wpv' ),
		) ,
		array(
			'name' => esc_html__( 'Width', 'wpv' ),
			'desc' => esc_html__( 'You can use % or px as units for width.', 'wpv' ),
			'id' => 'width',
			'size' => 30,
			'default' => '100%',
			'type' => 'text',
		) ,
		array(
			'name' => esc_html__( 'Height', 'wpv' ),
			'desc' => esc_html__( 'You can use px as units for height.', 'wpv' ),
			'id' => 'height',
			'size' => 30,
			'default' => '400px',
			'type' => 'text',
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
	),
);
