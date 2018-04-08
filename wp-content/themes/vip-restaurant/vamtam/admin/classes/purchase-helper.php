<?php

/**
 * Purchase Helper
 *
 * @package vip-restaurant
 */
/**
 * class VamtamPurchaseHelper
 */
class VamtamPurchaseHelper extends VamtamAjax {

	public static $storage_path;

	public static $mu_plugin_version;

	public static $mu_plugin_opt_name;

	/**
	 * Hook ajax actions
	 */
	public function __construct() {
		parent::__construct();

		self::$mu_plugin_version  = 1;
		self::$mu_plugin_opt_name = 'vamtam_' . VAMTAM_THEME_SLUG . '_mu_plugin_version';

		add_action( 'admin_menu', array( __CLASS__, 'admin_menu' ), 20 );
		add_action( 'admin_init', array( __CLASS__, 'admin_init' ) );
		add_action( 'admin_init', array( __CLASS__, 'admin_early_init' ), 5 );
		add_action( 'admin_notices', array( __CLASS__, 'notice' ), 20 ); // later than TGMPA

		add_action( 'admin_enqueue_scripts', array( __CLASS__, 'admin_scripts' ) );

		add_filter( 'tgmpa_update_bulk_plugins_complete_actions', array( __CLASS__, 'tgmpa_plugins_complete_actions' ), 10, 2 );
	}

	private static function is_theme_setup_page() {
		return isset( $_GET['page'] ) && in_array( $_GET['page'], array( 'vamtam_theme_setup' ) );
	}

	public static function admin_scripts() {
		$theme_version = VamtamFramework::get_version();

		wp_register_script( 'vamtam-check-license', VAMTAM_ADMIN_ASSETS_URI .'js/check-license.js', array( 'jquery' ), $theme_version, true );
		wp_register_script( 'vamtam-import-buttons', VAMTAM_ADMIN_ASSETS_URI .'js/import-buttons.js', array( 'jquery' ), $theme_version, true );
	}

	public static function tgmpa_plugins_complete_actions( $update_actions, $plugin_info ) {
		if ( isset( $update_actions['dashboard'] ) ) {
			$update_actions['dashboard'] = sprintf(
				esc_html__( 'All plugins installed and activated successfully. %1$s', 'wpv' ),
				'<a href="' . esc_url( admin_url( 'admin.php?page=vamtam_theme_setup' ) ) . '" class="button button-primary">' . esc_html__( 'Continue with theme setup.', 'wpv' ) . '</a>'
			);

			$update_actions['dashboard'] .= "
				<script>
					window.scroll( 0, 10000000 );
				</script>
			";
		}

		return $update_actions;
	}

	public static function notice() {
		if ( self::needs_mu_plugin() && ( ! isset( $_GET['page'] ) || ( $_GET['page'] !== 'vamtam_theme_setup' && $_GET['page'] !== 'tgmpa-install-plugins' ) ) ) {
			$url = admin_url( 'admin.php?page=vamtam_theme_setup' );

			echo '<div class="notice-warning settings-error notice">';
			echo '<p>';
			echo wp_kses_post( sprintf( __( 'You have activated your VamTam theme for the first time. <a href="%s">Click here</a> to complete the setup.', 'wpv' ),  esc_url( $url ) ) );
			echo '</p>';
			echo '</div>';
		}
	}

	public static function admin_menu() {
		add_theme_page( esc_html__( 'VamTam Theme Setup', 'wpv' ), esc_html__( 'VamTam Theme Setup', 'wpv' ), 'edit_theme_options', 'vamtam_theme_setup', array( __CLASS__, 'page' ) );
	}

	public static function admin_early_init() {
		if ( self::is_theme_setup_page() ) {
			add_filter( 'wp_redirect', array( __CLASS__, 'block_redirects_to_admin' ) ); // prevents redirects out of the theme setup page
		}

		add_filter( 'woocommerce_prevent_automatic_wizard_redirect', '__return_true' );
		if ( get_transient( '_fp_activation_redirect' ) ) {
			delete_transient( '_fp_activation_redirect' );
		}
	}

