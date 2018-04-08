<?php
return array(
	'name' => esc_html__( 'Accordion', 'wpv' ),
	'desc' => esc_html__( 'Adding panes, changing the name of the pane and adding content into the panes is done when the accordion element is toggled.' , 'wpv' ),
	'icon' => array(
		'char' => Vamtam_Editor::get_icon( 'menu1' ),
		'size' => '30px',
		'lheight' => '45px',
		'family' => 'vamtam-editor-icomoon',
	),
	'value' => 'accordion',
	'controls' => 'size name clone edit delete always-expanded',
	'callbacks' => array(
		'init' => 'init-accordion',
		'generated-shortcode' => 'generate-accordion',
	),
	'options' => array(

		array(
			'name' => esc_html__( 'Allow All Panes to be Closed', 'wpv' ),
			'desc' => esc_html__( 'If enabled, the accordion will load with collapsed panes. Clicking on the title of the currently active pane will close it. Clicking on the title of an inactive pane will change the active pane.', 'wpv' ),
			'id' => 'collapsible',
			'default' => true,
			'type' => 'toggle',
		) ,

		array(
			'name' => esc_html__( 'Pane Background', 'wpv' ),
			'id' => 'closed_bg',
			'default' => 'accent1',
			'type' => 'color',
		) ,

		array(
			'name' => esc_html__( 'Title Color', 'wpv' ),
			'id' => 'title_color',
			'default' => 'accent8',
			'type' => 'color',
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
				'double' => esc_html__( 'Title with divider under it ', 'wpv' ),
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
