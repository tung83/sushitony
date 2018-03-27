<?php

/**
 * CSS-related helpers
 *
 * @package vip-restaurant
 */

/**
 * Map an accent name to its value
 *
 * @param  string      $color           accent name
 * @param  string|bool $support_preview false if customizer preview not supported, 'less' if a LESS variable is required, truthy if CSS variable required
 * @return string                       hex color or the input string
 */
function vamtam_sanitize_accent( $color, $support_preview = false ) {
	if ( preg_match( '/accent(?:-color-)?(\d)/i', $color, $matches ) ) {
		$num     = (int) $matches[1];

		if ( is_customize_preview() && $support_preview !== false && vamtam_use_accent_preview() ) {
			if ( $support_preview === 'less' ) {
				$color = "@accent-color-{$num}";
			} else {
				$color = "var( --vamtam-accent-color-{$num} )";
			}
		} else {
			$accents = rd_vamtam_get_option( 'accent-color' );
			$color   = $accents[ $num ];
		}
	}

	return $color;
}