	public static function block_redirects_to_admin( $location ) {
		if ( strpos( $location, 'wp-admin/' ) !== false ) {
			return false; // block redirect to other admin pages
		}

		return $location;
	}

	public static function admin_init() {
		add_settings_section(
			'vamtam_purchase_settings_section',
			'',
			array( __CLASS__, 'settings_section' ),
			'vamtam_theme_setup'
		);

		add_settings_field(
			'vamtam-envato-license-key',
			esc_html__( 'Envato Purchase Key', 'wpv' ),
			array( __CLASS__, 'purchase_key' ),
			'vamtam_theme_setup',
			'vamtam_purchase_settings_section',
			array(
				'vamtam-envato-license-key',
			)
		);

		register_setting(
			'vamtam_theme_setup',
			'vamtam-envato-license-key',
			array( __CLASS__, 'sanitize_license_key' )
		);

		add_settings_field(
			'vamtam-system-status-opt-out',
			esc_html__( 'Disable System Status Information Gathering', 'wpv' ),
			array( __CLASS__, 'radio' ),
			'vamtam_theme_setup',
			'vamtam_purchase_settings_section',
			array(
				'vamtam-system-status-opt-out',
			)
		);

		register_setting(
			'vamtam_theme_setup',
			'vamtam-system-status-opt-out'
		);
	}

	public static function sanitize_license_key( $value ) {
		return preg_replace( '/[^-\w\d]/', '', $value );
	}

	public static function settings_section() {
	}

	public static function page() {
		wp_enqueue_script( 'vamtam-check-license' );

		?>
		<div class="wrap">
			<h1><?php esc_html_e( 'Vamtam Theme Setup', 'wpv' ); ?></h1>

			<h2><?php esc_html_e( 'Step 1', 'wpv' ) ?></h2>

			<?php
				if ( self::needs_mu_plugin() ) {
					if ( self::can_install_mu_plugin() ) {
						self::install_mu_plugin();
					} else {
						echo '<p>' . wp_kses_post( __( 'This step is optional, but <em>highly recommended</em>, especially if your server has a low memory limit. ', 'wpv' ) ) . '</p>';

						echo '<p>' . wp_kses_post( sprintf( __( 'By clicking the button below, we will install a Must-Use plugin on your site. You can remove it by manually deleting the following file: <pre>%s/10-vamtam-exclude-plugins.php</pre> We use this plugin in order to deal with hosting environments with low memory limits, which may prevent us from correctly saving any changes made to the theme options.', 'wpv' ), WPMU_PLUGIN_DIR ) ) . '</p>';

						echo '<a href="' . esc_url( add_query_arg( 'vamtam-mu-plugin', 'opt-in' ) ) . '" class="button">' . esc_html__( 'Install MU Plugin', 'wpv' ) . '</a>';
					}
				} else {
					esc_html_e( 'All done.', 'wpv' );
				}
			?>

			<h2><?php esc_html_e( 'Step 2', 'wpv' ) ?></h2>

			<form method="post" action="options.php">
			<?php
				settings_fields( 'vamtam_theme_setup' );
				do_settings_sections( 'vamtam_theme_setup' );

				submit_button();
			?>
			</form>

			<h3><?php esc_html_e( 'Step 3', 'wpv' ) ?></h2>

			<?php self::import_buttons() ?>
		</div>
		<?php
	}

	public static function can_install_mu_plugin() {
		return isset( $_GET[ 'vamtam-mu-plugin' ] ) && 'opt-in' === $_GET[ 'vamtam-mu-plugin' ];
	}

	public static function needs_mu_plugin() {
		return get_option( self::$mu_plugin_opt_name, 0 ) < self::$mu_plugin_version;
	}

