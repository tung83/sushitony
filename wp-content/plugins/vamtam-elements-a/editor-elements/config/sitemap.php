<?php
return array(
	'name' => 'Sitemap',
	'icon' => array(
		'char'    => Vamtam_Editor::get_icon( 'list' ),
		'size'    => '30px',
		'lheight' => '45px',
		'family'  => 'vamtam-editor-icomoon',
	),
	'value'    => 'sitemap',
	'controls' => 'size name clone edit delete',
	'class'    => 'slim',
	'options'  => array(
		array(
			'name' => esc_html__( 'General', 'wpv' ),
			'type' => 'separator',
		),
			array(
				'name'    => esc_html__( 'Filter', 'wpv' ),
				'id'      => 'shows',
				'default' => array(),
				'options' => array(
					'pages'      => esc_html__( 'Pages', 'wpv' ),
					'categories' => esc_html__( 'Categories', 'wpv' ),
					'posts'      => esc_html__( 'Posts', 'wpv' ),
					'projects'   => esc_html__( 'Projects', 'wpv' ),
				),
				'type'   => 'multiselect',
				'layout' => 'checkbox',
			) ,

			array(
				'name' => esc_html__( 'Limit', 'wpv' ),
				'desc' => wp_kses_post( __( 'Sets the number of items to display.<br>leaving this setting as 0 displays all items.', 'wpv' ) ),
				'id' => 'number',
				'default' => 0,
				'min' => 0,
				'max' => 200,
				'type' => 'range',
			) ,

			array(
				'name'    => esc_html__( 'Depth', 'wpv' ),
				'desc'    => wp_kses_post( __( 'This parameter controls how many levels in the hierarchy are to be included. <br> 0: Displays pages at any depth and arranges them hierarchically in nested lists<br> -1: Displays pages at any depth and arranges them in a single, flat list<br> 1: Displays top-level Pages only<br> 2, 3, ... Displays Pages to the given depth', 'wpv' ) ),
				'id'      => 'depth',
				'default' => 0,
				'min'     => - 1,
				'max'     => 5,
				'type'    => 'range',
			) ,

		array(
			'name' => esc_html__( 'Posts and projects', 'wpv' ),
			'type' => 'separator',
		),
			array(
				'name'    => esc_html__( 'Show comments', 'wpv' ),
				'id'      => 'show_comment',
				'desc'    => '',
				'default' => true,
				'type'    => 'toggle',
			) ,
			array(
				'name'    => esc_html__( 'Specific post categories', 'wpv' ),
				'id'      => 'post_categories',
				'default' => array(),
				'target'  => 'cat',
				'type'    => 'multiselect',
			) ,
			array(
				'name'    => esc_html__( 'Specific posts', 'wpv' ),
				'desc'    => esc_html__( 'The specific posts you want to display', 'wpv' ),
				'id'      => 'posts',
				'default' => array(),
				'target'  => 'post',
				'type'    => 'multiselect',
			) ,
			array(
				'name'    => esc_html__( 'Specific project types', 'wpv' ),
				'id'      => 'portfolio_type',
				'default' => array(),
				'target'  => 'portfolio-type',
				'type'    => 'multiselect',
			) ,

		array(
			'name' => esc_html__( 'Categories', 'wpv' ),
			'type' => 'separator',
		),
			array(
				'name'    => esc_html__( 'Show Count', 'wpv' ),
				'id'      => 'show_count',
				'desc'    => esc_html__( 'Toggles the display of the current count of posts in each category.', 'wpv' ),
				'default' => true,
				'type'    => 'toggle',
			) ,
			array(
				'name'    => esc_html__( 'Show Feed', 'wpv' ),
				'id'      => 'show_feed',
				'desc'    => wp_kses_post( __( "Display a link to each category's <a href='http://codex.wordpress.org/Glossary#RSS' target='_blank'>rss-2</a> feed.", 'wpv' ) ),
				'default' => true,
				'type'    => 'toggle',
			) ,

		array(
			'name'    => esc_html__( 'Title', 'wpv' ),
			'desc'    => esc_html__( 'The column title is placed just above the element.', 'wpv' ),
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
				'single'     => esc_html__( 'Title with divider next to it', 'wpv' ),
				'double'     => esc_html__( 'Title with divider below', 'wpv' ),
				'no-divider' => esc_html__( 'No Divider', 'wpv' ),
			),
		) ,
	),
);
