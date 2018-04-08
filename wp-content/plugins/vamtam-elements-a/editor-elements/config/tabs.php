<?php
return array(
	'name' => esc_html__( 'Tabs', 'wpv' ),
	'desc' => esc_html__( 'Change to vertical or horizontal tabs from the element option panel.  Add an icon by clicking on the "pencil" icon next to the pane title. Adding tabs, changing the name of the tab and adding content into the tabs is done when the tab element is toggled.' , 'wpv' ),
	'icon' => array(
		'char' => Vamtam_Editor::get_icon( 'storage1' ),
		'size' => '30px',
		'lheight' => '45px',
		'family' => 'vamtam-editor-icomoon',
	),
	'value' => 'tabs',
	'controls' => 'size name clone edit delete always-expanded',
	'callbacks' => array(
		'init' => 'init-tabs',
		'generated-shortcode' => 'generate-tabs',
	),
	'options' => array(

		array(
			'name' => esc_html__( 'Layout', 'wpv' ),
			'id' => 'layout',
			'default' => 'horizontal',
			'type' => 'radio',
			'options' => array(
				'horizontal' => esc_html__( 'Horizontal', 'wpv' ),
				'vertical' => esc_html__( 'Vertical', 'wpv' ),
			),
			'field_filter' => 'fts',
		) ,
		array(
			'name' => esc_html__( 'Navigation Color', 'wpv' ),
			'id' => 'nav_color',
			'type' => 'color',
			'default' => 'accent2',
		) ,
		array(
			'name' => esc_html__( 'Navigation Background', 'wpv' ),
			'id' => 'nav_bg',
			'type' => 'color',
			'default' => 'accent8',
		) ,
		array(
			'name' => esc_html__( 'Content Background', 'wpv' ),
			'id' => 'right_color',
			'type' => 'color',
			'default' => 'accent1',
		) ,
		array(
			'name' => esc_html__( 'Active Tab Color', 'wpv' ),
			'id' => 'active_nav_color',
			'type' => 'color',
			'default' => 'accent6',
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
				'single' => esc_html__( 'Title with divider next to it.', 'wpv' ),
				'double' => esc_html__( 'Title with divider below', 'wpv' ),
				'no-divider' => esc_html__( 'No Divider', 'wpv' ),
			),
			'class' => 'fts fts-horizontal',
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
