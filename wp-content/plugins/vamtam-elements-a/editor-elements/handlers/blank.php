<?php

class Vamtam_Blank {
	public function __construct() {
		add_shortcode( 'blank', array( &$this, 'blank' ) );
		add_shortcode( 'push', array( &$this, 'blank' ) );
	}

	public function blank( $atts, $content = null, $code = '' ) {
		extract(shortcode_atts(array(
			'h'            => false,
			'hide_low_res' => false,
			'class'        => '',
		), $atts));

		$h = intval( $h );

		$type = $h < 0 ? 'margin-bottom' : 'height';

		$hide_low_res = vamtam_sanitize_bool( $hide_low_res );

		$style = "{$type}:{$h}px";

		if ( $hide_low_res ) {
			$class .= ' vamtam-hide-lowres';
		}

		$tag = 'push' === $code ? 'span' : 'div';

		return '<' . $tag . ' class="vamtam-blank-space ' . esc_attr( $class ) . '" style="' . esc_attr( $style ) . '"></' . $tag . '>';
	}
}

new VAMTAM_blank;
