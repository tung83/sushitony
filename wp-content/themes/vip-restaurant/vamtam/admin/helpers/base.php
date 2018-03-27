<?php

/**
 *
 * @desc registers a theme activation hook
 * @param string $code : Code of the theme. This can be the base folder of your theme. Eg if your theme is in folder 'mytheme' then code will be 'mytheme'
 * @param callback $function : Function to call when theme gets activated.
 */
function vamtam_register_theme_activation_hook( $code, $function ) {
	$optionKey = 'theme_is_activated_' . $code;
	if ( ! get_option( $optionKey ) ) {
		call_user_func( $function );
		update_option( $optionKey , 1 );
	}
}

/**
 * @desc registers deactivation hook
 * @param string $code : Code of the theme. This must match the value you provided in vamtam_register_theme_activation_hook function as $code
 * @param callback $function : Function to call when theme gets deactivated.
 */
function vamtam_register_theme_deactivation_hook( $code, $function ) {
	// store function in code specific global
	$GLOBALS[ 'vamtam_register_theme_deactivation_hook_function' . $code ] = $function;

	// create a runtime function which will delete the option set while activation of this theme and will call deactivation function provided in $function
	$fn = create_function( '$theme', ' call_user_func( $GLOBALS["vamtam_register_theme_deactivation_hook_function' . $code . '"] ); delete_option( "theme_is_activated_' . $code. '" );' );

	// add above created function to switch_theme action hook. This hook gets called when admin changes the theme.
	// Due to wordpress core implementation this hook can only be received by currently active theme ( which is going to be deactivated as admin has chosen another one.
	// Your theme can perceive this hook as a deactivation hook.
	add_action( 'switch_theme', $fn );
}

// theme activation hook
function vamtam_theme_activated() {
	if ( vamtam_validate_install() ) {
		vamtam_register_theme_activation_hook( 'vamtam_'.VAMTAM_THEME_NAME, 'vamtam_theme_activated' );

		// disable jetpack likes & comments modules on activation
		$jetpack_opt_name = 'jetpack_active_modules';
		update_option( $jetpack_opt_name, array_diff( get_option( $jetpack_opt_name, array() ), array( 'likes', 'comments' ) ) );

		wp_redirect( admin_url( 'admin.php?page=tgmpa-install-plugins' ) );
	}
}

vamtam_register_theme_activation_hook( 'vamtam_'.VAMTAM_THEME_NAME, 'vamtam_theme_activated' );

// theme deactivation hook
function vamtam_theme_deactivated() {
}
vamtam_register_theme_deactivation_hook( 'vamtam_'.VAMTAM_THEME_NAME, 'vamtam_theme_deactivated' );

add_action( 'admin_init', 'vamtam_validate_install' );
function vamtam_validate_install() {
	global $vamtam_errors, $vamtam_validated;
	if ( $vamtam_validated )
		return;

	$vamtam_validated = true;
	$vamtam_errors    = array();

	if ( strpos( str_replace( WP_CONTENT_DIR.'/themes/', '', get_template_directory() ), '/' ) !== false ) {
		$vamtam_errors[] = esc_html__( 'The theme must be installed in a directory which is a direct child of wp-content/themes/', 'wpv' );
	}

	if ( ! is_writable( VAMTAM_CACHE_DIR ) ) {
		$vamtam_errors[] = sprintf( esc_html__( 'You must set write permissions (755 or 777) for the cache directory (%s)', 'wpv' ), VAMTAM_CACHE_DIR );
	}

	if ( ! extension_loaded( 'gd' ) || ! function_exists( 'gd_info' ) ) {
		$vamtam_errors[] = esc_html__( "It seems that your server doesn't have the GD graphic library installed. Please contact your hosting provider, they should be able to assist you with this issue", 'wpv' );
	}

	if ( count( $vamtam_errors ) ) {
		if ( ! function_exists( 'vamtam_invalid_install' ) ) {
			function vamtam_invalid_install() {
				global $vamtam_errors;
				?>
					<div class="updated fade error" style="background: #FEF2F2; border: 1px solid #DFB8BB; color: #666;"><p>
						<?php esc_html_e( 'There were some some errors with your Vamtam theme setup:', 'wpv' )?>
						<ul>
							<?php foreach ( $vamtam_errors as $error ) : ?>
								<li><?php echo wp_kses_post( $error ) ?></li>
							<?php endforeach ?>
						</ul>
					</p></div>
				<?php
			}
			add_action( 'admin_notices', 'vamtam_invalid_install' );
		}
		switch_theme( WP_DEFAULT_THEME, WP_DEFAULT_THEME );
		return false;
	}

	return true;
}

function vamtam_static( $option ) {
	if ( isset( $option['static'] ) && $option['static'] ) {
		echo 'static'; }
}

function vamtam_description( $id, $desc ) {
	if ( ! empty( $desc ) ) : ?>
		<div class="row-desc">
			<a href="#" class="va-icon va-icon-info desc-handle"></a>
			<div>
				<section class="content"><?php echo wp_kses_post( $desc ) ?></section>
				<footer><a href="<?php echo esc_url( 'http://support.vamtam.com' ) ?>" title="<?php esc_attr_e( 'Read more on our Help Desk', 'wpv' ) ?>" target="_blank"><?php esc_html_e( 'Read more on our Help Desk', 'wpv' ) ?></a></footer>
			</div>
		</div>
	<?php endif;
}

function vamtam_compile_less_ajax() {
	if ( ! wp_verify_nonce( $_POST['_nonce'], 'vamtam-compile-less' ) ) {
		exit;
	}

	$error = VamtamLessBridge::basic_compile( $_POST['input'], $_POST['output'] );

	if ( $error ) {
		echo json_encode( array( 'status' => 'error', 'message' => $error, 'memory' => memory_get_peak_usage() / 1024 / 1024 ) );
	} else {
		echo json_encode( array( 'status' => 'ok', 'memory' => memory_get_peak_usage() / 1024 / 1024 ) );
	}

	exit;
}
add_action( 'wp_ajax_vamtam-compile-less', 'vamtam_compile_less_ajax' );
