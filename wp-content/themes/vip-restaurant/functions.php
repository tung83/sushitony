<?php

/**
 * Theme functions. Initializes the Vamtam Framework.
 *
 * @package vip-restaurant
 */

require_once get_template_directory() . '/vamtam/classes/framework.php';

new VamtamFramework( array(
	'name' => 'vip-restaurant',
	'slug' => 'vip-restaurant',
) );

// TODO remove next line when the editor is fully functional, to be packaged as a standalone module with no dependencies to the theme
define( 'VAMTAM_EDITOR_IN_THEME', true ); include_once VAMTAM_THEME_DIR . 'vamtam-editor/editor.php';

// only for one page home demos
function vamtam_onepage_menu_hrefs( $atts, $item, $args ) {
	if ( 'custom' === $item->type && 0 === strpos( $atts['href'], '/#' ) ) {
		$atts['href'] = $GLOBALS['vamtam_inner_path'] . $atts['href'];
	}
	return $atts;
}

if ( ( $path = parse_url( get_home_url(), PHP_URL_PATH ) ) !== null ) {
	$GLOBALS['vamtam_inner_path'] = untrailingslashit( $path );
	add_filter( 'nav_menu_link_attributes', 'vamtam_onepage_menu_hrefs', 10, 3 );
}

remove_action( 'admin_head', 'jordy_meow_flattr', 1 );

require_once VAMTAM_DIR . 'customizer/setup.php';

require_once VAMTAM_DIR . 'customizer/preview.php';

function vamtam_ninja_starter_form( $contents ) {
	return vamtam_silent_get_contents( VAMTAM_SAMPLES_DIR . 'ninja-forms/1.nff' );
}
add_filter( 'ninja_forms_starter_form_contents', 'vamtam_ninja_starter_form' );

// this filter fixes some invalid HTML generated by the third-party plugins
add_filter( 'vamtam_escaped_shortcodes', 'vamtam_shortcode_compat_fix' );
function vamtam_shortcode_compat_fix( $codes ) {
	$codes[] = 'add_foodpress_menu';
	$codes[] = 'gallery';

	return $codes;
}