	public static function install_mu_plugin() {
		if ( ! self::can_install_mu_plugin() ) {
			return false;
		}

		if ( ! self::needs_mu_plugin() ) {
			return true;
		}

		$url    = admin_url( 'admin.php?page=vamtam_theme_setup&vamtam-mu-plugin=opt-in' );
		$method = '';

		if (false === ( $creds = request_filesystem_credentials( $url, $method ) ) ) {
			return true;
		}

		if ( ! WP_Filesystem( $creds ) ) {
			request_filesystem_credentials( $url, $method, true );
			return true;
		}

		$source_file = VAMTAM_HELPERS . '10-vamtam-exclude-plugins.php';
		$target_file = trailingslashit( WPMU_PLUGIN_DIR ) . '10-vamtam-exclude-plugins.php';

		global $wp_filesystem;

		show_message( esc_html__( 'Creating directory...', 'wpv' ) );

		wp_mkdir_p( WPMU_PLUGIN_DIR );

		show_message( esc_html__( 'Copying file...', 'wpv' ) );

		if ( ! $wp_filesystem->copy( $source_file, $target_file, FS_CHMOD_FILE ) ) {
			printf( esc_html__( "Couldn't install the requisite mu-plugin. Please manually copy <b>%s</b> to <b>%s</b>", 'wpv' ), $source_file, $target_file );

			return false;
		}

		show_message( __( 'All done. Please continue below.', 'wpv' ) );

		update_option( self::$mu_plugin_opt_name, self::$mu_plugin_version );
	}

