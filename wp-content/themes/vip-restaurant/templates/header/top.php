<?php
	/**
	 * Actual, visible header. Includes the logo, menu, etc.
	 * @package vip-restaurant
	 */

	$layout = rd_vamtam_get_option( 'header-layout' );

	if ( is_page_template( 'page-blank.php' ) ) return;

	$style_attr = '';

	if (
		rd_vamtam_get_optionb( 'sticky-header' ) &&
		in_array( vamtam_post_meta( null, 'sticky-header-type', true ), array( 'over', 'half-over' ), true )
	) {
		$style_attr .= 'height:0;';
	}
?>
<div class="fixed-header-box sticky-header-state-reset" style="<?php echo esc_attr( $style_attr ) ?>">
	<header class="main-header layout-<?php echo esc_attr( $layout ) ?> <?php if ( $layout === 'logo-menu' ) echo 'header-content-wrapper' ?>">
		<?php get_template_part( 'templates/header/top/nav' ) ?>
		<?php get_template_part( 'templates/header/top/main', $layout ) ?>
	</header>

	<?php do_action( 'vamtam_header_box' ); ?>
</div>
