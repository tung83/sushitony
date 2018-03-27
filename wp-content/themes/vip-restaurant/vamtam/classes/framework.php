<?php

/**
 * Vamtam Theme Framework base class
 *
 * @author Nikolay Yordanov <me@nyordanov.com>
 * @package vip-restaurant
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * This is the first loaded framework file
 *
 * VamtamFramework does the following ( in this order ):
 *  - sets constants for the frequently used paths
 *  - loads translations
 *  - loads the plugins bundled with the theme
 *  - loads some functions and helpers used in various places
 *  - sets the custom post types
 *  - loads the shortcode library for the framework
 *  - if this is wp-admin, load admin files
 *
 * This class also loads the custom widgets and sets what the theme supports ( + custom menus )
 */

class VamtamFramework {

	/**
	 * Cache the result of some operations in memory
	 *
	 * @var array
	 */
	private static $cache = array();

	/**
	 * Post types with double sidebars
	 */
	public static $complex_layout = array( 'page', 'post', 'jetpack-portfolio', 'product' );

	/**
	 * Initialize the Vamtam framework
	 * @param array $options framework options
	 */
	public function __construct( $options ) {
		// Autoload classes on demand
		if ( function_exists( '__autoload' ) )
			spl_autoload_register( '__autoload' );
		spl_autoload_register( array( $this, 'autoload' ) );

		$this->set_constants( $options );
		$this->load_languages();
		$this->load_functions();
		$this->load_shortcodes();
		$this->load_admin();

		require_once VAMTAM_DIR . 'classes/plugin-activation.php';
		require_once VAMTAM_SAMPLES_DIR . 'dependencies.php';

		add_action( 'after_setup_theme', array( &$this, 'theme_supports' ) );
		add_action( 'widgets_init', array( &$this, 'load_widgets' ) );
		add_filter( 'vamtam_purchase_code', create_function( '', 'return get_option( "vamtam-envato-license-key" );' ) );

		VamtamLoadMore::get_instance();
		VamtamHideWidgets::get_instance();
	}

	/**
	 * Autoload classes when needed
	 *
	 * @param  string $class class name
	 */
	public function autoload( $class ) {
		$class = strtolower( preg_replace( '/([a-z])([A-Z])/', '$1-$2', str_replace( '_', '', $class ) ) );

		if ( strpos( $class, 'vamtam-' ) === 0 ) {
			$path = trailingslashit( get_template_directory() ) . 'vamtam/classes/';
			$file = str_replace( 'vamtam-', '', $class ) . '.php';

			if ( is_readable( $path . $file ) ) {
				include_once( $path . $file );
				return;
			}

			if ( is_admin() ) {
				$admin_path = VAMTAM_ADMIN_DIR . 'classes/';

				if ( is_readable( $admin_path . $file ) ) {
					include_once( $admin_path . $file );
					return;
				}
			}
		}

	}

	/**
	 * Sets self::$cache[ $key ] = $value
	 *
	 * @param mixed $key
	 * @param mixed $value
	 */
	public static function set( $key, $value ) {
		self::$cache[ $key ] = $value;
	}

	/**
	 * Returns self::$cache[ $key ]
	 *
	 * @param  mixed $key
	 * @return mixed        value
	 */
	public static function get( $key, $default = false ) {
		return isset( self::$cache[ $key ] ) ? self::$cache[ $key ] : $default;
	}

	/**
	 * Get the theme version
	 *
	 * @return string theme version as defined in style.css
	 */
	public static function get_version() {
		if ( isset( self::$cache['version'] ) )
			return self::$cache['version'];

		$the_theme = wp_get_theme();
		if ( $the_theme->parent() ) {
			$the_theme = $the_theme->parent();
		}

		self::$cache['version'] = $the_theme->get( 'Version' );

		return self::$cache['version'];
	}

