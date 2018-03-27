<?php

/*
Plugin Name: VamTam Importers
Description: This plugin is used in order to import the sample content for VamTam themes
Version: 2.4.0
Author: VamTam
Author URI: http://vamtam.com
*/

class Vamtam_Importers {
	public function __construct() {
		add_action( 'admin_init', array( __CLASS__, 'admin_init' ), 1 );

		if ( ! class_exists( 'Vamtam_Updates_2' ) ) {
			require 'vamtam-updates/class-vamtam-updates.php';
		}

		new Vamtam_Updates_2( __FILE__ );
	}

	public static function admin_init() {
		add_action( 'vamtam_before_content_import', array( __CLASS__, 'before_content_import' ) );

		require 'importers/importer/importer.php';
		require 'importers/widget-importer/importer.php';
		require 'importers/revslider/importer.php';
		require 'importers/ninja-forms/importer.php';
		require 'importers/megamenu/importer.php';
		require 'importers/acx-coming-soon/importer.php';
		require 'importers/booked/importer.php';
		require 'importers/google-maps-easy/importer.php';
	}

	public static function before_content_import() {
		wp_suspend_cache_invalidation( true );

		self::generic_option_import( 'jetpack', array( __CLASS__, 'jetpack_import' ) );
		self::generic_option_import( 'foodpress', array( __CLASS__, 'foodpress_import' ) );

		wp_suspend_cache_invalidation( false );
	}

	public static function generic_option_import( $file, $callback ) {
		$path = VAMTAM_SAMPLES_DIR . $file . '.json';

		if ( file_exists( $path ) ) {
			$settings = json_decode( file_get_contents( $path ), true );

			foreach ( $settings as $opt_name => $opt_val ) {
				update_option( $opt_name, $opt_val );
			}

			call_user_func( $callback );
		}
	}

	public static function jetpack_import() {
		Jetpack::load_modules();

		if ( class_exists( 'Jetpack_Portfolio' ) ) {
			Jetpack_Portfolio::init()->register_post_types();
		}

		if ( class_exists( 'Jetpack_Testimonial' ) ) {
			Jetpack_Testimonial::init()->register_post_types();
		}
	}

	public static function foodpress_import() {
		if ( function_exists( 'foodpress_generate_options_css' ) ) {
			foodpress_generate_options_css();
		}
	}
}

new Vamtam_Importers;
