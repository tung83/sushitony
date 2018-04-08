<?php
return array(
	'name' => esc_html__( 'Blank Space', 'wpv' ),
	'desc' => esc_html__( 'You can increase or decrease the space between elements using this shortcode.' , 'wpv' ),
	'icon' => array(
		'char'    => Vamtam_Editor::get_icon( 'page-break' ),
		'size'    => '30px',
		'lheight' => '45px',
		'family'  => 'vamtam-editor-icomoon',
	),
	'value'    => 'blank',
	'controls' => 'name clone edit delete',
	'class'    => 'slim',
	'options'  => array(
		array(
			'name'    => esc_html__( 'Height (px)', 'wpv' ),
			'desc'    => esc_html__( 'You can increase or decrease the space between elements using this option. Please note that using negative number - decreasing space will not work for all elements and situations ', 'wpv' ),
			'id'      => 'h',
			'default' => 30,
			'min'     => -500,
			'max'     => 500,
			'type'    => 'range',
		) ,
		array(
			'name'    => esc_html__( 'Hide on Low Resolutions', 'wpv' ),
			'id'      => 'hide_low_res',
			'default' => false,
			'type'    => 'toggle',
		) ,
		array(
			'name'    => esc_html__( 'Class', 'wpv' ),
			'id'      => 'class',
			'default' => '',
			'type'    => 'text',
		) ,
	),
);
