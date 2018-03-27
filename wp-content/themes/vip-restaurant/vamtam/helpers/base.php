<?php

function vamtam_get_the_ID() {
	global $post;

	return (vamtam_has_woocommerce() && is_woocommerce() && ! is_singular( array( 'page', 'product' ) )) ? woocommerce_get_page_id( 'shop' ) : (isset( $post ) ? $post->ID : null);
}

/**
 * Wrapper around get_post_meta which takes special pages into account
 *
 * @uses get_post_meta()
 *
 * @param  int    $post_id Post ID.
 * @param  string $key     Optional. The meta key to retrieve. By default, returns data for all keys.
 * @param  bool   $single  Whether to return a single value.
 * @return mixed           Will be an array if $single is false. Will be value of meta data field if $single is true.
 */
function vamtam_post_meta( $post_id, $meta = '', $single = false ) {
	$real_id = vamtam_get_the_ID();

	if ($real_id && $post_id != $real_id)
		$post_id = $real_id;

	return get_post_meta( $post_id, $meta, $single );
}

/**
 * helper function - returns second argument when the first is empty, otherwise returns the first
 *
 */
function vamtam_default( $value, $default ) {
	if (empty( $value ))
		return $default;
	return $value;
}

function vamtam_get_portfolio_options() {
	global $post;

	$res = array();

	$res['image'] = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_id() ), 'full', true );
	$res['type']  = vamtam_default( get_post_meta( get_the_id(), 'portfolio_type', true ), 'image' );

	$res['link_target'] = '_self';

	// calculate some options depending on the project's type
	if ( $res['type'] == 'image' || $res['type'] == 'html' ) {
		$res['href'] = $res['image'][0];
	} elseif ( $res['type'] == 'video' ) {
		$res['href'] = get_post_meta( get_the_id(), 'vamtam-portfolio-format-video', true );

		if (empty( $res['href'] ))
			$res['href'] = $res['image'][0];
	} elseif ( $res['type'] == 'link' ) {
		$res['href'] = get_post_meta( get_the_ID(), 'vamtam-portfolio-format-link', true );

		$res['link_target'] = get_post_meta( get_the_ID(), '_link_target', true );
		$res['link_target'] = $res['link_target'] ? $res['link_target'] : '_self';
	} elseif ( $res['type'] == 'gallery' ) {
		list($res['gallery'], ) = VamtamPostFormats::get_first_gallery( get_the_content(), null, 'theme-loop-4' );
	} elseif ( $res['type'] == 'document' ) {
		if ( is_single() ) {
			$res['href'] = $res['image'][0];
		} else {
			$res['href'] = get_permalink();
		}
	}

	return $res;
}

function vamtam_custom_js() {
	$custom_js = rd_vamtam_get_option( 'custom-js' );

	if ( ! empty( $custom_js ) ) :
?>
	<script><?php echo $custom_js; // xss ok ?></script>
<?php
	endif;
}
add_action( 'wp_footer', 'vamtam_custom_js', 10000 );

function vamtam_get_attachment_file( $src ) {
	$attachment_id = attachment_url_to_postid( $src );
	$upload_dir    = wp_upload_dir();

	if ( $attachment_id !== false && wp_attachment_is_image( $attachment_id ) ) {
		$file = get_attached_file( $attachment_id );

		$file = preg_replace( '/^('. preg_quote( $upload_dir['basedir'] . '/', '/' ) .')?/', $upload_dir['basedir'].'/', $file );

		return $file;
	}

	return str_replace( $upload_dir['baseurl'], $upload_dir['basedir'], $src );
}

function vamtam_url_to_image( $src, $size = 'full', $attr = '' ) {
	$attachment_id = attachment_url_to_postid( $src );

	if ( $attachment_id !== false && wp_attachment_is_image( $attachment_id ) ) {
		echo wp_get_attachment_image( $attachment_id, $size, $attr ); } else {
		// fallback, typically used on fresly imported demo content

		echo '<img src="' . esc_url( $src ) . '" alt="" />';
	}
}

function vamtam_prepare_url( $url ) {
	while ( preg_match( '#/[-\w]+/\.\./#', $url ) ) {
		$url = preg_replace( '#/[-\w]+/\.\./#', '/', $url );
	}

	return $url;
}

function vamtam_sanitize_portfolio_item_type( $type ) {
	if ($type == 'gallery' || $type == 'video' || $type == 'image')
		return $type;

	return 'image';
}
add_filter( 'vamtam_fancy_portfolio_item_type', 'vamtam_sanitize_portfolio_item_type' );

function vamtam_fix_shortcodes( $content ) {
	// array of custom shortcodes requiring the fix
	$block = join( '|', apply_filters( 'vamtam_escaped_shortcodes', include( VAMTAM_METABOXES . 'shortcode.php' ) ) );

	// opening tag
	$rep = preg_replace( "/(<p>\s*)?\[($block)(\s[^\]]+)?\](\s*<\/p>|<br \/>)?/",'[$2$3]', $content );

	// closing tag
	$rep = preg_replace( "/(?:<p>\s*)?\[\/($block)](?:\s*<\/p>|<br \/>)?/",'[/$1]', $rep );

	return $rep;
}
add_filter( 'the_content', 'vamtam_fix_shortcodes' );

function vamtam_get_portfolio_terms() {
	$terms_slug = $terms_name = array();

	if ( class_exists( 'Jetpack_Portfolio' ) ) {
		$terms = get_the_terms( get_the_id(), Jetpack_Portfolio::CUSTOM_TAXONOMY_TYPE );

		if ( is_array( $terms ) ) {
			foreach ( $terms as $term ) {
				$terms_slug[] = preg_replace( '/[\pZ\pC]+/u', '-', $term->slug );
				$terms_name[] = $term->name;
			}
		}
	}

	return array( $terms_slug, $terms_name );
}

function vamtam_recursive_preg_replace( $regex, $replace, $subject ) {
	if ( is_array( $subject ) || is_object( $subject ) ) {
		foreach ( $subject as &$sub ) {
			$sub = vamtam_recursive_preg_replace( $regex, $replace, $sub );
		}
		unset( $sub );
	}
	if ( is_string( $subject ) ) {
		$subject = preg_replace( $regex, $replace, $subject );
	}
	return $subject;
}

function vamtam_get_google_fonts_subsets() {
	global $vamtam_fonts;

	$subsets = array();

	foreach ( $vamtam_fonts as $font ) {
		if ( isset( $font['gf'] ) && $font['gf'] ) {
			$subsets = array_merge( $subsets, $font['subsets'] );
		}
	}

	sort( $subsets );

	return array_combine( $subsets, $subsets );
}

function vamtam_get_fonts_by_family() {
	global $vamtam_fonts, $vamtam_fonts_by_family;

	if ( ! isset( $vamtam_fonts_by_family ) ) {
		$vamtam_fonts_by_family = array();

		foreach ( $vamtam_fonts as $id => $font ) {
			$vamtam_fonts_by_family[ $font['family'] ] = $id;
		}
	}

	return $vamtam_fonts_by_family;
}

function vamtam_use_accent_preview() {
	return ! ( ( isset( $GLOBALS['is_IE'] ) && $GLOBALS['is_IE'] ) || ( isset( $GLOBALS['is_edge'] ) && $GLOBALS['is_edge'] ) ); // IE and Edge do not support CSS variables and do not intend to any time soon (comment added 9 June 2016)
}