	/**
	 * Defines constants used by the theme
	 *
	 * @param array $options framework options
	 */
	private function set_constants( $options ) {
		define( 'VAMTAM_THEME_NAME', $options['name'] );
		define( 'VAMTAM_THEME_SLUG', $options['slug'] );

		// theme dir and uri
		define( 'VAMTAM_THEME_DIR', get_template_directory() . '/' );
		define( 'VAMTAM_THEME_URI', get_template_directory_uri() .'/' );

		// framework dir and uri
		define( 'VAMTAM_DIR', VAMTAM_THEME_DIR . 'vamtam/' );
		define( 'VAMTAM_URI', VAMTAM_THEME_URI . 'vamtam/' );

		// common assets dir and uri
		define( 'VAMTAM_ASSETS_DIR', VAMTAM_DIR . 'assets/' );
		define( 'VAMTAM_ASSETS_URI', VAMTAM_URI . 'assets/' );

		// common file paths
		define( 'VAMTAM_FONTS_URI',  VAMTAM_ASSETS_URI . 'fonts/' );
		define( 'VAMTAM_HELPERS',    VAMTAM_DIR . 'helpers/' );
		define( 'VAMTAM_JS',         VAMTAM_ASSETS_URI . 'js/' );
		define( 'VAMTAM_METABOXES',  VAMTAM_DIR . 'metaboxes/' );
		define( 'VAMTAM_OPTIONS',    VAMTAM_DIR . 'options/' );
		define( 'VAMTAM_PLUGINS',    VAMTAM_DIR . 'plugins/' );
		define( 'VAMTAM_SCGEN',      VAMTAM_DIR . 'shortcodes-generator/' );
		define( 'VAMTAM_CSS',        VAMTAM_ASSETS_URI . 'css/' );
		define( 'VAMTAM_CSS_DIR',    VAMTAM_ASSETS_DIR . 'css/' );
		define( 'VAMTAM_IMAGES',     VAMTAM_ASSETS_URI . 'images/' );
		define( 'VAMTAM_IMAGES_DIR', VAMTAM_ASSETS_DIR . 'images/' );

		// sample content
		define( 'VAMTAM_SAMPLES_DIR',   VAMTAM_THEME_DIR . 'samples/' );
		define( 'VAMTAM_SAMPLES_URI',   VAMTAM_THEME_URI . 'samples/' );
		define( 'VAMTAM_SAVED_OPTIONS', VAMTAM_SAMPLES_DIR . 'saved_skins/' );

		// cache
		define( 'VAMTAM_CACHE_DIR', VAMTAM_THEME_DIR . 'cache/' );
		define( 'VAMTAM_CACHE_URI', VAMTAM_THEME_URI . 'cache/' );

		// admin
		define( 'VAMTAM_ADMIN_DIR', VAMTAM_DIR . 'admin/' );
		define( 'VAMTAM_ADMIN_URI', VAMTAM_URI . 'admin/' );

		define( 'VAMTAM_ADMIN_AJAX',       VAMTAM_ADMIN_URI . 'ajax/' );
		define( 'VAMTAM_ADMIN_AJAX_DIR',   VAMTAM_ADMIN_DIR . 'ajax/' );
		define( 'VAMTAM_ADMIN_ASSETS_URI', VAMTAM_ADMIN_URI . 'assets/' );
		define( 'VAMTAM_ADMIN_HELPERS',    VAMTAM_ADMIN_DIR . 'helpers/' );
		define( 'VAMTAM_ADMIN_CGEN',       VAMTAM_ADMIN_HELPERS . 'config_generator/' );
		define( 'VAMTAM_ADMIN_METABOXES',  VAMTAM_ADMIN_DIR . 'metaboxes/' );
		define( 'VAMTAM_ADMIN_TEMPLATES',  VAMTAM_ADMIN_DIR . 'templates/' );
	}

	/**
	 * Register theme support for various features
	 */
	public function theme_supports() {
		global $content_width;

		self::set( 'is_responsive', apply_filters( 'vamtam-theme-responsive-mode', true ) );

		/**
		 * the max content width the css is built for should equal the actual content width,
		 * for example, the width of the text of a page without sidebars
		 */
		if ( ! isset( $content_width ) ) $content_width = rd_vamtam_get_option( 'site-max-width' );

		if ( is_customize_preview() ) {
			$content_width = 1400;
		}

		$post_formats = apply_filters( 'vamtam_post_formats', array( 'aside', 'link', 'image', 'video', 'audio', 'quote', 'gallery' ) );
		self::set( 'post_formats', $post_formats );

		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'automatic-feed-links' );
		add_theme_support( 'html5', array( 'comment-list', 'comment-form', 'search-form', 'gallery', 'caption' ) );
		add_theme_support( 'post-formats', $post_formats );
		add_theme_support( 'title-tag' );

		add_theme_support( 'vamtam-ajax-siblings' );
		add_theme_support( 'vamtam-page-title-style' );
		add_theme_support( 'vamtam-centered-text-divider' );
		add_theme_support( 'vamtam-foodpress-import' );

		add_theme_support( 'customize-selective-refresh-widgets' );

		if ( class_exists( 'Jetpack_Portfolio' ) ) {
			add_post_type_support( Jetpack_Portfolio::CUSTOM_POST_TYPE, 'excerpt' );
		}

		if ( function_exists( 'register_nav_menus' ) ) {
			register_nav_menus(
				array(
					'menu-header' => esc_html__( 'Menu Header', 'wpv' ),
					'menu-top'    => esc_html__( 'Menu Top', 'wpv' ),
				)
			);
		}

