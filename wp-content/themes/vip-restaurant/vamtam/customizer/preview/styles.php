<?php

global $wp_customize;

// all compiler options

function vamtam_partial_custom_css() {
	global $vamtam_theme;

	$GLOBALS['vamtam_less_preview'] = true;

	VamtamLessBridge::compile( apply_filters( 'vamtam_customizer_compiler_options', $vamtam_theme ) );

	$fonts = '@import url("' . vamtam_customizer_preview_fonts_url() . '");';

	echo "<style id='front-all-css'>" . $fonts . vamtam_silent_get_contents( VAMTAM_CACHE_DIR . 'all-' . ( is_multisite() ? $GLOBALS['blog_id'] : '' ) . 'preview.css' ) . '</style>'; // xss ok
}

$compiler_options = vamtam_custom_css_options();

$wp_customize->selective_refresh->add_partial( 'vamtam-custom-css-partial', array(
	'selector'            => '#front-all-css',
	'settings'            => $compiler_options,
	'container_inclusive' => true,
	'render_callback'     => 'vamtam_partial_custom_css',
) );

// all typography options

$typography_options  = $GLOBALS['vamtam_theme_customizer']->get_fields_by_type( 'typography' );

function vamtam_customizer_preview_fonts_url() {
	global $vamtam_fonts, $vamtam_theme;

	$fonts_by_family = vamtam_get_fonts_by_family();

	$google_fonts = array();

	$typography_options  = $GLOBALS['vamtam_theme_customizer']->get_fields_by_type( 'typography' );

	foreach ( $typography_options as $id => $field ) {
		$font_id = $fonts_by_family[ $vamtam_theme[ $id ]['font-family'] ];
		$font    = $vamtam_fonts[ $font_id ];

		if ( isset( $font['gf'] ) && $font['gf'] ) {
			$google_fonts[ $font_id ][] = isset( $vamtam_theme[ $id ]['variant'] ) ? $vamtam_theme[ $id ]['variant'] : 'normal';
		}
	}

	$font_imports_url = Vamtam_Customizer::build_google_fonts_url( $google_fonts, $vamtam_theme['gfont-subsets'] );

	return $font_imports_url;
}

// accents

$wp_customize->selective_refresh->add_partial( 'vamtam-accents-partial', array(
	'selector'            => '#vamtam-accents',
	'settings'            => 'vamtam_theme[accent-color]',
	'container_inclusive' => true,
	'render_callback'     => array( 'VamtamEnqueues', 'print_accents' ),
) );