<?php

/**
 * Theme options / Styles / Skins
 *
 * @package vip-restaurant
 */

return array(
	array(
		'label'       => esc_html__( 'Export/Import Skins', 'wpv' ),
		'description' => esc_html__( 'If you use the same name as a previously saved skin it will overwrite the latter.', 'wpv' ),
		'type'        => 'skins',
		'id'          => 'export-import-skins',
	),
);
