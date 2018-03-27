<?php

function vamtam_shortcode_generator() {
	$config = array(
		'title' => esc_html__( 'Shortcodes', 'wpv' ),
		'id' => 'shortcode',
	);

	$shortcodes = apply_filters( 'vamtam_shortcode_'.$_GET['slug'], include( VAMTAM_SCGEN . $_GET['slug'] .'.php' ) );
	$generator  = new VamtamShortcodesGenerator( $config, $shortcodes );

	$generator->render();
}
add_action( 'wp_ajax_vamtam-shortcode-generator', 'vamtam_shortcode_generator' );
