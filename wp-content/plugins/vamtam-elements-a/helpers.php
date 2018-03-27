<?php

function vamtam_sub_shortcode( $name, $content, &$params, &$sub_contents ) {
	if ( ! preg_match_all( "/\[$name\b(?P<params>.*?)(?:\/)?\](?:(?P<contents>.*?)\[\/$name\])?/s", $content, $matches ) ) {
		return false;
	}

	$params = array();
	$sub_contents = $matches['contents'];

	// this is from wp-includes/formatting.php
	/* translators: opening curly double quote */
	$opening_quote = esc_html_x( '&#8220;', 'opening curly double quote', 'default' );
	/* translators: closing curly double quote */
	$closing_quote = esc_html_x( '&#8221;', 'closing curly double quote', 'default' );
	/* translators: double prime, for example in 9" (nine inches) */
	$double_prime = esc_html_x( '&#8243;', 'double prime', 'default' );

	foreach ( $matches['params'] as $param_str ) {
		$param_str = str_replace( array( $opening_quote, $closing_quote, $double_prime, '&#8220;', '&#8221;' ), '"', $param_str );
		$params[]  = shortcode_parse_atts( $param_str );
	}

	return true;
}

// manual css cache regeneration
function vamtam_setup_adminbar() {
	if ( ! current_user_can( 'edit_theme_options' ) || ! class_exists( 'VamtamFramework' ) ) {
		return;
	}

	global $wp_admin_bar;

	$wp_admin_bar->add_menu( array(
		'parent' => false,
		'id'     => 'vamtam_theme_options',
		'title'  => esc_html__( 'VamTam', 'wpv' ),
		'href'   => '',
		'meta'   => false,
	) );

	$wp_admin_bar->add_menu(array(
		'parent' => 'vamtam_theme_options',
		'id'     => 'vamtam_clear_css_cache',
		'title'  => esc_html__( 'Clear Cache', 'wpv' ),
		'href'   => admin_url( 'admin.php?vamtam_action=clear_cache' ),
		'meta'   => false,
	) );
}
add_action( 'wp_before_admin_bar_render', 'vamtam_setup_adminbar', 11 );
