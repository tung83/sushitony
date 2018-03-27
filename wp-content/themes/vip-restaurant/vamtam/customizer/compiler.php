<?php

function vamtam_recompile_css() {
	global $vamtam_theme;

	return vamtam_customizer_compiler( $vamtam_theme );
}

// "clear cache" implementation
function vamtam_actions() {
	if ( isset( $_GET['vamtam_action'] ) ) {
		if ( 'clear_cache' === $_GET['vamtam_action'] ) {
			vamtam_recompile_css();

			wp_redirect( admin_url() );
		}
	}
}
add_action( 'admin_init', 'vamtam_actions' );

// we need font-style and font-weight to be in a single variable
function vamtam_customizer_normalize_typography( $options ) {
	foreach ( $options as $name => $value ) {
		if ( is_array( $value ) && isset( $value['font-family'] ) ) {
			$options[ $name ]['font-weight'] = isset( $value['variant'] ) ? $value['variant'] : 'normal';

			unset( $options[ $name ]['variant'] );
		}
	}

	return $options;
}
add_filter( 'vamtam_customizer_compiler_options', 'vamtam_customizer_normalize_typography' );

function vamtam_customizer_compiler( $options ) {
	$status = VamtamLessBridge::compile( apply_filters( 'vamtam_customizer_compiler_options', $options ) );

	if ( $status === 0 ) {
		update_option( 'vamtam-css-cache-timestamp', time() );
	}

	return $status;
}
add_action( 'vamtam_customizer/' . $opt_name . '/compiler', 'vamtam_customizer_compiler', 10, 1 );