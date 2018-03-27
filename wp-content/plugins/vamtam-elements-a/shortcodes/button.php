<?php

/**
 * displays a button
 */

function vamtam_shortcode_button( $atts, $content = null ) {
	extract(shortcode_atts(array(
		'id'             => false,
		'class'          => false,
		'font'           => '',
		'link'           => '',
		'linktarget'     => '',
		'bgcolor'        => '',
		'text_color'     => '',
		'hover_color'    => 'accent1',
		'align'          => false,
		'icon'           => '',
		'icon_placement' => 'left',
		'icon_color'     => '',
		'icon_size'      => '',
		'style'          => 'filled',
	), $atts));

	$id = $id ? ' id="' . $id . '"' : '';
	$class = $class ? ' '.$class : '';
	$link = $link ? ' href="' . $link . '"' : '';
	$linktarget = $linktarget ? ' target="' . $linktarget . '"' : '';

	// inline styles for the button
	$font_size = $font;

	if ( ! empty( $font ) ) {
		if ( substr( $font, -2 ) !== 'em' ) {
			$font .= 'px';
		}

		$font = "font-size: {$font};";
	}

	$class .= ' button-'.$style;

	$class .= ' hover-'.$hover_color;

	$style = ( '' != $font ) ? " style='$font'" : '';

	$aligncss = ($align && 'center' != $align ) ? ' align'.$align : '';

	$icon = empty( $icon ) ? '' : vamtam_shortcode_icon( array( 'name' => $icon, 'color' => $icon_color, 'size' => ! empty( $icon_size )  ? $icon_size : ( $font_size ? (int) $font_size + 8 : 0 ) ) );

	$icon_b = $icon_a = '';

	if ( 'left' == $icon_placement ) {
		$icon_b = $icon;
	} else {
		$icon_a = $icon;
	}

	$text_style = empty( $text_color ) ? '' : 'style="color:' . vamtam_sanitize_accent( $text_color, 'css' ) . '"';

	$content_parsed = do_shortcode( $content );

	$content = '<a'.
					$id .
					$link .
					$linktarget .
					$style .
					' class="vamtam-button ' .
					"$bgcolor $class $aligncss".
				'">' . $icon_b . '<span class="btext" data-text="' . esc_attr( strip_tags( $content_parsed ) ) . '" ' . $text_style . '>' . trim( $content_parsed ) . '</span>'.$icon_a.'</a>';

	$content = $content;

	if ( 'center' === $align ) {
		return '<p class="textcenter">' . $content . '</p>';
	}

	return $content;
}
add_shortcode( 'button', 'vamtam_shortcode_button' );
