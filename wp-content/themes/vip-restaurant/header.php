<?php
/**
 * Header template
 *
 * @package vip-restaurant
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">

<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />

	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
	<span id="top"></span>
	<?php do_action( 'vamtam_body' ) ?>
	<div id="page" class="main-container">

		<?php include locate_template( 'templates/header/top.php' );?>

		<?php do_action( 'vamtam_after_top_header' ) ?>

		<div class="boxed-layout">
			<div class="pane-wrapper clearfix">
				<?php include locate_template( 'templates/header/middle.php' );?>
				<div id="main-content">
					<?php include locate_template( 'templates/header/sub-header.php' );?>

					<?php $hide_lowres_bg = rd_vamtam_get_optionb( 'main-background-hide-lowres' ) ? 'vamtam-hide-bg-lowres' : ''; ?>
					<div id="main" role="main" class="vamtam-main layout-<?php echo esc_attr( VamtamTemplates::get_layout() ) ?>  <?php echo esc_attr( $hide_lowres_bg ) ?>">
						<?php do_action( 'vamtam_inside_main' ) ?>

						<?php if ( ! class_exists( 'Vamtam_Columns' ) || ( Vamtam_Columns::had_limit_wrapper() && ! is_singular( 'jetpack-portfolio' ) ) ) :  ?>
							<div class="limit-wrapper">
						<?php endif ?>
