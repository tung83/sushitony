<?php

/**
 * Expandable services shortcode options
 *
 * @package editor
 */

return array(
	'name' => esc_html__( 'Expandable Box ', 'wpv' ),
	'desc' => esc_html__( 'You have open and closed states of the box and you can set diffrenet content and background of each state.' , 'wpv' ),
	'icon' => array(
		'char' => Vamtam_Editor::get_icon( 'expand1' ),
		'size' => '26px',
		'lheight' => '39px',
		'family' => 'vamtam-editor-icomoon',
	),
	'value' => 'services_expandable',
	'controls' => 'size name clone edit delete',
	'callbacks' => array(
		'init' => 'init-expandable-services',
		'generated-shortcode' => 'generate-expandable-services',
	),
	'options' => array(
		array(
			'name' => esc_html__( 'Closed Background', 'wpv' ),
			'type' => 'background',
			'id'   => 'background',
			'only' => 'color,image,repeat,size',
			'sep'  => '_',
		) ,

		array(
			'name'    => esc_html__( 'Expanded Background', 'wpv' ),
			'type'    => 'color',
			'id'      => 'hover_background',
			'default' => 'accent1',
		) ,

		array(
			'name'    => esc_html__( 'Closed state image', 'wpv' ),
			'id'      => 'image',
			'default' => '',
			'type'    => 'upload',
		) ,

		array(
			'name'    => esc_html__( 'Closed state icon', 'wpv' ),
			'desc'    => esc_html__( 'The icon will not be visable if you have an image in the option above.', 'wpv' ),
			'id'      => 'icon',
			'default' => '',
			'type'    => 'icons',
		) ,
		array(
			'name'    => esc_html__( 'Icon Color', 'wpv' ),
			'id'      => 'icon_color',
			'default' => 'accent6',
			'type'    => 'color',
		) ,
		array(
			'name'    => esc_html__( 'Icon Size', 'wpv' ),
			'id'      => 'icon_size',
			'type'    => 'range',
			'default' => 62,
			'min'     => 8,
			'max'     => 100,
		),

		array(
			'name'    => esc_html__( 'Title', 'wpv' ),
			'type'    => 'text',
			'id'      => 'title',
			'default' => '',
		) ,

		array(
			'name'    => esc_html__( 'Title Color', 'wpv' ),
			'id'      => 'title_color',
			'default' => 'accent8',
			'type'    => 'color',
		) ,

		array(
			'name'    => esc_html__( 'Closed state text', 'wpv' ),
			'id'      => 'closed',
			'default' => esc_html__( 'Proin gravida nibh vel velit auctor aliquet. Aenean sollicitudin, lorem quis bibendum auctor, nisi elit consequat ipsum, nec sagittis sem nibh id elit. Duis sed odio sit amet nibh vulputate cursus a sit amet mauris. Morbi accumsan ipsum velit. Nam nec tellus a odio tincidunt auctor a ornare odio. Sed non mauris vitae erat consequat auctor eu in elit.', 'wpv' ),
			'type'    => 'textarea',
			'class'   => 'noattr',
		) ,

		array(
			'name'    => esc_html__( 'Expanded state', 'wpv' ),
			'id'      => 'html-content',
			'default' => '[split]',
			'type'    => 'editor',
			'holder'  => 'textarea',
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
