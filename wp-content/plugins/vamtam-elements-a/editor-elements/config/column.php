<?php

/**
 * Column shortcode options
 *
 * @package editor
 */

return array(
	'name' => esc_html__( 'Column - Color Box', 'wpv' ),
	'desc' => wp_kses_post( __('Once inserted into the editor you can change its width using +/- icons on the left.<br/>
	You can insert any element into by draging and dropping it onto the box. <br/>
	You can drag and drop column into column for complex layouts.<br/>
	You can move any element outside of the column by drag and drop.<br/>
	You can set color/image background on any column.
	' , 'wpv') ),
	'icon' => array(
		'char'    => Vamtam_Editor::get_icon( 'table1' ),
		'size'    => '26px',
		'lheight' => '39px',
		'family'  => 'vamtam-editor-icomoon',
	),
	'value'    => 'column',
	'controls' => 'size name clone edit delete handle',
	'options'  => array(

		array(
			'name' => esc_html__( 'Background Parallax', 'wpv' ),
			'desc' => wp_kses_post( __('The parallax effect will affect only the image background of the column not the elements you place into it.<br/>
				You can insert column into column with transparent background images and thus create multi layers parallax effects. <br/>
				Parallax - Simple, align in the middle  - the column background is positioned - center/center   when it is in the middle of the screen.<br/>
				Parallax - Fixed attachment - the column background is positioned top center when the column is at the top of the screen.<br/>
				The option bellow controls speed and direction of the animation.<br/>
				The parallax effect will be disabled on mobile devices as they do not yet properly support this animations and may cause different issues.
				', 'wpv' ) ),
			'id'      => 'parallax_bg',
			'type'    => 'select',
			'default' => 'disabled',
			'options' => array(
				'disabled'  => esc_html__( 'Disabled', 'wpv' ),
				'to-centre' => esc_html__( 'Simple, align at the middle', 'wpv' ),
				'fixed'     => esc_html__( 'Fixed attachment', 'wpv' ),
			),
			'field_filter' => 'fbprlx',
		),

		array(
			'name'    => esc_html__( 'Background Parallax Inertia', 'wpv' ),
			'desc'    => esc_html__( 'The option controls speed and direction of the animation. Minus means against the scroll direction. Plus means with the direction of the scroll. The bigger the number the higher the speed. ', 'wpv' ),
			'id'      => 'parallax_bg_inertia',
			'type'    => 'range',
			'min'     => -5,
			'max'     => 5,
			'step'    => 0.05,
			'default' => -.2,
			'class'   => 'fbprlx fbprlx-fixed fbprlx-to-centre',
		),

		array(
			'name'    => esc_html__( 'Extend Column', 'wpv' ),
			'desc'    => esc_html__( 'Extend the column to the end of the screen.', 'wpv' ),
			'id'      => 'extend',
			'type'    => 'select',
			'default' => 'disabled',
			'options' => array(
				'disabled'   => esc_html__( 'Auto', 'wpv' ),
				'background' => esc_html__( 'Column Background Only', 'wpv' ),
				'content'    => esc_html__( 'Column Content', 'wpv' ),
			),
			'class'        => 'hide-1-2 hide-1-3 hide-1-4 hide-1-5 hide 1-6 hide-2-3 hide-2-5 hide-3-4 hide-3-5 hide-4-5 hide-5-6',
			'field_filter' => 'fbe',
		),

		array(
			'name' => esc_html__( 'Background Color / Image', 'wpv' ),
			'desc' => esc_html__( 'Please note that the background image left/right positions, as well as the cover option will not work as expected if the option Full Screen Mode is ON.', 'wpv' ),
			'id'   => 'background',
			'type' => 'background',
			'only' => 'color,image,repeat,position,size,attachment',
			'sep'  => '_',
		),

		array(
			'name'    => esc_html__( 'Hide the Background Image on Lower Resolutions', 'wpv' ),
			'id'      => 'hide_bg_lowres',
			'type'    => 'toggle',
			'default' => false,
		),

		array(
			'name'    => esc_html__( 'Hide the Element on Lower Resolutions', 'wpv' ),
			'id'      => 'hide_element_lowres',
			'type'    => 'toggle',
			'default' => false,
		),

		array(
			'name'    => esc_html__( 'Child Columns Width on Lower Resolutions', 'wpv' ),
			'desc'    => esc_html__( 'This option is used for child columns with an original width of less than 1/1 only.', 'wpv' ),
			'id'      => 'lowres_child_width',
			'type'    => 'radio',
			'default' => '1-1',
			'options' => array(
				'1-1' => esc_html__( '1/1', 'wpv' ),
				'1-2' => esc_html__( '1/2', 'wpv' ),
			),
		),

		array(
			'name'  => esc_html__( 'Background Video', 'wpv' ),
			'desc'  => esc_html__( 'Insert self-hosted video. Please note that if the video is the first element below the menu, It will not work properly in Chrome. You should use Revolution Slider instead.', 'wpv' ),
			'id'    => 'background_video',
			'type'  => 'upload',
			'video' => true,
			'class' => 'fbprlx fbprlx-disabled',
		),

		array(
			'name'    => esc_html__( 'Use Left/Right Padding', 'wpv' ),
			'id'      => 'extended_padding',
			'default' => false,
			'type'    => 'toggle',
			'class'   => 'hide-inner fbe fbe-background',
		),

		array(
			'name'   => esc_html__( 'Vertical Padding', 'wpv' ),
			'desc'   => wp_kses_post( __( 'Positive values increase the blank space at the top/bottom of the column. Negative values are interpreted as setting the blank space so that the column is a certain amount of px shorter than the window. 0 means no padding.<br><br> Having both values set to a negative number will center the content vertically. In this case only the <em>top</em> value is used in the calculations.', 'wpv' ) ),
			'id'     => 'vertical_padding',
			'type'   => 'range-row',
			'ranges' => array(
				'vertical_padding_top' => array(
					'desc'    => esc_html__( 'Top', 'wpv' ),
					'default' => 0,
					'unit'    => 'px',
					'min'     => -500,
					'max'     => 500,
				),
				'vertical_padding_bottom' => array(
					'desc'    => esc_html__( 'Bottom', 'wpv' ),
					'default' => 0,
					'unit'    => 'px',
					'min'     => -500,
					'max'     => 500,
				),
			),
		),

		array(
			'name'    => esc_html__( 'Left/Right Padding', 'wpv' ),
			'id'      => 'horizontal_padding',
			'default' => 0,
			'min'     => 0,
			'max'     => 500,
			'unit'    => 'px',
			'type'    => 'range',
		),

		array(
			'name'    => esc_html__( '"Read More" Button Link (optional)', 'wpv' ),
			'desc'    => esc_html__( 'If enabled, the column will have a button on the right.', 'wpv' ),
			'id'      => 'more_link',
			'default' => '',
			'type'    => 'text',
			'class'   => 'fbe fbe-false',
		),

		array(
			'name'    => esc_html__( '"Read More" Button Text (optional)', 'wpv' ),
			'desc'    => esc_html__( 'If enabled, the column will have a button on the right.', 'wpv' ),
			'id'      => 'more_text',
			'default' => '',
			'type'    => 'text',
			'class'   => 'fbe fbe-false',
		),

		array(
			'name'    => esc_html__( 'Left Border', 'wpv' ),
			'id'      => 'left_border',
			'default' => 'transparent',
			'type'    => 'color',
		),

		array(
			'name'    => esc_html__( 'Column Ornaments', 'wpv' ),
			'id'      => 'ornaments',
			'default' => '',
			'type'    => 'select',
			'options' => array(
				''                            => esc_html__( 'None', 'wpv' ),
				'vamtam-add-ornaments-top'    => esc_html__( 'Top only', 'wpv' ),
				'vamtam-add-ornaments-bottom' => esc_html__( 'Bottom only', 'wpv' ),
				'vamtam-add-ornaments-all'    => esc_html__( 'Both top and bottom', 'wpv' ),
			),
		),

		array(
			'name'    => esc_html__( 'Class (Optional)', 'wpv' ),
			'desc'    => esc_html__( 'If you would like to add a specific class or ID for any element, you can do this by first wrapping the element in a Column, and then adding your chosen class/ID to the respective column options. In the case of the ID, you need to enter an alphanumeric string without any spaces. In the case of the Class option, you need to enter a space-separated list of classes without dots (similar to how you would use HTMLs class  attribute). If you have entered my-column-class as the columns class, you can then use the following CSS selector for this column: .my-column-class', 'wpv' ),
			'id'      => 'class',
			'default' => '',
			'type'    => 'text',
		),

		array(
			'name'    => esc_html__( 'ID (Optional)', 'wpv' ),
			'desc'    => esc_html__('If you would like to add a specific class or ID for any element, you can do this by first wrapping the element in a Column, and then adding your chosen class/ID to the respective column options. In the case of the ID, you need to enter an alphanumeric string without any spaces. In the case of the Class option, you need to enter a space-separated list of classes without dots (similar to how you would use HTMLs class attribute). If you have entered my-column-class as the columns class, you can then use the following CSS selector for this column: .my-column-class', 'wpv'),
			'id'      => 'id',
			'default' => '',
			'type'    => 'text',
		),

		array(
			'name'    => esc_html__( 'Title (optional)', 'wpv' ),
			'desc'    => esc_html__( 'The column title is placed at the top of the column.', 'wpv' ),
			'id'      => 'title',
			'default' => '',
			'type'    => 'text',
		),

		array(
			'name'    => esc_html__( 'Title Type (optional)', 'wpv' ),
			'id'      => 'title_type',
			'default' => 'single',
			'type'    => 'select',
			'options' => array(
				'single'     => esc_html__( 'Title with divider next to it', 'wpv' ),
				'double'     => esc_html__( 'Title with divider below', 'wpv' ),
				'no-divider' => esc_html__( 'No Divider', 'wpv' ),
			),
		),

		array(
			'name'    => esc_html__( 'Entrance Animation (optional)', 'wpv' ),
			'id'      => 'animation',
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
			'class' => 'fbprlx fbprlx-disabled',
		),

		array(
			'name'    => esc_html__( 'Progressive Animation (optional)', 'wpv' ),
			'id'      => 'progressive_animation',
			'default' => 'none',
			'type'    => 'select',
			'options' => array(
				'none'        => esc_html__( 'No animation', 'wpv' ),
				'fade-top'    => esc_html__( 'Fade to top', 'wpv' ),
				'fade-bottom' => esc_html__( 'Fade to bottom', 'wpv' ),
				'custom'      => esc_html__( 'Custom Tween', 'wpv' ),
			),
			'class'        => 'hidden fbprlx fbprlx-disabled',
			'field_filter' => 'fbprani',
		),

		array(
			'name'    => esc_html__( 'Progressive Animation Custom Tween', 'wpv' ),
			'desc'    => esc_html__( 'Allows you to animate to any end state. Enter a single class name which represents the end state of the element. You are responsible for setting the correct initial state.', 'wpv' ),
			'id'      => 'progressive_animation_custom',
			'default' => '',
			'type'    => 'text',
			'class'   => 'hidden fbprani fbprani-custom',
		),

	),
);
