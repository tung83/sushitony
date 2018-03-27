<div id="comment-<?php comment_ID() ?>" <?php comment_class( 'cbp-item' . ( $args['has_children'] ? 'has-children' : '' ) ) ?>>

	<div class="comment-inner">
		<?php echo vamtam_get_icon_html( array( 'name' => 'theme-quote' ) ); // xss ok ?>
		<header class="comment-header">
			<h5 class="comment-author-link"><?php comment_author_link(); ?></h5>
			<?php
				if ( ( ! isset( $args['reply_allowed'] ) || $args['reply_allowed'] ) && ( $args['type'] == 'all' || get_comment_type() == 'comment' )  ) :
					comment_reply_link( array_merge( $args, array(
						'reply_text' => esc_html__( 'Reply', 'wpv' ),
						'login_text' => esc_html__( 'Log in to reply.', 'wpv' ),
						'depth'      => $depth,
						'before'     => '<h6 class="comment-reply-link">',
						'after'      => '</h6>',
					) ) );
				endif;
			?>
		</header>
		<?php comment_text() ?>
		<footer class="comment-footer">
			<div title="<?php comment_time(); ?>" class="comment-time"><?php comment_date(); ?></div>
			<?php edit_comment_link( sprintf( '[%s]', esc_html__( 'Edit', 'wpv' ) ) ) ?>
			<?php if ( $comment->comment_approved == '0' ): ?>
				<span class='unapproved'><?php esc_html_e( "Your comment is awaiting moderation.", 'wpv' ); ?></span>
			<?php endif ?>
		</footer>
	</div>
