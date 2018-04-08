<?php
	$normal_style = $hover_style = '';

	$id = 'vamtam-expandable-'.md5( uniqid() );

	$less      = '';
	$less_vars = array();

	if ( ! empty( $background_color ) || ! empty( $background_image ) ) {
		if ( ! empty( $background_image ) ) {
			$background_image = "
				background: url( '$background_image' ) $background_repeat $background_position $background_attachment;
				background-size: $background_size;
			";
		}

		$background_color = vamtam_sanitize_accent( $background_color, 'less' );

		if ( empty( $background_color ) ) {
			$background_color = 'transparent';
		}

		$text_color = '';
		if ( $background_color !== 'transparent' ) {
			$text_color = "
				&,
				p,
				.sep-text h2.regular-title-wrapper,
				.text-divider-double,
				.sep-text .sep-text-line,
				.sep,
				.sep-2,
				.sep-3,
				h1, h2, h3, h4, h5, h6,
				td,
				th,
				caption {
					.readable-color( @background_color );
				}
			";
		}

		$less .= "
			.closed {
				$background_image

				background-color: @background_color;

				$text_color
			}
		";

		$less_vars['background_color'] = $background_color;
	}

	if ( ! empty( $hover_background ) && $hover_background !== 'transparent' ) {
		$less_vars['hover_background'] = vamtam_sanitize_accent( $hover_background, 'less' );

		$less .= "
			.open {
				background: @hover_background;

				&,
				p,
				.sep-text h2.regular-title-wrapper,
				.text-divider-double,
				.sep-text .sep-text-line,
				.sep,
				.sep-2,
				.sep-3,
				h1, h2, h3, h4, h5, h6,
				td,
				th,
				caption {
					.readable-color( @hover_background );
				}
			}
		";
	}

	$all_styles = VamtamTemplates::compile_local_css( $id, $less, $less_vars );
?>
<div class="services has-more <?php echo esc_attr( $class )?>" id="<?php echo esc_attr( $id ) ?>">
	<div class="closed services-inside">
		<div class="services-content-wrapper clearfix">
			<?php if ( ! empty( $image ) ) :  ?>
				<div class="image-wrapper">
					<?php vamtam_url_to_image( $image, 'full', array( 'class' => 'aligncenter' ) ) ?>
				</div>
			<?php elseif ( ! empty( $icon ) ) :  ?>
				<div class="image-wrapper"><?php
					echo vamtam_get_icon_html( array( // xss ok
						'name'  => $icon,
						'size'  => $icon_size,
						'color' => vamtam_sanitize_accent( $icon_color, 'css' ),
						'style' => 'border',
					) );
				?></div>
			<?php endif ?>

			<?php if ( ! empty( $title ) ) :  ?>
				<h3 class="title" style="color:<?php echo esc_attr( vamtam_sanitize_accent( $title_color, 'css' ) ) ?>"><?php echo wp_kses_post( $title ) ?></h3><br>
			<?php endif ?>
			<?php echo do_shortcode( $before ) ?>

		</div>
	</div>
	<div class="open services-inside">
		<div class="services-content-wrapper">
			<div class="row">
				<?php echo do_shortcode( $content ) ?>
			</div>
		</div>
	</div>
</div>
<?php echo $all_styles; // xss ok ?>
