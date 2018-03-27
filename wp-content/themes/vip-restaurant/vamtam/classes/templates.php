<?php
/**
 * Various static template helpers
 *
 * @package vip-restaurant
 */
/**
 * class VamtamTemplates
 */
class VamtamTemplates {

	private static $layout_cache = false;

	public static $in_page_wrapper = false;

	/**
	 * Returns the current layout type and defines VAMTAM_LAYOUT accordingly
	 *
	 * @return string current page layout
	 */
	public static function get_layout() {
		global $post;

		if ( ! self::$layout_cache ) {
			$has_left  = VamtamSidebars::get_instance()->has_sidebar( 'left' );
			$has_right = VamtamSidebars::get_instance()->has_sidebar( 'right' );

			$layout_type = 'full';

			if ( $has_left && $has_right ) {
				$layout_type = 'left-right';
			} else if ( $has_left ) {
				$layout_type = 'left-only';
			} else if ( $has_right ) {
				$layout_type = 'right-only';
			}

			self::$layout_cache = $layout_type;
		}

		return self::$layout_cache;
	}

	/**
	 * Echoes a pagination in the form of 1 2 [3] 4 5
	 */
	public static function pagination_list( $query = null ) {
		if ( is_null( $query ) ) {
			$query = $GLOBALS['wp_query'];
		}

		$total_pages = (int) $query->max_num_pages;

		$output = '';

		if ( $total_pages > 1 ) {
			$big = PHP_INT_MAX;

			if ( isset( $query->query_vars['paged'] ) ) {
				$current_page = $query->query_vars['paged'];
			} else {
				$current_page = ( get_query_var( 'paged' ) > 1 ) ? get_query_var( 'paged' ) : ( get_query_var( 'page' ) ? get_query_var( 'page' ) : 1 );
			}

			$current_page = max( 1, $current_page );

			$output .= '<div class="wp-pagenavi vamtam-pagination-wrapper">';

			$output .= '<span class="pages">' . sprintf( esc_html__( 'Page %d of %d', 'wpv' ), (int) $current_page, (int) $total_pages ) . '</span>';

			$output .= paginate_links( array( // xss ok
				'base'      => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
				'format'    => '?paged=%#%',
				'current'   => $current_page,
				'total'     => $total_pages,
				'prev_text' => esc_html__( 'Prev', 'wpv' ),
				'next_text' => esc_html__( 'Next', 'wpv' ),
			) );
			$output .= '</div>';
		}

		return $output;
	}

	/**
	 * Checks whether the main content area is currently being printed
	 *
	 * @return bool True immediately before displaying the left sidebar, false after the right sidebar has been displayed
	 */
	public static function in_page_wrapper() {
		return self::$in_page_wrapper;
	}

	/**
	 * Displays the pagination code based on the theme options or $pagination_type
	 *
	 * @param  string|null $pagination_type		overrides the pagination settings
	 * @param  bool        $echo                print or return the pagination code
	 * @param  array       $other_vars          vars passed to the remote handler - can be anything but elements must be whitelisted in VamtamLoadMore
	 * @param  object|null $query               WP_Query object
	 */
	public static function pagination( $pagination_type = null, $echo = true, $other_vars = array(), $query ) {
		$output = apply_filters( 'vamtam_pagination', null, $pagination_type );

		if ( is_archive() || is_search() ) {
			$pagination_type = 'paged';
		}

		if ( is_null( $output ) ) {
			if ( is_null( $pagination_type ) ) {
				$pagination_type = rd_vamtam_get_option( 'pagination-type' );
			}

			if ( 'load-more' === $pagination_type || 'infinite-scrolling' === $pagination_type ) {
				$max   = $query->max_num_pages;
				$paged = 1;

				if ( isset( $query->query_vars['paged'] ) ) {
					$paged = $query->query_vars['paged'];
				} else {
					$paged = ( get_query_var( 'paged' ) > 1 ) ? get_query_var( 'paged' ) : ( get_query_var( 'page' ) ? get_query_var( 'page' ) : 1 );
				}

				$new_query = $query->query;

				$new_query['paged'] = $paged + 1;

				$class = 'lm-btn vamtam-button button-border accent1 hover-accent6';
				if ( 'cube-load-more' === $pagination_type ) {
					$class .= ' vamtam-cube-load-more';
				}

				$output = '';
				if ( (int) $max > (int) $paged ) {
					$url  = remove_query_arg( array( 'page', 'paged' ) );
					$url .= ( strpos( $url, '?' ) === false ) ? '?' : '&';
					$url .= 'paged=' . $new_query['paged'];

					if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
						$url = '#';
					}

					$btext = esc_html__( 'Load more', 'wpv' );

					$output = '<div class="load-more clearboth vamtam-pagination-wrapper"><a href="' . esc_url( $url ) . '" class="' . esc_attr( $class ) . '" data-query="' . esc_attr( json_encode( $new_query ) ) . '" data-other-vars="' . esc_attr( json_encode( $other_vars ) ) . '"><span class="btext" data-text="' . esc_attr( strip_tags( $btext ) ) . '">' . $btext . '</span></a></div>'; wp_enqueue_script( 'wp-mediaelement' );
					wp_enqueue_style( 'wp-mediaelement' );
				}
			} else {
				$output = self::pagination_list( $query );
			}
		}

