<?php
return array(
	'name' => esc_html__( 'LayerSlider', 'wpv' ),
	'desc' => esc_html__('Please note that the theme uses LayerSlider and its option panel is found in the WordPress navigation menu on the left. This element insert already created slider into the page/post body.
	If you need to activate the slider in the Header, then you will need the option - "Page Slider" found below the editor. ' , 'wpv'),
	'icon' => array(
		'char' => Vamtam_Editor::get_icon( 'images' ),
		'size' => '30px',
		'lheight' => '45px',
		'family' => 'vamtam-editor-icomoon',

	),
	'value' => 'layerslider',
	'controls' => 'size name clone edit delete',
	'options' => array(
		array(
			'name' => esc_html__( 'Slider', 'wpv' ),
			'id' => 'id',
			'default' => '',
			'options' => VamtamTemplates::get_layer_sliders( '' ),
			'type' => 'select',
		) ,
	),
);
