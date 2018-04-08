<?php

class Vamtam_Divider {
	public function __construct() {
		add_shortcode( 'divider', array( &$this, 'divider' ) );
	}

	public function divider( $atts, $content = null, $code ) {
		extract(shortcode_atts(array(
			'type' => '1',
		), $atts));

		$output = '';

		if ( $type === '1' ) {
			$output = '<div class="sep"></div>';
		}

		if ( $type === '2' ) {
			$output = '<div class="sep-2"></div>';
		}

		if ( $type === '3' ) {
			$output = '<div class="sep-3"></div>';
		}

		if ( $type === 'clear' ) {
			return '<div class="clearboth"></div>';
		}

		// no .limit-wrapper necessary if in column
		if ( isset( $GLOBALS['vamtam_column_stack'] ) && count( $GLOBALS['vamtam_column_stack'] ) > 0 ) {
			return $output;
		}

		return '<div class="limit-wrapper">' . $output . '</div>';
	}
}

new Vamtam_Divider;
