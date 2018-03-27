<?php

echo $before_widget; // xss ok

if ( $title ) {
	echo $before_title; // xss ok

	if ( count( $orderby ) === 1 ) {
		do_action( 'vamtam_multiwidget_single_title', $orderby[0], $this->get_section_title( $orderby[0], true ) );
	}

	echo $title . $after_title; // xss ok
}

$title_tag = apply_filters( 'vamtam_multiwidget_item_title_tag', 'h6' );
$meta_tag = apply_filters( 'vamtam_multiwidget_item_meta_tag', 'h6' );

$class = ($disable_thumbnail && $desc_length == 0) ? 'compact' : '';

ob_start();

echo count( $orderby ) > 1 ? '[tabs style="clean" delay="0" vertical="false" left_color="" right_color="" nav_color=""] ' : '';

foreach ( $orderby as $current_order ) :
	echo count( $orderby ) > 1 ? ' [tab title="' . esc_attr( $this->get_section_title( $current_order ) ) . '" class="' . esc_attr( $current_order ) . '"] ' : '';

	if ( 'comments' === $current_order ) :
		$comments = get_comments(array(
			'status' => 'approve',
			'number' => $number,
		));

		?>
		<ul class="posts_list clearfix <?php echo esc_attr( $class ) ?>">
			<?php
			foreach ( $comments as $i => $c ) :
				$post = get_post( $c->comment_post_ID );
			?>
				<li>
					<div class="clearfix">
						<div class="post_extra_info nothumb">
							<<?php echo $title_tag // xss ok ?> class="title">
								<a href="<?php echo esc_url( $c->comment_author_url ) ?>" rel="nofollow"><?php echo wp_kses_post( $c->comment_author ) ?></a> <?php esc_html_e( 'on', 'wpv' ) ?> <a href="<?php echo esc_url( get_permalink( $post->ID ) ) ?>"><?php echo wp_kses_post( $post->post_title ) ?></a>
							</<?php echo $title_tag // xss ok ?>>
						</div>
					</div>
				</li>
			<?php endforeach ?>
		</ul>
		<?php
	elseif ( $current_order == 'tags' ) :
		echo '<div class="tagcloud"> ';
		wp_tag_cloud( apply_filters( 'widget_tag_cloud_args', array( 'taxonomy' => $tag_taxonomy ) ) );
		echo ' </div>';
	else :
		$query = array(
			'posts_per_page' => (int) $number,
			'paged' => 1,
			'orderby' => $current_order,
			'post_status' => 'publish',
			'ignore_sticky_posts' => 1,
		);

		if ( ! empty( $instance['cat'] ))
			$query['cat'] = implode( ',', $instance['cat'] );

		$r = new WP_Query( $query );
		$i = 0;
		if ( $r->have_posts() ) :
		?>
			<ul class="posts_list clearfix <?php echo esc_attr( $class ) ?>">
				<?php while ( $r->have_posts() ) : 	$r->the_post();

					$format = get_post_format( get_the_ID() );

					$media = get_the_post_thumbnail(get_the_ID(), $thumbnail_name , array(
						'title' => get_the_title(),
						'alt' => get_the_title(),
					));

					$has_media = ! empty( $media );
				?>
					<li>
						<div class="clearfix">
							<?php if ( ! $disable_thumbnail && $has_media ) :  ?>
								<div class="thumbnail">
									<a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>">
										<?php echo $media; // xss ok ?>
									</a>
								</div>
							<?php endif; ?>
							<div class="post_extra_info <?php if ($disable_thumbnail || ! $has_media) echo 'nothumb'?>">
								<<?php echo $title_tag // xss ok ?> class="title">
									<a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title() ?></a>
								</<?php echo $title_tag // xss ok ?>>
								<div>
									<?php the_time( get_option( 'date_format' ) ) ?>
								</div>
							</div>
						</div>
					</li>
				<?php endwhile; ?>
			</ul>

		<?php endif;

		wp_reset_postdata();
	endif;

	echo count( $orderby ) > 1 ? ' [/tab] ' : '';
endforeach;

echo count( $orderby ) > 1 ? '[/tabs]' : '';
echo do_shortcode( ob_get_clean() ); // xss ok
echo $after_widget; // xss ok