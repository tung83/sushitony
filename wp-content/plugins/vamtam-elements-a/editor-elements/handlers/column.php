<?php

/**
 * Column shortcodes handler
 *
 * @package editor
 */

/**
 * class Vamtam_Columns
 */
class Vamtam_Columns {
	/**
	 * Current row
	 *
	 * @var integer
	 */
	public static $in_row = 0;
	/**
	 * Last row
	 * @var integer
	 */
	public static $last_row = -1;

	/**
	 * Register the shortcodes
	 */
	public function __construct() {
		$GLOBALS['vamtam_column_stack'] = array();
		$GLOBALS['vamtam_column_stack__child'] = array();

		for ( $i = 0; $i < 20; $i++ ) {
			$suffix = ( $i == 0 ) ? '' : '_'.$i;
			add_shortcode( 'column'.$suffix, array( __CLASS__, 'dispatch' ) );
		}

		add_action( 'wp_head', array( __CLASS__, 'limit_wrapper' ) );
	}

	public static function limit_wrapper() {
		$GLOBALS['vamtam_had_limit_wrapper'] =
			rd_vamtam_get_option( 'site-layout-type' ) !== 'full' ||
			! is_singular( VamtamFramework::$complex_layout ) ||
			VamtamTemplates::get_layout() !== 'full' ||
			! preg_match( '/\[column[^\]]+extend="(?!disabled)/', $GLOBALS['post']->post_content );
	}

	public static function had_limit_wrapper() {
		return apply_filters( 'vamtam_had_limit_wrapper', isset( $GLOBALS['vamtam_had_limit_wrapper'] ) && $GLOBALS['vamtam_had_limit_wrapper'] );
	}

