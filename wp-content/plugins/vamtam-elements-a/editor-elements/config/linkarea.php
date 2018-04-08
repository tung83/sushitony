<?php
return array(
	'name' => esc_html__( 'Box with a Link', 'wpv' ),
	'desc' => esc_html__( 'You can set a link, background color and hover color to a section of the website and place your content there.' , 'wpv' ),
	'icon' => array(
		'char' => Vamtam_Editor::get_icon( 'link5' ),
		'size' => '30px',
		'lheight' => '40px',
		'family' => 'vamtam-editor-icomoon',
	),
	'value' => 'linkarea',
	'controls' => 'size name clone edit delete',
	'options' => array(
		array(
			'name' => esc_html__( 'Background Color', 'wpv' ),
			'id' => 'background_color',
			'default' => '',
			'prompt' => esc_html__( 'No background', 'wpv' ),
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
			'type' => 'select',
		) ,
		array(
			'name' => esc_html__( 'Hover Color', 'wpv' ),
			'id' => 'hover_color',
			'default' => 'accent1',
			'prompt' => esc_html__( 'No background', 'wpv' ),
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
			'type' => 'select',
		) ,

		array(
			'name' => esc_html__( 'Link', 'wpv' ),
			'id' => 'href',
			'default' => '',
			'type' => 'text',
		) ,

		array(
			'name' => esc_html__( 'Target', 'wpv' ),
			'id' => 'target',
			'default' => '_self',
			'options' => array(
				'_blank' => esc_html__( 'Load in a new window', 'wpv' ),
				'_self' => esc_html__( 'Load in the same frame as it was clicked', 'wpv' ),
			),
			'type' => 'select',
		) ,

		array(
			'name' => esc_html__( 'Contents', 'wpv' ),
			'id' => 'html-content',
			'default' => esc_html__('Proin gravida nibh vel velit auctor aliquet.
Aenean sollicitudin, lorem quis bibendum auctor, nisi elit consequat ipsum, nec sagittis sem nibh id elit.
Duis sed odio sit amet nibh vulputate cursus a sit amet mauris. Morbi accumsan ipsum velit. Nam nec tellus a odio tincidunt auctor a ornare odio. Sed non mauris vitae erat consequat auctor eu in elit.', 'wpv'),
			'type' => 'editor',
			'holder' => 'textarea',
		) ,

		array(
			'name' => esc_html__( 'Icon', 'wpv' ),
			'desc' => esc_html__( 'This option overrides the "Image" option.', 'wpv' ),
			'id' => 'icon',
			'default' => '',
			'type' => 'icons',
		) ,
		array(
			'name' => esc_html__( 'Icon Color', 'wpv' ),
			'id' => 'icon_color',
			'default' => 'accent6',
			'prompt' => '',
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
			'type' => 'select',
		) ,
		array(
			'name' => esc_html__( 'Icon Size', 'wpv' ),
			'id' => 'icon_size',
			'type' => 'range',
			'default' => 62,
			'min' => 8,
			'max' => 100,
		),

		array(
			'name' => esc_html__( 'Image', 'wpv' ),
			'desc' => esc_html__( 'The image will appear above the content.', 'wpv' ),
			'id' => 'image',
			'default' => '',
			'type' => 'upload',
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
