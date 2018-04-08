<?php
/**
 * Vamtam Basic Shortcode Generator
 *
 * @package vip-restaurant
 */

/**
 * class VamtamShortcodesGenerator
 */
class VamtamShortcodesGenerator extends VamtamConfigGenerator {

	/**
	 * Initialize the generator
	 *
	 * @param array $config    generator options
	 * @param array $shortcode shortcode option definitions
	 */
	public function __construct( $config, $shortcode ) {
		$this->config    = $config;
		$this->shortcode = $shortcode;
	}

	/**
	 * Render the generator
	 */
	public function render() {
		global $post;

		require_once VAMTAM_ADMIN_HELPERS . 'shortcodes/render.php';
	}
}
