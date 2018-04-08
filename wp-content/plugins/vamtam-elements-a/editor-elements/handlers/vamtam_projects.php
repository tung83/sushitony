<?php

/**
 * Portfolio shortcode handler
 *
 * @package editor
 */

/**
 * class Vamtam_Projects
 */
class Vamtam_Projects {
	public static $defaults;

	/**
	 * Register the shortcode
	 */
	public function __construct() {
		add_shortcode( 'vamtam_projects', array( __CLASS__, 'shortcode' ) );

		self::$defaults = array(
			'column'             => 4,
			'type'               => '',
			'ids'                => '',
			'max'                => 4,
			'height'             => 400,
			'show_title'         => 'false',
			'desc'               => 'false',
			'nopaging'           => 'false',
			'layout'             => 'static',
			'link_opens'         => 'single',
			'title_filter'       => false,
			'category_filter'    => false,
			'image_aspect_ratio' => 'fixed',
			'post__not_in'       => '',
			'class'              => '',
		);
	}

	/**
	 * Portfolio shortcode callback
	 *
	 * @param  array  $atts    shortcode attributes
	 * @param  string $content shortcode content
	 * @param  string $code    shortcode name
	 * @return string          output html
	 */
	public static function shortcode( $atts, $content = null, $code = 'vamtam_projects' ) {
		if ( ! class_exists( 'Jetpack_Portfolio' ) ) {
			return 'Jetpack_Portfolio not found.';
		}

		global $post;

		$orig_atts = $atts;
		$atts = shortcode_atts( self::$defaults, $atts );

		extract( $atts );

		$type = empty( $type ) ?
				array() :
				( is_array( $type ) ? $type : explode( ',', $type ) );

		$desc = vamtam_sanitize_bool( $desc );

		$title_filter    = vamtam_sanitize_bool( $title_filter );
		$category_filter = vamtam_sanitize_bool( $category_filter );

		// number of columns - get the css class
		$column = intval( $column );

		$max_columns = $column;

		if ( 0 === $column ) {
			$column = 4; // this is used for thumbnails only
		}

		$scrollable = $layout === 'scrollable';

		if ( $scrollable ) {
			$nopaging           = 'true';
			$image_aspect_ratio = 'fixed';
		}

		$old_column                      = isset( $GLOBALS['vamtam_portfolio_column'] ) ? $GLOBALS['vamtam_portfolio_column'] : null;
		$GLOBALS['vamtam_portfolio_column'] = $column;

		$query = array(
			'post_type' => Jetpack_Portfolio::CUSTOM_POST_TYPE,
			'orderby'   => array(
				'menu_order' => 'ASC',
				'date'       => 'DESC',
			),
			'posts_per_page' => $max,
			'paged'          => $nopaging === 'false' ? (
			                    ( get_query_var( 'paged' ) > 1 ) ?
			                      get_query_var( 'paged' ) : ( get_query_var( 'page' ) ?
			                                                   get_query_var( 'page' ) : 1 )
			                    ) : 1,
		);

		if ( ! empty( $type ) && ! empty( $type[0] ) ) {
			$query['tax_query'] = array(
				array(
					'taxonomy' => 'jetpack-portfolio-type',
					'field'    => 'slug',
					'terms'    => $type,
				),
			);
		}

		if ( $ids && $ids != 'null' ) {
			$query['post__in'] = explode( ',',$ids );
		}

		if ( ! empty( $post__not_in ) ) {
			$query['post__not_in'] = explode( ',',$post__not_in );
		}

		$portfolio_query = new WP_Query( $query );

		ob_start();

		if ( $scrollable ) {
			include locate_template( 'templates/portfolio/scrollable.php' );
		} else {
			include locate_template( 'templates/portfolio/loop.php' );
		}

		$GLOBALS['vamtam_portfolio_column'] = $old_column;

		wp_reset_postdata();

		return ob_get_clean();
	}

	/**
	 * Returns the number of projects in a list of types
	 * @param  array $categories array of categories
	 * @return int               number of items
	 */
	public static function in_category( $categories ) {
		if ( ! class_exists( 'Jetpack_Portfolio' ) ) {
			return 0;
		}

		$query = new WP_Query( array(
			'post_type' => Jetpack_Portfolio::CUSTOM_POST_TYPE,
			'tax_query' => array(
				array(
					'taxonomy' => Jetpack_Portfolio::CUSTOM_TAXONOMY_TYPE,
					'field'    => 'slug',
					'terms'    => $categories,
				),
			),
			'posts_per_page' => -1,
		) );

		return $query->post_count;
	}
}

new Vamtam_Projects;
