<?php

/**
 * Theme options / General / Projects
 *
 * @package vip-restaurant
 */

return array(
	array(
		'label'       => esc_html__( 'Show "Related Projects" in Single Project View', 'wpv' ),
		'description' => esc_html__( 'Enabling this option will show more projects from the same type in the single project.', 'wpv' ),
		'id'          => 'show-related-portfolios',
		'type'        => 'switch',
		'transport'   => 'postMessage',
	),

	array(
		'label'     => esc_html__( '"Related Projects" title', 'wpv' ),
		'id'        => 'related-portfolios-title',
		'type'      => 'text',
		'transport' => 'postMessage',
	),
);