		if ( $echo ) {
			echo $output; // xss ok
		} else {
			return $output;
		}
	}

	/**
	 * Checks whether the current page has a title
	 *
	 * @return boolean whether the current page has a title
	 */
	public static function has_page_header() {
		$post_id = vamtam_get_the_ID();

		if ( is_null( $post_id ) )
			return true;

		if ( is_single() && has_post_format( 'aside' ) )
			return false;

		return get_post_meta( $post_id, 'show-page-header', true ) !== 'false' && ! is_page_template( 'page-blank.php' );
	}

	/**
	 * Returns a CSS string with background-related properties
	 *
	 * Since WP Core insists on supporting PHP 5.2, we can't even use __callStatic() to overload static methods
	 * also no null coalescence
	 */
	public static function build_background( $bg ) {
		if ( ! is_array( $bg ) ) {
			return '';
		}

		return self::build_background_full(
			isset( $bg['background-color'] )      ? $bg['background-color'] : '',
			isset( $bg['background-image'] )      ? $bg['background-image'] : '',
			isset( $bg['background-repeat'] )     ? $bg['background-repeat'] : '',
			isset( $bg['background-size'] )       ? $bg['background-size'] : '',
			isset( $bg['background-attachment'] ) ? $bg['background-attachment'] : '',
			isset( $bg['background-position'] )    ? $bg['background-position'] : ''
		);
	}

	public static function build_background_full( $bgcolor, $bgimage, $bgrepeat, $bgsize, $bgattachment, $bgposition = 'center top' ) {
		$style = '';
		if ( ! empty( $bgcolor ) ) {
			$style .= "background-color:$bgcolor;";

			if ( empty( $bgimage ) ) {
				$style .= 'background-image:none;';
			}
		}

		if ( ! empty( $bgimage ) ) {
			$style .= "background-image:url('$bgimage' );";

			if ( ! empty( $bgrepeat ) ) {
				$style .= "background-repeat:$bgrepeat;";
			}

			if ( ! empty( $bgsize ) ) {
				$style .= "background-size:$bgsize;";
			}

			if ( ! empty( $bgattachment ) ) {
				$style .= "background-attachment:$bgattachment;";
			}
		}

		return $style;
	}

	/**
	 * Page title background styles
	 *
	 * @return string background styles
	 */
	public static function page_header_background() {
		$post_id = vamtam_get_the_ID();

		if ( is_null( $post_id ) || ! self::has_page_header() || is_archive() || is_search() )
			return '';

		$bgcolor      = vamtam_sanitize_accent( vamtam_post_meta( $post_id, 'local-page-title-background-color', true ), 'css' );
		$bgimage      = vamtam_post_meta( $post_id, 'local-page-title-background-image', true );
		$bgrepeat     = vamtam_post_meta( $post_id, 'local-page-title-background-repeat', true );
		$bgsize       = vamtam_post_meta( $post_id, 'local-page-title-background-size', true );
		$bgattachment = vamtam_post_meta( $post_id, 'local-page-title-background-attachment', true );
		$bgposition   = vamtam_post_meta( $post_id, 'local-page-title-background-position', true );

		return self::build_background_full( $bgcolor, $bgimage, $bgrepeat, $bgsize, $bgattachment, $bgposition );
	}

	/**
	 * Returns a LESS mixin for generating a readable color based on a bg color
	 *
	 * @return string LESS mixin
	 */
	public static function readable_color_mixin() {
		return '
            .readable-color( @bgcolor:#FFF, @treshold:70, @diff:80% ) when ( iscolor( @bgcolor ) ) and ( lightness( @bgcolor ) >= @treshold ) and ( iscolor( @bgcolor ) ) {
                color: desaturate( darken( @bgcolor, @diff ), 50% );
            }

            .readable-color( @bgcolor:#FFF, @treshold:70, @diff:80% ) when ( iscolor( @bgcolor ) ) and ( lightness( @bgcolor ) < @treshold ) and ( iscolor( @bgcolor ) ) {
                color: desaturate( lighten( @bgcolor, @diff ), 50% );
            }

            .readable-color( @bgcolor:#FFF, @treshold:70, @diff:80% ) when not ( iscolor( @bgcolor ) ) {}
        ';
	}

	/**
	 * Checks whether the current page has post siblings links
	 *
	 * @return boolean whether the current page has post siblings links
	 */
	public static function has_post_siblings_buttons() {
		return is_singular( array( 'post', 'jetpack-portfolio' ) ) && current_theme_supports( 'vamtam-ajax-siblings' ) && ! is_page_template( 'page-blank.php' );
	}

	/**
	 * Displays the page header
	 *
	 * @param  bool $placed whether the title has already been output
	 * @param  string|null $title if set, overrides the current post title
	 */
	public static function page_header( $placed = false, $title = null ) {
		if ( $placed ) return;

		global $post;

		if ( is_null( $title ) ) {
			$title = get_the_title();
		}

		$title_color = $layout = '';

		if ( isset( $post ) && isset( $post->ID ) ) {
			$title_color = vamtam_post_meta( $post->ID, 'local-page-title-color', true );
			$layout      = vamtam_post_meta( $post->ID, 'local-page-title-layout', true );
		}

		$uses_local_title_layout = '';

		if ( empty( $layout ) ) {
			$layout = rd_vamtam_get_option( 'page-title-layout' );
		} else if ( is_customize_preview() ) {
			$uses_local_title_layout = 'uses-local-title-layout';
		}

		$description = '';

		if ( ! empty( $title_color ) ) {
			$title_color = "color:$title_color";
		}

		if ( is_archive() ) {
			$description = get_the_archive_description();
		} else if ( ! is_search() && is_object( $post ) ) {
			$description = get_post_meta( $post->ID, 'description', true );
		}

		if ( has_post_format( 'link' ) && ! empty( $title ) ) {
			$title = "<a href='" . vamtam_post_meta( vamtam_get_the_ID(), 'vamtam-post-format-link', true ) . "' target='_blank'>$title</a>";
		}

		if ( VamtamTemplates::has_page_header() && ! empty( $title ) ) {
			include locate_template( 'templates/header/page-title.php' );
		}
	}

	/**
	 * Displays the header sidebars
	 */
	public static function header_sidebars() {
		self::header_footer_sidebars( 'header' );
	}

	/**
	 * Displays the footer sidebars
	 */
	public static function footer_sidebars() {
		self::header_footer_sidebars( 'footer' );
	}

	/**
	 * check if there are header/footer sidebars
	 *
	 * @param  string  $area header or footer
	 * @return boolean
	 */
	public static function has_header_footer_sidebars( $area = 'header' ) {
		$is_active = false;

		for ( $i = 1; $i <= 8; $i++ ) {
			if ( is_active_sidebar( "$area-sidebars-$i" ) ) {
				$is_active = true;
				break;
			}
		}

		return $is_active && ! is_page_template( 'page-blank.php' );
	}

	/**
	 * displays header/footer sidebars
	 *
	 * @param string $area one of "header" or "footer"
	 */
	private static function header_footer_sidebars( $area ) {
		if ( self::has_header_footer_sidebars( $area ) ) {
			include locate_template( 'templates/header-footer-sidebars.php' );
		}
	}

	/**
	 * Comments template
	 *
	 * @param  object $comment comment data
	 * @param  array $args    comment arguments
	 * @param  int $depth   comment depth
	 */
	public static function comments( $comment, $args, $depth ) {
		include locate_template( 'templates/comment'. ( isset( $args['vamtam-layout'] ) ? '-'.$args['vamtam-layout'] : '' ) .'.php' );
	}

	/**
	 * Displays the icon for a post format $format
	 * @param  string $format post format slug
	 * @return string         icon html
	 */
	public static function post_format_icon( $format ) {
		?>
		<a class="single-post-format" href="<?php echo esc_url( add_query_arg( 'format_filter',$format, home_url( '/' ) ) ) ?>" title="<?php echo esc_attr( get_post_format_string( $format ) ) ?>">
			<?php echo do_shortcode( '[icon name="'.VamtamPostFormats::get_post_format_icon( $format ).'"]' ) ?>
		</a>
		<?php
	}

	/**
	 * Outputs the page title styles
	 */
	public static function get_title_style() {
		$post_id = vamtam_get_the_ID();

		if ( ! current_theme_supports( 'vamtam-page-title-style' ) || is_null( $post_id ) )
			return;

		$bgcolor      = vamtam_sanitize_accent( vamtam_post_meta( $post_id, 'local-title-background-color', true ), 'css' );
		$bgimage      = vamtam_post_meta( $post_id, 'local-title-background-image', true );
		$bgrepeat     = vamtam_post_meta( $post_id, 'local-title-background-repeat', true );
		$bgsize       = vamtam_post_meta( $post_id, 'local-title-background-size', true );
		$bgattachment = vamtam_post_meta( $post_id, 'local-title-background-attachment', true );
		$bgposition   = vamtam_post_meta( $post_id, 'local-title-background-position', true );

		$style = '';
		if ( ! empty( $bgcolor ) ) {
			$style .= "background-color:$bgcolor;";
		}

		if ( ! empty( $bgimage ) ) {
			$style .= "background-image:url('$bgimage' );";

			if ( ! empty( $bgrepeat ) ) {
				$style .= "background-repeat:$bgrepeat;";
			}

			if ( ! empty( $bgsize ) ) {
				$style .= "background-size:$bgsize;";
			}
		}

		return $style;
	}

	/**
	 * Checks whether the current page has a header slider
	 * @return boolean true if there is a header slider
	 */
	public static function has_header_slider() {
		$post_id = vamtam_get_the_ID();

		return ! is_null( $post_id ) &&
				apply_filters(
					'vamtam_has_header_slider',
					( ! is_404() && vamtam_post_meta( $post_id, 'slider-category', true ) !== '' && ! is_page_template( 'page-blank.php' ) )
				);
	}

	/**
	 * Returns true if this is the WP login page
	 *
	 * @return bool whether the current page is wp-login
	 */
	public static function is_login() {
		return strpos( $_SERVER['PHP_SELF'], 'wp-login.php' ) !== false;
	}

	/**
	 * Returns the list of all embeddable sliders to be used in the config generator
	 *
	 * @return array list of sliders
	 */
	public static function get_all_sliders() {
		return array_merge( self::get_layer_sliders(), self::get_rev_sliders() );
	}

	/**
	 * Returns the list of Revolution Slider sliders in 'revslider-ID' => 'Name' array
	 * @return array list of Revolution Slider WP sliders
	 */
	public static function get_rev_sliders( $prefix = 'revslider-' ) {
		$result = array();

		if ( class_exists( 'RevSlider' ) ) {
			$revslider = new RevSlider();
			$sliders   = $revslider->getArrSliders();

			foreach ( $sliders as $item ) {
				$result[ $prefix . $item->getAlias() ] = $item->getTitle();
			}
		}

		return $result;
	}

	/**
	 * Returns the list of LayerSlider sliders in 'layerslider-ID' => 'Name' array
	 * @return array list of LayerSlider WP sliders
	 */
	public static function get_layer_sliders( $prefix = 'layerslider-' ) {
		$result = array();

		if ( class_exists( 'LS_Sliders' ) ) {
			$sliders = LS_Sliders::find(
				array(
				'orderby' => 'date_m',
				'limit' => 10000,
				'data' => false,
				)
			);

			foreach ( $sliders as $item ) {
				$result[ $prefix . $item['id'] ] = $item['name'];
			}
		}

		return $result;
	}

	/**
	 * The formatted output of a list of pages.
	 *
	 * Displays page links for paginated posts ( i.e. includes the "nextpage".
	 * Quicktag one or more times ). This tag must be within The Loop.
	 *
	 * The defaults for overwriting are:
	 * 'next_or_number' - Default is 'number' ( string ). Indicates whether page
	 *      numbers should be used. Valid values are number and next.
	 * 'nextpagelink' - Default is 'Next Page' ( string ). Text for link to next page.
	 *      of the bookmark.
	 * 'previouspagelink' - Default is 'Previous Page' ( string ). Text for link to
	 *      previous page, if available.
	 * 'pagelink' - Default is '%' ( String ).Format string for page numbers. The % in
	 *      the parameter string will be replaced with the page number, so Page %
	 *      generates "Page 1", "Page 2", etc. Defaults to %, just the page number.
	 * 'before' - Default is '<p id="post-pagination"> Pages:' ( string ). The html
	 *      or text to prepend to each bookmarks.
	 * 'after' - Default is '</p>' ( string ). The html or text to append to each
	 *      bookmarks.
	 * 'text_before' - Default is '' ( string ). The text to prepend to each Pages link
	 *      inside the <a> tag. Also prepended to the current item, which is not linked.
	 * 'text_after' - Default is '' ( string ). The text to append to each Pages link
	 *      inside the <a> tag. Also appended to the current item, which is not linked.
	 *
	 * @param string|array $args Optional. Overwrite the defaults.
	 * @return string Formatted output in HTML.
	 */
	public static function custom_link_pages( $args = '' ) {
		$defaults = array(
			'before'           => '<p id="post-pagination">' . esc_html__( 'Pages:', 'wpv' ),
			'after'            => '</p>',
			'text_before'      => '',
			'text_after'       => '',
			'next_or_number'   => 'number',
			'nextpagelink'     => esc_html__( 'Next page', 'wpv' ),
			'previouspagelink' => esc_html__( 'Previous page', 'wpv' ),
			'pagelink'         => '%',
			'echo'             => 1,
		);

		$r = wp_parse_args( $args, $defaults );
		$r = apply_filters( 'wp_link_pages_args', $r );
		extract( $r, EXTR_SKIP );

		global $page, $numpages, $multipage, $more, $pagenow;

		$output = '';
		if ( $multipage ) {
			if ( 'number' == $next_or_number ) {
				$output .= $before;
				for ( $i = 1; $i < ( $numpages + 1 ); $i = $i + 1 ) {
					$j = str_replace( '%', $i, $pagelink );
					$output .= ' ';
					if ( $i != $page || ( ( ! $more ) && ( $page == 1 ) ) )
						$output .= _wp_link_page( $i );
					else $output .= '<span class="current">';

					$output .= $text_before . $j . $text_after;
					if ( $i != $page || ( ( ! $more ) && ( $page == 1 ) ) )
						$output .= '</a>';
					else $output .= '</span>';
				}
				$output .= $after;
			} else {
				if ( $more ) {
					$output .= $before;
					$i = $page - 1;
					if ( $i && $more ) {
						$output .= _wp_link_page( $i );
						$output .= $text_before . $previouspagelink . $text_after . '</a>';
					}
					$i = $page + 1;
					if ( $i <= $numpages && $more ) {
						$output .= _wp_link_page( $i );
						$output .= $text_before . $nextpagelink . $text_after . '</a>';
					}
					$output .= $after;
				}
			}
		}

		if ( $echo ) {
			echo $output; // xss ok
		}

		return $output;
	}

	public static function project_tax( $tax ) {
		$project_types = get_the_terms( get_the_id(), $tax );

		$links = array();

		foreach ( $project_types as $project_type ) {
			$project_type_link = get_term_link( $project_type, $tax );

			if ( is_wp_error( $project_type_link ) ) {
				return $project_type_link;
			}

			$links[] = '<a href="' . esc_url( $project_type_link ) . '" rel="tag">' . esc_html( $project_type->name ) . '</a>';
		}

		return $links;
	}

	public static function scrollable_columns( $max ) {
		global $content_width;

		if ( 0 === $max ) {
			$max = 11;
		}

		$min = apply_filters( 'vamtam-scrollable-columns-minimum', 1 ); // should be replaced with min( 2, $max ); if a minimum of two columns is required

		$queries = array();

		$step = $content_width / 4;

		// start from site_width/4, increment column count by 1 for every $step px
		for ( $cols = $min; $cols <= $max; ++$cols ) {
			$queries[] = array(
				'width' => ( $cols === $min ? 1 : $cols ) * $step,
				'cols'  => $cols,
			);
		}

		$queries = array_reverse( $queries );

		return apply_filters( 'vamtam-scrollable-columns', $queries, $max );
	}

	/**
	 * Prints display: none if $visible is false
	 *
	 * @param  bool $visible
	 */
	public static function display_none( $visible ) {
		if ( ! $visible ) {
			echo 'style="display:none"';
		}
	}

	/**
	 * Compiles LESS code to be used inline and not cached
	 */
	public static function compile_local_css( $id, $less, $less_vars ) {
		$result = '';

		if ( ! empty( $less ) ) {
			$accents = '';

			foreach ( rd_vamtam_get_option( 'accent-color' ) as $num => $color ) {
				$accents .= '@accent-color-' . intval( $num ) . ': ' . $color . ';';
			}

			$less_before = '';

			foreach ( $less_vars as $name => $value ) {
				$less_before .= '@' . $name . ': ' . $value . ';';
			}

			$less_before .= VamtamTemplates::readable_color_mixin();

			$less_before .= "
				.safe-bg( @bgcolor ) when ( iscolor( @bgcolor ) ) {
					background-color: @bgcolor;
				}
				.safe-bg( @bgcolor ) {}
			";

			$less_before .= "#{$id} {";

			$less_after = '}';

			$source = $less_before . $less . $less_after;

			$l = new VamtamLessc();
			$l->importDir = '.';
			$l->setFormatter( 'compressed' );

			$inner_style = $l->compile( $accents . $source );

			$source_attr = '';

			if ( is_customize_preview() ) {
				$source_attr = ' data-vamtam-less-source="' . esc_attr( $source ) . '"';
			}

			$result = '<style' . $source_attr . '>' . $inner_style . '</style>';
		}

		return $result;
	}

	public static function shortcode( $name, $atts, $content = null ) {
		$function_name = 'vamtam_shortcode_' . $name;

		if ( ! function_exists( $function_name ) ) {
			return '<!-- ' . sprintf( esc_html__( '%s not found.', 'wpv' ), $function_name ) . '-->';
		}

		if ( is_null( $content ) ) {
			return call_user_func( $function_name, $atts );
		}

		return call_user_func( $function_name, $atts, $content );
	}

	public static function the_author_posts_link_with_icon() {
		global $authordata;
		if ( ! is_object( $authordata ) ) {
			return;
		}

		$link = sprintf(
			'<a href="%1$s" title="%2$s" rel="author">%3$s</a>',
			esc_url( get_author_posts_url( $authordata->ID, $authordata->user_nicename ) ),
			esc_attr( sprintf( __( 'Posts by %s', 'wpv' ), get_the_author() ) ),
			vamtam_get_icon_html( array( 'name' => 'theme-pencil2' ) ) . ' ' . get_the_author()
		);

		/**
		 * Filters the link to the author page of the author of the current post.
		 *
		 * @since 2.9.0
		 *
		 * @param string $link HTML link.
		 */
		echo wp_kses_post( apply_filters( 'the_author_posts_link', $link ) );
	}

	public static function remove_outer_columns( $text ) {
		$text = preg_replace( '/\[column.*?\]/', '', $text );
		$text = preg_replace( '/\[\/column.*?\]/', '', $text );

		return $text;
	}
}
