<?php

return array(
	'name'    => esc_html__( 'Highlight', 'wpv' ),
	'value'   => 'highlight',
	'options' => array(
		array(
			'name'    => esc_html__( 'Type', 'wpv' ),
			'id'      => 'type',
			'default' => '',
			'type'    => 'select',
			'options' => array(
				'light' => esc_html__( 'light', 'wpv' ),
				'dark'  => esc_html__( 'dark', 'wpv' ),
			),
		) ,
		array(
			'name'    => esc_html__( 'Content', 'wpv' ),
			'id'      => 'content',
			'default' => '',
			'type'    => 'textarea',
		) ,
	),
);
