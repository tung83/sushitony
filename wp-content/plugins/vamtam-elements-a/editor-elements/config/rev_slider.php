<?php
return array(
	'name' => esc_html__( 'Revolution Slider', 'wpv' ),
	'desc' => esc_html__('Please note that the theme uses Revolution Slider and its option panel is found in the WordPress navigation menu on the left. This element inserts already created slider into the page/post body.
	If you need to activate the slider in the Header, then you will need the option - "Page Slider" found below the editor. ' , 'wpv'),
	'icon' => array(
		'char' => Vamtam_Editor::get_icon( 'images' ),
		'size' => '26px',
		'lheight' => '39px',
		'family' => 'vamtam-editor-icomoon',

	),
	'value' => 'rev_slider',
	'controls' => 'size name clone edit delete',
	'options' => array(
		array(
			'name' => esc_html__( 'Slider', 'wpv' ),
			'id' => 'alias',
			'default' => '',
			'options' => VamtamTemplates::get_rev_sliders( '' ),
			'type' => 'select',
		) ,
	),
);
