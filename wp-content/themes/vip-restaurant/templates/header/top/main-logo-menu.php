<div class="<?php echo rd_vamtam_get_option( 'full-width-header' ) ? '' : 'limit-wrapper' ?> header-maybe-limit-wrapper header-padding">
	<div class="header-contents">
		<div class="first-row">
			<?php get_template_part( 'templates/header/top/logo' ) ?>
		</div>

		<div class="second-row <?php if ( rd_vamtam_get_option( 'enable-header-search' ) ) echo 'has-search' ?>">
			<div id="menus">
				<?php get_template_part( 'templates/header/top/main-menu' ) ?>
			</div>
		</div>

		<?php do_action( 'vamtam_header_cart' ) ?>

		<?php get_template_part( 'templates/header/top/search-button' ) ?>

		<?php get_template_part( 'templates/header/top/text-main' ) ?>
	</div>
</div>
