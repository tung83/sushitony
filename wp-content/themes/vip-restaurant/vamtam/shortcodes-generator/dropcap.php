<?php
return array(
	'name'    => esc_html__( 'Drop Cap', 'wpv' ),
	'value'   => 'dropcap',
	'options' => array(
		array(
			'name'    => esc_html__( 'Type', 'wpv' ),
			'id'      => 'type',
			'default' => '1',
			'type'    => 'select',
			'options' => array(
				'1' => esc_html__( 'Type 1', 'wpv' ),
				'2' => esc_html__( 'Type 2', 'wpv' ),
			),
		) ,
		array(
			'name'    => esc_html__( 'Letter', 'wpv' ),
			'id'      => 'letter',
			'default' => '',
			'type'    => 'text',
		) ,
		array(
			'name'    => esc_html__( 'Text', 'wpv' ),
			'id'      => 'text',
			'default' => '',
			'type'    => 'text',
		) ,
	),
);
