<?php

/**
 * Various filters and actions configuring some of the shortcodes
 *
 * @package vip-restaurant
 */

/**
 * class VamtamOverrides
 */
class VamtamOverrides {

	/**
	 * add filters
	 */
	public static function filters() {
		add_filter( 'vamtam_multiwidget_tab_title', array( __CLASS__, 'multiwidget_tab_title' ), 10, 3 );
		add_action( 'vamtam_multiwidget_single_title', array( __CLASS__, 'multiwidget_single_title' ), 10, 2 );
		add_filter( 'vamtam_posts_widget_thumbnail_name', array( __CLASS__, 'posts_widget_thumbnail_name' ), 10, 2 );
		add_filter( 'vamtam_posts_widget_img_size', array( __CLASS__, 'posts_widget_img_size' ), 10, 2 );
		add_filter( 'vamtam_column_title', array( __CLASS__, 'column_title' ), 10, 2 );

		add_filter( 'excerpt_length', array( __CLASS__, 'excerpt_length' ) );
		add_filter( 'excerpt_more', array( __CLASS__, 'excerpt_more' ) );
		add_filter( 'wp_trim_excerpt', array( __CLASS__, 'prepare_excerpt' ), 1, 2 );

		add_filter( 'wp_title', array( __CLASS__, 'wp_title' ) );

		wp_embed_register_handler( 'vamtam-swf', '#https?://[^\s]+?.swf$#i', array( __CLASS__, 'embed_handler_swf' ) );

		add_filter( 'pre_option_page_for_posts', '__return_zero' );

		add_filter( 'oembed_dataparse', array( __CLASS__, 'oembed_dataparse' ), 90, 3 );

		add_filter( 'nav_menu_css_class', array( __CLASS__, 'nav_menu_css_class' ), 10, 2 );
		add_filter( 'nav_menu_css_class', array( __CLASS__, 'nav_menu_css_class' ), 11, 2 );
		add_filter( 'megamenu_nav_menu_css_class', array( __CLASS__, 'nav_menu_css_class' ), 10, 2 );
		add_filter( 'megamenu_nav_menu_css_class', array( __CLASS__, 'nav_menu_css_class' ), 11, 2 );

		add_action( 'vamtam_body', array( __CLASS__, 'vamtam_splash_screen' ) );

		add_filter( 'wpcf7_form_elements', array( __CLASS__, 'shortcodes_in_cf7' ) );

		add_filter( 'pre_option_vamtam_header-layout', array( __CLASS__, 'header_layout' ) );

		add_action( 'loop_start', array( __CLASS__, 'jetpack_remove_share' ) );

		add_action( 'wp_footer', array( __CLASS__, 'post_siblings' ) );

		add_filter( 'fp_menu_image_size_regular', array( __CLASS__, 'fp_menu_image_size' ) );
		add_filter( 'fp_menu_image_size_full', array( __CLASS__, 'fp_menu_image_size' ) );

		add_action( 'fp_interpret_menu_item_html_start', array( __CLASS__, 'unlimited_image_sizes' ) );
		add_action( 'fp_interpret_menu_item_html_end', array( __CLASS__, 'limit_image_sizes' ) );
	}

	public static function fp_menu_image_size( $size ) {
		return 'theme-normal-4';
	}

	public static function unlimited_image_sizes() {
		add_filter( 'wp_calculate_image_sizes', array( __CLASS__, 'wp_calculate_image_sizes' ), 10, 5 );
	}

	public static function limit_image_sizes() {
		remove_filter( 'wp_calculate_image_sizes', array( __CLASS__, 'wp_calculate_image_sizes' ), 10, 5 );
	}

	public static function wp_calculate_image_sizes( $sizes, $size, $image_src, $image_meta, $attachment_id ) {
		return '(min-width: 900px) 50vw, 100vw';
	}

	public static function post_siblings() {
		if ( VamtamTemplates::has_post_siblings_buttons() ) {
			get_template_part( 'templates/post-siblings-links' );
		}
	}

