<?php
/**
 * Projects shortcode options
 *
 * @package editor
 */


return array(
	'name' => esc_html__( 'Projects', 'wpv' ),
	'desc' => esc_html__( 'Please note that this element displays projects which you have already created. To create one go to the Projects tab in the main WordPress navigation menu on the left - Add New. ' , 'wpv' ),
	'icon' => array(
		'char'    => Vamtam_Editor::get_icon( 'grid2' ),
		'size'    => '30px',
		'lheight' => '45px',
		'family'  => 'vamtam-editor-icomoon',
	),
	'value'    => 'vamtam_projects',
	'controls' => 'size name clone edit delete',
	'options'  => array(
		array(
			'name'    => esc_html__( 'Layout', 'wpv' ),
			'id'      => 'layout',
			'desc'    => wp_kses_post( __( 'Static - no filtering.<br/> Filtering - Enable filtering for the projects depending on their category.<br/> Srollable - shows the projects in a slider', 'wpv' ) ),
			'type'    => 'select',
			'options' => array(
				'grid'       => esc_html__( 'Static', 'wpv' ),
				'mosaic'     => esc_html__( 'Mosaic', 'wpv' ),
				'scrollable' => esc_html__( 'Scrollable', 'wpv' ),
			),
			'field_filter' => 'fbs',
		) ,
		array(
			'name'    => esc_html__( 'Item Aspect Ratio', 'wpv' ),
			'id'      => 'image_aspect_ratio',
			'default' => 'fixed',
			'type'    => 'radio',
			'class'   => 'fbs fbs-grid fbs-mosaic',
			'options' => array(
				'fixed'    => esc_html__( 'Fixed', 'wpv' ),
				'original' => esc_html__( 'Original', 'wpv' ),
			),
		) ,
		array(
			'name'    => esc_html__( 'Category Filter', 'wpv' ),
			'id'      => 'category_filter',
			'default' => false,
			'type'    => 'toggle',
			'class'   => 'fbs fbs-grid fbs-mosaic',
		) ,
		array(
			'name'    => esc_html__( 'Title Filter', 'wpv' ),
			'id'      => 'title_filter',
			'default' => false,
			'type'    => 'toggle',
			'class'   => 'fbs fbs-grid fbs-mosaic',
		) ,
		array(
			'name'    => esc_html__( 'No Paging', 'wpv' ),
			'id'      => 'nopaging',
			'desc'    => esc_html__( 'If the option is on, it will disable pagination. You can set the type of pagination in General Settings - Posts - Pagination Type. ', 'wpv' ),
			'default' => false,
			'type'    => 'toggle',
			'class'   => 'fbs fbs-grid fbs-mosaic',
		) ,
		array(
			'name'    => esc_html__( 'Columns', 'wpv' ),
			'desc'    => esc_html__( 'Set to 0 for automatic number of columns. ', 'wpv' ),
			'id'      => 'column',
			'default' => 4,
			'type'    => 'range',
			'min'     => 0,
			'max'     => 4,
		) ,
		array(
			'name'    => esc_html__( 'Limit', 'wpv' ),
			'desc'    => esc_html__( 'Number of item to show per page. If you set it to -1, it will display all projects.', 'wpv' ),
			'id'      => 'max',
			'default' => '4',
			'min'     => -1,
			'max'     => 100,
			'step'    => '1',
			'type'    => 'range',
		) ,

		array(
			'name'    => esc_html__( 'Item Link Opens', 'wpv' ),
			'id'      => 'link_opens',
			'default' => 'single',
			'type'    => 'select',
			'class'   => 'fbs fbs-mosaic',
			'options' => array(
				'single' => esc_html__( 'Single project page', 'wpv' ),
				'ajax'   => esc_html__( 'Simplified project page in a modal', 'wpv' ),
			),
		) ,

		array(
			'name'    => esc_html__( 'Display Title', 'wpv' ),
			'id'      => 'show_title',
			'desc'    => esc_html__( 'If the option is on, it will display the title of the project.', 'wpv' ),
			'default' => 'false',
			'type'    => 'select',
			'options' => array(
				'false' => esc_html__( 'No Title', 'wpv' ),
				'below' => esc_html__( 'Title on', 'wpv' ),
			),
		) ,

		array(
			'name'    => esc_html__( 'Display Description', 'wpv' ),
			'id'      => 'desc',
			'desc'    => esc_html__( 'If the option is on, it will display short description of the project.', 'wpv' ),
			'default' => false,
			'type'    => 'toggle',
		) ,

		array(
			'name'    => esc_html__( 'Project Types (optional)', 'wpv' ),
			'desc'    => esc_html__( 'All types will be shown if none are selected. Please note that if you do not see any types, it is likely that you have not created any.', 'wpv' ),
			'id'      => 'type',
			'default' => array(),
			'target'  => 'portfolio-type',
			'type'    => 'multiselect',
			'layout'  => 'checkbox',
		) ,
		array(
			'name'    => esc_html__( 'Specific Projects (optional)', 'wpv' ),
			'desc'    => esc_html__( 'All projects will be shown if none are selected. If you select any posts here, this option will override the type option above. You can use Ctrl + Click to select multiple projects.', 'wpv' ),
			'id'      => 'ids',
			'default' => array(),
			'target'  => 'portfolio',
			'type'    => 'multiselect',
		) ,

		array(
			'name'    => esc_html__( 'Title (optional)', 'wpv' ),
			'desc'    => esc_html__( 'The title is placed just above the element.', 'wpv' ),
			'id'      => 'column_title',
			'default' => '',
			'type'    => 'text',
		) ,
		array(
			'name'    => esc_html__( 'Title Type (optional)', 'wpv' ),
			'id'      => 'column_title_type',
			'default' => 'single',
			'type'    => 'select',
			'options' => array(
				'single'     => esc_html__( 'Title with divider next to it ', 'wpv' ),
				'double'     => esc_html__( 'Title with divider below', 'wpv' ),
				'no-divider' => esc_html__( 'No Divider', 'wpv' ),
			),
		) ,
	),
);
