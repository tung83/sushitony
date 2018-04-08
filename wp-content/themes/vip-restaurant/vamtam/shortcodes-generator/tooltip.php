<?php
return 	array(
	'name'    => 'Tooltip',
	'value'   => 'tooltip',
	'options' => array(
		array(
			'name'    => esc_html__( 'Tooltip content', 'wpv' ),
			'id'      => 'tooltip_content',
			'default' => '',
			'type'    => 'textarea',
		),
		array(
			'name'    => esc_html__( 'Tooltip trigger', 'wpv' ),
			'id'      => 'content',
			'default' => '',
			'type'    => 'textarea',
		),
	),
);
