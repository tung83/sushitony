<?php

/**
 * Single portfolio content template
 * @package vip-restaurant
 */

global $content_width;

$client = get_post_meta( get_the_id(), 'portfolio-client', true );
$client = preg_replace( '@</\s*([^>]+)\s*>@', '</$1>', $client );

$content = get_the_content();

$portfolio_options = vamtam_get_portfolio_options();
if ( 'gallery' === $portfolio_options['type'] ) {
	list( , $content ) = VamtamPostFormats::get_first_gallery( $content );
}

$content = apply_filters( 'the_content', $content );

$project_types = get_the_terms( get_the_id(), Jetpack_Portfolio::CUSTOM_TAXONOMY_TYPE );
$project_tags  = get_the_terms( get_the_id(), Jetpack_Portfolio::CUSTOM_TAXONOMY_TAG );

?>

<?php if ( 'document' !== $type ) : ?>
	<div class="clearfix limit-wrapper ">
		<div class="portfolio-image-wrapper fullwidth-folio">
			<?php
				$logo = get_post_meta( get_the_id(), 'portfolio-logo',   true );

				if ( 'gallery' === $type ) :
					list( $gallery, ) = VamtamPostFormats::get_first_gallery( get_the_content(), null, 'single-portfolio' );
					echo do_shortcode( $gallery );
				elseif ( 'video' === $type ) :
					global $wp_embed;
					echo do_shortcode( $wp_embed->run_shortcode( '[embed width="' . esc_attr( $content_width ) . '"]' . $href . '[/embed]' ) );
				elseif ( 'html' === $type ) :
					echo do_shortcode( get_post_meta( get_the_ID(), 'portfolio-top-html', true ) );
				else :
					the_post_thumbnail( 'theme-single' );
				endif;
			?>
			<?php if ( ! empty( $logo ) ) : ?>
				<div class="client-logo">
					<img src="<?php echo esc_url( $logo ) ?>" alt="<?php the_title_attribute() ?>"/>
				</div>
			<?php endif ?>

		</div>
	</div>
<?php endif ?>

<div class="portfolio-text-content">
	<div class="row portfolio-content">
		<div class="project-meta limit-wrapper">

			<div class="cell">
				<p class="meta"><span  class="meta-title"><?php esc_html_e( 'Date:', 'wpv' ) ?></span> <?php the_date() ?></p>
			</div>

			<?php if ( ! empty( $client ) ) : ?>
				<div class="cell client-name">
					<p class="client-details"><span  class="meta-title"><?php esc_html_e( 'Client:', 'wpv' ) ?></span> <?php echo wp_kses_post( $client ) ?></p>
				</div>
			<?php endif ?>

			<?php if ( ! empty( $project_types ) && ! is_wp_error( $project_types ) ) : ?>
				<div class="cell">
					<p class="meta posted_in">
						<span  class="meta-title"><?php esc_html_e( 'Types:', 'wpv' ) ?></span> <?php echo wp_kses_post( implode( ' ', VamtamTemplates::project_tax( Jetpack_Portfolio::CUSTOM_TAXONOMY_TYPE ) ) ) ?></div>
				</p>
			<?php endif ?>

			<?php if ( ! empty( $project_tags ) && ! is_wp_error( $project_tags ) ) : ?>
				<div class="cell">
					<p class="meta tagged_as"><span  class="meta-title"><?php esc_html_e( 'Tags:', 'wpv' ) ?></span> <?php echo wp_kses_post( implode( ' ', VamtamTemplates::project_tax( Jetpack_Portfolio::CUSTOM_TAXONOMY_TAG ) ) ) ?></p>
				</div>
			<?php endif ?>
		</div>

		<div class="project-main-content <?php if ( ! class_exists( 'Vamtam_Columns' ) || Vamtam_Columns::had_limit_wrapper() ) echo 'limit-wrapper'; ?>">
			<?php echo $content; // xss ok ?>
			<?php get_template_part( 'templates/share' ); ?>
		</div>
	</div>
</div>
