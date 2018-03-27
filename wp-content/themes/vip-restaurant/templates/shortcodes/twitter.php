<?php foreach ( $results as $tweet ) :  Vamtam_Twitter::format_tweet( $tweet ) ?>
	<div class="single-tweet">
		<p class="tweet-text">
			<?php echo wp_kses_post( $tweet->text ) ?>
		</p>
		<span class="tweet-time"><?php printf( esc_html__( '%s ago', 'wpv' ), esc_html( human_time_diff( strtotime( $tweet->created_at ) ) ) ); ?></span>
	</div>
	<div class="tweet-divider"></div>
<?php endforeach; ?>
