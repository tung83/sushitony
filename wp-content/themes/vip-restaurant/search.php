<?php
/**
 * Search results template
 *
 * @package vip-restaurant
 */

VamtamFramework::set( 'page_title', sprintf( esc_html__( 'Search Results for: %s', 'wpv' ), '<span>' . get_search_query() . '</span>' ) );

get_header(); ?>

<div class="row page-wrapper">
	<?php if ( have_posts() ) : the_post(); ?>
		<?php VamtamTemplates::$in_page_wrapper = true; ?>

		<article id="post-<?php the_ID(); ?>" <?php post_class( VamtamTemplates::get_layout() ); ?>>
			<?php VamtamTemplates::header_sidebars(); ?>
			<div class="page-content">
				<?php
				rewind_posts();
				get_template_part( 'loop', 'category' );
				get_template_part( 'templates/share' );
				?>
			</div>
		</article>
		<?php get_template_part( 'sidebar' ) ?>
	<?php else : ?>
	<article>
		<h1 id="vamtam-no-search-results"><?php esc_html_e( 'Sorry, nothing found', 'wpv' ) ?></h1>
	</article>
	<?php endif ?>
</div>

<?php get_footer(); ?>
