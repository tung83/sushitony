<?php

/**
 * Plugin Name: VamTam Elements (A)
 * Plugin URI: http://vamtam.com
 * Description: Drag&Drop elements and shortcodes used in VamTam themes
 * Version: 2.0.1
 * Author: Vamtam
 * Author URI: http://vamtam.com
 */

class Vamtam_Elements_A {

	// key is element id,
	// value determines whether the short code handler is ours (true) or third party (false)
	private $elements = array(
		'accordion' => true,
		'blank' => true,
		'blog' => true,
		'column' => true,
		'divider' => true,
		'iframe' => true,
		'linkarea' => true,
		'price' => true,
		'services' => true,
		'services_expandable' => true,
		'sitemap' => true,
		'slogan' => true,
		'tabs' => true,
		'team_member' => true,
		'text' => true,
		'text_divider' => true,
		'vamtam_countdown' => true,
		'vamtam_progress' => true,
		'vamtam_projects' => true,
		'vamtam_testimonials' => true,

		// third-party
		'contact-form-7' => false,
		'ninja_forms' => false,
		'layerslider' => false,
		'rev_slider' => false,
		'booked-calendar' => false,

		// third party, but partially implemented by us
		'vamtam_featured_products' => true,
		'vamtam_twitter' => true,
	);

	private $dir;

	private static $instance;

	public function __construct() {
		if ( ! class_exists( 'Vamtam_Updates' ) ) {
			require 'vamtam-updates/class-vamtam-updates.php';
		}

		$plugin_slug = basename( dirname( __FILE__ ) );
		$plugin_file = basename( __FILE__ );

		new Vamtam_Updates( array(
			'slug' => $plugin_slug,
			'main_file' => $plugin_slug . '/' . $plugin_file,
		) );

		$this->dir = plugin_dir_path( __FILE__ );

		include_once $this->dir . 'helpers.php';

		add_action( 'vamtam_editor_register_elements', array( $this, 'register_editor_elements' ) );
		add_action( 'init', array( $this, 'register_shortcodes' ) );

		add_action( 'before_vamtam_inline_shortcode_preview', array( $this, 'before_inline_shortcode_preview' ) );

		add_filter( 'widget_text', 'do_shortcode' );
		add_filter( 'widget_title', 'do_shortcode' );
	}

	public static function get_instance() {
		if ( ! isset( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	// register elements with the drag&drop editor
	public function register_editor_elements() {
		foreach ( $this->elements as $id => $has_handler ) {
			$args = apply_filters( 'vamtam_elements_config_' . $id, include( $this->dir . 'editor-elements/config/' . $id . '.php' ) );

			Vamtam_Editor::get_instance()->register_element( $id, $args );
		}
	}

	public function register_shortcodes() {
		foreach ( $this->elements as $id => $has_handler ) {
			if ( $has_handler ) {
				include_once $this->dir . 'editor-elements/handlers/' . $id . '.php';
			}
		}

		if ( defined( 'VAMTAM_METABOXES' ) ) {
			include $this->dir . 'shortcodes/gallery.php';

			$shortcodes = include VAMTAM_METABOXES . 'shortcode.php';

			foreach ( $shortcodes as $name ) {
				$longname = $this->dir . 'shortcodes/' . $name . '.php';

				if ( file_exists( $longname ) ) {
					require_once $longname;
				}
			}
		}
	}

	public function before_inline_shortcode_preview() {
		add_filter( 'show_admin_bar', '__return_false' );
	}

	public static function array_pluck( $key, $array ) {
		if ( is_array( $key ) || ! is_array( $array ) ) return array();
		$funct = create_function( '$e', '$e = (array)$e; return is_array($e) && array_key_exists("'.$key.'",$e) ? $e["'. $key .'"] : null;' );
		return array_map( $funct, $array );
	}

	public static function get_wpcf7_posts( $by = 'ID' ) {
		if ( ! class_exists( 'WPCF7_ContactForm' ) ) return array();

		$posts = get_posts( array(
			'posts_per_page' => -1,
			'post_type' => WPCF7_ContactForm::post_type,
		) );

		$data = self::array_pluck( $by, $posts );

		return array_combine( $data, $data );
	}

	public static function get_ninja_forms() {
		if ( ! class_exists( 'Ninja_Forms' ) ) return array();

		$result = array();

		if ( isset( Ninja_Forms()->forms ) ) {
			// 2.9

			$ids = Ninja_Forms()->forms->get_all();

			$result = array();

			foreach ( $ids as $form_id ) {
				$result[ $form_id ] = "($form_id) " . Ninja_Forms()->form( $form_id )->get_setting( 'form_title' );
			}
		} else {
			// 3.0

			$forms = Ninja_Forms()->form()->get_forms();

			foreach ( $forms as $form ) {
				$form_id = $form->get_id();

				$result[ $form_id ] = "($form_id) " . $form->get_setting( 'title' );
			}
		}

		return $result;
	}

	public static function get_booked_calendars() {
		if ( ! is_plugin_active( 'booked/booked.php' ) ) return array();

		$calendars = get_terms( 'booked_custom_calendars', array( 'orderby' => 'name', 'order' => 'ASC' ) );

		$result = array();

		foreach ( $calendars as $calendar ) {
			if ( is_object( $calendar ) ) {
				$result[ $calendar->term_id ] = $calendar->name;
			}
		}

		return $result;
	}

}

Vamtam_Elements_A::get_instance();
