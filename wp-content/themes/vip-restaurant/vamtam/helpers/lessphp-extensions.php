<?php

/**
 *
 * Extensions to the LESSPHP compiler
 *
 * This file *must* be included after lessphp has been initialized
 *
 * It is assumed that the lessphp instance is available as $l
 *
 * @package vip-restaurant
 */

if ( ! function_exists( 'vamtam_get_icon_list' ) ) {
	/**
	 * Returns the list of Icomoon icons
	 * @return array list of icons
	 */
	function vamtam_get_icon_list() {
		if ( ! isset( $GLOBALS['VAMTAM_ICONS_CACHE'] ))
			$GLOBALS['VAMTAM_ICONS_CACHE'] = include BASEPATH . 'vamtam/assets/fonts/icons/list.php';

		return $GLOBALS['VAMTAM_ICONS_CACHE'];
	}

	/**
	 * Returns the list of theme icons
	 * @return array list of icons
	 */
	function vamtam_get_theme_icon_list() {
		if ( ! isset( $GLOBALS['VAMTAM_THEME_ICONS_CACHE'] ))
			$GLOBALS['VAMTAM_THEME_ICONS_CACHE'] = include BASEPATH . 'vamtam/assets/fonts/theme-icons/list.php';

		return $GLOBALS['VAMTAM_THEME_ICONS_CACHE'];
	}
}

if ( ! function_exists( 'vamtam_lessphp_icon' ) ) {
	/**
	 * icon() function for LESSPHP
	 *
	 * @param  string $arg icon name
	 * @return array       LESSPHP token
	 */
	function vamtam_lessphp_icon( $arg ) {
		list($type, $icon) = $arg;

		$icons = vamtam_get_icon_list();
		$theme_icons = vamtam_get_theme_icon_list();

		if (isset( $icons[ $icon ] ))
			$icon = '\\'.dechex( $icons[ $icon ] );

		$theme_icon = preg_replace( '/^theme-/', '', $icon, 1 );
		if (isset( $theme_icons[ $theme_icon ] ))
			$icon = '\\'.dechex( $theme_icons[ $theme_icon ] );

		return array( 'string', '"', array( $icon ) );
	}
}
// deliberately left outside the is statement above
// this simplifies the CLI compiler
$l->registerFunction( 'icon', 'vamtam_lessphp_icon' );
