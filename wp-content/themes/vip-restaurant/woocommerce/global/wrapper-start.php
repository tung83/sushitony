<?php
/**
 * Content wrappers
 *
 * @author  VamTam
 * @package vip-restaurant
 * @version 2.1.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $post;

?>

<div class="row page-wrapper">

	<article class="<?php echo esc_attr( VamtamTemplates::get_layout() ) ?>">
		<?php VamtamTemplates::header_sidebars(); ?>
		<div class="page-content no-image">
