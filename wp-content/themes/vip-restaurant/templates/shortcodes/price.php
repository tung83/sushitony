<div class="price-outer-wrapper">
	<div class="price-wrapper <?php echo $featured == 'true'? 'featured':'' ?>">
		<h3 class="price-title"><?php echo wp_kses_post( $title ) ?></h3>
		<div class="price" style="text-align: <?php echo esc_attr( $text_align ) ?>">
			<div class="value-box">
				<div class="value-box-content">
					<span class="value">
						<i><?php echo esc_html( $currency ) ?></i><span class="number"><?php echo esc_html( $price ) ?></span>
					</span>
					<span class="meta <?php if ( empty( $duration ) ) echo 'invisible' ?>"><?php echo esc_html( $duration ) ?></span>
				</div>
			</div>

			<div class="content-box">
				<?php echo do_shortcode( $content ) ?>
			</div>
			<div class="meta-box">
				<?php if ( ! ! $summary ) : ?><p class="description"><?php echo htmlspecialchars_decode( $summary ) // xss ok ?></p><?php endif?>
				<?php
					echo VamtamTemplates::shortcode( 'button', array( // xss ok
						'link'        => $button_link,
						'bgcolor'     => 'accent1',
						'hover_color' => 'accent6',
						'text_color'  => 'accent6',
						'font'        => 14,
						'style'       => 'border',
					), $button_text, 'button' );
				?>
			</div>
		</div>
	</div>
</div>
