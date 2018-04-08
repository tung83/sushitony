<?php

return array(
	'name'    => esc_html__( 'Styled List', 'wpv' ),
	'value'   => 'list',
	'options' => array(
		array(
			'name'    => esc_html__( 'Style', 'wpv' ),
			'id'      => 'style',
			'default' => '',
			'type'    => 'icons',
		) ,
		array(
			'name'    => esc_html__( 'Color', 'wpv' ),
			'id'      => 'color',
			'default' => '',
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
			'name'    => esc_html__( 'Content', 'wpv' ),
			'desc'    => esc_html__( 'Please insert a valid HTML unordered list', 'wpv' ),
			'id'      => 'content',
			'type'    => 'textarea',
			'default' => wp_kses_post( __( '<ul>
                <li>list item</li>
                <li>another item</li>
            </ul>', 'wpv' ) ),
		) ,
	),
);
