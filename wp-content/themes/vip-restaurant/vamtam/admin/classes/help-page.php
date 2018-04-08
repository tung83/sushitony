<?php

/**
 * Help page
 *
 * @package vip-restaurant
 */
class VamtamHelpPage {

	public static $mu_plugin_opt_name;

	/**
	 * Actions
	 */
	public function __construct() {
		add_action( 'admin_menu', array( __CLASS__, 'admin_menu' ), 20 );
	}

	public static function admin_menu() {
		add_theme_page( esc_html__( 'VamTam Help', 'wpv' ), esc_html__( 'VamTam Help', 'wpv' ), 'edit_theme_options', 'vamtam_theme_help', array( __CLASS__, 'page' ) );
	}

	public static function page() {
		?>
		<div class="wrap">
			<h1><?php esc_html_e( 'Vamtam Help', 'wpv' ); ?></h1>

			<?php include VAMTAM_OPTIONS . 'help/docs.php'; ?>
		</div>
		<?php
	}
}
