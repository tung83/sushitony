<?php
/**
 * Author template
 *
 * @package vip-restaurant
 */

$author = get_user_by( 'slug', get_query_var( 'author_name' ) );
$description = get_the_author_meta( 'description', $author->ID );

VamtamFramework::set( 'page_title', "<a href='" . get_author_posts_url( $author->ID ) . "' rel='me'>" . ( $author->data->display_name ) . '</a>' );

rewind_posts();
get_header();

?>

<div class="row page-wrapper">
	<?php VamtamTemplates::$in_page_wrapper = true; ?>

	<article class="<?php echo esc_attr( VamtamTemplates::get_layout() ) ?>">
		<?php VamtamTemplates::header_sidebars(); ?>
		<div class="page-content">
			<?php if ( ! empty( $description ) ) : ?>
				<div class="author-info-box clearfix">
					<div class="author-avatar">
						<?php echo get_avatar( get_the_author_meta( 'user_email', $author->ID ), 60 ); ?>
					</div>
					<div class="author-description">
						<h4><?php echo sprintf( esc_html__( 'About %s', 'wpv' ), wp_kses_post( $author->data->display_name ) ); ?></h4>
						<?php echo wp_kses_post( $description ) ?>
					</div>
				</div>
			<?php endif; ?>
			<?php rewind_posts() ?>
			<?php if ( have_posts() ) : ?>
				<?php get_template_part( 'loop', 'archive' ) ?>
			<?php else : ?>
				<h2 class="no-posts-by-author"><?php sprintf( esc_html__( '%s has not published any posts yet', 'wpv' ), $author->data->display_name ) ?></h2>
			<?php endif ?>
		</div>
	</article>

	<?php get_template_part( 'sidebar' ) ?>
</div>

<?php get_footer(); ?>
