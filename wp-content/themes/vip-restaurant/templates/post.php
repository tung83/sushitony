<?php

/**
 * The common code for the single and looped post template
 *
 * @package vip-restaurant
 */

	global $post, $wp_query;

	if ( ! isset( $blog_query ) ) {
		$blog_query = $wp_query;
	}

	extract( VamtamPostFormats::post_layout_info() );
	$format = get_post_format();
	$format = empty( $format ) ? 'standard' : $format;

	$post_data = array_merge(
		array(
		'p'       => $post,
		'format'  => $format,
		'content' => $blog_query->is_single( $post ) ? get_the_content() :
			             ( $show_content && ! $news ? get_the_content( esc_html__( 'Read more', 'wpv' ), false ) : get_the_excerpt() ),
	), VamtamPostFormats::post_layout_info() );

	if ( has_post_format( 'quote' ) && ! $blog_query->is_single( $post ) && ($news || ! $show_content) ) {
		$post_data['content'] = '';
	}

	$post_data = VamtamPostFormats::process( $post_data );

	$has_media = isset( $post_data['media'] ) ? 'has-image' : 'no-image';
?>
<div class="post-article <?php echo esc_attr( $has_media ) ?>-wrapper <?php echo esc_attr( $blog_query->is_single( $post ) ? 'single' : '' ) ?>">
	<div class="<?php echo esc_attr( $format ) ?>-post-format clearfix <?php echo esc_attr( isset( $post_data['act_as_image'] ) ? 'as-image' : 'as-normal' ) ?> <?php echo esc_attr( isset( $post_data['act_as_standard'] ) ? 'as-standard-post-format' : '' ) ?>">
		<?php
			if ( $blog_query->is_single( $post ) ) {
				include locate_template( 'templates/post/main/single.php' );
			} elseif ( $news ) {
				include locate_template( 'templates/post/main/news.php' );
			} else {
				include locate_template( 'templates/post/main/loop.php' );
			}
		?>
	</div>
</div>
