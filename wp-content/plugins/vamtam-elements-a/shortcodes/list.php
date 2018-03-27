<?php

function vamtam_shortcode_list( $atts, $content = null, $code ) {
	extract(shortcode_atts(array(
		'style' => false,
		'color' => '',
	), $atts));

	if ($color)
		$color = ' icon-'.$color;

	$icon_font = vamtam_get_icon_type( $style );

	$content = str_replace( '<li>', '<li class="">', do_shortcode( $content ) );
	$content = preg_replace( '/(<li .*?class="[^"]*)"/', '$1 icon-b ' . $icon_font . '" data-icon="' . vamtam_get_icon( $style ) . '"', $content );

	return str_replace( '<ul>', '<ul class="styled-list '.$color.'">', $content );
}
add_shortcode( 'list', 'vamtam_shortcode_list' );
