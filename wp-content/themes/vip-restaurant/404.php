<?php
/**
 * 404 page template
 *
 * @package vip-restaurant
 */

get_header(); ?>

<div class="clearfix">
	<div id="header-404">
		<div class="line-1">404</div>
		<div class="line-2"><?php esc_html_e( 'Holy guacamole!', 'wpv' ) ?></div>
		<div class="line-3"><?php esc_html_e( 'Looks like this page is kaput. Or on vacation. Or just playing hard to get. At any rate... it is not here.', 'wpv' ) ?></div>
		<div class="line-4"><a href="<?php echo esc_url( home_url( '/' ) ) ?>"><?php echo esc_html__( '&larr; Go to the home page or just search...', 'wpv' ) ?></a></div>
	</div>
	<div class="page-404">
		<?php get_search_form(); ?>
	</div>
</div>

<?php get_footer(); ?>
