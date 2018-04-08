<?php

if ( $count > 0 ) :

echo $before_widget; // xss ok;

if ( $title ) {
	echo $before_title . wp_kses_post( $title ) . $after_title; // xss
}

$title_tag = apply_filters( 'vamtam_widget_author_title_tag', 'h6' );
?>

<ul class="authors_list">
	<?php
		for ($i = 1; $i <= $count; $i++)
			if ( isset( $instance['author_id'][ $i ] ) ) :
				$id = $instance['author_id'][ $i ];
				?>
				<li class="clearfix">
					<?php if ( ! ! $instance['show_avatar'] ) :  ?>
						<div class="gravatar">
								<a href="<?php echo esc_url( get_author_posts_url( $id, get_the_author_meta( 'user_nicename', $id ) ) ) ?>">
									<?php echo get_avatar( get_the_author_meta( 'user_email', $id ), 40 ) ?>
								</a>
						</div>
					<?php endif ?>
					<div class="author_info">
						<div class="author_name">
							<<?php echo $title_tag // xss ok ?>>
								<a href="<?php echo esc_url( get_author_posts_url( $id, get_the_author_meta( 'user_nicename', $id ) ) ) ?>">
									<?php echo wp_kses_post( get_the_author_meta( 'display_name', $id ) ); ?>
								</a>
								<?php if ( ! ! $instance['show_post_count'] ) :  ?>
									<span class="post-count">(<?php echo intval( count_user_posts( $id ) ) ?>)</span>
								<?php endif ?>
							</<?php echo $title_tag // xss ok ?>>
						</div>
						<div class="author_desc">
							<?php
								if ( ! empty( $instance['author_desc'][ $i ] ) ) {
									echo wp_kses_post( $instance['author_desc'][ $i ] );
								} else {
									echo wp_kses_post( get_the_author_meta( 'description',$id ) );
								}
							?>
						</div>
					</div>
				</li>
			<?php endif; ?>
</ul>

<?php

echo $after_widget; // xss ok

endif;
