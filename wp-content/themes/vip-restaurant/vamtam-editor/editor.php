<?php
/*
Plugin Name: Vamtam visual editor
Plugin URI: http://vamtam.com
Description: A drag and drop content editor
Version: 1
Author: Vamtam
Author URI: http://vamtam.com
License:
*/

/**
 * @package editor
 */

if ( ! defined( 'ABSPATH' ) ) die( 'Move along, nothing to see here.' );

final class Vamtam_Editor {
	private $elements = array();

	private static $instance;

	private $kses_args = array(
		'a' => array(
			'href' => array(),
			'title' => array(),
			'target' => array(),
		),
		'br' => array(),
		'em' => array(),
		'strong' => array(),
	);

	private function __construct() {
		$this->is_plugin = ! defined( 'VAMTAM_EDITOR_IN_THEME' );

		$this->url = $this->is_plugin ? plugin_dir_url( __FILE__ ) : VAMTAM_THEME_URI . 'vamtam-editor/';
		$this->dir = plugin_dir_path( __FILE__ );

		define( 'VAMTAM_EDITOR_ASSETS', $this->url . 'assets/' );
		define( 'VAMTAM_EDITOR_ASSETS_DIR', $this->dir . 'assets/' );

		add_action( 'admin_init', array( $this, 'admin_init' ), 0, 999 );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueues' ) );
		add_filter( 'vamtam-editor-available-shortcodes', array( $this, 'third_party_shortcodes' ) );

		add_filter( 'vamtam_escaped_shortcodes', array( __CLASS__, 'escape_shortcodes' ) );

		require_once $this->dir . 'ajax.php';
	}

	private function prepare_elements() {
		// use this to add filters for the elements' options config
		do_action( 'vamtam_editor_pre_register_elements' );

		// register all available elements
		do_action( 'vamtam_editor_register_elements' );

		// last chance to remove elements not supported by this theme
		$this->elements = apply_filters( 'vamtam_editor_registered_elements', $this->elements );
	}

	public function register_element( $id, $element ) {
		if ( isset( $this->elements[ $id ] ) ) {
			trigger_error( sprintf( esc_html__( 'VamTam Editor element %s is already registered.', 'wpv' ), $id ), E_USER_WARNING );

			return false;
		}

		$this->elements[ $id ] = $element;

		return true;
	}

	public static function escape_shortcodes( $codes ) {
		$codes = array_merge( array_keys( include plugin_dir_path( __FILE__ ) . 'available-shortcodes.php' ), $codes );
		$codes[] = 'vamtam_featured_products';
		$codes[] = 'tab';
		$codes[] = 'pane';
		$codes[] = 'split';
		$codes[] = 'rev_slider';
		$codes[] = 'vamtam_projects';
		$codes[] = 'vamtam_testimonials';
		$codes[] = 'column(?:_\d+)?';

		return $codes;
	}

	public function third_party_shortcodes( $available_shortcodes ) {
		if ( is_plugin_active( 'layerslider/layerslider.php' ) ) {
			$available_shortcodes['layerslider'] = 'layouts';
		}

		if ( is_plugin_active( 'revslider/revslider.php' ) ) {
			$available_shortcodes['rev_slider'] = 'layouts';
		}

		if ( class_exists( 'WPCF7_ContactForm' ) ) {
			$available_shortcodes['contact-form-7'] = 'layouts';
		}

		if ( class_exists( 'Ninja_Forms' ) ) {
			$available_shortcodes['ninja_forms'] = 'layouts';
		}

		if ( is_plugin_active( 'booked/booked.php' ) ) {
			$available_shortcodes['booked-calendar'] = 'layouts';
		}

		if ( is_plugin_active( 'woocommerce/woocommerce.php' ) ) {
			$available_shortcodes['vamtam_featured_products'] = 'layouts';
		}

		if ( is_plugin_active( 'vamtam-twitter/vamtam-twitter.php' ) ) {
			$available_shortcodes['vamtam_twitter'] = 'layouts';
		}

		if ( is_plugin_active( 'jetpack/jetpack.php' ) ) {
			$available_shortcodes['vamtam_testimonials'] = 'layouts';
			$available_shortcodes['vamtam_projects'] = 'layouts';
		}

		return $available_shortcodes;
	}

	public function admin_init() {
		add_action( 'edit_post', array( &$this, 'save_meta' ) );

		// for now, you must explicitly set which post types can use the editor
		$post_types = VamtamFramework::$complex_layout;
		foreach ( $post_types as $type ) {
			add_meta_box( 'vamtam_visual_editor', esc_html__( 'Visual Editor', 'wpv' ), array( &$this, 'editor' ), $type, 'advanced', 'low' );
		}

		$this->map_shortcodes();
	}

