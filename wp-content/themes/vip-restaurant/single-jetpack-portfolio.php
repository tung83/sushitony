<?php
/**
 * Single portfolio template
 *
 * @package vip-restaurant
 */

if ( isset( $_SERVER['HTTP_X_REQUESTED_WITH'] ) && 'XMLHttpRequest' === $_SERVER['HTTP_X_REQUESTED_WITH'] && have_posts() ) :
	the_post();

	if ( function_exists( 'sharing_add_header' ) ) {
		sharing_add_header();
	}

	extract( vamtam_get_portfolio_options() );
?>

	<h1 class="ajax-portfolio-title textcenter"><?php the_title() ?></h1>
	<article id="post-<?php the_ID(); ?>" <?php post_class( 'full ' . $type ); ?>>
		<div class="page-content">
			<?php include locate_template( 'single-jetpack-portfolio-content.php' ); ?>
		</div>
	</article>

<?php

	if ( function_exists( 'sharing_add_footer' ) ) {
		sharing_add_footer();
	}

	print_late_styles();

?>
	<script> try { twttr.widgets.load(); } catch(e) {} </script>
<?php

	exit;
endif;

get_header();
?>
	<div class="row page-wrapper">
		<?php VamtamTemplates::$in_page_wrapper = true; ?>

		<?php
			if ( have_posts() ) :
				while ( have_posts() ) : the_post();
		?>
				<?php
					extract( vamtam_get_portfolio_options() );

					list( $terms_slug, $terms_name ) = vamtam_get_portfolio_terms();
				?>
				<article id="post-<?php the_ID(); ?>" <?php post_class( VamtamTemplates::get_layout() . ' ' . $type ); ?>>
					<div class="page-content">
						<?php VamtamTemplates::header_sidebars(); ?>
						<?php include locate_template( 'single-jetpack-portfolio-content.php' ); ?>

						<div class="clearboth">
							<?php comments_template(); ?>
						</div>
					</div>
				</article>
			<?php endwhile ?>
		<?php endif ?>

		<?php get_template_part( 'sidebar' ) ?>
	</div>

	<?php if ( ( rd_vamtam_get_optionb( 'show-related-portfolios' ) || is_customize_preview() ) && class_exists( 'Vamtam_Projects' ) && Vamtam_Projects::in_category( $terms_slug ) > 1 ) : ?>
		<?php

			$related_query = new WP_Query( array(
				'post_type'      => Jetpack_Portfolio::CUSTOM_POST_TYPE,
				'posts_per_page' => 1,
				'post__not_in'   => array( get_the_ID() ),
				'tax_query'      => array(
					array(
						'taxonomy' => 'jetpack-portfolio-type',
						'field'    => 'slug',
						'terms'    => $terms_slug,
					),
				),
			) );

			if ( intval( $related_query->found_posts ) > 0 ) :
		?>
				<div class="related-portfolios row vamtam-related-content" <?php VamtamTemplates::display_none( rd_vamtam_get_optionb( 'show-related-portfolios' ) ) ?>>
					<div class="clearfix limit-wrapper">
						<div class="grid-1-1">
							<?php echo wp_kses_post( apply_filters( 'vamtam_related_portfolios_title', '<h5 class="related-content-title">' . rd_vamtam_get_option( 'related-portfolios-title' ) . '</h5>' ) ); ?>
							<?php echo Vamtam_Projects::shortcode( array( // xss ok
								'column'       => 4,
								'type'         => $terms_slug,
								'ids'          => '',
								'max'          => 8,
								'height'       => 400,
								'show_title'   => 'below',
								'desc'         => true,
								'more'         => esc_html__( 'View', 'wpv' ),
								'nopaging'     => 'true',
								'group'        => 'true',
								'layout'       => 'scrollable',
								'post__not_in' => get_the_ID(),
							) ); ?>
						</div>
					</div>
				</div>
		<?php endif ?>
	<?php endif ?>
<?php get_footer();
