<?php
	$mobile_top_bar = isset( $megamenu_settings['vamtam-mobile-top-bar'] ) ? $megamenu_settings['vamtam-mobile-top-bar'] : '';

	if ( ! empty( $mobile_top_bar ) ) :
?>
		<div class="mobile-top-bar"><?php echo do_shortcode( $mobile_top_bar ) ?></div>
<?php endif ?>
<?php get_template_part( 'templates/header/top/logo', 'wrapper' ) ?>
