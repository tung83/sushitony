<?php

/**
 * Vamtam Editor Shortcode Options Editor
 *
 * @package vip-restaurant
 */

/**
 * class Vamtam_Editor_Shortcode_Config
 */
class Vamtam_Editor_Shortcode_Config {

	/**
	 * Initialize the generator
	 * @param array $config generator options
	 */
	public function __construct( $config ) {
		$this->config = $config;
	}

	/**
	 * Reinitialize the generator
	 * @param array $config generator options
	 */
	public static function setConfig( $config ) {
		return new self( $config );
	}

	/**
	 * Single row template
	 * @param  string $template template name
	 * @param  array  $value    option row config
	 */
	public function tpl( $template, $value ) {
		extract( $value );
		if ( ! isset( $desc ))
			$desc = '';

		if ( ! isset( $default ))
			$default = null;

		if ( ! isset( $class ))
			$class = '';

		include VAMTAM_ADMIN_HELPERS . "config_generator/$template.php";
	}

	/**
	 * Renders the shortcode editor
	 */
	public function render() {
?>
		<div class="vamtam-config-group metabox">
			<div class="vamtam-config-row shortcode-title">
				<h3><?php echo wp_kses_post( $this->config['name'] ) ?></h3>
				<div class="action-buttons">
					<a class="vamtam-cancel-element" href="#"><?php esc_html_e( 'Cancel', 'wpv' ) ?></a>
					<a class="vamtam-save-element button-primary" href="#"><?php esc_html_e( 'Save Element', 'wpv' ) ?></a>
				</div>
			</div>

			<?php foreach ($this->config['options'] as $option) $this->tpl( $option['type'], $option ) ?>

			<div class="vamtam-config-row last-row">
				<a class="vamtam-cancel-element" href="#"><?php esc_html_e( 'Cancel', 'wpv' ) ?></a>
				<a class="vamtam-save-element button-primary" href="#"><?php esc_html_e( 'Save Element', 'wpv' ) ?></a>
			</div>
		</div>
<?php
	}
}
