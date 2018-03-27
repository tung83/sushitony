<?php

/**
 * Enqueue styles and scripts used by the theme
 *
 * @package vip-restaurant
 */

/**
 * class VamtamEnqueues
 */
class VamtamEnqueues {
	private static $use_min;
	/**
	 * Hook the relevant actions
	 */
	public static function actions() {
		self::$use_min = ! ( WP_DEBUG || ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) || ( defined( 'VAMTAM_SCRIPT_DEBUG' ) && VAMTAM_SCRIPT_DEBUG ) );

		add_action( 'wp_enqueue_scripts', array( __CLASS__, 'scripts_first' ), 1 );
		add_action( 'wp_enqueue_scripts', array( __CLASS__, 'scripts' ) );
		add_action( 'wp_enqueue_scripts', array( __CLASS__, 'styles' ), 99 );
		add_action( 'admin_enqueue_scripts', array( __CLASS__, 'admin_scripts' ) );
		add_action( 'admin_enqueue_scripts', array( __CLASS__, 'admin_styles' ), 99 );
		add_action( 'customize_controls_enqueue_scripts', array( __CLASS__, 'customize_controls_enqueue_scripts' ) );
		add_action( 'customize_preview_init', array( __CLASS__, 'customize_preview_init' ) );
	}

	private static function is_our_admin_page() {
		if ( ! is_admin() ) return false;

		$screen = get_current_screen();

		return
			in_array( $screen->base, array( 'post', 'widgets', 'themes', 'upload' ) ) ||
			strpos( $screen->base, 'vamtam_' ) !== false ||
			strpos( $screen->base, 'toplevel_page_vamtam' ) === 0 ||
			strpos( $screen->base, 'toplevel_page_vamtam' ) === 0 ||
			$screen->base === 'media_page_vamtam_icons';
	}

	private static function inject_dependency( $handle, $dep ) {
		global $wp_scripts;

		$script = $wp_scripts->query( $handle, 'registered' );

		if ( ! $script )
			return false;

		if ( ! in_array( $dep, $script->deps ) ) {
			$script->deps[] = $dep;
		}

		return true;
	}

	public static function scripts_first() {
		if ( is_admin() || VamtamTemplates::is_login() ) return;

		// modernizr should be on top
		wp_enqueue_script( 'modernizr', VAMTAM_JS . 'modernizr.min.js', array(), '3.2.0' );
	}

	/**
	 * Front-end scripts
	 */
	public static function scripts() {
		if ( is_admin() || VamtamTemplates::is_login() ) return;

		$theme_version = VamtamFramework::get_version();

		if ( is_singular() && comments_open() ) {
			wp_enqueue_script( 'comment-reply', false, false, false, true );
		}

		wp_enqueue_script( 'jquery-match-height', VAMTAM_JS . 'plugins/thirdparty/jquery.matchheight.min.js', array( 'jquery-core' ), '0.5.1', true );
		wp_enqueue_script( 'jquery-easypiechart', VAMTAM_JS . 'plugins/thirdparty/jquery.easypiechart.js', array( 'jquery-core' ), '2.1.3', true );
		wp_enqueue_script( 'vamtam-reponsive-elements', VAMTAM_JS . 'plugins/thirdparty/responsive-elements.js', array( 'jquery-core' ), $theme_version, true );

		wp_enqueue_script( 'cubeportfolio', VAMTAM_ASSETS_URI . 'cubeportfolio/js/jquery.cubeportfolio' . ( self::$use_min ? '.min' : '' ) . '.js', array(), '3.2.1', true );

		wp_register_script( 'vamtam-ls-height-fix', VAMTAM_JS . 'layerslider-height.js', array( 'jquery-core' ), $theme_version, true );
		wp_register_script( 'vamtam-countdown', VAMTAM_JS . 'countdown.js', array( 'jquery-core', 'vamtam-reponsive-elements' ), $theme_version, true );
		wp_register_script( 'vamtam-animate-number', VAMTAM_JS . 'plugins/vamtam/jquery.vamtamanimatenumber.js', array( 'jquery-core' ), $theme_version, true );
		wp_register_script( 'vamtam-progress', VAMTAM_JS . 'progress.js', array( 'jquery-core', 'vamtam-animate-number', 'jquery-easypiechart' ), $theme_version, true );

		wp_register_script( 'vamtam-linkarea', VAMTAM_JS . 'linkarea.js', array( 'jquery-core' ), $theme_version, true );

		wp_register_script( 'vamtam-services-expandable', VAMTAM_JS . 'services-expandable.js', array( 'jquery-core' ), $theme_version, true );

		$all_js_path = self::$use_min ? 'all.min.js' : 'all.js';
		$all_js_deps = array(
			'jquery-core',
			'jquery-ui-core',
			'jquery-effects-core',
			'jquery-ui-widget',
			'underscore',
			'jquery-match-height',
			'modernizr',
		);

		wp_enqueue_script( 'vamtam-all', VAMTAM_JS . $all_js_path, $all_js_deps, $theme_version, true );

		self::inject_dependency( 'wc-cart-fragments', 'vamtam-all' );

		$script_vars = array(
			'ajaxurl' => admin_url( 'admin-ajax.php' ),
			'jspath'  => VAMTAM_JS,
		);

		wp_localize_script( 'vamtam-all', 'VAMTAM_FRONT', $script_vars );

		if ( is_customize_preview() ) {
			wp_enqueue_script( 'vamtam-customizer-preview-front', VAMTAM_ADMIN_ASSETS_URI . 'js/customizer-preview-front.js', array( 'jquery-core', 'customize-selective-refresh' ), $theme_version, true );
		}
	}

	/**
	 * Admin scripts
	 */
	public static function admin_scripts() {
		if ( ! self::is_our_admin_page() ) return;

		$theme_version = VamtamFramework::get_version();

		wp_enqueue_script( 'jquery-magnific-popup', VAMTAM_JS .'plugins/thirdparty/jquery.magnific.js', array( 'jquery' ), $theme_version, true );

		wp_enqueue_script( 'common' );
		wp_enqueue_script( 'editor' );
		wp_enqueue_script( 'jquery-ui-sortable' );
		wp_enqueue_script( 'jquery-ui-draggable' );
		wp_enqueue_script( 'jquery-ui-tabs' );
		wp_enqueue_script( 'jquery-ui-range', VAMTAM_ADMIN_ASSETS_URI .'js/jquery.ui.range.js', array( 'jquery' ), $theme_version, true );
		wp_enqueue_script( 'jquery-ui-slider' );

		wp_enqueue_script( 'farbtastic' );

		wp_enqueue_media();

		wp_enqueue_script( 'vamtam_admin', VAMTAM_ADMIN_ASSETS_URI .'js/admin-all.js', array( 'jquery', 'underscore', 'backbone' ), $theme_version, true );
		wp_enqueue_script( 'vamtam-shortcode', VAMTAM_ADMIN_ASSETS_URI . 'js/shortcode.js', array( 'jquery' ), $theme_version, true );

		wp_localize_script(
			'vamtam_admin', 'VAMTAM_ADMIN', array(
				'addNewIcon' => esc_html__( 'Add New Icon', 'wpv' ),
				'iconName'   => esc_html__( 'Icon', 'wpv' ),
				'iconText'   => esc_html__( 'Text', 'wpv' ),
				'iconLink'   => esc_html__( 'Link', 'wpv' ),
				'iconChange' => esc_html__( 'Change', 'wpv' ),
				'fonts'      => $GLOBALS['vamtam_fonts'],
			)
		);
	}

	/**
	 * Front-end styles
	 */
	public static function styles() {
		if ( is_admin() || VamtamTemplates::is_login() ) return;

		$theme_version = VamtamFramework::get_version();

		$preview = isset( $_POST['wp_customize'] ) && $_POST['wp_customize'] == 'on' && isset( $_POST['customized'] ) && ! empty( $_POST['customized'] ) && ! isset( $_POST['action'] ) ? '-preview' : '';

		$fonts_url = empty( $preview ) ? rd_vamtam_get_option( 'google_fonts' ) : vamtam_customizer_preview_fonts_url();

		wp_enqueue_style( 'vamtam-gfonts', $fonts_url, array(), $theme_version );

		wp_enqueue_style( 'cubeportfolio', VAMTAM_ASSETS_URI . 'cubeportfolio/css/cubeportfolio' . ( self::$use_min ? '.min' : '' ) . '.css', array( 'front-all' ), '3.2.1' );

		$cache_timestamp = get_option( 'vamtam-css-cache-timestamp' );

		$generated_deps = array();

		if ( vamtam_has_woocommerce() ) {
			$generated_deps[] = 'woocommerce-layout';
			$generated_deps[] = 'woocommerce-smallscreen';
			$generated_deps[] = 'woocommerce-general';
		}

		$suffix  = is_multisite() ? $GLOBALS['blog_id'] : '';

		$css_file = 'all' . $suffix . $preview . '.css';
		$css_path = VAMTAM_CACHE_URI . $css_file;

		if ( ! file_exists( VAMTAM_CACHE_DIR . $css_file ) && ! empty( $preview ) ) {
			$css_file = 'all' . $suffix . '.css';
			$css_path = VAMTAM_CACHE_URI . $css_file;
		}

		if ( ! file_exists( VAMTAM_CACHE_DIR . $css_file ) ) {
			$css_path = VAMTAM_SAMPLES_URI . 'all-default.css';
		}

		wp_enqueue_style( 'front-all', vamtam_prepare_url( $css_path ), $generated_deps, $cache_timestamp );

		global $vamtam_is_shortcode_preview;

		if ( $vamtam_is_shortcode_preview ) {
			wp_enqueue_style( 'vamtam-shortcode-preview', VAMTAM_ADMIN_ASSETS_URI . 'css/shortcode-preview.css' );
		}

		$custom_icons = get_option( 'vamtam-custom-icons-map' );

		if ( $custom_icons ) {
			$icons_path = trailingslashit( WP_CONTENT_URL ) . 'vamtam/custom-icon-font/';
			$custom_icons_css = "
				@font-face {
					font-family: 'vamtam-custom-icons';
					src: url({$icons_path}custom-icons.eot);
					src: url({$icons_path}custom-icons.eot?#iefix) format('embedded-opentype'),
						url({$icons_path}custom-icons.ttf) format('truetype');
					font-weight: normal;
					font-style: normal;
				}
			";

			wp_add_inline_style( 'front-all', $custom_icons_css );
		}

		$theme_url = VAMTAM_THEME_URI;
		$theme_icons_css = "
			@font-face {
				font-family: 'icomoon';
				src: url( {$theme_url}vamtam/assets/fonts/icons/icons.ttf) format('truetype');
				font-weight: normal;
				font-style: normal;
			}

			@font-face {
				font-family: 'theme';
				src: url({$theme_url}vamtam/assets/fonts/theme-icons/theme-icons.ttf) format('truetype'),
					url({$theme_url}vamtam/assets/fonts/theme-icons/theme-icons.woff) format('woff'),
					url({$theme_url}vamtam/assets/fonts/theme-icons/theme-icons.svg#theme-icons) format('svg');
				font-weight: normal;
				font-style: normal;
			}
		";

		wp_add_inline_style( 'front-all', $theme_icons_css );
	}

	/**
	 * Admin styles
	 */
	public static function admin_styles() {
		if ( is_admin() ) {
			wp_enqueue_style( 'vamtam-admin-fonts', VAMTAM_ADMIN_ASSETS_URI . 'css/fonts.css' );
		}

		if ( ! self::is_our_admin_page() ) return;

		wp_enqueue_style( 'magnific', VAMTAM_ADMIN_ASSETS_URI . 'css/magnific.css' );
		wp_enqueue_style( 'vamtam_admin', VAMTAM_ADMIN_ASSETS_URI . 'css/vamtam_admin.css' );
		wp_enqueue_style( 'farbtastic' );
	}

	/**
	 * Customizer styles
	 */
	public static function customize_controls_enqueue_scripts() {
		$theme_version = VamtamFramework::get_version();

		wp_enqueue_style( 'vamtam-customizer', VAMTAM_ADMIN_ASSETS_URI . 'css/customizer.css', array(), $theme_version );

		wp_enqueue_script( 'vamtam-customize-controls-conditionals', VAMTAM_ADMIN_ASSETS_URI . 'js/customize-controls-conditionals.js', array( 'jquery', 'customize-controls' ), $theme_version, true );
	}

	public static function customize_preview_init() {
		$theme_version = VamtamFramework::get_version();

		wp_enqueue_script( 'vamtam-customizer-preview', VAMTAM_ADMIN_ASSETS_URI . 'js/customizer-preview.js', array( 'jquery', 'customize-preview' ), $theme_version, true );

		$hf_sidebar_widths = array(
			'header' => array( false, ),
			'footer' => array( false, ),
		);

		for ( $i = 1; $i <= 8; $i++ ) {
			$hf_sidebar_widths['header'][] = rd_vamtam_get_option( "header-sidebars-$i-width" );
			$hf_sidebar_widths['footer'][] = rd_vamtam_get_option( "footer-sidebars-$i-width" );
		}

		wp_localize_script(
			'vamtam-customizer-preview', 'VAMTAM_CUSTOMIZE_PREVIEW', array(
				'hf_sidebars'      => $hf_sidebar_widths,
				'compiler_options' => vamtam_custom_css_options(),
				'ajaxurl'          => admin_url( 'admin-ajax.php' )
			)
		);

		add_action( 'wp_head', array( __CLASS__, 'print_accents' ) );
	}

	public static function print_accents() {
		$accents = rd_vamtam_get_option( 'accent-color' );
		echo '<style id="vamtam-accents">';
		echo ':root {';

		foreach ( $accents as $id => $color ) {
			echo '--vamtam-accent-color-' . intval( $id ) . ': ' . sanitize_hex_color( $color ) . ';'; // xss ok
		}

		echo '}';
		echo '</style>';
	}
}
