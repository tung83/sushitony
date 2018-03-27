<?php
/**
 * Slider or custom content between the menu and the page title
 *
 * @package vip-restaurant
 */

if ( is_page_template( 'page-blank.php' ) || is_archive() || is_search() ) return;

$post_id    = vamtam_get_the_ID();
$fullwidth  = vamtam_post_meta( $post_id, 'page-middle-header-content-fullwidth', true ) === 'true';
$min_height = vamtam_post_meta( $post_id, 'page-middle-header-min-height', true );

function vamtam_header_middle_limit_wrapper() {
	return vamtam_post_meta( vamtam_get_the_ID(), 'page-middle-header-content-fullwidth', true ) !== 'true';
}

add_filter( 'vamtam_had_limit_wrapper', 'vamtam_header_middle_limit_wrapper' );

$content = do_shortcode( wp_kses_post( vamtam_post_meta( $post_id, 'page-middle-header-content', true ) ) );

remove_filter( 'vamtam_had_limit_wrapper', 'vamtam_header_middle_limit_wrapper' );

if ( ! VamtamTemplates::has_header_slider() && empty( $content ) && empty( $min_height ) ) return;

$style  = VamtamTemplates::get_title_style();
$style .= "min-height:{$min_height}px";

if ( VamtamTemplates::has_header_slider() ) :
?>
<header class="header-middle row type-slider">
	<?php
		$slider = vamtam_post_meta( $post_id, 'slider-category', true );
		$slider_engine = strpos( $slider, 'layerslider' ) === 0 ? 'layerslider' : 'revslider';
		?>
		<div id="header-slider-container" class="<?php echo esc_attr( $slider_engine ) ?>">
			<div class="header-slider-wrapper">
				<?php
					get_template_part( 'slider', $slider_engine );
				?>
			</div>
		</div>
</header>
<?php endif ?>

<?php if ( $post_id ) :  ?>
	<header class="header-middle header-middle-bottom row <?php echo esc_attr( $fullwidth ? 'fullwidth' : 'normal' ) ?> type-featured" style="<?php echo esc_attr( $style ) ?>">
		<?php if ( ! $fullwidth ) :  ?>
			<div class="limit-wrapper">
				<div class="header-middle-content">
					<?php echo $content; // xss ok, filtered above ?>
				</div>
			</div>
		<?php else : ?>
			<?php echo $content; // xss ok, filtered above ?>
		<?php endif ?>
	</header>
<?php endif; ?>