	public static function prepare_excerpt( $text = '', $raw_excerpt ) {
		if ( '' == $raw_excerpt ) {
			$text = get_the_content( '' );

			$text = VamtamTemplates::remove_outer_columns( $text );

			$text = strip_shortcodes( $text );

			/** This filter is documented in wp-includes/post-template.php */
			$text = apply_filters( 'the_content', $text );
			$text = str_replace( ']]>', ']]&gt;', $text );

			$excerpt_length = apply_filters( 'excerpt_length', 40 );

			$excerpt_more = apply_filters( 'excerpt_more', ' [&hellip;]' );

			$text = wp_trim_words( $text, $excerpt_length, $excerpt_more );
		}

		return $text;
	}

	public static function jetpack_remove_share() {
		remove_filter( 'the_content', 'sharing_display',19 );
		remove_filter( 'the_excerpt', 'sharing_display',19 );

		if ( class_exists( 'Jetpack_Likes' ) ) {
			remove_filter( 'the_content', array( Jetpack_Likes::init(), 'post_likes' ), 30, 1 );
		}
	}

	public static function header_layout( $layout ) {
		$logo_type = rd_vamtam_get_option( 'header-logo-type' );

		if ( $logo_type === 'names' ) {
			return 'standard';
		}

		return $layout;
	}

	public static function wp_title( $title ) {
		if ( empty( $title ) && ( is_home() || is_front_page() ) ) {
			$description = get_bloginfo( 'description' );
			return get_bloginfo( 'name' ) . ( ! empty( $description ) ? ' | ' . $description : '' );
		}

		return $title;
	}

	/**
	 * enable any shortcodes in CF7
	 * @param  string $form original html
	 * @return string       parsed with do_shortcode
	 */
	public static function shortcodes_in_cf7( $form ) {
		return do_shortcode( vamtam_fix_shortcodes( $form ) );
	}

	/**
	 * Show a splash screen on some pages
	 */
	public static function vamtam_splash_screen() {
		$local = vamtam_post_meta( null, 'show-splash-screen-local', true );

		$enabled = $local === 'default' ? rd_vamtam_get_option( 'show-splash-screen' ) : vamtam_sanitize_bool( $local );

		$style = '';

		if ( ! $enabled ) {
			if ( ! is_customize_preview() ) {
				return;
			}

			$style = 'style="display: none"'; // we need the html for the customizer preview, but there is no need to show it on the first load
		}

		$logo = rd_vamtam_get_option( 'splash-screen-logo' );

		echo '
		<div class="vamtam-splash-screen" ' . $style . '>
			<div class="vamtam-splash-screen-progress-wrapper">'; // xss ok

		if ( ! empty( $logo ) ) {
			vamtam_url_to_image( $logo, 'full' );
		}

		echo '<div class="vamtam-splash-screen-progress"></div>
			</div>
		</div>';
	}

	/**
	 * Remove unnecessary menu item classes
	 *
	 * @param  array  $classes current menu item classes
	 * @param  object $item    menu item
	 * @param  object $args    menu item args
	 * @return array           filtered classes
	 */
	public static function nav_menu_css_class( $classes, $item ) {
		if ( isset( $item->url ) && strpos( $item->url, '#' ) !== false && ( $key = array_search( 'mega-current-menu-item', $classes ) ) !== false ) {
			unset( $classes[ $key ] );
			$classes[] = 'maybe-current-menu-item';

			$GLOBALS['vamtam_menu_had_hash'] = true;
		}

		if ( isset( $GLOBALS['vamtam_menu_had_hash'] ) && $GLOBALS['vamtam_menu_had_hash'] ) {
			$classes = array_diff( $classes, array( 'mega-current-menu-item', 'mega-current-menu-ancestor', 'mega-current-menu-parent' ) );
		}

		return $classes;
	}

	/**
	 * Wrap oEmbeds in .vamtam-video-frame
	 *
	 * @param  string $output original oembed output
	 * @param  object $data   data from the oEmbed provider
	 * @param  string $url    original embed url
	 * @return string         $output wrapped in additional html
	 */
	public static function oembed_dataparse( $output, $data, $url ) {
		if ( $data->type == 'video' )
			return '<div class="vamtam-video-frame">'.$output.'</div>';

		return $output;
	}

