<?php
/**
 * VamTam ACX Coming Soon Importer
 */

if ( ! defined( 'WP_LOAD_IMPORTERS' ) )
	return;

// Load Importer API
require_once ABSPATH . 'wp-admin/includes/import.php';

if ( ! class_exists( 'WP_Importer' ) ) {
	$class_wp_importer = ABSPATH . 'wp-admin/includes/class-wp-importer.php';
	if ( file_exists( $class_wp_importer ) )
		require $class_wp_importer;
}

/**
 * WordPress Importer class for managing the import process of a WXR file
 *
 * @package Importer
 */
if ( class_exists( 'WP_Importer' ) ) {
class Vamtam_AcxComingSoon_Import extends WP_Importer {
	private $file;

	public function __construct() {
		$this->file = VAMTAM_SAMPLES_DIR . 'acx-coming-soon.json';
	}

	/**
	 * Registered callback function for the WordPress Importer
	 *
	 * Manages the three separate stages of the WXR import process
	 */
	public function dispatch() {
		$this->header();

		check_admin_referer( 'vamtam-import-acx-coming-soon' );

		set_time_limit( 0 );
		$this->import( );

		$this->footer();
	}

	/**
	 * The main controller for the actual import stage.
	 */
	public function import() {
		add_filter( 'http_request_timeout', array( $this, 'bump_request_timeout' ) );

		$this->import_start();

		wp_suspend_cache_invalidation( true );

		$theme = json_decode( file_get_contents( $this->file ), true );

		update_option( 'acx_csma_appearence_array', $theme['acx_csma_appearence_array'] );

		wp_suspend_cache_invalidation( false );

		$this->import_end();
	}

	private function import_start() {
		if ( ! file_exists( $this->file ) ) {
			echo '<p><strong>' . esc_html__( 'Sorry, there has been an error.', 'wordpress-importer' ) . '</strong><br />';
			echo esc_html__( 'The file does not exist, please try again.', 'wordpress-importer' ) . '</p>';
			$this->footer();
			die();
		}

		do_action( 'import_start' );
	}

	/**
	 * Performs post-import cleanup of files and the cache
	 */
	private function import_end() {
		$redirect = admin_url( '' );

		echo '<p>' . esc_html__( 'All done.', 'wordpress-importer' ) . ' <a href="' . esc_url( $redirect ) . '">' . esc_html__( 'Have fun!', 'wordpress-importer' ) . '</a></p>';

		echo '<!-- all done -->';

		do_action( 'import_end' );
	}

	// Display import page title
	private function header() {
		echo '<div class="wrap">';
		echo '<h2>' . esc_html__( 'Import Acurax Coming Soon Settings', 'wordpress-importer' ) . '</h2>'; }

	// Close div.wrap
	private function footer() {
		echo '</div>';
	}

	/**
	 * Added to http_request_timeout filter to force timeout at 120 seconds during import
	 * @return int 120
	 */
	public function bump_request_timeout( $imp ) {
		return 120;
	}
}

} // class_exists( 'WP_Importer' )

function vamtam_acx_coming_soon_importer_init() {
	$GLOBALS['vamtam_acx_coming_soon_import'] = new Vamtam_AcxComingSoon_Import();
	register_importer( 'vamtam_acx_coming_soon', 'Vamtam Acurax Coming Soon Importer', sprintf( esc_html__( 'Import Acurax Coming Soon settings used for the demo content of VamTam themes, not to be used as a stand-alone product.', 'wpv' ), VAMTAM_THEME_NAME ), array( $GLOBALS['vamtam_acx_coming_soon_import'], 'dispatch' ) );
}
add_action( 'admin_init', 'vamtam_acx_coming_soon_importer_init' );
