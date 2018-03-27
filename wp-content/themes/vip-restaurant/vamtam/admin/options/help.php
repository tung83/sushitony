<?php
return array(
	'name' => esc_html__( 'Help', 'wpv' ),
	'auto' => true,
	'config' => array(

		array(
			'name' => esc_html__( 'Help', 'wpv' ),
			'type' => 'title',
			'desc' => '',
		),

		array(
			'name' => esc_html__( 'Help', 'wpv' ),
			'type' => 'start',
			'nosave' => true,
		),
//----
		array(
			'type' => 'docs',
		),

			array(
				'type' => 'end',
			),
	),
);
