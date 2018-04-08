<?php

/**
 * Text divider shortcode handler
 *
 * @package editor
 */

/**
 * class Vamtam_Text_Divider
 */
class Vamtam_Text_Divider {
	/**
	 * Register the shortcode
	 */
	public function __construct() {
		add_shortcode( 'text_divider',array( __CLASS__, 'shortcode' ) );
	}

	/**
	 * Text divider shortcode callback
	 *
	 * @param  array  $atts    shortcode attributes
	 * @param  string $content shortcode content
	 * @param  string $code    shortcode name
	 * @return string          output html
	 */
	public static function shortcode( $atts, $content = null, $code = 'text_divider' ) {
		extract(shortcode_atts(array(
			'more'      => '',
			'more_text' => '',
			'subtitle'  => '',
			'type'      => 'single',
		), $atts));

		$content = preg_replace( '#<\s*/?\s*p[^>]*>#', '', $content );

		if ( strlen( $content ) === 0 || ctype_space( $content ) ) {
			return ''; // no reason for text dividers without text
		}

		$has_html = preg_match( '/^\s*</', $content );

		$link  = '';
		$class = 'single';
		if ( ! empty( $more ) ) {
			$class = 'has-more';
			$link  = "<span class='sep-text-more'><a href='$more' title='" . esc_attr( $more_text ) . "' class='more'>" . $more_text . '</a></span>';
		}

		if ( current_theme_supports( 'vamtam-centered-text-divider' ) ) {
			$class .= ' centered';
		}

		if ( ! empty( $subtitle ) ) {
			$subtitle = '<div class="text-divider-subtitle">' . $subtitle . '</div>';
		}

		ob_start();

		if ( $type == 'single' ) :
	?>
		<div class="sep-text <?php echo esc_attr( $class ) ?>">
			<?php if ( current_theme_supports( 'vamtam-centered-text-divider' ) ) : ?>
				<div class="sep-text-before"><div class="sep-text-line"></div></div>
			<?php endif ?>
			<div class="content">
				<?php
					if ( $has_html ) {
						echo do_shortcode( $content );
					} else {
						echo '<h2 class="text-divider-double">' . do_shortcode( $content ) . '</h2>';
					}

					echo $subtitle; // xss ok
				?>
			</div>
			<div class="sep-text-after"><div class="sep-text-line"></div></div>
			<?php echo $link; // xss ok ?>
		</div>
	<?php elseif ( $type == 'double' ) : ?>
		<?php if ( ! $has_html) echo '<h2 class="text-divider-double">'; ?>
			<?php echo do_shortcode( $content ) ?>
		<?php if ( ! $has_html) echo '</h2>'; ?>
		<?php echo $subtitle // xss ok ?>
		<div class="sep"></div>
	<?php
		endif;

		$output = ob_get_clean();

		// .limit-wrapper necessary if not in a column
		if ( ! isset( $GLOBALS['vamtam_column_stack'] ) || count( $GLOBALS['vamtam_column_stack'] ) === 0 ) {
			$output = '<div class="limit-wrapper">' . $output . '</div>';
		}

		return apply_filters( 'vamtam_shortcode_text_divider_html', $output, $content, $atts );
	}
}

new Vamtam_Text_Divider;
