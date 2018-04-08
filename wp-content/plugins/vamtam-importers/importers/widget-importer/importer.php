<?php
/**
 * VamTam Widget Importer
 */

if ( ! defined( 'WP_LOAD_IMPORTERS' ) )
	return;

/** Display verbose errors */
if ( ! defined( 'IMPORT_DEBUG' ) ) {
	define( 'IMPORT_DEBUG', false );
}

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
class Vamtam_Widget_Import extends WP_Importer {
	public function __construct() {
	/* nothing */ }

	/**
	 * Registered callback function for the WordPress Importer
	 *
	 * Manages the three separate stages of the WXR import process
	 */
	public function dispatch() {
		$this->header();

		check_admin_referer( 'vamtam-import' );
		$file = $_GET['file'];

		set_time_limit( 0 );
		$this->import( $file );

		$this->footer();
	}

	/**
	 * The main controller for the actual import stage.
	 *
	 * @param string $file Path to the WXR file for importing
	 */
	private function import( $file ) {
		add_filter( 'import_post_meta_key', array( $this, 'is_valid_meta_key' ) );
		add_filter( 'http_request_timeout', array( &$this, 'bump_request_timeout' ) );

		$this->import_start( $file );

		wp_suspend_cache_invalidation( true );

		$this->import_widgets( $file );

		wp_suspend_cache_invalidation( false );

		$this->import_end();
	}

	private function import_widgets( $file ) {
		$data = unserialize( base64_decode( file_get_contents( $file ) ) );

		$data['positions']['wp_inactive_widgets'] = array();
		wp_set_sidebars_widgets( $data['positions'] );

		$map = get_option( 'vamtam_last_import_map', array() );

		foreach ( $data['widgets'] as $class => $widget ) {
			update_option( $class, $this->process_widget_conditions( $widget, $map ) );
		}
	}

	private function process_widget_conditions( $widgets, & $map ) {
		if ( ! empty( $map ) ) {
			foreach ( $widgets as $id => &$widget ) {
				if ( is_array( $widget['conditions'] ) ) {
					// key is the widget visibility rule type, value is the key in $map
					$major_tr = array(
						'author'   => 'authors',
						'page'     => 'posts',
						'category' => 'terms',
						'tag'      => 'terms',
						// 'taxonomy' => 'terms', // unimplemented, yet
					);

					foreach ( $widget['conditions']['rules'] as $rule_id => &$rule ) {
						if ( isset( $major_tr[ $rule['major'] ] ) && is_numeric( $rule[ 'minor' ] ) ) {
							$rule['minor'] = $map[ $major_tr[ $rule['major'] ] ][ (int) $rule[ 'minor' ] ];
						}
					}
				}
			}
		}

		return $widgets;
	}

	/**
	 * Parses the WXR file and prepares us for the task of processing parsed data
	 *
	 * @param string $file Path to the WXR file for importing
	 */
	private function import_start( $file ) {
		if ( ! is_file( $file ) ) {
			echo '<p><strong>' . esc_html__( 'Sorry, there has been an error.', 'wordpress-importer' ) . '</strong><br />';
			esc_html_e( 'The file does not exist, please try again.', 'wordpress-importer' );
			echo '</p>';
			$this->footer();
			die();
		}

		do_action( 'import_start' );
	}

	/**
	 * Performs post-import cleanup of files and the cache
	 */
	private function import_end() {
		echo '<p>' . esc_html__( 'All done.', 'wordpress-importer' ) . ' <a href="' . esc_url( admin_url() ) . '">' . esc_html__( 'Have fun!', 'wordpress-importer' ) . '</a></p>'; $redirect = admin_url( '' );

		do_action( 'import_end' );
	}

	// Display import page title
	private function header() {
		echo '<div class="wrap">';
		echo '<h2>' . esc_html__( 'Import Vamtam Widgets', 'wordpress-importer' ) . '</h2>'; }

	// Close div.wrap
	private function footer() {
		echo '</div>';
	}

	/**
	 * Added to http_request_timeout filter to force timeout at 60 seconds during import
	 * @return int 60
	 */
	public function bump_request_timeout( $imp ) {
		return 60;
	}
}

}

function vamtam_widget_importer_init() {
	if ( defined( 'VAMTAM_SAMPLES_DIR' ) ) {
		$GLOBALS['vamtam_widget_import'] = new Vamtam_Widget_Import();
		register_importer( 'vamtam_widgets', 'Vamtam Widget Import', sprintf( esc_html__( 'Import widgets from Vamtam themes, not to be used as a stand-alone product.', 'wpv' ), VAMTAM_THEME_NAME ), array( $GLOBALS['vamtam_widget_import'], 'dispatch' ) );
	}
}
add_action( 'admin_init', 'vamtam_widget_importer_init' );
