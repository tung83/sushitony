<?php

/**
 * Catch-all post loop
 */

// display full post/image or thumbs
if ( ! isset( $called_from_shortcode ) ) {
	$show_content = true;
	$nopaging     = false;
	$layout       = class_exists( 'Vamtam_Elements_A' ) ? rd_vamtam_get_option( 'archive-layout' ) : 'normal';
	$news         = $layout === 'mosaic';
	$column       = $layout === 'mosaic' ? 4 : 1;
	$max_columns  = 0;
}

if ( defined( 'VAMTAM_ARCHIVE_TEMPLATE' ) && ! $news ) {
	$show_content = false;
}

global $vamtam_loop_vars;
$old_vamtam_loop_vars = $vamtam_loop_vars;
$vamtam_loop_vars     = array(
	'show_content' => $show_content,
	'news'         => $news,
	'column'       => $column,
	'layout'       => $layout,
);

$wrapper_class = array();

$wrapper_class[] = $news ? 'news' : 'regular';
$wrapper_class[] = $layout;
$wrapper_class[] = $nopaging ? 'not-paginated' : 'paginated';

$cube_options = array();
$data_options = '';

if ( $layout === 'mosaic' || $layout === 'grid' ) {
	$cube_options = array(
		'layoutMode'        => $layout,
		'sortToPreventGaps' => true,
		'defaultFilter'     => '*',
		'animationType'     => 'quicksand',
		'gapHorizontal'     => 0,
		'gapVertical'       => 30,
		'gridAdjustment'    => 'responsive',
		'mediaQueries'      => VamtamTemplates::scrollable_columns( $max_columns ),
		'displayType'       => 'bottomToTop',
		'displayTypeSpeed'  => 100,
	);

	$wrapper_class[] = 'vamtam-cubeportfolio cbp';

	$data_options = 'data-options="' . esc_attr( json_encode( $cube_options ) ) . '"';

	wp_enqueue_script( 'cubeportfolio' );
	wp_enqueue_style( 'cubeportfolio' );

	$GLOBALS['vamtam_inside_cube'] = true;
}

?>
<div class="loop-wrapper clearfix <?php echo esc_attr( implode( ' ', $wrapper_class ) ) ?>" data-columns="<?php echo esc_attr( $column ) ?>" <?php echo $data_options // xss ok ?>>
<?php

	do_action( 'vamtam_before_main_loop' );

	$i = 0;

	if ( ! isset( $blog_query ) ) {
		$blog_query = $GLOBALS['wp_query'];
	}

	if ( $blog_query->have_posts() ) :
		while ( $blog_query->have_posts() ) : $blog_query->the_post();
			$post_class   = array();
			$post_class[] = 'page-content post-header';

			if ( $column === 1 && ! $news ) {
				$post_class[] = 'clearfix';
			}

			if ( $news && 0 === $i % $column ) {
				$post_class[] = 'clearboth';
			}

			if ( ! $blog_query->is_single() ) {
				$post_class[] = 'list-item';
			}

			if ( $layout === 'mosaic' ) {
				$post_class[] = 'cbp-item';
			}

			$starting_width = 100 / $column;
?>
			<div <?php post_class( implode( ' ', $post_class ) ) ?> style="width: <?php echo $starting_width ?>%">
				<div>
					<?php include locate_template( 'templates/post.php' );	?>
				</div>
			</div>
<?php
			$i++;
		endwhile;
	endif;

	do_action( 'vamtam_after_main_loop' );
?>
</div>

<?php

if ( ! $nopaging ) {
	$pagination_type = rd_vamtam_get_option( 'pagination-type' );

	if ( 'mosaic' !== $layout || defined( 'VAMTAM_ARCHIVE_TEMPLATE' ) ) {
		$pagination_type = 'paged';
	}

	VamtamTemplates::pagination( $pagination_type, true, $vamtam_loop_vars, $blog_query );
}

if ( $layout === 'mosaic' || $layout === 'grid' ) {
	$GLOBALS['vamtam_inside_cube'] = false;
}

$vamtam_loop_vars = $old_vamtam_loop_vars;
