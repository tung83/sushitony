<?php
	$comment_class = array( 'clearfix' );

	if ( $args['has_children'] ) {
		$comment_class[] = 'has-children';
	}

	if ( 'pings' === $args['type'] ) {
		$comment_class[] = 'comment';
	}
?>
<div id="comment-<?php comment_ID() ?>" <?php comment_class( implode( ' ', $comment_class ) ) ?>>
	<div class="comment-author">
		<?php echo get_avatar( get_comment_author_email(), 73 ); ?>
	</div>
	<div class="comment-content">
		<div class="comment-meta">
			<h5 class="comment-author-link"><?php comment_author_link(); ?></h5>
			<div title="<?php comment_time(); ?>" class="comment-time">on <?php comment_date(); ?></div>
			<?php edit_comment_link( sprintf( '[%s]', esc_html__( 'Edit', 'wpv' ) ) ) ?>
			<?php
				if ( $args['type'] == 'all' || get_comment_type() == 'comment' ) :
					comment_reply_link( array_merge( $args, array(
						'reply_text' => esc_html__( 'Reply', 'wpv' ),
						'login_text' => esc_html__( 'Log in to reply.', 'wpv' ),
						'depth'      => $depth,
						'before'     => '<h6 class="comment-reply-link">',
						'after'      => '</h6>',
					) ) );
				endif;
			?>
		</div>
		<?php if ( $comment->comment_approved == '0' ): ?>
			<span class='unapproved'><?php esc_html_e( "Your comment is awaiting moderation.", 'wpv' ); ?></span>
		<?php endif ?>
		<?php comment_text() ?>
	</div>
