<?php


include locate_template( 'templates/post/header.php' );

$meta_author   = rd_vamtam_get_optionb( 'post-meta', 'author' );
$meta_date     = rd_vamtam_get_optionb( 'post-meta', 'date' );
$meta_comments = rd_vamtam_get_optionb( 'post-meta', 'comments' ) && comments_open();

?><div class="post-content-outer single-post">


	<?php if ( ! empty( $description ) ) :  ?>
		<div class="desc" style="<?php echo esc_attr( $title_color ) ?>"><?php echo wp_kses_post( $description ) ?></div>
	<?php endif ?>

	<?php if ( $meta_author || $meta_date || $meta_comments || is_customize_preview() ) : ?>
		<div class="meta-top clearfix">
			<?php if ( $meta_author || is_customize_preview() ) : ?>
				<span class="author vamtam-meta-author" <?php VamtamTemplates::display_none( $meta_author ) ?>><?php the_author_posts_link()?></span>
			<?php endif ?>

			<?php if ( $meta_date || is_customize_preview() ) : ?>
				<span class="post-date vamtam-meta-date" itemprop="datePublished" <?php VamtamTemplates::display_none( $meta_date ) ?>><?php the_time( get_option( 'date_format' ) ); ?> </span>
			<?php endif ?>

			<?php get_template_part( 'templates/post/meta/comments' ); ?>

		</div>
	<?php endif ?>

	<?php if ( isset( $post_data['media'] ) && ( rd_vamtam_get_optionb( 'show-single-post-image' ) || is_customize_preview() ) ) : ?>
		<div class="post-media post-media-image" <?php VamtamTemplates::display_none( rd_vamtam_get_optionb( 'show-single-post-image' ) ) ?>>
			<div class='media-inner'>
				<?php echo $post_data['media']; // xss ok ?>
			</div>
		</div>
	<?php endif; ?>


	<?php include locate_template( 'templates/post/content.php' ); ?>

	<div class="post-meta">
		<?php get_template_part( 'templates/post/meta/tax' ); ?>
	</div>

	<?php get_template_part( 'templates/share' ); ?>

</div>