	/**
	 * Returns the HTML for the column titles, based on their type
	 *
	 * @param  string $title title text
	 * @param  string $type  title type
	 * @return string        column title html
	 */
	public static function column_title( $title, $type ) {
		if ( $type === 'no-divider' )
			return "<h2 class='column-title'>$title</h2>";

		return Vamtam_Text_Divider::shortcode( array(
			'more' => '',
			'type' => $type,
		), $title );
	}

	/**
	 * Implements .swf oEmbeds
	 *
	 * @param  array  $matches preg_match matches
	 * @param  array  $attr    embed attributes
	 * @param  string $url     embed url
	 * @param  array  $rawattr raw attributes
	 * @return string          output html
	 */
	public static function embed_handler_swf( $matches, $attr, $url, $rawattr ) {
		$embed = sprintf(
			'
	<div class="vamtam-video-frame">
		<object width="%2$s" height="%3$s" type="application/x-shockwave-flash" data="%1$s">
			<param name="movie" value="%1$s" />
			<param name="allowFullScreen" value="true" />
			<param name="allowscriptaccess" value="always" />
			<param name="wmode" value="transparent" />
			<embed src="%1$s" type="application/x-shockwave-flash" wmode="transparent" allowscriptaccess="always" allowfullscreen="true" width="%2$s" height="%3$s" />
		</object>
	</div>',
			esc_attr( $matches[0] ),
			esc_attr( $attr['width'] ),
			esc_attr( $attr['height'] )
		);

		return apply_filters( 'vamtam_embed_swf', $embed, $matches, $attr, $url, $rawattr );
	}

	/**
	 * Correct image size for the multiwidget images
	 *
	 * @param  int    $img_size original image size
	 * @param  array  $args     widget arguments
	 * @return int              image size
	 */
	public static function posts_widget_img_size( $img_size, $args ) {
		if ( strpos( $args['id'], 'footer-sidebar' ) !== false )
			return 43;

		return 350;
	}

	/**
	 * Correct thumbnail name for the multiwidget images
	 *
	 * @param  string $img_size original thumbnail
	 * @param  array  $args     widget arguments
	 * @return string           thumbnail name
	 */
	public static function posts_widget_thumbnail_name( $img_size, $args ) {
		if ( strpos( $args['id'], 'footer-sidebar' ) !== false )
			return 'posts-widget-thumb-small';

		return 'posts-widget-thumb';
	}

	/**
	 * Sets the excerpt length
	 *
	 * @param  int $length original length
	 * @return int         excerpt length
	 */
	public static function excerpt_length( $length ) {
		global $vamtam_loop_vars;

		if ( isset( $vamtam_loop_vars ) && $vamtam_loop_vars['news'] )
			return 15;

		return $length;
	}

	/**
	 * Sets the excerpt ending
	 *
	 * @param  string $more original ending
	 * @return string         excerpt ending
	 */
	public static function excerpt_more( $more ) {
		return '...';
	}

	/**
	 * Add the tabbed widget icons
	 * @param  string $title  current tab title
	 * @param  string $slug   current tab slug
	 * @param  string $single if this is the only tab shown
	 * @return string         current tab title with icon
	 */
	public static function multiwidget_tab_title( $title, $slug, $single ) {
		if ( $single )
			return '';

		$icons = array(
			'comment_count' => 'theme-heart',
			'date' => 'theme-pencil',
			'comments' => 'theme-comment',
			'tags' => 'theme-tag',
		);

		if ( isset( $icons[ $slug ] ) ) {
			$title = esc_attr( $title );
			return "<span title='$title'>".do_shortcode( '[icon name="'.$icons[ $slug ].'"]' ).'</span>';
		}

		return $title;
	}

	/**
	 * Show the tab title if only one tab is to be displayed
	 * @param  string $only  tab slug
	 * @param  string $title tab title
	 */
	public static function multiwidget_single_title( $only, $title ) {
		echo wp_kses_post( $title );
	}
}