	/**
	 * Column shortcode callback
	 *
	 * @param  array  $atts    shortcode attributes
	 * @param  string $content shortcode content
	 * @param  string $code    shortcode name
	 * @return string          output html
	 */
	public static function dispatch( $atts, $content, $code ) {
		extract( shortcode_atts( array(
			'animation'                    => 'none',
			'progressive_animation'        => 'none',
			'progressive_animation_custom' => '',
			'background_attachment'        => 'scroll',
			'background_color'             => '',
			'background_image'             => '',
			'background_position'          => '',
			'background_repeat'            => '',
			'background_size'              => '',
			'background_video'             => '',
			'hide_bg_lowres'               => '',
			'hide_element_lowres'          => '',
			'lowres_child_width'           => '1-1',
			'class'                        => '',
			'extend'                       => 'disabled',
			'extended_padding'             => 'false',
			'last'                         => 'false',
			'more_link'                    => '',
			'more_text'                    => '',
			'parallax_bg'                  => 'disabled',
			'parallax_bg_inertia'          => '1',
			'title'                        => '',
			'title_type'                   => 'single',
			'vertical_padding_bottom'      => '0',
			'vertical_padding_top'         => '0',
			'horizontal_padding'           => '0',
			'width'                        => '1/1',
			'div_atts'                     => '',
			'left_border'                  => 'transparent',
			'id'                           => '',
			'implicit'                     => 'false',
			'ornaments'                    => '',
		), $atts ) );

		if ( ! preg_match( '/column_\d+/', $code ) )
			$class .= ' vamtam-first-level';

		$GLOBALS['vamtam_column_stack'][] = $width;

		if ( $parallax_bg !== 'disabled' ) {
			$class                .= ' parallax-bg';
			$div_atts             .= ' data-parallax-method="'.esc_attr( $parallax_bg ).'" data-parallax-inertia="'.esc_attr( $parallax_bg_inertia ).'"';
			$background_position   = 'center top';
			$background_attachment = 'scroll';
		}

		$has_price         = ( strpos( $content, '[price' ) !== false );
		$has_vertical_tabs = preg_match( '/\[tabs.+layout="vertical"/s', $content );

		$width = str_replace( '/', '-', $width );
		$title = apply_filters( 'vamtam_column_title', $title, $title_type );

		$last  = vamtam_sanitize_bool( $last );
		$first = false;

		$id = empty( $id ) ? 'vamtam-column-' . md5( uniqid() ) : $id;

		if ( $width === '1-1' ) {
			$first = true;
			$last  = true;
		}

		if ( $width !== '1-1' || ( VamtamTemplates::get_layout() !== 'full' && VamtamTemplates::in_page_wrapper() ) ) {
			$extend = 'disabled';
		}

		$class .= ' grid-' . $width;

		$class .= ' ' . $ornaments;

		// column width on lower resolutions
		// determined by an option for the *parent* column
		$lowres_width = end( $GLOBALS['vamtam_column_stack__child'] );

		if ( ! empty( $lowres_width ) && '1-1' !== $lowres_width && '1-1' !== $width ) {
			$class .= ' lowres-width-override lowres-grid-' . $lowres_width;
		}

		$GLOBALS['vamtam_column_stack__child'][] = $lowres_child_width;

		$result = $result_before = $result_after = $content_before = $content_after = '';

		if ( self::$in_row > self::$last_row ) {
			$rowclass = ( $has_price ) ? 'has-price' : '';

			$class  .= ' first';

			$result_before = '<div class="row '.$rowclass.'">';
			self::$last_row = self::$in_row;

			$first = true;
		}

		if ( ! empty( $background_image ) ) {
			$background_image = "
				background: url( '$background_image' ) $background_repeat $background_position;
				background-size: $background_size;
			";

			if ( ! empty( $background_attachment ) ) {
				$background_image .= "background-attachment: $background_attachment;";
			}

			if ( vamtam_sanitize_bool( $hide_bg_lowres ) ) {
				$class .= ' vamtam-hide-bg-lowres';
			}

			if ( 'cover' === $background_size ) {
				$class .= ' vamtam-cover-bg';
			}
		}

		if ( vamtam_sanitize_bool( $hide_element_lowres ) ) {
			$class .= ' vamtam-hide-lowres';
		}

		$inner_style = '';
		$inner_style_less = '';

		$inner_style_vars = array();

		if ( ! empty( $background_color ) && $background_color !== 'transparent' ) {
			$background = vamtam_sanitize_accent( $background_color, 'less' );

			$inner_style_less .= "
				&,
				p,
				em,
				h1, h2, h3, h4, h5, h6,
				h1 a:not(:hover), h2 a:not(:hover), h3 a:not(:hover), h4 a:not(:hover), h5 a:not(:hover), h6 a:not(:hover),
				.column-title,
				.sep-text h2.regular-title-wrapper,
				.text-divider-double,
				.sep-text .sep-text-line,
				.sep,
				.sep-2,
				.sep-3,
				.portfolio-filters .inner-wrapper .cbp-filter-item,
				.portfolio-filters .inner-wrapper .cbp-filter-item:hover,
				.portfolio-filters .inner-wrapper .cbp-filter-item.cbp-filter-item-active,
				td,
				th,
				caption {
					.readable-color( @background );
				}
			";

			if ( strpos( $class, 'vamtam-add-ornaments-top' ) !== false || strpos( $class, 'vamtam-add-ornaments-all' ) !== false ) {
				$inner_style_less .= "
					&:before {
						background-color: @background;
					}
				";
			}

			if ( strpos( $class, 'vamtam-add-ornaments-bottom' ) !== false || strpos( $class, 'vamtam-add-ornaments-all' ) !== false ) {
				$inner_style_less .= "
					&:after {
						background-color: @background;
					}
				";
			}

			$inner_style_vars[ 'background' ] = $background;

			$background_color = 'background-color:' . vamtam_sanitize_accent( $background_color, 'css' ) . ';';
		} else {
			$background_color = '';
		}

		if ( ! empty( $left_border ) && $left_border !== 'transparent' ) {
			$inner_style_less .= "
				&:before {
					.safe-bg( @left_border );
				}
			";

			$inner_style_vars[ 'left_border' ] = $left_border;
		}

		$content_before .= VamtamTemplates::compile_local_css( $id, $inner_style_less, $inner_style_vars );

		if ( ! empty( $more_link ) && ! empty( $more_text ) && $extend === 'disabled' ) {
			$class .= ' has-more-button';
			$more_link = esc_attr( $more_link );
			$content_after .= "<a href='$more_link' title='".esc_attr( $more_text )."' class='column-read-more-btn'>$more_text</a>";
		}

		if ( ! empty( $background_video ) && ! VamtamMobileDetect::get_instance()->isMobile() ) {
			$type = wp_check_filetype( $background_video, wp_get_mime_types() );

			$content_before .= '<div class="vamtam-video-bg">
				<video autoplay loop preload="metadata" width="100%" class="vamtam-background-video" style="width:100%">
					<source type="'.$type['type'].'" src="'.$background_video.'"></source>
				</video>
			</div><div class="vamtam-video-bg-content">';

			$content_after .= '</div>';

			$class .= ' has-video-bg';

			wp_enqueue_style( 'wp-mediaelement' );
			wp_enqueue_script( 'wp-mediaelement' );
		}

		if ( ! empty( $background_image ) || ( ! empty( $background_color ) && $background_color !== 'transparent' ) )
			$class .= ' has-background';

		if ( (int) $vertical_padding_top < 0 ) {
			$div_atts .= ' data-padding-top="'.(int) $vertical_padding_top.'"';
		}

		if ( (int) $vertical_padding_bottom < 0 ) {
			$div_atts .= ' data-padding-bottom="'.(int) $vertical_padding_bottom.'"';
		}

		$style = $background_image . $background_color . 'padding-top:' . max( $vertical_padding_top, 0.05 ) . 'px;padding-bottom:' . max( $vertical_padding_bottom, 0.05 ) . 'px;';

		if ( (int) $horizontal_padding > 0 ) {
			$class .= ' has-horizontal-padding';

			$horizontal_padding = ( max( 0, (int) $horizontal_padding ) + 25 ) . 'px';
			$style .= "padding-left:$horizontal_padding;padding-right:$horizontal_padding;";
		}

		if ( $extend === 'content' ) {
			$class .= $extend === 'content' ? ' extended-content' : '';
		}

		$style = 'style="' . esc_attr( $style ) . '"';

		$class .= $extend === 'background' ? ' extended' : ' unextended';

		if ( $left_border != 'transparent' )
			$class .= ' left-border';

		if ( $animation !== 'none' && $parallax_bg == 'disabled' ) {
			$class .= ' animation-'.$animation.' animated-active';
		}

		if ( $progressive_animation !== 'none' && $parallax_bg == 'disabled' ) {
			$div_atts .= ' data-progressive-animation="' . esc_attr( $progressive_animation ) . '"';

			if ( ! empty( $progressive_animation_custom ) ) {
				$div_atts .= ' data-progressive-animation-custom="' . esc_attr( $progressive_animation_custom ) . '"';
			}
		}

		$class .= ( $extended_padding === 'false' ) ? ' no-extended-padding' : ' has-extended-padding';

		if ( $extend !== 'disabled' ) {
			$content_before = '<div class="extended-column-inner">'.$content_before;
			$content_after .= '</div>';
		}

		if ( ! self::had_limit_wrapper() ) {
			if ( $width === '1-1' && $extend === 'background' ) {
				if ( $extend === 'disabled' && count( $GLOBALS['vamtam_column_stack'] ) === 1 ) {
					$class .= ' limit-wrapper';
				} elseif ( $extend === 'background' ) {
					$content_before = '<div class="limit-wrapper">' . $content_before;
					$content_after .= '</div>';
				}
			} elseif (
				count( $GLOBALS['vamtam_column_stack'] ) === 1 &&
				(
					( $width === '1-1' && $extend === 'disabled' ) ||
					$width !== '1-1'
				)
			) {
				if ( $first ) {
					$result_before = '<div class="limit-wrapper">' . $result_before;
				}

				if ( $last ) {
					$result_after .= '</div>'; // check if $result_before and $result_after are balanced if changed elsewhere in this file
				}
			}
		}

		$result .= '<div class="vamtam-grid grid-'.$width.' '.$class.'" '.$style.' id="'.$id.'" '.$div_atts.'>' . $content_before . $title . self::content( $content ) . $content_after . '</div>';

		if ( $last ) {
			self::$last_row--;

			$result_after .= '</div>';
		}

		array_pop( $GLOBALS['vamtam_column_stack'] );
		array_pop( $GLOBALS['vamtam_column_stack__child'] );

		return $result_before.$result.$result_after;
	}

	/**
	 * Parse column content
	 *
	 * @param  string $content unparsed content
	 * @return string          parsed content
	 */
	public static function content( $content ) {
		self::$in_row++;
		$content = do_shortcode( trim( $content ) );
		self::$in_row--;

		return $content;
	}
};

new Vamtam_Columns;
