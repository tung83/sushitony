<?php

/**
 * Testimonials shortcode options
 *
 * @package editor
 */

return array(
	'name' => esc_html__( 'Testimonials', 'wpv' ),
	'desc' => esc_html__( 'Please note that this element shows already created testimonials. To create one go to Testimonials tab in the WordPress main navigation menu on the left - add new.  ' , 'wpv' ),
	'icon' => array(
		'char' => Vamtam_Editor::get_icon( 'quotes-left' ),
		'size' => '30px',
		'lheight' => '45px',
		'family' => 'vamtam-editor-icomoon',
	),
	'value' => 'vamtam_testimonials',
	'controls' => 'size name clone edit delete',
	'options' => array(

		array(
			'name' => esc_html__( 'Layout', 'wpv' ),
			'id' => 'layout',
			'default' => 'slider',
			'type' => 'select',
			'options' => array(
				'slider' => esc_html__( 'Slider', 'wpv' ),
				'static' => esc_html__( 'Static', 'wpv' ),
			),
			'field_filter' => 'fbl',
		) ,
		array(
			'name' => esc_html__( 'IDs (optional)', 'wpv' ),
			'desc' => esc_html__( ' By default all testimonials are active. You can use ctr + click to select multiple IDs.', 'wpv' ),
			'id' => 'ids',
			'default' => array(),
			'target' => 'testimonials',
			'type' => 'multiselect',
		) ,

		array(
			'name' => esc_html__( 'Automatically rotate', 'wpv' ),
			'id' => 'autorotate',
			'default' => false,
			'type' => 'toggle',
			'class' => 'fbl fbl-slider',
		) ,

		array(
			'name' => esc_html__( 'Title (optional)', 'wpv' ),
			'desc' => esc_html__( 'The title is placed just above the element.', 'wpv' ),
			'id' => 'column_title',
			'default' => esc_html__( '', 'wpv' ),
			'type' => 'text',
		) ,


		array(
			'name' => esc_html__( 'Title Type (optional)', 'wpv' ),
			'id' => 'column_title_type',
			'default' => 'single',
			'type' => 'select',
			'options' => array(
				'single' => esc_html__( 'Title with devider next to it.', 'wpv' ),
				'double' => esc_html__( 'Title with devider under it.', 'wpv' ),
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
