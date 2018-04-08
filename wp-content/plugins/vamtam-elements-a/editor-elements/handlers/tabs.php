<?php

class Vamtam_Tabs {
	public function __construct() {
		add_shortcode( 'tabs', array( __CLASS__, 'shortcode' ) );
	}

	public static function shortcode( $atts, $content = null, $code ) {
		extract(shortcode_atts(array(
			'layout'           => 'horizontal',
			'right_color'      => '',
			'nav_bg'           => '',
			'nav_color'        => '',
			'active_nav_color' => '',
		), $atts));

		$content = htmlspecialchars_decode( $content );

		if ( ! vamtam_sub_shortcode( 'tab', $content, $params, $sub_contents ))
			return 'error parsing slider shortcode';

		wp_enqueue_script( 'jquery-ui-tabs' );

		global $vamtam_tabs_shown;
		if ( ! isset( $vamtam_tabs_shown ))
			$vamtam_tabs_shown = 0;

		$vamtam_tabs_shown++;

		$id = 'tabs-'.$vamtam_tabs_shown;

		$wrapper_class = array( $layout );

		$output = '<ul class="ui-tabs-nav">';

		foreach ( $params as $i => &$p ) {
			$p = shortcode_atts(array(
				'title' => '',
				'class' => '',
				'icon'  => '',
			), $p);

			if ( ! empty( $p['icon'] ) ) {
				$p['icon'] = vamtam_shortcode_icon(array(
					'name' => $p['icon'],
				));

				$p['class'] .= ' has-icon';
			}

			$params[ $i ]['title'] = htmlspecialchars_decode( $params[ $i ]['title'], ENT_QUOTES );
			$params[ $i ]['class'] = htmlspecialchars_decode( $params[ $i ]['class'], ENT_QUOTES );

			$class = empty( $p['class'] ) ? '' : " class='{$p['class']}'";

			$output .= '<li'.$class.'><a href="#tab-' . $vamtam_tabs_shown . '-' . $i . '-' . self::sanitize_id( $params[ $i ]['title'] ) . '">' . $p['icon'] . ' <span class="title-text">' . $p['title'] . '</span></a></li>';
		}
		$output .= '</ul>';

		foreach ( $sub_contents as $i => $c ) {
			$class = isset( $params[ $i ]['class'] ) ? ' tab-'.$params[ $i ]['class'] : '';
			$output .= '<div class="pane'.$class.'" id="tab-' . $vamtam_tabs_shown . '-' . $i . '-' . self::sanitize_id( $params[ $i ]['title'] ) . '">' . do_shortcode( trim( $c ) ) . '</div>';
		}

		$l = new VamtamLessc();
		$l->importDir = '.';
		$l->setFormatter( 'compressed' );

		$right_color      = vamtam_sanitize_accent( $right_color, 'css' );
		$nav_bg           = vamtam_sanitize_accent( $nav_bg, 'css' );
		$nav_color        = vamtam_sanitize_accent( $nav_color, 'css' );
		$active_nav_color = vamtam_sanitize_accent( $active_nav_color, 'css' );

		$inner_style = '';

		if ( ! empty( $nav_bg ) && ! empty( $right_color ) ) {
			// do not use color function in the LESS code

			$vertical_styles = $layout !== 'vertical' ? '' : "
				#{$id}.vertical {
					.ui-tabs-nav {
						background: $nav_bg;
					}
				}
			";

			$inner_style = $l->compile( $vertical_styles . "
				#{$id} {
					.ui-tabs-nav {
						li {
							&, a, a .icon {
								color: $nav_color;
							}
						}

						.ui-state-active,
						.ui-state-selected,
						.ui-state-hover {
							background: $right_color;

							&, a, a .icon {
								color: $active_nav_color;
							}
						}
					}

					.pane {
						background: $right_color;
					}
				}
			");

			if ( 'transparent' !== $right_color ) {
				$wrapper_class[] = 'has-pane-background';
			}
		}

		$style = '<style>' . $inner_style . '</style>';

		return '<div class="vamtam-tabs ' . implode( ' ', $wrapper_class ) . '" id="'.$id.'">' . $output . '</div>' . $style;
	}

	public static function sanitize_id( $title ) {
		if ( class_exists( 'Transliterator' ) ) {
			$transliterator = Transliterator::create( 'Any-Latin; Latin-ASCII' );

			if ( is_a( $transliterator, 'Transliterator' ) ) {
				$title = $transliterator->transliterate( $title );
			} else {
				$transliterator = Transliterator::create( 'Any-Latin; NFD; [:Nonspacing Mark:] Remove; NFC' );

				if ( is_a( $transliterator, 'Transliterator' ) ) {
					$title = $transliterator->transliterate( $title );
				}
			}
		} else if ( function_exists( 'iconv' ) ) {
			$title = iconv( 'UTF-8', 'ASCII//TRANSLIT', $title );
		}

		$title = preg_replace( '/[^(\x20-\x7F)]*/', '', $title );
		return sanitize_title_with_dashes( $title );
	}
}

new Vamtam_Tabs;
