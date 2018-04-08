<?php

/*
 * Vamtam CRM Integration, used to check for updates and aiding support queries
 */

class Version_Checker {
	public $remote;
	public $interval;
	public $notice;

	private $update_api_prefix = 'https://updates.api.vamtam.com/0/envato/';

	private $update_api_url;
	private $validate_api_url;

	private static $instance;

	public static function get_instance() {
		if ( ! isset( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	public function __construct() {
		$this->remote   = 'https://api.vamtam.com/version';
		$this->interval = 2 * 3600;

		$this->update_api_url   = $this->update_api_prefix . 'check-theme';
		$this->validate_api_url = $this->update_api_prefix . 'validate-license';

		if ( ! isset( $_GET['import'] ) && ( ! isset( $_GET['step'] ) || (int) $_GET['step'] != 2 ) ) {
			add_action( 'admin_init', array( $this, 'check_version' ) );
		}

		add_action( 'wp_ajax_vamtam-check-license', array( $this, 'check_license' ) );
		add_action( 'vamtam_saved_options', array( $this, 'check_version' ) );

		// set_site_transient('update_themes', null);

		add_filter( 'pre_set_site_transient_update_themes', array( $this, 'check_update' ) );
	}

	public function check_update( $updates ) {
		$response = $this->update_api_request();

		if ( false === $response ) {
			return $updates;
		}

		if ( ! isset( $updates->response ) ) {
			$updates->response = array();
		}

		$updates->response = array_merge( $updates->response, $response );

		// Small trick to ensure the updates get shown in the network admin
		if ( is_multisite() && ! is_main_site() ) {
			global $current_site;

			switch_to_blog( $current_site->blog_id );
			set_site_transient( 'update_themes', $updates );
			restore_current_blog();
		}

		return $updates;
	}

	private function update_api_request() {
		global $wp_version;

		$update_cache = get_site_transient( 'update_themes' );

		$raw_response = wp_remote_post( $this->update_api_url, array(
			'body' => array(
				'version' => VamtamFramework::get_version(),
				'purchase_key' => apply_filters( 'vamtam_purchase_code', '' ),
			),
			'user-agent' => 'WordPress/' . $wp_version . '; ' . home_url( '/' ),
		) );

		if ( is_wp_error( $raw_response ) || 200 !== wp_remote_retrieve_response_code( $raw_response ) ) {
			return false;
		}

		$response = json_decode( wp_remote_retrieve_body( $raw_response ), true );

		return $response['themes'];
	}

	public function check_license() {
		check_ajax_referer( 'vamtam-check-license', 'nonce' );

		global $wp_version;

		$raw_response = wp_remote_post( $this->validate_api_url, array(
			'body' => array(
				'purchase_key' => $_POST['license-key'],
			),
			'user-agent' => 'WordPress/' . $wp_version . '; ' . home_url( '/' ),
		) );

		if ( ! is_wp_error( $raw_response ) ) {
			if ( $raw_response['response']['code'] >= 200 && $raw_response['response']['code'] < 300  ) {
				echo '<span style="color: green">'; esc_html_e( 'Valid Purchase Key', 'wpv' );
				echo '</span>';
			} else {
				echo '<span style="color: red">'; esc_html_e( 'Incorrect Purchase Key', 'wpv' );
				echo '</span>';
			}
		} else {
			echo '<span style="color: red">'; esc_html_e( 'Cannot validate Purchase Key. Please try again later. If the problem persists your server might not have the curl PHP extension enabled.', 'wpv' );
			echo '</span>';
		}

		$this->check_version();

		die;
	}

	public function check_version() {
		$local_version = VamtamFramework::get_version();
		$key           = VAMTAM_THEME_SLUG.'_'.$local_version;

		$last_license_key    = get_option( 'vamtam-envato-license-key-old' );
		$current_license_key = get_option( 'vamtam-envato-license-key' );

		$system_status_opt_out_old = get_option( 'vamtam-system-status-opt-out-old' );
		$system_status_opt_out     = get_option( 'vamtam-system-status-opt-out' );

		if ( $last_license_key !== $current_license_key || $system_status_opt_out_old !== $system_status_opt_out || false === get_transient( $key ) ) {
			global $wp_version;

			$data = array(
				'user-agent' => 'WordPress/' . $wp_version . '; ' . home_url( '/' ).'; ',
				'blocking'   => false,
				'body'       => array(
					'theme_version'  => $local_version,
					'php_version'    => phpversion(),
					'server'         => $_SERVER['SERVER_SOFTWARE'],
					'theme_name'     => VAMTAM_THEME_NAME,
					'license_key'    => $current_license_key,
					'active_plugins' => self::active_plugins(),
					'system_status'  => self::system_status(),
				),
			);

			if ( $last_license_key !== $current_license_key ) {
				update_option( 'vamtam-envato-license-key-old', $current_license_key );
			}

			if ( $system_status_opt_out_old !== $system_status_opt_out ) {
				update_option( 'vamtam-system-status-opt-out-old', $system_status_opt_out );
			}

			wp_remote_post( $this->remote, $data );

			set_transient( $key, true, $this->interval ); // cache
		}
	}

	public static function active_plugins() {
		$active_plugins = (array) get_option( 'active_plugins', array() );

		if ( is_multisite() )
			$active_plugins = array_merge( $active_plugins, get_site_option( 'active_sitewide_plugins', array() ) );

		return $active_plugins;
	}

	public static function system_status() {
		if ( get_option( 'vamtam-system-status-opt-out' ) ) {
			return array( 'disabled' => true );
		}

		$result = array(
			'disabled'         => false,
			'wp_debug'         => WP_DEBUG,
			'wp_debug_display' => WP_DEBUG_DISPLAY,
			'wp_debug_log'     => WP_DEBUG_LOG,
			'active_plugins'   => array(),
			'writable'         => array(),
			'ziparchive'       => class_exists( 'ZipArchive' ),
		);

		if ( function_exists( 'ini_get' ) ) {
			$result['post_max_size']      = ini_get( 'post_max_size' );
			$result['max_input_vars']     = ini_get( 'max_input_vars' );
			$result['max_execution_time'] = ini_get( 'max_execution_time' );
			$result['memory_limit'] = ini_get( 'memory_limit' );
		}

		$active_plugins = self::active_plugins();

		foreach ( $active_plugins as $plugin ) {
			$plugin_data = @get_plugin_data( WP_PLUGIN_DIR . '/' . $plugin );

			$result['active_plugins'][ $plugin ] = array(
				'name'    => $plugin_data['Name'],
				'version' => $plugin_data['Version'],
				'author'  => $plugin_data['AuthorName'],
			);
		}

		$result['writable'][ VAMTAM_CACHE_DIR ] = is_writable( VAMTAM_CACHE_DIR );

		$cache_contents = glob( VAMTAM_CACHE_DIR . '*.{less,css}', GLOB_BRACE );
		if ( is_array( $cache_contents ) ) {
			foreach ( $cache_contents as $filepath ) {
				$result['writable'][ $filepath ] = is_writable( $filepath );
			}
		}

		$result['wp_remote_post'] = 'Irrelevant';

		return $result;
	}
}

Version_Checker::get_instance();
