<?php
/**
 * Single Product Image
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/product-image.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.6.3
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $post, $woocommerce, $product;

$attachment_ids = $product->get_gallery_attachment_ids();

?>
<div class="images">

	<?php
		if ( has_post_thumbnail() ) :
			$large_thumbnail_size = apply_filters( 'single_product_large_thumbnail_size', 'shop_single' );
			$small_thumbnail_size = apply_filters( 'single_product_small_thumbnail_size', 'shop_thumbnail' );

			$main_image_id = get_post_thumbnail_id();

			$attachment_count = count( $attachment_ids );

			wp_enqueue_script( 'cubeportfolio' );
			wp_enqueue_style( 'cubeportfolio' );

			$slider_options = array(
				'layoutMode'       => 'slider',
				'drag'             => true,
				'auto'             => false,
				'autoTimeout'      => 5000,
				'autoPauseOnHover' => true,
				'showNavigation'   => true,
				'showPagination'   => false,
				'rewindNav'        => true,
				'gridAdjustment'   => 'responsive',
				'mediaQueries'     => array(
					array(
						'width' => 1,
						'cols'  => 1,
					),
				),
				'gapHorizontal' => 0,
				'gapVertical'   => 0,
				'caption'       => '',
				'displayType'   => 'default',
				'plugins'       => array(
					'slider' => array(
						'pagination'      => '#product-gallery-pager-' . intval( $post->ID ),
						'paginationClass' => 'cbp-pagination-active',
					),
				),
			);

			array_unshift( $attachment_ids, $main_image_id );
			?>
				<div id="product-gallery-<?php echo intval( $post->ID ) ?>" class="vamtam-cubeportfolio cbp cbp-slider-edge" data-options="<?php echo esc_attr( json_encode( $slider_options ) ) ?>">
					<?php foreach ( $attachment_ids as $aid ) : ?>
						<div class="cbp-item">
							<div class="cbp-caption">
								<div class="cbp-caption-defaultWrap">
									<?php
										$image_link  = wp_get_attachment_url( $aid );
										$image       = wp_get_attachment_image( $aid, $large_thumbnail_size );
										$image_title = esc_attr( get_the_title( $aid ) );

										echo wp_kses_post( apply_filters( 'woocommerce_single_product_image_html', sprintf( '<a href="%s" itemprop="image" class="woocommerce-main-image zoom cbp-lightbox" title="%s">%s</a>', esc_url( $image_link ), $image_title, $image ), $post->ID ) ); ?>
								</div>
							</div>
						</div>
					<?php endforeach ?>
				</div>
	<?php
		else :

			echo wp_kses_post( apply_filters( 'woocommerce_single_product_image_html', sprintf( '<img src="%s" alt="Placeholder" />', esc_url( woocommerce_placeholder_img_src() ) ), $post->ID ) );
		endif;
	?>

	<?php if ( $attachment_count > 0 ) : ?>
		<div class="thumbnails" id="product-gallery-pager-<?php echo intval( $post->ID ) ?>"><?php

			$loop = 0;
			$columns = apply_filters( 'woocommerce_product_thumbnails_columns', 3 );

			foreach ( $attachment_ids as $attachment_id ) {

				$classes = array( 'cbp-pagination-item' );

				if ( 0 === $loop || 0 === $loop % $columns )
					$classes[] = 'first';

				if ( 0 === ( $loop + 1 ) % $columns )
					$classes[] = 'last';

				$image_link = wp_get_attachment_url( $attachment_id );

				if ( $image_link ) {
					$image       = wp_get_attachment_image( $attachment_id, apply_filters( 'single_product_small_thumbnail_size', 'shop_thumbnail' ) );
					$image_class = esc_attr( implode( ' ', $classes ) );
					$image_title = esc_attr( get_the_title( $attachment_id ) );

					echo wp_kses_post( apply_filters( 'vamtam_woocommerce_single_product_image_thumbnail_html', sprintf( '<div class="%s" title="%s">%s</div>',  $image_class, $image_title, $image ), $attachment_id, $post->ID, $image_class ) );

					$loop++;
				}
			}

		?></div>
	<?php endif ?>
</div>
