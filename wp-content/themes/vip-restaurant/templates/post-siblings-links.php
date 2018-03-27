<?php

/**
 * Prev/next/view all buttons for posts and projects
 *
 * @package vip-restaurant
 */

?>
<span class="post-siblings">
	<?php
		previous_post_link( '%link', vamtam_get_icon_html( array( 'name' => 'theme-arrow-left-sample', 'link_hover' => false ) ) );
		next_post_link( '%link', vamtam_get_icon_html( array( 'name' => 'theme-arrow-right-sample', 'link_hover' => false ) ) );
	?>
</span>
