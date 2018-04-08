<?php

/**
 * Fonts Helper
 *
 * @package vip-restaurant
 */
/**
 * class VamtamFontsHelper
 */
class VamtamFontsHelper extends VamtamAjax {
	/**
	 * Hook ajax actions
	 */
	public function __construct() {
		$this->actions = array(
			'font-preview' => 'font_preview',
		);

		parent::__construct();
	}

	/**
	 * gets the stylesheet for the font preview
	 */
	public function font_preview() {
		$url = vamtam_get_font_url( $_POST['face'], $_POST['weight'] );

		if ( ! empty( $url ) ) {
			echo $url; // xss ok
		}

		exit;
	}
}
