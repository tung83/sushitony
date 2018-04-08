<?php

class Vamtam_Sc_Countdown {
	public function __construct() {
		add_shortcode( 'vamtam_countdown', array( &$this, 'shortcode' ) );
	}

	public function shortcode( $atts, $content = null, $code ) {
		extract( shortcode_atts( array(
			'datetime' => '',
			'done' => '',
		), $atts ) );

		wp_enqueue_script( 'vamtam-reponsive-elements' );
		wp_enqueue_script( 'vamtam-countdown' );

		ob_start();

		?>
		<div class="vamtam-countdown regular" data-until="<?php echo esc_attr( strtotime( $datetime ) ) ?>" data-done="<?php echo esc_attr( $done ) ?>" data-respond>
			<span class="vamtamc-days vamtamc-block">
				<div class="value"></div>
				<div class="value-label"><?php esc_html_e( 'Days', 'wpv' ) ?></div>
			</span>
			<span class="vamtamc-sep">:</span>
			<span class="vamtamc-hours vamtamc-block">
				<div class="value"></div>
				<div class="value-label"><?php esc_html_e( 'Hours', 'wpv' ) ?></div>
			</span>
			<?php if ( ! trim( $content ) === false ) : ?>
				<div class="vamtamc-description">
					<?php echo wp_kses_post( $content ) ?>
				</div>
			<?php else : ?>
				<span class="vamtamc-sep">:</span>
			<?php endif ?>
			<span class="vamtamc-minutes vamtamc-block">
				<div class="value"></div>
				<div class="value-label"><?php esc_html_e( 'Minutes', 'wpv' ) ?></div>
			</span>
			<span class="vamtamc-sep">:</span>
			<span class="vamtamc-seconds vamtamc-block">
				<div class="value"></div>
				<div class="value-label"><?php esc_html_e( 'Seconds', 'wpv' ) ?></div>
			</span>
		</div>
<?php
		return ob_get_clean();
	}
}

new Vamtam_Sc_Countdown;
