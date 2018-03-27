<?php
/**
 * Single post template
 *
 * @package vip-restaurant
 */

get_header();

?>

<?php
if ( have_posts() ) :
	while ( have_posts() ) : the_post(); ?>

		<div class="row page-wrapper">
			<?php VamtamTemplates::$in_page_wrapper = true; ?>

			<article <?php post_class( 'single-post-wrapper '.VamtamTemplates::get_layout() )?>>
				<?php VamtamTemplates::header_sidebars(); ?>
				<div class="page-content loop-wrapper clearfix full">
					<?php get_template_part( 'templates/post' ); ?>
					<div class="clearboth">
						<?php comments_template(); ?>
					</div>
				</div>
			</article>

			<?php get_template_part( 'sidebar' ) ?>
		</div>

		<?php if ( ( rd_vamtam_get_optionb( 'show-related-posts' ) || is_customize_preview() ) && is_singular( 'post' ) && class_exists( 'Vamtam_Blog' ) ) : ?>
			<?php if ( ! class_exists( 'Vamtam_Columns' ) || Vamtam_Columns::had_limit_wrapper() ) :  ?>
				</div>
			<?php endif ?>
			<?php
				$terms = array();
				$cats  = get_the_category();
				foreach ( $cats as $cat ) {
					$terms[] = $cat->term_id;
				}

				$related_query = new WP_Query( array(
					'post_type'      => 'post',
					'category__in'   => $terms,
					'post__not_in'   => array( get_the_ID() ),
					'posts_per_page' => 1,
				) );

				if ( intval( $related_query->found_posts ) > 0 ) :
			?>
					<div class="related-posts row vamtam-related-content" <?php VamtamTemplates::display_none( rd_vamtam_get_optionb( 'show-related-posts' ) ) ?>>
						<div class="clearfix limit-wrapper">
							<div class="grid-1-1">
								<?php echo wp_kses_post( apply_filters( 'vamtam_related_posts_title', '<h5 class="related-content-title">' . rd_vamtam_get_option( 'related-posts-title' ) . '</h5>' ) ); ?>
								<?php
									echo Vamtam_Blog::shortcode( array( // xss ok
										'count'        => 8,
										'column'       => 4,
										'cat'          => $terms,
										'layout'       => 'scroll-x',
										'show_content' => true,
										'post__not_in' => get_the_ID(),
									) );
								?>
							</div>
						</div>
					</div>
			<?php endif ?>
			<?php if ( ! class_exists( 'Vamtam_Columns' ) || Vamtam_Columns::had_limit_wrapper() ) :  ?>
				<div class="limit-wrapper">
			<?php endif ?>
		<?php endif ?>
	<?php endwhile;
endif;

get_footer();
