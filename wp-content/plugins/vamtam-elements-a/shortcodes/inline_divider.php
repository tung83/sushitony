<?php

function vamtam_shortcode_inline_divider( $atts, $content = null, $code ) {
	extract(shortcode_atts(array(
		'type' => '1',
	), $atts));

	if ( '1' == $type ) {
		return '<div class="sep"></div>';
	}

	if ( '2' == $type ) {
		return '<div class="sep-2"></div>';
	}

	if ( '3' == $type ) {
		return '<div class="sep-3"></div>';
	}

	if ( 'clear' == $type ) {
		return '<div class="clearboth"></div>';
	}
}
add_shortcode( 'inline_divider', 'vamtam_shortcode_inline_divider' );
