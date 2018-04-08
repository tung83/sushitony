<?php

class Vamtam_Progress {
	public function __construct() {
		add_shortcode( 'vamtam_progress', array( __CLASS__, 'shortcode' ) );
	}

	public static function shortcode( $atts, $content = null, $code ) {
		extract(shortcode_atts(array(
			'type'         => 'percentage',
			'value'        => 0,
			'before_value' => '',
			'after_value'  => '',
			'percentage'   => 0,
			'bar_color'    => 'accent1',
			'track_color'  => 'accent7',
			'value_color'  => 'accent2',
			'icon'         => '',
		), $atts));

		$value_color = 'color:' . vamtam_sanitize_accent( $value_color, 'css' );

		wp_enqueue_script( 'vamtam-progress' );

		$output = '';
		if ( $type === 'percentage' ) {
			$output = '<div class="vamtam-progress pie" data-percent="' . esc_attr( $percentage ) . '" data-bar-color="' . esc_attr( vamtam_sanitize_accent( $bar_color, 'css' ) ) . '" data-track-color="' . esc_attr( vamtam_sanitize_accent( $track_color, 'css' ) ) . '" style="' . esc_attr( $value_color ) . '"><span>0</span>%</div>';
		} elseif ( $type === 'number' ) {
			if ( ! empty( $icon ) ) {
				$icon = vamtam_shortcode_icon( array(
					'name' => $icon,
				) );
			}

			$output = '<div class="vamtam-progress number" data-number="' . esc_attr( $value ) . '" style="' . esc_attr( $value_color ) . '">' . $icon . do_shortcode( $before_value ) . '<span>0</span>' . do_shortcode( $after_value ) . '</div>';
		}

		if ( ! empty( $content ) ) {
			$output .= '<div class="vamtam-progress-content" style="' . esc_attr( $value_color ) . '">' . do_shortcode( $content ) . '</div>';
		}

		return $output;
	}
}

new Vamtam_Progress;
