<?php
	/**
	 * Top bar ( above the logo )
	 * @package vip-restaurant
	 */

	$layout = rd_vamtam_get_option( 'top-bar-layout' );

	$layout = ! empty( $layout ) ? explode( '-', $layout ) : null;
?>
<?php if ( $layout ) :  ?>
	<div id="top-nav-wrapper" style="<?php echo esc_attr( VamtamTemplates::build_background( rd_vamtam_get_option( 'top-nav-background' ) ) ) ?>">
		<?php do_action( 'vamtam_top_nav_before' ) ?>
		<?php get_template_part( 'templates/header/top/nav', 'inner' ) ?>
		<?php do_action( 'vamtam_top_nav_after' ) ?>
	</div>
<?php endif ?>