	public static function import_buttons() {
		wp_enqueue_script( 'vamtam-import-buttons' );

		include_once ABSPATH . 'wp-admin/includes/plugin.php';

		$revslider  = function_exists( 'is_plugin_active' ) && is_plugin_active( 'revslider/revslider.php' );
		$ninjaforms = function_exists( 'Ninja_Forms' );
		$megamenu   = class_exists( 'Mega_Menu' );
		$jetpack    = function_exists( 'is_plugin_active' ) && is_plugin_active( 'jetpack/jetpack.php' );
		$gmp_easy   = function_exists( 'is_plugin_active' ) && is_plugin_active( 'google-maps-easy/gmp.php' );

		$content_allowed  = $jetpack;

		$content_imported = !! get_option( 'vamtam_last_import_map', false );
		$content_disable  = $content_imported ? '' : ' disabled content-disabled';

		$messages = array(
			'success-msg' => esc_html__( 'Imported.', 'wpv' ),
			'error-msg  ' => esc_html__( 'Failed to import. Please <a href="{fullimport}" target="_blank">click here</a> in order to see the full error message.', 'wpv' ),
		);

		$buttons = array(
			array(
				'label'        => esc_html__( 'Content Import', 'wpv' ),
				'id'           => 'content-import-button',
				'description'  => esc_html__( 'You are advised to use this importer only on new WordPress sites. Jetpack must be installed and active.', 'wpv' ),
				'button_title' => esc_html__( 'Import Dummy Content', 'wpv' ),
				'href'         => $content_allowed ? wp_nonce_url( admin_url( 'admin.php?import=wpv&step=2&file=' . VAMTAM_SAMPLES_DIR . 'content.xml' ), 'vamtam-import' ) : 'javascript:void( 0 )',
				'type'         => 'button',
				'class'        => $content_allowed ? 'vamtam-import-button' : 'disabled',
				'data'         => array_merge( $messages, array( 'content-imported', $content_imported ) ),
				'disabled_msg' => wp_kses_data( __( 'Please install and activate <strong>Jetpack</strong> first.', 'wpv' ) ),
			),

			array(
				'label'        => esc_html__( 'Ninja Forms', 'wpv' ),
				'id'           => 'widget-import-button',
				'button_title' => esc_html__( 'Import Forms', 'wpv' ),
				'href'         => $ninjaforms ? wp_nonce_url( admin_url( 'admin.php?import=vamtam_ninjaforms' ), 'vamtam-import-ninja-forms' ) : 'javascript:void( 0 )',
				'type'         => 'button',
				'class'        => $ninjaforms ? 'vamtam-import-button' : 'disabled',
				'data'         => $messages,
				'disabled_msg' => wp_kses_data( __( 'Please install and activate <strong>Ninja Forms</strong> first.', 'wpv' ) ),
			),

			array(
				'label'             => esc_html__( 'Widget Import', 'wpv' ),
				'id'                => 'widget-import-button',
				'description'       => esc_html__( 'Using this importer will overwrite your current sidebar settings', 'wpv' ),
				'button_title'      => esc_html__( 'Import Widgets', 'wpv' ),
				'href'              => wp_nonce_url( admin_url( 'admin.php?import=vamtam_widgets&file=' . VAMTAM_SAMPLES_DIR . 'sidebars' ), 'vamtam-import' ),
				'type'              => 'button',
				'class'             => 'vamtam-import-button' . $content_disable,
				'data'              => $messages,
				'disabled_msg'      => wp_kses_data( __( 'You must import the demo content before the widgets.', 'wpv' ) ),
				'disabled_msg_href' => 'nolink',
			),

			array(
				'label'        => esc_html__( 'Slider Revolution', 'wpv' ),
				'id'           => 'slider-import-button',
				'button_title' => esc_html__( 'Import Slider Revolution Samples', 'wpv' ),
				'href'         => $revslider ? wp_nonce_url( 'admin.php?import=vamtam_revslider', 'vamtam-import-revslider' ) : 'javascript:void( 0 )',
				'type'         => 'button',
				'class'        => $revslider ? 'vamtam-import-button' : 'disabled',
				'data'         => $messages,
				'disabled_msg' => wp_kses_data( __( 'Please install and activate Slider Revolution first.', 'wpv' ) ),
			),

			array(
				'label'        => esc_html__( 'Max Mega Menu', 'wpv' ),
				'id'           => 'megamenu-import-button',
				'description'  => esc_html__( 'Using this importer will overwrite your current Max Mega Menu themes', 'wpv' ),
				'button_title' => esc_html__( 'Import Menu Themes', 'wpv' ),
				'href'         => $megamenu ? wp_nonce_url( 'admin.php?import=vamtam_megamenu', 'vamtam-import-megamenu' ) : 'javascript:void( 0 )',
				'type'         => 'button',
				'class'        => $megamenu ? 'vamtam-import-button' : 'disabled',
				'data'         => $messages,
				'disabled_msg' => wp_kses_data( __( 'Please install and activate <strong>Max Mega Menu</strong> first.', 'wpv' ) ),
			),

			array(
				'label'        => esc_html__( 'Coming Soon (Acurax)', 'wpv' ),
				'id'           => 'acx-coming-soon-import-button',
				'description'  => esc_html__( 'Using this importer will overwrite your current ACX Coming Soon theme', 'wpv' ),
				'button_title' => esc_html__( 'Import Coming Soon Theme', 'wpv' ),
				'href'         => wp_nonce_url( 'admin.php?import=vamtam_acx_coming_soon', 'vamtam-import-acx-coming-soon' ),
				'type'         => 'button',
				'class'        => 'vamtam-import-button',
				'data'         => $messages,
				'disabled_msg' => wp_kses_data( __( 'Please install and activate <strong>Under Construction / Maintenance Mode from Acurax</strong> first.', 'wpv' ) ),
			),

			array(
				'label'        => esc_html__( 'Google Maps Easy', 'wpv' ),
				'id'           => 'gmp-easy-import-button',
				'button_title' => esc_html__( 'Import Google Maps Easy', 'wpv' ),
				'href'         => $gmp_easy ? wp_nonce_url( 'admin.php?import=vamtam_gmp_easy', 'vamtam-import-gmp-easy' ) : 'javascript:void( 0 )',
				'type'         => 'button',
				'class'        => $gmp_easy ? 'vamtam-import-button' : 'disabled',
				'data'         => $messages,
				'disabled_msg' => wp_kses_data( __( 'Please install and activate <strong>Google Maps Easy</strong> first.', 'wpv' ) ),
			),
		);

		echo '<table class="form-table">';

		foreach ( $buttons as $button ) {
			self::render_button( $button );
		}

		echo '</table>';
	}

