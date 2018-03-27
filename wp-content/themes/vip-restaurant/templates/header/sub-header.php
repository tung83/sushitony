<?php
/**
 * Site sub-header. Includes a slider, page title, etc.
 *
 * @package vip-restaurant
 */

$page_title = VamtamFramework::get( 'page_title', null );

if ( ! is_404() ) {
	if ( vamtam_has_woocommerce() ) {
		if ( is_woocommerce() && ! is_single() ) {
			if ( is_product_category() ) {
				$page_title = single_cat_title( '', false );
			} elseif ( is_product_tag() ) {
				$page_title = single_tag_title( '', false );
			} else {
				$page_title = woocommerce_get_page_id( 'shop' ) ? get_the_title( woocommerce_get_page_id( 'shop' ) ) : '';
			}
		} elseif ( is_cart() || is_checkout() ) {
			$cart_title     = get_the_title( wc_get_page_id( 'cart' ) );
			$checkout_title = get_the_title( wc_get_page_id( 'checkout' ) );
			$complete_title = esc_html__( 'Order Complete', 'wpv' );

			$cart_state     = is_cart() ? 'active' : 'inactive';
			$checkout_state = is_checkout() && ! is_order_received_page() ? 'active' : 'inactive';
			$complete_state = is_order_received_page() ? 'active' : 'inactive';

			$page_title = "
				<span class='checkout-breadcrumb'>
					<span class='title-part-{$cart_state}'>$cart_title</span>" .
					vamtam_get_icon_html( array( 'name' => 'theme-arrow-right-sample' ) ) .
					"<span class='title-part-{$checkout_state}'>$checkout_title</span>" .
					vamtam_get_icon_html( array( 'name' => 'theme-arrow-right-sample' ) ) .
					"<span class='title-part-{$complete_state}'>$complete_title</span>
				</span>
			";
		}
	}
}

$sub_header_class = array( 'layout-' . VamtamTemplates::get_layout() );

$page_header_bg = VamtamTemplates::page_header_background();

// $has_header_bg should be true for non-transparent backgrounds
$sub_header_bg_str = str_replace(
	'background-color:transparent;background-image:none;',
	'',
	$page_header_bg . rd_vamtam_get_option( 'page-title-background', 'background-image' ) . rd_vamtam_get_option( 'page-title-background', 'background-color'
) );

if ( ! empty( $sub_header_bg_str ) ) {
	$sub_header_class[] = 'has-background';
}

if ( ( ! VamtamTemplates::has_page_header() && ! VamtamTemplates::has_post_siblings_buttons() ) || is_404() ) return;
if ( is_page_template( 'page-blank.php' ) ) return;

$has_text_shadow = is_singular( VamtamFramework::$complex_layout ) && vamtam_sanitize_bool( get_post_meta( get_the_ID(), 'has-page-title-shadow', true ) );

if ( $has_text_shadow ) {
	$sub_header_class[] = 'has-text-shadow';
}

?>
<div id="sub-header" class="<?php echo esc_attr( implode( ' ', $sub_header_class ) ) ?>">
	<div class="meta-header" style="<?php echo esc_attr( $page_header_bg ) ?>">
		<?php if ( $has_text_shadow ) : ?>
			<div class="text-shadow"> </div>
		<?php endif ?>
		<div class="limit-wrapper">
			<div class="meta-header-inside">
				<?php
					VamtamTemplates::page_header( false, $page_title );
				?>
			</div>
		</div>
	</div>
</div>
