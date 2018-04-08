<?php

/**
 * Suggest things to do after a theme update
 *
 * @package vip-restaurant
 */
class VamtamUpdateNotice {
	/**
	 * Key for the option which holds the last theme version
	 *
	 * @var string
	 */
	public static $last_version_key = '-vamtam-last-theme-version';

	/**
	 * checks if the theme has been updated
	 * and the update message has not been dismissed
	 */
	public static function check() {
		$current_version = VamtamFramework::get_version();
		$last_known_version = get_option( VAMTAM_THEME_SLUG . self::$last_version_key );

		if ( $current_version !== $last_known_version || ! get_option( 'vamtam-theme-update-notice-dismissed' ) ) {
			$GLOBALS['vamtam_only_smart_less_compilation'] = true;
			$status = function_exists( 'vamtam_recompile_css' ) ? vamtam_recompile_css() : -1;

			if ( 0 != $status ) {
				add_action( 'admin_notices', array( __CLASS__, 'after_update_notice' ) );
				add_action( 'vamtam_after_save_theme_options', array( __CLASS__, 'dismiss_notice' ) );

				update_option( 'vamtam-last-theme-version', $current_version );
				update_option( 'vamtam-theme-update-notice-dismissed', false );
			} else {
				self::dismiss_notice();
			}
		}
	}

	/**
	 * Display the update notice
	 */
	public static function after_update_notice() {
		if ( is_plugin_active( 'redux-framework/redux-framework.php' ) ) {

			echo '<div class="error fade"><p><strong>'; ;
			esc_html_e( "It is highly recommended that you regenerate your theme's CSS cache.", 'wpv' );
			echo '</strong></p><p>';
			printf( wp_kses_post( __( 'We advise you to <a href="%s">click here</a> to regenerate your theme\'s CSS cache. This will ensure that you are seeing the latest styles and that all theme caches have been cleared.', 'wpv' ) ), esc_url( admin_url( 'admin.php?vamtam_action=clear_cache' ) ) );
			echo '</p></div>'; ;
		}
	}

	/**
	 * dissmiss the notice once the theme options have been saved
	 */
	public static function dismiss_notice() {
		update_option( VAMTAM_THEME_SLUG . self::$last_version_key, VamtamFramework::get_version() );
		update_option( 'vamtam-theme-update-notice-dismissed', true );
	}
}
