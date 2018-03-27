<?php

/**
 * Framework admin enhancements
 *
 * @author Nikolay Yordanov <me@nyordanov.com>
 * @package vip-restaurant
 */

/**
 * class VamtamAdmin
 */
class VamtamAdmin {
	/**
	 * Initialize the theme admin
	 */
	public static function actions() {
		if ( ! defined( 'DOING_AJAX') || ! DOING_AJAX ) {
			add_action( 'admin_init', array( 'VamtamUpdateNotice', 'check' ) );
		}

		add_action( 'admin_footer', array( __CLASS__, 'icons_selector' ) );

		add_action( 'add_meta_boxes', array( __CLASS__, 'load_metaboxes' ) );
		add_action( 'save_post', array( __CLASS__, 'load_metaboxes' ) );

		add_filter( 'admin_notices', array( __CLASS__, 'update_warning' ) );

		add_action( 'admin_init', array( __CLASS__, 'setup_settings' ) );

		require_once VAMTAM_ADMIN_METABOXES . 'shortcode.php';

		self::load_functions();

		new VamtamIconsHelper;
		new VamtamPurchaseHelper;
		new VamtamHelpPage;
		new VamtamFontsHelper;
		new VamtamCustomizerLocalCssAjax;

		require_once VAMTAM_ADMIN_HELPERS . 'updates/version-checker.php';

		if ( ! get_option( VAMTAM_THEME_SLUG.'_vamtam_theme_activated', false ) ) {
			update_option( VAMTAM_THEME_SLUG.'_vamtam_theme_activated', true );
			delete_option( 'default_comment_status' );
		}
	}

	public static function setup_settings() {
		add_settings_field( 'vamtam_custom_font_families', esc_html__( 'Custom Font Families', 'wpv' ), array( __CLASS__, 'custom_font_families_settings_field' ), 'general' );

		register_setting( 'general', 'vamtam_custom_font_families' );

		add_settings_field( 'vamtam_featured_images_ratio', esc_html__( 'Featured images width-to-height ratio', 'wpv' ), array( __CLASS__, 'featured_images_settings_field' ), 'media' );

		register_setting( 'media', 'vamtam_featured_images_ratio' );
	}

	public static function custom_font_families_settings_field() {
		$value = get_option( 'vamtam_custom_font_families' );

?>
		<textarea name="vamtam_custom_font_families" class="large-text" aria-describedby="vamtam_custom_font_families-description" rows="5"><?php echo esc_textarea( $value ) ?></textarea>
		<p class="description" id="vamtam_custom_font_families-description"><?php esc_html_e( 'If you need any custom font families in the VamTam typography options, list one font family per line here. Quotes are not necessary.', 'wpv' ) ?></p>
<?php
	}

	public static function featured_images_settings_field() {
		$values = get_option( 'vamtam_featured_images_ratio', array(
			'theme-loop'   => 0,
			'theme-single' => 1.3,
		) );
?>
		<fieldset><legend class="screen-reader-text"><span>Large size</span></legend>
		<label for="vamtam_featured_images_ratio[theme-loop]"><?php esc_html_e( 'Listing', 'wpv') ?></label>
		<input name="vamtam_featured_images_ratio[theme-loop]" step="0.05" min="0" id="vamtam_featured_images_ratio[theme-loop]" value="<?php echo esc_attr( $values['theme-loop'] ) ?>" class="small-text" type="number">
		<label for="vamtam_featured_images_ratio[theme-single]"><?php esc_html_e( 'Single', 'wpv') ?></label>
		<input name="vamtam_featured_images_ratio[theme-single]" step="0.05" min="0" id="vamtam_featured_images_ratio[theme-single]" value="<?php echo esc_attr( $values['theme-single'] ) ?>" class="small-text" type="number">
		<p class="description"><?php esc_html_e( 'Set this to 0 if you prefer not to crop the images.', 'wpv' ) ?></p>
		<p class="description"><?php echo wp_kses_post( sprintf( __( 'If you have changed any of these options, please use the <a href="%s" title="Regenerate thumbnails" target="_blank">Regenerate thumbnails</a> plugin in order to update your images.', 'wpv' ), 'http://wordpress.org/extend/plugins/regenerate-thumbnails/' ) ) ?>
		</fieldset>
<?php
	}

