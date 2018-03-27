<?php
/**
 * Catch-all template
 *
 * @package vip-restaurant
 */

$format = get_query_var( 'format_filter' );

VamtamFramework::set( 'page_title', $format ? sprintf( esc_html__( 'Post format: %s', 'wpv' ), $format ) : esc_html__( 'Blog', 'wpv' ) );

get_header();
?>
<div class="row page-wrapper">

	<article <?php post_class( VamtamTemplates::get_layout() ) ?>>
		<?php VamtamTemplates::header_sidebars(); ?>
		<div class="page-content">
			<?php get_template_part( 'loop', 'index' ); ?>
		</div>
	</article>

	<?php get_template_part( 'sidebar' ) ?>
</div>
<?php get_footer(); ?>
