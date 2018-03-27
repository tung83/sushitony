<?php
/**
 * Post metadata template
 *
 * @package vip-restaurant
 */

?>
<div class="post-meta">
	<nav class="clearfix">
		<?php if ( ! post_password_required() ) :  ?>
			<?php get_template_part( 'templates/post/meta/tax' ) ?>
		<?php endif ?>
	</nav>
</div>
