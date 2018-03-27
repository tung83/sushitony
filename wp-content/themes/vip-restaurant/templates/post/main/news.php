<div class="post-media">
	<?php if ( isset( $post_data['media'] ) ) :  ?>
		<div class="thumbnail">
			<?php if ( has_post_format( 'image' ) || ( isset( $post_data['act_as_image'] ) && $post_data['act_as_image'] ) ) :  ?>
				<a href="<?php the_permalink() ?>" title="<?php the_title_attribute()?>">
					<?php echo $post_data['media']; // xss ok ?>
					<?php echo vamtam_get_icon_html( array( 'name' => 'theme-circle-post' ) ); // xss ok ?>
				</a>
			<?php else : ?>
				<?php echo $post_data['media']; // xss ok ?>
			<?php endif ?>
		</div>
	<?php endif; ?>
</div>

<?php if ( $show_content ) :  ?>
	<div class="post-content-wrapper">
		<?php
			$show_tax = rd_vamtam_get_optionb( 'post-meta', 'tax' ) && ( ! post_password_required() || is_customize_preview() );
			$tags = get_the_tags();
		?>

		<?php if ( $show_tax || is_customize_preview() ) : ?>
			<div class="post-content-meta">
				<div class="vamtam-meta-tax the-categories" <?php VamtamTemplates::display_none( $show_tax ) ?>><span class="icon theme"><?php vamtam_icon( 'theme-layers' ); ?></span> <span class="visuallyhidden"><?php esc_html_e( 'Category', 'wpv' ) ?> </span><?php the_category( ' ' ); ?></div>
			</div>
		<?php endif ?>

		<?php include locate_template( 'templates/post/header.php' ); ?>

		<div class="post-content-outer">
			<?php echo $post_data['content']; // xss ok ?>
		</div>


		<?php if ( ( $show_tax || is_customize_preview() ) && count( $tags ) ) : ?>
			<div class="post-content-meta">
				<div class="the-tags vamtam-meta-tax" <?php VamtamTemplates::display_none( $show_tax ) ?>>
					<?php the_tags( '<span class="icon">' . vamtam_get_icon( 'tag' ) . '</span> <span class="visuallyhidden">' . esc_html__( 'Tags', 'wpv' ) . '</span> ', ', ', '' ); ?>
				</div>
			</div>
		<?php endif ?>


		<div class="post-actions-wrapper clearfix">

		<?php get_template_part( 'templates/post/meta/author' ) ?>

		<?php if ( rd_vamtam_get_optionb( 'post-meta', 'date' ) || is_customize_preview() ) : ?>
			<div class="post-date vamtam-meta-date" <?php VamtamTemplates::display_none( rd_vamtam_get_optionb( 'post-meta', 'date' ) ) ?>>
				<a href="<?php the_permalink() ?>" title="<?php the_title_attribute() ?>">
					<?php the_time( get_option( 'date_format' ) ); ?>
				</a>
			</div>
		<?php endif ?>
		<?php if ( ! post_password_required() ) :  ?>
			<?php get_template_part( 'templates/post/meta/comments' ) ?>
			<?php edit_post_link( '<span class="icon">' . vamtam_get_icon( 'pencil' ) . '</span><span class="visuallyhidden">'. esc_html__( 'Edit', 'wpv' ) .'</span>' ) ?>
		<?php endif ?>
		</div>


	</div>
<?php endif; ?>