	public static function update_warning() {
		if ( did_action( 'load-update-core.php' ) ) {
			echo '<div class="updated notice fade is-dismissible"><p><strong>'; ;
			esc_html_e( 'Hey, just a polite reminder that if you update WordPress you will also need to update your theme and plugins.', 'wpv' );
			echo '</strong>';
			echo '</p><p>';
			printf( wp_kses_post( __( 'You should see any available theme updates on this page if you have entered your purchase information in <a href="%s">Settings / VamTam Purchase</a>', 'wpv' ) ), esc_url( admin_url( 'options-general.php?page=vamtam_theme_setup' ) ) );
			echo '</p><p>';
			esc_html_e( "Please note that if we haven't released an update, you shouldn't update your WordPress and plugins until we release one. Otherwise you may run into various compatibility issues.", 'wpv' );
			echo '</p><p>';
			printf( wp_kses_post( __( 'If you are unsure as to whether it is safe to update your site, please do ask us at <a href="%s" target="_blank">%s</a> and we\'ll help you.', 'wpv' ) ), esc_url( 'http://support.vamtam.com' ), 'our support site' );
			echo '</p></div>';
		}

		if ( did_action( 'load-update-core.php' ) || did_action( 'load-themes.php' ) ) {
			echo '<div class="notice is-dismissible"><p><strong>'; ;
			esc_html_e( 'VamTam theme resources: ', 'wpv' );
			echo '</strong>';
			echo '<a href="https://vamtam.com/child-themes" target="_blank">';
			esc_html_e( 'Sample child themes', 'wpv' );
			echo '</a>; ';
			echo '<a href="https://vamtam.com/changelog" target="_blank">';
			esc_html_e( 'Changelog', 'wpv' );
			echo '</a>';
			echo '</p></div>';
		}
	}

	public static function icons_selector() {
		?>
		<div class="vamtam-config-icons-selector hidden">
			<input type="search" placeholder="<?php esc_attr_e( 'Filter icons', 'wpv' ) ?>" class="icons-filter"/>
			<div class="icons-wrapper spinner">
				<input type="radio" value="" checked="checked"/>
			</div>
		</div>
		<?php
	}

	/**
	 * Theme metaboxes
	 *
	 * @param int|null $post_id  id of the current post ( if any )
	 */
	public static function load_metaboxes( $post_id = null ) {
		$config = array(
			'id' => 'testimonials-post-options',
			'title' => esc_html__( 'VamTam Testimonials', 'wpv' ),
			'pages' => array( 'jetpack-testimonial' ),
			'context' => 'normal',
			'priority' => 'high',
			'post_id' => $post_id,
		);

		$options = include VAMTAM_METABOXES . 'testimonials.php';
		new VamtamMetaboxesGenerator( $config, $options );

		$config = array(
			'id' => 'vamtam-post-format-options',
			'title' => esc_html__( 'VamTam Post Formats', 'wpv' ),
			'pages' => array( 'post' ),
			'context' => 'normal',
			'priority' => 'high',
			'post_id' => $post_id,
		);

		$options = include VAMTAM_METABOXES . 'post-formats.php';
		new VamtamMetaboxesGenerator( $config, $options );

		$config = array(
			'id' => 'vamtam-portfolio-format-options',
			'title' => esc_html__( 'Project Formats', 'wpv' ),
			'pages' => array( 'jetpack-portfolio' ),
			'context' => 'normal',
			'priority' => 'high',
			'post_id' => $post_id,
		);

		$options = include VAMTAM_METABOXES . 'portfolio-formats.php';
		new VamtamMetaboxesGenerator( $config, $options );

		$config = array(
			'id' => 'vamtam-portfolio-formats-select',
			'title' => esc_html__( 'Project Format', 'wpv' ),
			'pages' => array( 'jetpack-portfolio' ),
			'context' => 'side',
			'priority' => 'high',
			'post_id' => $post_id,
		);

		$options = include VAMTAM_METABOXES . 'portfolio-formats-select.php';
		new VamtamMetaboxesGenerator( $config, $options );

		$config = array(
			'id' => 'general-post-options',
			'title' => esc_html__( 'VamTam Options', 'wpv' ),
			'pages' => VamtamFramework::$complex_layout,
			'context' => 'normal',
			'priority' => 'high',
			'post_id' => $post_id,
		);

		$options = include VAMTAM_METABOXES . 'general.php';
		new VamtamMetaboxesGenerator( $config, $options );
	}

	/**
	 * Admin helper functions
	 */
	private static function load_functions() {
		require_once VAMTAM_ADMIN_HELPERS . 'base.php';
		require_once VAMTAM_ADMIN_AJAX_DIR . 'base.php';
	}
}
