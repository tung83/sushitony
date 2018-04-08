<?php
return 	array(
	'name' => esc_html__( 'Team Member', 'wpv' ),
	'icon' => array(
		'char'    => Vamtam_Editor::get_icon( 'profile' ),
		'size'    => '26px',
		'lheight' => '39px',
		'family'  => 'vamtam-editor-icomoon',
	),
	'value'    => 'team_member',
	'controls' => 'size name clone edit delete',
	'options'  => array(

		array(
			'name'    => esc_html__( 'Name', 'wpv' ),
			'id'      => 'name',
			'default' => 'Nikolay Yordanov',
			'type'    => 'text',
			'holder'  => 'h5',
		),
		array(
			'name'    => esc_html__( 'Position', 'wpv' ),
			'id'      => 'position',
			'default' => 'Web Developer',
			'type'    => 'text',
		),
		array(
			'name'    => esc_html__( 'Link', 'wpv' ),
			'id'      => 'url',
			'default' => '/',
			'type'    => 'text',
		),
		array(
			'name'    => esc_html__( 'Email', 'wpv' ),
			'id'      => 'email',
			'default' => 'support@vamtam.com',
			'type'    => 'text',
		),
		array(
			'name'    => esc_html__( 'Phone', 'wpv' ),
			'id'      => 'phone',
			'default' => '+448786562223',
			'type'    => 'text',
		),
		array(
			'name'    => esc_html__( 'Picture', 'wpv' ),
			'id'      => 'picture',
			'default' => '',
			'type'    => 'upload',
		),

		array(
			'name'    => esc_html__( 'Biography', 'wpv' ),
			'id'      => 'html-content',
			'default' => esc_html__( 'Proin gravida nibh vel velit auctor aliquet. Aenean sollicitudin, lorem quis bibendum auctor, nisi elit consequat ipsum, nec sagittis sem nibh id elit. Duis sed odio sit amet nibh vulputate cursus a sit amet mauris. Morbi accumsan ipsum velit. Nam nec tellus a odio tincidunt auctor a ornare odio. Sed non mauris vitae erat consequat auctor eu in elit.', 'wpv' ),
			'type'    => 'editor',
			'holder'  => 'textarea',
		) ,

		array(
			'name'    => esc_html__( 'Google+', 'wpv' ),
			'id'      => 'googleplus',
			'default' => '/',
			'type'    => 'text',
		),
		array(
			'name'    => esc_html__( 'LinkedIn', 'wpv' ),
			'id'      => 'linkedin',
			'default' => '',
			'type'    => 'text',
		),
		array(
			'name'    => esc_html__( 'Facebook', 'wpv' ),
			'id'      => 'facebook',
			'default' => '/',
			'type'    => 'text',
		),
		array(
			'name'    => esc_html__( 'Twitter', 'wpv' ),
			'id'      => 'twitter',
			'default' => '/',
			'type'    => 'text',
		),
		array(
			'name'    => esc_html__( 'YouTube', 'wpv' ),
			'id'      => 'youtube',
			'default' => '/',
			'type'    => 'text',
		),
		array(
			'name'    => esc_html__( 'Pinterest', 'wpv' ),
			'id'      => 'pinterest',
			'default' => '/',
			'type'    => 'text',
		),
		array(
			'name'    => esc_html__( 'LastFM', 'wpv' ),
			'id'      => 'lastfm',
			'default' => '/',
			'type'    => 'text',
		),
		array(
			'name'    => esc_html__( 'Instagram', 'wpv' ),
			'id'      => 'instagram',
			'default' => '/',
			'type'    => 'text',
		),
		array(
			'name'    => esc_html__( 'Dribble', 'wpv' ),
			'id'      => 'dribble',
			'default' => '/',
			'type'    => 'text',
		),
		array(
			'name'    => esc_html__( 'Vimeo', 'wpv' ),
			'id'      => 'vimeo',
			'default' => '/',
			'type'    => 'text',
		),

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
