<?php
return array(
	'name' => esc_html__( 'Divider', 'wpv' ),
	'value' => 'inline_divider',
	'options' => array(
		array(
			'name'    => esc_html__( 'Type', 'wpv' ),
			'desc'    => wp_kses_post( __( '"Clear floats" is just a div element with <em>clear:both</em> styles. Although it is safe to say that unless you already know how to use it, you will not need this, you can <a href="https://developer.mozilla.org/en-US/docs/CSS/clear">click here for a more detailed description</a>.', 'wpv' ) ),
			'id'      => 'type',
			'default' => 1,
			'options' => array(
				1       => esc_html__( 'Divider line (1)', 'wpv' ),
				2       => esc_html__( 'Divider line (2)', 'wpv' ),
				3       => esc_html__( 'Divider line (3)', 'wpv' ),
				'clear' => esc_html__( 'Clear floats', 'wpv' ),
			),
			'type'  => 'select',
			'class' => 'add-to-container',
		) ,
	),
);
