<?php

$subfooter_limit_wrapper = 'limit-wrapper';

if ( rd_vamtam_get_optionb( 'full-width-subfooter' ) ) {
	$subfooter_limit_wrapper = '';
}

$hide_lowres_bg = rd_vamtam_get_optionb( 'footer-background-hide-lowres' ) ? 'vamtam-hide-bg-lowres' : '';

?>
<?php if ( rd_vamtam_get_option( 'subfooter-left' ) . rd_vamtam_get_option( 'subfooter-center' ) . rd_vamtam_get_option( 'subfooter-right' ) != '' ) : ?>
	<div class="vamtam-subfooter copyrights <?php echo esc_attr( $hide_lowres_bg ) ?>" style="<?php echo esc_attr( VamtamTemplates::build_background( rd_vamtam_get_option( 'subfooter-background' ) ) ) ?>">
		<div class="<?php echo esc_attr( $subfooter_limit_wrapper ) ?>">
			<div class="row">
				<?php
					$left   = do_shortcode( rd_vamtam_get_option( 'subfooter-left' ) );
					$center = do_shortcode( rd_vamtam_get_option( 'subfooter-center' ) );
					$right  = do_shortcode( rd_vamtam_get_option( 'subfooter-right' ) );
				?>
				<?php if ( empty( $left ) && empty( $right ) ) : ?>
					<div class="vamtam-grid grid-1-1 textcenter"><?php echo $center // xss ok ?></div>
				<?php elseif ( empty( $center ) ) : ?>
					<div class="vamtam-grid grid-1-2"><?php echo $left // xss ok ?></div>
					<div class="vamtam-grid grid-1-2 textright"><?php echo $right // xss ok ?></div>
				<?php else : ?>
					<div class="vamtam-grid grid-1-3"><?php echo $left // xss ok ?></div>
					<div class="vamtam-grid grid-1-3 textcenter"><?php echo $center // xss ok ?></div>
					<div class="vamtam-grid grid-1-3 textright"><?php echo $right // xss ok ?></div>
				<?php endif ?>
			</div>
		</div>
	</div>
<?php endif ?>