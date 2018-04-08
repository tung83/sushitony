<?php
/**
 * Slogan shortcode handler
 *
 * @package editor
 */

/**
 * class Vamtam_Slogan
 */
class Vamtam_Slogan {
	/**
	 * Register the shortcode
	 */
	public function __construct() {
		add_shortcode( 'slogan', array( &$this, 'slogan' ) );
	}

	/**
	 * Slogan shortcode callback
	 *
	 * @param  array  $atts    shortcode attributes
	 * @param  string $content shortcode content
	 * @param  string $code    shortcode name
	 * @return string          output html
	 */
	public function slogan( $atts, $content = null, $code ) {
		extract(shortcode_atts(array(
			'button_text' => 'Button Text',
			'link' => '',
			'button_icon' => 'cart',
			'button_icon_color' => 'accent1',
			'button_icon_placement' => 'left',
		), $atts));

		ob_start();

		include locate_template( 'templates/shortcodes/slogan.php' );

		return ob_get_clean();
	}
}

new Vamtam_Slogan;
