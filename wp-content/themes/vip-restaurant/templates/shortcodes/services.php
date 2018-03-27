<?php
	$has_image  = ! empty( $image );
	$has_icon   = ! empty( $icon );
	$has_button = ! empty( $button_link );

	$className[] = 'services clearfix';
	$className[] = $has_image  ? 'has-image'  : 'no-image';
	$className[] = $has_icon   ? 'has-icon'   : 'no-icon';
	$className[] = $has_button ? 'has-button' : 'no-button';
	$className[] = 'align-' . esc_attr( $text_align );
	$className[] = $class;
	$className   = implode( ' ', $className );

?>
<div class="<?php echo esc_attr( $className ) ?>" style="text-align:<?php echo esc_attr( $text_align ) ?>;">
	<div class="services-inside">
		<?php if ( $has_image || $has_icon ) :  ?>
			<div class="thumbnail">
				<?php if ( $has_button ) :  ?>
					<a href="<?php echo esc_url( $button_link ) ?>" title="<?php echo esc_attr( $title ) ?>" class="<?php if ( $has_image ) echo 'has-border' ?>">
				<?php endif ?>
					<?php if ( $has_image ) :  ?>
						<?php vamtam_url_to_image( $image ) ?>
					<?php elseif ( $has_icon ) :  ?>
						<?php
							echo vamtam_get_icon_html( array( // xss ok
								'name' => $icon,
								'color' => $icon_color,
								'size' => $icon_size,
							) );
						?>
					<?php endif ?>
				<?php if ( $has_button ) :  ?>
					</a>
				<?php endif ?>
			</div>
			<?php if ( $has_icon ) :  ?>
				<div class="sep-2"></div>
			<?php endif ?>
		<?php endif ?>
		<?php if ( $title != '' ) : ?>
			<h4 class="services-title">
				<?php if ( ! empty( $button_link ) ) :  ?>
					<a href="<?php echo esc_url( $button_link ) ?>" title="<?php echo esc_attr( $title ) ?>"><?php echo wp_kses_post( $title ) ?></a>
				<?php else : ?>
					<?php echo wp_kses_post( $title ); ?>
				<?php endif ?>
			</h4>
		<?php endif ?>
		<?php if ( ! empty( $content ) ) :  ?>
			<div class="services-content"><?php echo do_shortcode( $content )?></div>
		<?php endif ?>
	</div>
</div>