	public function enqueues() {
		wp_enqueue_script( 'vamtam-editor', $this->url . 'assets/js/editor.js', array( 'jquery', 'jquery-ui-tabs', 'jquery-ui-accordion', 'jquery-ui-droppable', 'jquery-ui-draggable', 'underscore' ), false, true );

		wp_enqueue_style( 'vamtam-editor', $this->url . 'assets/css/editor.css' );

		wp_localize_script( 'vamtam-editor', 'VAMTAMED_LANG', array(
			'empty_notice' => esc_html__( 'Please drag  any element you want here.', 'wpv' ),
		) );
	}

	/**
	 * outputs the basic html code for the editor in a meta box
	 */
	public function editor( $post, $metabox ) {
		include $this->dir . 'editor-tpl.php';
	}

	/**
	 * save some meta fields which are used to preserve the state of the editor
	 */
	public function save_meta( $post_id ) {
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return $post_id;

		$fields = array( '_vamtam_ed_js_status' );

		foreach ( $fields as $f ) {
			if ( isset( $_POST[ $f ] ) && ! empty( $_POST[ $f ] ) ) {
				update_post_meta( $post_id, $f, trim( $_POST[ $f ] ) );
			} else {
				delete_post_meta( $post_id, $f );
			}
		}
	}

	/**
	 * map the shortcode configuration generator files to $vamtam_sc and $vamtam_sc_menus
	 */
	public function map_shortcodes() {
		$this->prepare_elements();

		global $vamtam_sc, $vamtam_sc_menus;

		$vamtam_sc = array();
		$vamtam_sc_menus = array();

		$available_shortcodes = apply_filters( 'vamtam-editor-available-shortcodes', include $this->dir . 'available-shortcodes.php' );

		$sorted = array();

		foreach ( $this->elements as $slug => $args ) {
			if ( isset( $available_shortcodes[ $slug ] ) ) {
				$vamtam_sc[ $slug ] = $args;

				$sorted[ $slug ] = $args['name'];
			}
		}

		asort( $sorted );

		foreach ( $sorted as $slug => $name ) {
			$vamtam_sc_menus[ $available_shortcodes[ $slug ] ][] = $slug;
		}
	}

	private function complex_elements() {
		global $vamtam_sc, $vamtam_sc_menus;

		foreach ( $vamtam_sc_menus as $menu_name => $menu_codes ) : ?>
			<li class='<?php echo esc_attr( $menu_name )?>'>
				<ul>
					<?php foreach ( $menu_codes as $slug ) : ?>
						<?php
							$id    = "shortcode-$slug";
							$class = '';

							if ( $slug === 'column' )
								$id = $class = 'column-11';
						?>
						<li>
							<a id="<?php echo esc_attr( $id ) ?>" class="<?php echo esc_attr( $class ) ?> droppable_source clickable_action" href="javascript:void(0)">
								<?php
									if ( isset( $vamtam_sc[ $slug ]['icon'] ) ) :
										$icon = $vamtam_sc[ $slug ]['icon'];
								?>
									<span class="shortcode-icon" style="font-size:<?php echo esc_attr( $icon['size'] ) ?>;font-family:<?php echo esc_attr( $icon['family'] ) ?>;line-height:<?php echo esc_attr( $icon['lheight'] ) ?>"><?php echo esc_html( $icon['char'] ) ?></span>
								<?php endif ?>
								<span class="title"><?php echo esc_html( $vamtam_sc[ $slug ]['name'] ) ?></span>
							</a>
							<?php if ( isset( $vamtam_sc[ $slug ]['desc'] ) ) : ?>
								<div class="description">
									<span class="description-trigger va-icon va-icon-info"></span>
									<div>
										<section class="content"><?php echo wp_kses( $vamtam_sc[ $slug ]['desc'], $this->kses_args ) ?></section>
										<footer><a href="<?php echo esc_url( admin_url( 'admin.php?page=vamtam_help' ) ) ?>" title="<?php esc_attr_e( 'Read more in our documentation', 'wpv' ) ?>"><?php esc_html_e( 'Read more in our documentation', 'wpv' ) ?></a></footer>
									</div>
								</div>
							<?php endif ?>
						</li>
					<?php endforeach; ?>
				</ul>
			</li>
		<?php endforeach;
	}

	public static function get_icon( $key ) {
		$icons = include VAMTAM_EDITOR_ASSETS_DIR . 'fonts/icomoon/list.php';

		if ( isset( $icons[ $key ] ) )
			return "&#{$icons[$key]};";

		return $key;
	}

	public static function get_instance() {
		if ( ! isset( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}
}

Vamtam_Editor::get_instance();
