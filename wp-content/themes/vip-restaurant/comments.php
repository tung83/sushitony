<?php
/**
 * Comments template
 *
 * @package vip-restaurant
 */

if ( is_page_template( 'page-blank.php' ) ) {
	return;
}

wp_reset_postdata();

if ( ! defined( 'ABSPATH' ) ) {
	die( 'Please do not load this page directly. Thanks!' );
}

?>

<div class="limit-wrapper">
<?php if ( 'open' == $post->comment_status ) : ?>

	<div id="comments" class="comments-wrapper">
		<?php
			$req = get_option( 'require_name_email' ); // Checks if fields are required.

			if ( ! empty( $post->post_password ) ) :
				if ( post_password_required() ) :
		?>
					</div><!-- #comments -->

	<?php
					return;
				endif;
			endif;
	?>

	<?php if ( have_comments() ) : ?>
		<?php // numbers of pings and comments
		$ping_count = $comment_count = 0;
		foreach ( $comments as $comment ) {
			get_comment_type() == 'comment' ? ++$comment_count : ++$ping_count;
		}
		?>

		<div class="sep-text has-more centered keep-always">
			<div class="sep-text-before"><div class="sep-text-line"></div></div>
			<div class="content">
				<h5>
					<?php comments_popup_link( esc_html__( '0 Comments:', 'wpv' ), esc_html__( '1 Comment', 'wpv' ), esc_html__( '% Comments:', 'wpv' ) ); ?>
				</h5>
			</div>
			<div class="sep-text-after"><div class="sep-text-line"></div></div>
			<span class='sep-text-more'><a href="#respond" title="<?php esc_attr_e( 'Post Comment', 'wpv' ) ?>" class="icon-b" data-icon="<?php esc_attr_vamtam_icon( 'pencil' ) ?>"><?php esc_html_e( 'Add Comment', 'wpv' ) ?></a></span>
		</div>

		<?php if ( $comment_count ) : ?>
			<div id="comments-list" class="comments">
				<?php wp_list_comments( array(
					'type'     => 'comment',
					'callback' => array( 'VamtamTemplates', 'comments' ),
					'style'    => 'div',
				) ); ?>
			</div><!-- #comments-list .comments -->
		<?php endif; /* if ( $comment_count ) */ ?>

		<?php if ( $ping_count ) : ?>
			<div class="sep-text centered keep-always">
				<div class="sep-text-before"><div class="sep-text-line"></div></div>
				<div class="content">
					<h5>
						<?php echo sprintf( $ping_count > 1 ? esc_html__( '%d Trackbacks:', 'wpv' ) : esc_html__( 'One Trackback:', 'wpv' ), (int) $ping_count ); ?>
					</h5>
				</div>
				<div class="sep-text-after"><div class="sep-text-line"></div></div>
			</div>

			<div id="trackbacks-list" class="comments">
				<?php wp_list_comments( array(
					'type'     => 'pings',
					'callback' => array( 'VamtamTemplates', 'comments' ),
					'style'    => 'div',
				) ); ?>
			</div><!-- #trackbacks-list .comments -->
		<?php endif /* if ( $ping_count ) */ ?>
	<?php endif /* if ( $comments ) */ ?>

	<?php
		$comment_pages = paginate_comments_links( array(
			'echo' => false,
		) );

		if ( ! empty( $comment_pages ) ) :
	?>
		<div class="wp-pagenavi comment-paging"><?php echo $comment_pages // xss ok ?></div>
	<?php endif ?>

	<div class="respond-box">
		<div class="respond-box-title sep-text centered keep-always">
			<div class="sep-text-before"><div class="sep-text-line"></div></div>
			<h5 class="content"><?php esc_html_e( 'Write a comment:', 'wpv' )?></h5>
			<div class="sep-text-after"><div class="sep-text-line"></div></div>
		</div>

		<?php // cancel_comment_reply_link() ?>

		<?php if ( get_option( 'comment_registration' ) && ! $user_ID ) : ?>
			<p id="login-req"><?php printf( wp_kses_post( __( 'You must be <a href="%s" title="Log in">logged in</a> to post a comment.', 'wpv' ) ), esc_url( get_option( 'siteurl' ) . '/wp-login.php?redirect_to=' . get_permalink() ) ) ?></p>
		<?php else : ?>
			<?php
				comment_form( array(
					'title_reply'    => '',
					'title_reply_to' => '',
					'logged_in_as'   => '<p class="logged-in-as grid-1-1">' . sprintf( wp_kses_post( __( 'Logged in as <a href="%1$s">%2$s</a>. <a href="%3$s" title="Log out of this account">Log out?</a>', 'wpv' ) ), admin_url( 'profile.php' ), wp_get_current_user()->display_name, wp_logout_url( apply_filters( 'the_permalink', get_permalink( ) ) ) ) . '</p>',
					'fields'         => array(
							'author' => '<div class="comment-form-author form-input grid-1-2"><label for="author" class="visuallyhidden">' . esc_html__( 'Name', 'wpv' ) . '</label>' . ( $req ? ' <span class="required">*</span>' : '' ) .
							'<input id="author" name="author" type="text" ' . ( $req ? 'required="required"' : '' ) . ' value="' . esc_attr( $commenter['comment_author'] ) . '" size="30" placeholder="'.esc_attr__( 'John Doe', 'wpv' ).'" /></div>',
							'email'  => '<div class="comment-form-email form-input grid-1-2"><label for="email" class="visuallyhidden">' . esc_html__( 'Email', 'wpv' ) . '</label> ' . ( $req ? ' <span class="required">*</span>' : '' ) .
							'<input id="email" name="email" type="email" ' . ( $req ? 'required="required"' : '' ) . ' value="' . esc_attr( $commenter['comment_author_email'] ) . '" size="30" placeholder="email@example.com" /></div> <p class="comment-notes grid-1-1">' . esc_html__( 'Your email address will not be published.', 'wpv' ) . '</p>',
					),
					'comment_field'        => '<div class="comment-form-comment grid-1-1"><label for="comment" class="visuallyhidden">' . esc_html_x( 'Message', 'noun', 'wpv' ) . '</label><textarea id="comment" name="comment" required placeholder="'.esc_attr__( 'Write us something nice or just a funny joke...', 'wpv' ).'" rows="2"></textarea></div>',
					'comment_notes_before' => '',
					'comment_notes_after'  => '',
					'format'               => 'xhtml', // otherwise we get novalidate on the form
				) );
			?>

		<?php endif /* if ( get_option( 'comment_registration' ) && !$user_ID ) */ ?>
	</div><!-- .respond-box -->
</div><!-- #comments -->

<?php endif /* if ( 'open' == $post->comment_status ) */ ?>
</div>
