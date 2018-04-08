<?php

/**
 * Testimonials shortcode handler
 *
 * @package editor
 */

/**
 * class Vamtam_Testimonials
 */
class Vamtam_Testimonials {
	/**
	 * Register the shortcodes
	 */
	public function __construct() {
		add_shortcode( 'vamtam_testimonials', array( __CLASS__, 'dispatch' ) );
	}

	/**
	 * Testimonials shortcode callback
	 *
	 * @param  array  $atts    shortcode attributes
	 * @param  string $content shortcode content
	 * @param  string $code    shortcode name
	 * @return string          output html
	 */
	public static function dispatch( $atts, $content, $code ) {
		$raw_atts = $atts;
		$atts = shortcode_atts( array(
			'layout'     => 'slider',
			'ids'        => '',
			'autorotate' => false,
		), $atts );

		$query = array(
			'post_type'      => 'jetpack-testimonial',
			'orderby'        => 'menu_order',
			'order'          => 'DESC',
			'posts_per_page' => -1,
		);

		if ( $atts['ids'] && $atts['ids'] !== 'null' ) {
			$query['post__in'] = explode( ',', $atts['ids'] );
		}

		$q = new WP_Query( $query );

		$output = '';

		if ( $atts['layout'] === 'slider' ) {
			wp_enqueue_script( 'cubeportfolio' );
			wp_enqueue_style( 'cubeportfolio' );

			$slider_options = array(
				'layoutMode' => 'slider',
				'drag' => true,
				'auto' => vamtam_sanitize_bool( $atts['autorotate'] ),
				'autoTimeout' => 5000,
				'autoPauseOnHover' => true,
				'showNavigation' => false,
				'showPagination' => true,
				'rewindNav' => true,
				'scrollByPage' => false,
				'gridAdjustment' => 'responsive',
				'mediaQueries' => array( array(
					'width' => 1,
					'cols' => 1,
				),
),
				'gapHorizontal' => 0,
				'gapVertical' => 0,
				'caption' => '',
				'displayType' => 'default',
			);

			$output .= '<div class="vamtam-cubeportfolio cbp cbp-slider-edge vamtam-testimonials-slider" data-options="' . esc_attr( json_encode( $slider_options ) ) . '">';

			while ( $q->have_posts() ) {
				$q->the_post();

				$output .= '<div class="cbp-item">';
				$output .= self::format();
				$output .= '</div>';
			}

			$output .= '</div>';
		} else {
			$output .= '<div class="blockquote-list">';

			while ( $q->have_posts() ) {
				$q->the_post();

				$output .= self::format();
			}

			$output .= '</div>';
		}

		wp_reset_postdata();

		return $output;
	}

	private static function format() {
		$content = get_the_content();
		$cite    = get_post_meta( get_the_ID(), 'testimonial-author', true );
		$link    = get_post_meta( get_the_ID(), 'testimonial-link', true );
		$rating  = (int) get_post_meta( get_the_ID(), 'testimonial-rating', true );
		$summary = get_post_meta( get_the_ID(), 'testimonial-summary', true );
		$title   = get_the_title();

		if ( ! empty( $link ) && ! empty( $cite ) )
			$cite = '<a href="'.$link.'" target="_blank">'.$cite.'</a>';

		if ( ! empty( $title ) ) {
			$rating_str = str_repeat(
				vamtam_shortcode_icon( array( 'name' => 'star2', 'color' => '#F8DF04' ) ),
				$rating
			);

			if ( ! empty( $rating_str ) ) {
				$rating_str .= ' &mdash; ';
			}

			if ( ! empty( $cite ) ) {
				$cite = " <span class='company-name'>( $cite )</span>";
			}

			$title = "<div class='quote-title'>$rating_str<span class='the-title'>$title</span>$cite</div>";
		} elseif ( ! empty( $cite ) ) {
			$title = "<div class='quote-title'>$cite</div>";
		}

		if ( ! empty( $summary ) ) {
			$summary = '<h4 class="quote-summary">' . $summary . '</h4>';
		}

		$thumbnail = '';
		if ( has_post_thumbnail() ) {
			$thumbnail  = '<div class="quote-thumbnail">';
			$thumbnail .= get_the_post_thumbnail( get_the_ID(), 'thumbnail' );
			$thumbnail .= '</div>';
		}

		$before_content = $summary . '<div class="quote-title-wrapper clearfix">' . $title . '</div>';

		$content = '<div class="quote-content">' . $content . '</div>';

		return "<blockquote class='clearfix small simple " . implode( ' ', get_post_class() ) . "'>$thumbnail<div class='quote-text'>" . $before_content . wpautop( do_shortcode( $content ) ) . '</div></blockquote>';
	}
};

new Vamtam_Testimonials;
