<?php
/**
 * Vamtam Project Format Options
 *
 * @package vip-restaurant
 */

return array(

array(
	'name'      => esc_html__( 'Document', 'wpv' ),
	'type'      => 'separator',
	'tab_class' => 'vamtam-post-format-document',
),

array(
	'name'    => esc_html__( 'How do I use document project format?', 'wpv' ),
	'desc'    => esc_html__( 'Use the standard Featured Image option for the project image. Use the editor below for your content. The image will only be shown in the portfolio.You will need "Link" post format if you need the featured image to appear in the post itself.', 'wpv' ),
	'type'    => 'info',
	'visible' => true,
),

// --

array(
	'name'      => esc_html__( 'Image', 'wpv' ),
	'type'      => 'separator',
	'tab_class' => 'vamtam-post-format-image',
),

array(
	'name'    => esc_html__( 'How do I use image project format?', 'wpv' ),
	'desc'    => esc_html__( 'Use the standard Featured Image option for the project image. Use the editor below for your content. Clicking on the image in the portfolio page will open up the image in a lightbox. You will need "Link" post format if you want clicking on the image to lead to the project post.', 'wpv' ),
	'type'    => 'info',
	'visible' => true,
),

// --

array(
	'name'      => esc_html__( 'Gallery', 'wpv' ),
	'type'      => 'separator',
	'tab_class' => 'vamtam-post-format-gallery',
),

array(
	'name'    => esc_html__( 'How do I use gallery project format?', 'wpv' ),
	'desc'    => esc_html__( 'Use the "Add Media" button in a text/image block element to create a gallery.This button is also found in the top left side of the visual and text editors.Please note that when the media manager opens up in the lightbox, you have to click on "Create Gallery" on the left and then select the images for your gallery.', 'wpv' ),
	'type'    => 'info',
	'visible' => true,
),

// --

array(
	'name'      => esc_html__( 'Video', 'wpv' ),
	'type'      => 'separator',
	'tab_class' => 'vamtam-post-format-video',
),

array(
	'name'    => esc_html__( 'How do I use video project format?', 'wpv' ),
	'desc'    => esc_html__( 'Put the url of the video below. You must use an oEmbed provider supported by WordPress or a file supported by the [video] shortcode which comes with WordPress. Vimeo and Youtube are supported.', 'wpv' ),
	'type'    => 'info',
	'visible' => true,
),

array(
	'name'    => esc_html__( 'Link', 'wpv' ),
	'id'      => 'vamtam-portfolio-format-video',
	'type'    => 'text',
	'only'    => 'jetpack-portfolio',
	'default' => '',
),

// --

array(
	'name'      => esc_html__( 'Link', 'wpv' ),
	'type'      => 'separator',
	'tab_class' => 'vamtam-post-format-link',
),

array(
	'name'    => esc_html__( 'How do I use link project format?', 'wpv' ),
	'desc'    => esc_html__( 'Use the standard Featured Image option for the project image. Use the editor below for your content. Put the link in the option below if you want the image in the portfolio to lead to a particular link. If you leave the link field blank, clicking on the image in the portfolio page will open up the project.', 'wpv' ),
	'type'    => 'info',
	'visible' => true,
),

array(
	'name'    => esc_html__( 'Link', 'wpv' ),
	'id'      => 'vamtam-portfolio-format-link',
	'type'    => 'text',
	'only'    => 'jetpack-portfolio',
	'default' => '',
),

// --

array(
	'name'      => esc_html__( 'HTML', 'wpv' ),
	'type'      => 'separator',
	'tab_class' => 'vamtam-post-format-html',
),

array(
	'name'    => esc_html__( 'How do I use HTML project format?', 'wpv' ),
	'desc'    => esc_html__( 'Use the standard Featured Image option for the project image. Use the editor below for your content.', 'wpv' ),
	'type'    => 'info',
	'visible' => true,
),

array(
	'name'    => esc_html__( 'HTML Content Used for the "HTML" project Type', 'wpv' ),
	'id'      => 'portfolio-top-html',
	'type'    => 'textarea',
	'only'    => 'jetpack-portfolio',
	'default' => '',
),

// --

array(
	'name'    => esc_html__( 'Logo', 'wpv' ),
	'id'      => 'portfolio-logo',
	'type'    => 'upload',
	'only'    => 'jetpack-portfolio',
	'default' => '',
	'class'   => 'vamtam-all-formats',
),

array(
	'name'    => esc_html__( 'Client', 'wpv' ),
	'id'      => 'portfolio-client',
	'type'    => 'text',
	'only'    => 'jetpack-portfolio',
	'default' => '',
	'class'   => 'vamtam-all-formats',
),

);
