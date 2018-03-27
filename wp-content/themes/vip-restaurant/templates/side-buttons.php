<?php

/**
 * Displays the scroll to top button
 *
 * @package vip-restaurant
 */
?>

<?php if ( rd_vamtam_get_option( 'show-scroll-to-top' ) || is_customize_preview() ) : ?>
	<div id="scroll-to-top" class="icon" <?php VamtamTemplates::display_none( rd_vamtam_get_option( 'show-scroll-to-top' ) ) ?>><?php vamtam_icon( 'theme-arrow-top-sample' ) ?></div>
<?php endif ?>
