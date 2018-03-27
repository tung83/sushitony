<?php

/**
 * Various template helpers
 */

function theme_background_styles() {
	global $post;

	$post_id = vamtam_get_the_ID();

	if (is_null( $post_id )) return;

	$bgcolor = vamtam_sanitize_accent( vamtam_post_meta( $post_id, 'background-color', true ), 'css' );
	$bgimage = vamtam_post_meta( $post_id, 'background-image', true );
	$bgrepeat = vamtam_post_meta( $post_id, 'background-repeat', true );
	$bgsize = vamtam_post_meta( $post_id, 'background-size', true );
	$bgattachment = vamtam_post_meta( $post_id, 'background-attachment', true );
	$bgposition = vamtam_post_meta( $post_id, 'background-position', true );

	$page_style = '';
	if ( ! empty( $bgcolor ) ) {
		$page_style .= "background-color:$bgcolor;";
	}
	if ( ! empty( $bgimage ) ) {
		$page_style .= "background-image:url('$bgimage');";

		if ( ! empty( $bgrepeat ) ) {
			$page_style .= "background-repeat:$bgrepeat;";
		}

		if ( ! empty( $bgattachment ) ) {
			$page_style .= "background-attachment:$bgattachment;";
		}

		if ( ! empty( $bgsize ) ) {
			$page_style .= "background-size:$bgsize;";
		}
	}

	$bgcolor = vamtam_sanitize_accent( vamtam_post_meta( $post_id, 'local-main-background-color', true ), 'css' );
	$bgimage = vamtam_post_meta( $post_id, 'local-main-background-image', true );
	$bgrepeat = vamtam_post_meta( $post_id, 'local-main-background-repeat', true );
	$bgsize = vamtam_post_meta( $post_id, 'local-main-background-size', true );
	$bgattachment = vamtam_post_meta( $post_id, 'local-main-background-attachment', true );
	$bgposition = vamtam_post_meta( $post_id, 'local-main-background-position', true );

	$main_style = '';
	if ( ! empty( $bgcolor ) ) {
		$main_style .= "background-color:$bgcolor;";
	}
	if ( ! empty( $bgimage ) ) {
		$main_style .= "background-image:url('$bgimage');";

		if ( ! empty( $bgrepeat ) ) {
			$main_style .= "background-repeat:$bgrepeat;";
		}

		if ( ! empty( $bgattachment ) ) {
			$main_style .= "background-attachment:$bgattachment;";
		}

		if ( ! empty( $bgsize ) ) {
			$main_style .= "background-size:$bgsize;";
		}
	}

	if ( ! empty( $page_style ) || ! empty( $main_style ) ) {
		echo '<style>' . esc_html( "html,#main-content{{$page_style}}.vamtam-main{{$main_style}}" ) . '</style>';
	}
}
add_action( 'wp_head', 'theme_background_styles' );

function theme_body_classes( $body_class ) {
	global $post, $vamtam_is_shortcode_preview;

	$is_blank_page       = is_page_template( 'page-blank.php' );
	$has_header_slider   = VamtamTemplates::has_header_slider();
	$has_header_sidebars = VamtamTemplates::has_header_footer_sidebars( 'header' );
	$has_footer_sidebars = VamtamTemplates::has_header_footer_sidebars( 'footer' );
	$has_page_header     = ( VamtamTemplates::has_page_header() || VamtamTemplates::has_post_siblings_buttons() ) && ! is_404();
	$is_responsive        = VamtamFramework::get( 'is_responsive' );

	$body_class[] = $is_blank_page ? 'full' : rd_vamtam_get_option( 'site-layout-type' );
	$body_class[] = 'header-layout-' . rd_vamtam_get_option( 'header-layout' );
	$body_class[] = 'pagination-' . rd_vamtam_get_option( 'pagination-type' );
	$body_class[] = is_singular( VamtamFramework::$complex_layout ) ? 'page-vertical-padding-' . vamtam_post_meta( null, 'page-vertical-padding', true ) : '';
	$body_class[] = is_singular( VamtamFramework::$complex_layout ) ? 'sticky-header-type-'.vamtam_post_meta( null, 'sticky-header-type', true ) : 'sticky-header-type-normal';
	$body_class[] = 'vamtam-not-scrolled';

	$body_class_conditions = array(
		'no-page-header'                   => ! $has_page_header,
		'has-page-header'                  => $has_page_header,
		'has-header-slider'                => $has_header_slider,
		'has-header-sidebars'              => $has_header_sidebars,
		'no-header-slider'                 => ! $has_header_slider,
		'no-header-sidebars'               => ! $has_header_sidebars,
		'no-footer-sidebars'               => ! $has_footer_sidebars,
		'responsive-layout'                => $is_responsive,
		'fixed-layout'                     => ! $is_responsive,
		'sticky-header'                    => rd_vamtam_get_optionb( 'sticky-header' ),
		'sticky-footer'                    => rd_vamtam_get_optionb( 'sticky-footer' ),
		'vamtam-shortcode-tooltip-preview' => $vamtam_is_shortcode_preview && strpos( $GLOBALS['vamtam_current_shortcode'], '[tooltip' ) !== false,
		'vamtam-limit-wrapper'             => ! class_exists( 'Vamtam_Columns' ) || Vamtam_Columns::had_limit_wrapper(),
	);

	foreach ( $body_class_conditions as $class => $cond ) {
		if ( $cond ) {
			$body_class[] = $class;
		}
	}

	$body_class[] = 'layout-' . VamtamTemplates::get_layout();

	if ( is_search() || get_query_var( 'format_filter' ) ) {
		define( 'VAMTAM_ARCHIVE_TEMPLATE', true );
	}

	return $body_class;
}
add_filter( 'body_class', 'theme_body_classes' );