	public static function render_button( $button ) {
		echo '<tr>';
		echo '<th scope="row">' . esc_html( $button['label'] ) . '</th>';

		$data = array();

		if ( isset( $button['data'] ) ) {
			foreach ( $button['data'] as $attr_name => $attr_value ) {
				$data[] = 'data-' . sanitize_title_with_dashes( $attr_name ) . '="' . esc_attr( $attr_value ) . '"';
			}
		}

		$data = implode( ' ', $data );

		echo '<td>';

		echo '<a href="' . ( isset( $button['href'] ) ? esc_attr( $button['href'] ) : '#' ) . '" id="' . esc_attr( $button['id'] ) . '" title="' . esc_attr( $button['button_title'] ) . '" class="button ' . esc_attr( $button['class'] ) . '" ' . $data . '>' . esc_html( $button['button_title'] ) . '</a>'; // xss ok - $data escaped above

		if ( strpos( $button['class'], 'disabled' ) !== false ) {
			$href = isset( $button['disabled_msg_href'] ) ? $button['disabled_msg_href'] : admin_url( 'themes.php?page=tgmpa-install-plugins&plugin_status=all' );

			echo '<p class="description">';
			if ( $href !== 'nolink' ) {
				echo '<a href="' . esc_html( $href ) . '">' . wp_kses_data( $button['disabled_msg'] ) . '</a>';
			} else {
				echo wp_kses_data( $button['disabled_msg'] );
			}
			echo '</p>';
		}

		echo '</td>';
		echo '</tr>';
	}

	public static function purchase_key( $args ) {
		$option_value = get_option( $args[0] );

		$button_data = '';

		$data = array(
			'nonce'     => wp_create_nonce( 'vamtam-check-license' ),
			'full-info' => wp_kses_post( sprintf( __('
				<h5>Licensing Terms</h5>
				Please be advised, in order to use the theme in a legal manner, you need to purchase a separate license for each domain you are going to use the theme on. A single license is limited to a single domain/application. For more information please refer to the license included with the theme or <a href="%s" target="_blank">Licensing Terms</a> on the ThemeForest site.', 'wpv'), 'http://themeforest.net/licenses' ) ),
		);

		foreach ( $data as $key => $value ) {
			$button_data .= ' data-' . $key . '="' . esc_attr( $value ) . '"';
		}

		$html = '<input type="text" id="' . esc_attr( $args[0] ) . '" name="' . esc_attr( $args[0] ) . '" value="' . esc_attr( $option_value ) . '" size="64"/>';

		$html .= '<span>';
		$html .= '<button id="vamtam-check-license" class="button" ' . $button_data . '>' . esc_html__( 'Check', 'wpv' ) . '</button>';
		$html .= '</span>';

		$html .= '<p class="description">' . wp_kses_post( sprintf( __( ' <a href="%s" target="_blank">Where can I find my Item Purchase Code?</a>', 'wpv' ), 'http://hair.support.vamtam.com/support/solutions/articles/219861-where-to-get-your-item-purchase-key-from-vip-restaurant-theme' ) ) . '</p>';

		$html .= '<div id="vamtam-check-license-result"></div>';

		echo $html; // xss ok
	}

	public static function radio( $args ) {
		$value = vamtam_sanitize_bool( get_option( $args[0] ) );

		$html  = '<label><input type="radio" id="' . esc_attr( $args[0] ) . '" name="' . esc_attr( $args[0] ) . '" value="1" ' . checked( $value, true, false ) . '/> ' . esc_html__( 'On', 'wpv' ) . '</label> ';
		$html .= '<label><input type="radio" id="' . esc_attr( $args[0] ) . '" name="' . esc_attr( $args[0] ) . '" value="0" ' . checked( $value, false, false ) . '/> ' . esc_html__( 'Off', 'wpv' ) . '</label>';

		$html .= '<p class="description">' . wp_kses_post( __('By enabling this option you will opt out of automatically sending our support system detailed information about your website. Please note that we might be able to respond more quickly if you leave this disabled. We advise you to turn off this option before opening a support ticket. Here is the information that we collect when this option is disabled:

		<ul>
			<li>memory limit</li>
			<li>is wp_debug enabled</li>
			<li>list of active plugins and their versions</li>
			<li>POST requests limit</li>
			<li>allowed number of request variables</li>
			<li>default time limit</li>
			<li>permissions for the cache/ directory inside the theme</li>
			<li>does wp_remote_post() work as expected</li>
		</ul>

		None of this information will be shared with third parties.
		', 'wpv') ) . '</p>';

		echo $html; // xss ok
	}
}
