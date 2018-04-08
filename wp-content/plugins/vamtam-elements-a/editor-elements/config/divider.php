<?php
return array(
	'name' => esc_html__( 'Divider', 'wpv' ),
	'icon' => array(
		'char'    => Vamtam_Editor::get_icon( 'minus' ),
		'size'    => '30px',
		'lheight' => '45px',
		'family'  => 'vamtam-editor-icomoon',
	),
	'value'    => 'divider',
	'controls' => 'name clone edit delete',
	'options'  => array(
		array(
			'name'    => esc_html__( 'Type', 'wpv' ),
			'desc'    => wp_kses_post( __( '"Clear floats" is just a div element with <em>clear:both</em> styles. Although it is safe to say that unless you already know how to use it, you will not need this, you can <a href="https://developer.mozilla.org/en-US/docs/CSS/clear">click here for a more detailed description</a>.', 'wpv' ) ),
			'id'      => 'type',
			'default' => 1,
			'options' => array(
				1       => esc_html__( 'Divider line 1 px with accent line', 'wpv' ),
				2       => esc_html__( 'Divider double lines', 'wpv' ),
				3       => esc_html__( 'Divider line 1 px', 'wpv' ),
				'clear' => esc_html__( 'Clear floats', 'wpv' ),
			),
			'type' => 'select',
			'class' => 'add-to-container',
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
