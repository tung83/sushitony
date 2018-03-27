<?php
/**
 * Single portfolio item used in a loop
 *
 * @package vip-restaurant
 */

list($terms_slug, $terms_name) = vamtam_get_portfolio_terms();

$item_class = array();

$item_class[] = $show_title === 'below' ? 'has-title' : 'no-title';
$item_class[] = $desc ? 'has-description' : 'no-description';
$item_class[] = 'state-closed';
$item_class[] = 'vamtam-project';

$item_class[] = 'cbp-item';

$featured = vamtam_sanitize_bool( vamtam_post_meta( get_the_id(), 'featured-project', true ) );
$starting_width = 100 / $column;

if ( $featured ) {
	$starting_width *= 2;
}

$gallery = $href = '';
extract( vamtam_get_portfolio_options() );

$video_url = ( $type === 'video' && ! empty( $href ) ) ? $href : '';

$suffix = ( $image_aspect_ratio === 'original' ) ? 'normal' : 'loop';

if ( $featured ) {
	$suffix .= '-featured';
}

$cbp_singlepage = '';
if ( 'ajax' === $link_opens && 'link' !== $type ) {
	$cbp_singlepage = 'cbp-singlePage';
}

?>
<div data-id="<?php the_id()?>" data-type="<?php echo esc_attr( implode( ' ', $terms_slug ) )?>" class="<?php echo esc_attr( implode( ' ', $item_class ) ); ?>" style="width: <?php echo intval( $starting_width ) ?>%">
	<div class="portfolio-item-wrapper">
		<?php if ( ( $show_title === 'below' || $desc ) && ( 'video' !== $type || empty( $video_url ) || has_post_thumbnail() ) ) : ?>
			<div class="portfolio_details">
				<span>
				<?php if ( $show_title === 'below' ) : ?>
					<h3 class="title">
						<a href="<?php echo esc_url( get_permalink() ) ?>" class="project-title <?php echo esc_attr( $cbp_singlepage ) ?>" target="<?php echo esc_attr( $link_target ) ?>"><?php the_title()?></a>
					</h3>
				<?php endif ?>
				<?php if ( $desc ) : ?>
					<div class="excerpt"><?php the_excerpt() ?></div>
				<?php endif ?>
				</span>
				<?php if ( 'mosaic' === $layout && ( has_post_thumbnail() || ! empty( $video_url ) || ! empty( $gallery ) ) ) : ?>
					<div class="lightbox-wrapper">
						<?php
							if ( 'gallery' === $type && ! empty( $gallery ) ) :
								echo do_shortcode( str_replace( 'vamtam_gallery', 'vamtam_gallery_lightbox', $gallery ) );
							else :
								if ( 'video' === $type ) {
									$link = $video_url;
								} else {
									$image = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' );

									$link = $image[0];
								}
						?>
							<a href="<?php echo esc_url( $link ) ?>" class="cbp-lightbox icon theme" title="<?php esc_attr_e( 'View Media', 'wpv' ) ?>" data-title="<?php the_title_attribute() ?>"><?php vamtam_icon( 'theme-search2' ) ?></a>
						<?php endif ?>
					</div>
				<?php endif ?>
			</div>
		<?php endif ?>

		<div class="portfolio-image">
			<div class="thumbnail">
				<?php
					if ( ! empty( $gallery ) ) :
						echo do_shortcode( $gallery ); elseif ( ! empty( $video_url ) && ! has_post_thumbnail() ) :
						global $wp_embed;
						echo do_shortcode( $wp_embed->run_shortcode( '[embed]'.$video_url.'[/embed]' ) ); echo '<a href="' . esc_url( $video_url ) . '" class="cbp-lightbox" title="" data-title="' . esc_attr( get_the_title() ) . '" style="display:none"></a>';
					elseif ( has_post_thumbnail() ) :
				?>
						<a href="<?php echo esc_url( get_permalink() ) ?>" class="meta <?php echo esc_attr( $cbp_singlepage ) ?>" target="<?php echo esc_attr( $link_target ) ?>">
							<?php
								VamtamOverrides::unlimited_image_sizes();
								the_post_thumbnail( apply_filters( 'vamtam_portfolio_loop_image_size', "theme-{$suffix}-4", $suffix, $column ) );
								VamtamOverrides::limit_image_sizes();
							?>
						</a>
				<?php endif ?>
			</div><!-- / .thumbnail -->
		</div>
	</div>
</div>
