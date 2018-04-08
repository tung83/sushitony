<?php

add_action( 'admin_init', 'vamtam_shortcodes_tinymce' );
function vamtam_shortcodes_tinymce() {
	add_filter( 'mce_external_plugins', 'vamtam_shortcodes_tinymce_plugin' );
	add_filter( 'mce_buttons', 'vamtam_shortcodes_tinymce_button' );
}

function vamtam_shortcodes_tinymce_button( $buttons ) {
	array_push( $buttons, 'separator', 'vamtam_shortcodes' );
	return $buttons;
}

function vamtam_shortcodes_tinymce_plugin( $plugin_array ) {
	$plugin_array['vamtam_shortcodes'] = VAMTAM_ADMIN_ASSETS_URI . 'js/shortcodes_tinymce.js';
	return $plugin_array;
}

function vamtam_tinymce_lang() {
	$lang = array(
		'url'        => VAMTAM_ADMIN_AJAX . 'get_shortcodes.php',
		'button'     => '',
		'title'      => esc_html__( 'Vamtam shortcodes', 'wpv' ),
		'shortcodes' => array(),
	);

	$shortcodes = include VAMTAM_METABOXES . 'shortcode.php';

	sort( $shortcodes );

	foreach ( $shortcodes as $slug ) {
		$shortcode_options    = include VAMTAM_SCGEN . $slug . '.php';
		$lang['shortcodes'][] = array(
			'title' => $shortcode_options['name'],
			'slug'  => $slug,
		);
	}

	echo '<script>VamtamTmceShortcodes='.json_encode( $lang ).';</script>';
}
add_action( 'admin_head', 'vamtam_tinymce_lang' );
