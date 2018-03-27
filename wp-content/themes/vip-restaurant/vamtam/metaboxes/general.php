<?php
/**
 * Vamtam Post Options
 *
 * @package vip-restaurant
 */

return array(

array(
	'name' => esc_html__( 'Layout and Styles', 'wpv' ),
	'type' => 'separator',
),

array(
	'name'    => esc_html__( 'Page Slider', 'wpv' ),
	'desc'    => esc_html__( 'In the drop down you will see the sliders that you have created. Please note that the theme uses Revolution Slider and its option panel is found in the WordPress navigation menu on the left.', 'wpv' ),
	'id'      => 'slider-category',
	'type'    => 'select',
	'default' => '',
	'prompt'  => esc_html__( 'Disabled', 'wpv' ),
	'options' => VamtamTemplates::get_all_sliders(),
),

array(
	'name'        => esc_html__( 'Show Splash Screen', 'wpv' ),
	'desc'        => esc_html__( 'This option is useful if you have video backgrounds, featured slider, galleries or other elements that may load slowly.', 'wpv' ),
	'id'          => 'show-splash-screen-local',
	'type'        => 'toggle',
	'default'     => 'default',
	'has_default' => true,
),

array(
	'name'    => esc_html__( 'Header Featured Area', 'wpv' ),
	'desc'    => esc_html__( 'The contents of this option are placed below the header slider, even if the slider is disabled. You can place plain text or HTML into it.', 'wpv' ),
	'id'      => 'page-middle-header-content',
	'type'    => 'textarea',
	'default' => '',
),

array(
	'name'    => esc_html__( 'Full Width Header Featured Area', 'wpv' ),
	'desc'    => esc_html__( 'Extend the featured area to the end of the screen. This is basicly a full screen mode.', 'wpv' ),
	'id'      => 'page-middle-header-content-fullwidth',
	'type'    => 'toggle',
	'default' => 'false',
),

array(
	'name'    => esc_html__( 'Header Featured Area Minimum Height', 'wpv' ),
	'desc'    => esc_html__( 'Please note that this option does not affect the slider height. The slider height is controled from the LayerSlider option panel.', 'wpv' ),
	'id'      => 'page-middle-header-min-height',
	'type'    => 'range',
	'default' => 0,
	'min'     => 0,
	'max'     => 1000,
	'unit'    => 'px',
),

array(
	'name'  => esc_html__( 'Featured Area / Slider Background', 'wpv' ),
	'desc'  => esc_html__( 'This option is used for the featured area and header slider.<br>If you want to use an image as a background, enabling the cover button will resize and crop the image so that it will always fit the browser window on any resolution.', 'wpv' ),
	'id'    => 'local-title-background',
	'type'  => 'background',
	'show'  => 'color,image,repeat,size',
),

array(
	'name'    => esc_html__( 'Sticky Header Behaviour', 'wpv' ),
	'id'      => 'sticky-header-type',
	'type'    => 'select',
	'default' => 'normal',
	'desc'    => esc_html__( 'Please make sure you have the sticky header enabled in theme options - layout - header.', 'wpv' ),
	'options' => array(
		'normal'    => esc_html__( 'Normal', 'wpv' ),
		'over'      => esc_html__( 'Over the page content', 'wpv' ),
		'half-over' => esc_html__( 'Bottom part over the page content', 'wpv' ),
	),
),

array(
	'name'    => esc_html__( 'Show Page Title Area', 'wpv' ),
	'desc'    => esc_html__( 'Enables the area used by the page title.', 'wpv' ),
	'id'      => 'show-page-header',
	'type'    => 'toggle',
	'default' => true,
),

array(
	'name'    => esc_html__( 'Page Title Layout', 'wpv' ),
	'id'      => 'local-page-title-layout',
	'type'    => 'select',
	'desc'    => esc_html__( 'The first row is the Title, the second row is the Description. The description can be added in the local option panel just below the editor.', 'wpv' ),
	'default' => '',
	'prompt'  => esc_html__( 'Default', 'wpv' ),
	'options' => array(
		'centered'      => esc_html__( 'Two rows, centered', 'wpv' ),
		'one-row-left'  => esc_html__( 'One row, title on the left', 'wpv' ),
		'one-row-right' => esc_html__( 'One row, title on the right', 'wpv' ),
		'left-align'    => esc_html__( 'Two rows, left-aligned', 'wpv' ),
		'right-align'   => esc_html__( 'Two rows, right-aligned', 'wpv' ),
	),
),

array(
	'name'  => esc_html__( 'Page Title Background', 'wpv' ),
	'id'    => 'local-page-title-background',
	'type'  => 'background',
	'show'  => 'color,image,repeat,size,attachment',
),

array(
	'name'    => esc_html__( 'Page Title Shadow', 'wpv' ),
	'id'      => 'has-page-title-shadow',
	'type'    => 'toggle',
	'default' => false,
),

array(
	'name'  => esc_html__( 'Page Title Color Override', 'wpv' ),
	'id'    => 'local-page-title-color',
	'type'  => 'color',
),

array(
	'name'    => esc_html__( 'Description', 'wpv' ),
	'desc'    => esc_html__( 'The text will appear next or bellow the title of the page, only if the option above is enabled.', 'wpv' ),
	'id'      => 'description',
	'type'    => 'textarea',
	'default' => '',
),

array(
	'name' => esc_html__( 'Page Background', 'wpv' ),
	'desc' => wp_kses_post( __('Please note that this option is used only in boxed layout mode.<br>
In full width layout mode the page background is covered by the header, slider, body and footer backgrounds respectively. If the color opacity of these areas is 1 or an opaque image is used, the page background won\'t be visible.<br>
If you want to use an image as a background, enabling the cover button will resize and crop the image so that it will always fit the browser window on any resolution.<br>
You can override this option on a page by page basis.', 'wpv') ),
	'id'   => 'background',
	'type' => 'background',
	'show' => 'color,image,repeat,size,attachment',
),

array(
	'name' => esc_html__( 'Body Background', 'wpv' ),
	'desc' => esc_html__( 'If you want to use an image as a background, enabling the cover button will resize and crop the image so that it will always fit the browser window on any resolution. If the color opacity  is less than 1 the page background underneath will be visible.', 'wpv' ),
	'id'   => 'local-main-background',
	'type' => 'background',
	'show' => 'color,image,repeat,size,attachment',
),

array(
	'name'    => esc_html__( 'Page Vertical Padding', 'wpv' ),
	'id'      => 'page-vertical-padding',
	'type'    => 'select',
	'default' => 'both',
	'options' => array(
		'both'        => esc_html__( 'Both top and bottom padding', 'wpv' ),
		'top-only'    => esc_html__( 'Only top padding', 'wpv' ),
		'bottom-only' => esc_html__( 'Only bottom padding', 'wpv' ),
		'none'        => esc_html__( 'No vertical padding', 'wpv' ),
	),
),

);
