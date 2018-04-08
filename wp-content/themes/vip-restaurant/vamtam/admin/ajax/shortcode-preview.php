<?php

	/*
		This file provides a real-time preview for the inline shortcode generator.

		As such, it has to be a simplified version of the front end:
		one which includes all styles/scripts normally loaded on the front end,
		but without any content other than the shortcode.

		For this reason the admin bar is disabled for the preview only. Otherwise there would be two admin bars on the page.
	 */
	do_action( 'before_vamtam_inline_shortcode_preview' );

	// minimal template below

	global $vamtam_is_shortcode_preview;
	$vamtam_is_shortcode_preview = true;

	$GLOBALS['vamtam_current_shortcode'] = stripslashes( $_POST['data'] );

	define( 'VAMTAM_NO_PAGE_CONTENT', true );
?><!doctype html>
<html>
<head>
	<?php wp_head() ?>
</head>
<body class="shortcode-preview">
	<div id="preview-content">
		<div>
			<?php echo apply_filters( 'the_content', do_shortcode( $GLOBALS['vamtam_current_shortcode'] ) ); // xss ok ?>
	<?php get_footer() ?>
</body>
</html>
