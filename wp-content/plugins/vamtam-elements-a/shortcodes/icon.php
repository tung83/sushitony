<?php

function vamtam_shortcode_icon( $atts, $content = null ) {
	return vamtam_get_icon_html( $atts );
}
add_shortcode( 'icon', 'vamtam_shortcode_icon' );

function vamtam_all_icons( $atts, $content = null ) {
	$icons = array_keys( vamtam_get_icons_extended() );

	$output = '<div class="vamtam-icons-demo clearfix">'; foreach ( $icons as $i => $icon ) {
		$output .= '<div class="vamtam-grid grid-1-3 lowres-width-override lowres-grid-1-2"><div class="vamtamid-inner">'; $output .= do_shortcode( '<span class="vamtamid-the-icon">[icon name="' . $icon . '" size="24"]</span><span class="vamtamid-the-icon-name">' . $icon . '</span>' ); $output .= '</div></div>'; ;
	}
	$output .= '</div>'; return $output;
}
add_shortcode( 'all_vamtam_icons', 'vamtam_all_icons' );
