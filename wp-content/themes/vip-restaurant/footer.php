<?php
/**
 * Footer template
 *
 * @package vip-restaurant
 */

$footer_limit_wrapper = 'limit-wrapper';

if ( rd_vamtam_get_optionb( 'full-width-footer' ) ) {
	$footer_limit_wrapper = '';
}

$hide_lowres_bg = rd_vamtam_get_optionb( 'footer-background-hide-lowres' ) ? 'vamtam-hide-bg-lowres' : '';

$footer_onepage = ( ! is_page_template( 'onepage.php' ) || rd_vamtam_get_optionb( 'one-page-footer' ) );

?>

<?php if ( ! defined( 'VAMTAM_NO_PAGE_CONTENT' ) ) : ?>
	<?php if ( ! class_exists( 'Vamtam_Columns' ) || ( Vamtam_Columns::had_limit_wrapper() && ! is_singular( 'jetpack-portfolio' ) ) ) :  ?>
					</div> <!-- .limit-wrapper -->
	<?php endif ?>

				</div><!-- #main -->

			</div><!-- #main-content -->

			<?php if ( ! is_page_template( 'page-blank.php' ) && ( $footer_onepage || is_customize_preview() ) ) : ?>
				<div class="footer-wrapper" <?php VamtamTemplates::display_none( $footer_onepage ) ?>>
					<footer class="main-footer <?php echo esc_attr( $hide_lowres_bg ) ?>" style="<?php echo esc_attr( VamtamTemplates::build_background( rd_vamtam_get_option( 'footer-background' ) ) ) ?>">
						<?php if ( VamtamTemplates::has_header_footer_sidebars( 'footer' ) ) : ?>
							<div class="footer-sidebars-wrapper <?php echo esc_attr( $footer_limit_wrapper ) ?>">
								<?php VamtamTemplates::footer_sidebars(); ?>
							</div>
						<?php endif ?>
					</footer>

					<?php do_action( 'vamtam_before_sub_footer' ) ?>

					<?php get_template_part( 'subfooter' ) ?>
				</div>
			<?php endif ?>

		</div><!-- / .pane-wrapper -->

<?php endif // VAMTAM_NO_PAGE_CONTENT ?>
	</div><!-- / .boxed-layout -->
</div><!-- / #page -->

<div id="vamtam-overlay-search">
	<button id="vamtam-overlay-search-close"><?php echo vamtam_get_icon_html( array( 'name' => 'theme-icon-close' ) ) // xss ok ?></button>
	<form action="<?php echo esc_url( home_url( '/' ) ) ?>" class="searchform" method="get" role="search" novalidate="">
		<input type="search" required="required" placeholder="<?php esc_attr_e( 'Search...', 'wpv' ) ?>" name="s" value="" />
		<?php if ( defined( 'ICL_LANGUAGE_CODE' ) ) : ?>
			<input type="hidden" name="lang" value="<?php echo esc_attr( ICL_LANGUAGE_CODE ) ?>"/>
		<?php endif ?>
	</form>
</div>

<?php get_template_part( 'templates/side-buttons' ) ?>
<?php wp_footer(); ?>
<!-- W3TC-include-js-head -->
</body>
</html>
