<?php
/**
 * Archive page template
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
				<?php get_template_part( 'loop', 'archive' ) ?>
				<?php get_template_part( 'templates/share' ); ?>
			</div>
		</article>

		<?php get_template_part( 'sidebar' ) ?>
	</div>
<?php endif ?>

<?php get_footer();
