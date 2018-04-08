<?php
return array(
	'name'    => esc_html__( 'Vertical Blank Space', 'wpv' ),
	'value'   => 'push',
	'options' => array(
		array(
			'name'    => esc_html__( 'Height', 'wpv' ),
			'id'      => 'h',
			'default' => 30,
			'min'     => -200,
			'max'     => 200,
			'type'    => 'range',
		) ,
		array(
			'name'    => esc_html__( 'Hide on Low Resolutions', 'wpv' ),
			'id'      => 'hide_low_res',
			'default' => false,
			'type'    => 'toggle',
		) ,
		array(
			'name'    => esc_html__( 'Class', 'wpv' ),
			'id'      => 'class',
			'default' => '',
			'type'    => 'text',
		) ,
	),
);
