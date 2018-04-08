<?php
return array(
	'name' => esc_html__( 'Countdown', 'wpv' ),
	'icon' => array(
		'char' => Vamtam_Editor::get_icon( 'clock' ),
		'size' => '26px',
		'lheight' => '39px',
		'family' => 'vamtam-editor-icomoon',
	),
	'value' => 'vamtam_countdown',
	'controls' => 'size name clone edit delete',
	'options' => array(
		array(
			'name' => esc_html__( 'Date and Time', 'wpv' ),
			'desc' => wp_kses_post( __( 'Any <a href="http://www.php.net/manual/en/datetime.formats.compound.php">compount time format</a> accepted by PHP. "Common Log Format" is recommended if your server is in different time zone from you.', 'wpv' ) ),
			'id' => 'datetime',
			'default' => '',
			'type' => 'text',
		) ,
		array(
			'name' => esc_html__( '"Finished" text', 'wpv' ),
			'id' => 'done',
			'default' => '',
			'type' => 'text',
		) ,
		array(
			'name' => esc_html__( 'Description text', 'wpv' ),
			'id' => 'html-content',
			'default' => '',
			'type' => 'editor',
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
