<?php
return array(
	'name' => esc_html__( 'Service Box', 'wpv' ),
	'desc' => esc_html__( 'Please note that the service box may not work properly in one half to full width layouts.' , 'wpv' ),
	'icon' => array(
		'char' => Vamtam_Editor::get_icon( 'cog1' ),
		'size' => '30px',
		'lheight' => '45px',
		'family' => 'vamtam-editor-icomoon',
	),
	'value' => 'services',
	'controls' => 'size name clone edit delete',
	'options' => array(
		array(
			'name' => esc_html__( 'Icon', 'wpv' ),
			'desc' => esc_html__( 'This option overrides the "Image" option.', 'wpv' ),
			'id' => 'icon',
			'default' => 'apple',
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
			'class' => 'fbs fbs-true',
		),
		array(
			'name' => esc_html__( 'Icon Background', 'wpv' ),
			'id' => 'background',
			'default' => 'accent1',
			'type' => 'color',
			'class' => 'fbs fbs-false',
		),

		array(
			'name' => esc_html__( 'Image', 'wpv' ),
			'desc' => esc_html__( 'This option can be overridden by the "Icon" option.', 'wpv' ),
			'id' => 'image',
			'default' => '',
			'type' => 'upload',
		) ,

		array(
			'name' => esc_html__( 'Title', 'wpv' ),
			'id' => 'title',
			'default' => 'This is a title',
			'type' => 'text',
		) ,

		array(
			'name' => esc_html__( 'Description', 'wpv' ),
			'id' => 'html-content',
			'default' => 'Proin gravida nibh vel velit auctor aliquet. Aenean sollicitudin, lorem quis bibendum auctor, nisi elit consequat ipsum, nec sagittis sem nibh id elit. Duis sed odio sit amet nibh vulputate cursus a sit amet mauris. Morbi accumsan ipsum velit. Nam nec tellus a odio tincidunt auctor a ornare odio. Sed non mauris vitae erat consequat auctor eu in elit.',
			'type' => 'editor',
			'holder' => 'textarea',
		) ,

		array(
			'name' => esc_html__( 'Text Alignment', 'wpv' ),
			'id' => 'text_align',
			'default' => 'justify',
			'type' => 'select',
			'options' => array(
				'justify' => 'justify',
				'left' => 'left',
				'center' => 'center',
				'right' => 'right',
			),
		) ,
		array(
			'name' => esc_html__( 'Link', 'wpv' ),
			'id' => 'button_link',
			'default' => '/',
			'type' => 'text',
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
