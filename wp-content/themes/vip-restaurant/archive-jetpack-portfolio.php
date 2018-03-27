<?php
/**
 * Portfolio archive page template
 *
 * @package vip-restaurant
 */

VamtamFramework::set( 'page_title', get_the_archive_title() );

get_header(); ?>

<?php if ( have_posts() ) : the_post(); ?>
	<div class="row page-wrapper">

		<?php VamtamTemplates::$in_page_wrapper = true; ?>

		<article id="post-<?php the_ID(); ?>" <?php post_class( VamtamTemplates::get_layout() ); ?>>
			<?php VamtamTemplates::header_sidebars(); ?>
			<div class="page-content">
				<?php rewind_posts() ?>
				<?php
					$atts = shortcode_atts( Vamtam_Projects::$defaults, array(
						'layout'             => 'masonry',
						'image_aspect_ratio' => 'original',
						'nopaging'           => false,
						'link_opens'         => 'single',
						'show_title'         => 'below',
					) );

					extract( $atts );

					$desc = true;

					$title_filter    = false;
					$category_filter = false;

					// number of columns - get the css class
					$column = 0;

					$max_columns = $column;

					if ( 0 === $column ) {
						$column = 4; // this is used for thumbnails only
					}

					$scrollable = false;

					$old_column                      = isset( $GLOBALS['vamtam_portfolio_column'] ) ? $GLOBALS['vamtam_portfolio_column'] : null;
					$GLOBALS['vamtam_portfolio_column'] = $column;

					$portfolio_query = $GLOBALS['wp_query'];

					include locate_template( 'templates/portfolio/loop.php' );
				?>
				<?php get_template_part( 'templates/share' ); ?>
			</div>
		</article>

		<?php get_template_part( 'sidebar' ) ?>
	</div>
<?php endif ?>

<?php get_footer();
