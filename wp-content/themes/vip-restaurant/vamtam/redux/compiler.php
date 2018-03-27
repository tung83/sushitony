<?php

// compiler, used for previews
function vamtam_redux_customizer_compiler( $options ) {
	vamtam_redux_compiler( $options );

	return $options;
}

if ( isset( $_POST['wp_customize'] ) && $_POST['wp_customize'] == 'on' && isset( $_POST['customized'] ) && ! empty( $_POST['customized'] ) && ! isset( $_POST['action'] ) ) {
	global $vamtam_theme;

	$options  = json_decode( stripslashes_deep( $_POST['customized'] ), true );
	$compiler = false;
	$changed  = false;

	foreach ( $options as $key => $value ) {
		if ( strpos( $key, $opt_name ) !== false ) {
			$key = str_replace( $opt_name . '[', '', rtrim( $key, ']' ) );

			if ( ! isset( $vamtam_theme[ $key ] ) || $vamtam_theme[ $key ] != $value || ( isset( $vamtam_theme[ $key ] ) && ! empty( $vamtam_theme[ $key ] ) && empty( $value ) ) ) {
				$vamtam_theme[ $key ] = $value;
				$changed              = true;

				// if ( isset( $this->parent->compiler_fields[ $key ] ) ) {
					$compiler = true;
				// }
			}
		}
	}

	if ( $changed && $compiler ) {
		$GLOBALS['vamtam_less_preview'] = true;
		add_filter( "redux/options/{$opt_name}/options", 'vamtam_redux_customizer_compiler', 1000 );
	}
}
