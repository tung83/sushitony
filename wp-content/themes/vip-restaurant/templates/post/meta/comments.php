<?php
$show = rd_vamtam_get_optionb( 'post-meta', 'comments' ) && comments_open();
$comment_icon = vamtam_get_icon_html( array( 'name' => 'theme-bubble' ) );
?>
<?php if ( $show || is_customize_preview() ) : ?>
	<span class="comment-count vamtam-meta-comments" <?php VamtamTemplates::display_none( $show ) ?>>
		<?php
			comments_popup_link(
				$comment_icon . wp_kses_post( __( '0 <span class="comment-word ">Comments</span>', 'wpv' ) ),
				$comment_icon . wp_kses_post( __( '1 <span class="comment-word ">Comment</span>', 'wpv' ) ),
				$comment_icon . wp_kses_post( __( '% <span class="comment-word ">Comments</span>', 'wpv' ) )
			);
		?>
	</span>
<?php endif; ?>