		add_image_size( 'posts-widget-thumb', 60, 60, true );
		add_image_size( 'posts-widget-thumb-small', 43, 43, true );

		$size_names = array( 'theme-single', 'theme-loop' );
		$size_info  = array();

		$wth = get_option( 'vamtam_featured_images_ratio', array(
			'theme-loop'   => 1.3,
			'theme-single' => 1.3,
		) );

		foreach ( $size_names as $name ) {
			$size_info[ $name ] = (object) array(
				'wth' => abs( floatval( $wth[ $name ] ) ),
				'crop' => true,
			);
		}

		$width = $content_width;

		$single_sizes     = array( 'theme-single' );
		$columnated_sizes = array( 'theme-loop' );

		foreach ( $single_sizes as $name ) {
			$height = $size_info[ $name ]->wth ? $width / $size_info[ $name ]->wth : false;
			add_image_size( $name, $width, $height, $size_info[ $name ]->crop );
		}

		for ( $num_columns = 1; $num_columns <= 4; $num_columns++ ) {
			$small_width = ( $width + 30 ) / $num_columns - 30;
			$small_width = ( $width + 30 ) / $num_columns - 30;

			add_image_size( 'theme-normal-' . $num_columns, $small_width, 0 ); // special case where we always use the original proportions
			add_image_size( 'theme-normal-featured-' . $num_columns, $small_width * 2, 0 ); // same, but double width

			foreach ( $columnated_sizes as $name ) {
				$col_width = ( $width + 30 ) / $num_columns - 30;
				$height    = $size_info[ $name ]->wth ? $col_width / $size_info[ $name ]->wth : false;

				add_image_size( $name . '-' . $num_columns, $col_width, $height, $size_info[ $name ]->crop );
				add_image_size( $name . '-featured-' . $num_columns, $col_width * 2, $height * 2, $size_info[ $name ]->crop );
			}
		}
	}

	/**
	 * Load interface translations
	 */
	private function load_languages() {
		load_theme_textdomain( 'wpv', VAMTAM_THEME_DIR . 'languages' );
	}

	/**
	 * Loads the main php files used by the framework
	 */
	private function load_functions() {
		global $vamtam_defaults, $vamtam_fonts;
		$vamtam_defaults = include VAMTAM_SAMPLES_DIR . 'default-options.php';
		$vamtam_fonts    = include VAMTAM_HELPERS . 'fonts.php';

		require_once VAMTAM_HELPERS . 'init.php';

		$custom_fonts = get_option( 'vamtam_custom_font_families', '' );
		if ( ! empty( $custom_fonts ) ) {
			$custom_fonts = explode( "\n", $custom_fonts );

			$vamtam_fonts['-- Custom fonts --'] = array( 'family' => '' );

			foreach ( $custom_fonts as $font ) {
				$font = preg_replace( '/["\']+/', '', trim( $font ) );

				$vamtam_fonts[ $font ] = array(
					'family' => '"' . $font . '"',
					'weights' => array( '300', '300 italic', 'normal', 'italic', '600', '600 italic', 'bold', 'bold italic', '800', '800 italic' ),
				);
			}
		}

		require_once VAMTAM_HELPERS . 'woocommerce-integration.php';
		require_once VAMTAM_HELPERS . 'megamenu-integration.php';

		require_once VAMTAM_HELPERS . 'icons.php';

		require_once VAMTAM_HELPERS . 'file.php';

		VamtamFormatFilter::actions();

		require_once VAMTAM_HELPERS . 'base.php';
		require_once VAMTAM_HELPERS . 'template.php';
		require_once VAMTAM_HELPERS . 'css.php';

		VamtamOverrides::filters();
		VamtamEnqueues::actions();
	}

	/**
	 * Load shortcodes
	 */
	private function load_shortcodes() {
		add_action( 'template_redirect', array( $this, 'shortcode_preview' ) );
	}

	public function shortcode_preview() {
		if ( isset( $_GET['vamtam_shortcode_preview'] ) ) {
			require_once VAMTAM_ADMIN_AJAX_DIR . 'shortcode-preview.php';

			exit;
		}
	}

	/**
	 * Load widgets
	 */
	public function load_widgets() {
		$vamtam_sidebars = VamtamSidebars::get_instance();

		$vamtam_sidebars->register_sidebars();

		$widgets = apply_filters( 'vamtam-enabled-widgets', array(
			'authors',
			'icon-link',
			'posts',
			'subpages',
		) );

		foreach ( $widgets as $name ) {
			require_once VAMTAM_DIR . "widgets/$name.php";
		}
	}

	/**
	 * Loads the theme administration code
	 */
	private function load_admin() {
		if ( ! is_admin() ) return;

		VamtamAdmin::actions();
	}
}
