<?php

/**
 * Slogan shortcode options
 *
 * @package editor
 */

return array(
	'name' => esc_html__( 'Call Out Box', 'wpv' ),
	'desc' => esc_html__( 'You can place the call out box into а column - color box elemnent in order to have background color.' , 'wpv' ),
	'icon' => array(
		'char' => Vamtam_Editor::get_icon( 'font-size' ),
		'size' => '30px',
		'lheight' => '45px',
		'family' => 'vamtam-editor-icomoon',
	),
	'value' => 'slogan',
	'controls' => 'size name clone edit delete handle',
	'options' => array(
		array(
			'name' => esc_html__( 'Content', 'wpv' ),
			'id' => 'html-content',
			'default' => '<h1>' . esc_html__( 'You can place your call out box text here', 'wpv' ) .'</h1>',
			'type' => 'editor',
			'holder' => 'textarea',
		) ,
		array(
			'name' => esc_html__( 'Button Text', 'wpv' ),
			'id' => 'button_text',
			'default' => 'Button Text',
			'type' => 'text',
		) ,
		array(
			'name' => esc_html__( 'Button Link', 'wpv' ),
			'id' => 'link',
			'default' => '',
			'type' => 'text',
		) ,
		array(
			'name' => esc_html__( 'Button Icon', 'wpv' ),
			'id' => 'button_icon',
			'default' => 'cart',
			'type' => 'icons',
		) ,
		array(
			'name' => esc_html__( 'Button Icon Style', 'wpv' ),
			'type' => 'select-row',
			'selects' => array(
				'button_icon_color' => array(
					'desc' => esc_html__( 'Color:', 'wpv' ),
					'default' => 'accent 1',
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
				),
				'button_icon_placement' => array(
					'desc' => esc_html__( 'Placement:', 'wpv' ),
					'default' => 'left',
					'options' => array(
						'left' => esc_html__( 'Left', 'wpv' ),
						'right' => esc_html__( 'Right', 'wpv' ),
					),
				),
				),
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
