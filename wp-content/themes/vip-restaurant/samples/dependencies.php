<?php

/**
 * Declare plugin dependencies
 *
 * @package vip-restaurant
 */

/**
 * Declare plugin dependencies
 */
function vamtam_register_required_plugins() {
	$plugins = array(
		array(
			'name'     => esc_html__( 'Jetpack', 'wpv' ),
			'slug'     => 'jetpack',
			'required' => false,
		),

		array(
			'name'     => esc_html__( 'Unplug Jetpack', 'wpv' ),
			'slug'     => 'unplug-jetpack',
			'required' => false,
		),

		array(
			'name'     => esc_html__( 'WP Retina 2x', 'wpv' ),
			'slug'     => 'wp-retina-2x',
			'required' => false,
		),

		array(
			'name'     => esc_html__( 'WooCommerce', 'wpv' ),
			'slug'     => 'woocommerce',
			'required' => false,
		),

		array(
			'name'     => esc_html__( 'WooCommerce Product Archive Customiser', 'wpv' ),
			'slug'     => 'woocommerce-product-archive-customiser',
			'required' => false,
		),

		array(
			'name'     => esc_html__( 'Max Mega Menu', 'wpv' ),
			'slug'     => 'megamenu',
			'required' => false,
		),

		array(
			'name'     => esc_html__( 'Instagram Feed', 'wpv' ),
			'slug'     => 'instagram-feed',
			'required' => false,
		),

		array(
			'name'     => esc_html__( 'Ninja Forms', 'wpv' ),
			'slug'     => 'ninja-forms',
			'required' => false,
		),

		array(
			'name'     => esc_html__( 'Google Maps Easy', 'wpv' ),
			'slug'     => 'google-maps-easy',
			'required' => false,
		),

		array(
			'name'     => esc_html__( 'MailChimp for WordPress', 'wpv' ),
			'slug'     => 'mailchimp-for-wp',
			'required' => false,
		),

		array(
			'name'     => esc_html__( 'Under Construction / Maintenance Mode from Acurax', 'wpv' ),
			'slug'     => 'coming-soon-maintenance-mode-from-acurax',
			'required' => false,
		),

		// add back Ninja Forms Layout Master after NF3 update

		array(
			'name'     => esc_html__( 'Vamtam Elements (A)', 'wpv' ),
			'slug'     => 'vamtam-elements-a',
			'source'   => VAMTAM_PLUGINS . 'vamtam-elements-a.zip',
			'required' => true,
			'version'  => '1.0.1',
		),

		array(
			'name'     => esc_html__( 'Vamtam Twitter', 'wpv' ),
			'slug'     => 'vamtam-twitter',
			'source'   => VAMTAM_PLUGINS . 'vamtam-twitter.zip',
			'required' => false,
			'version'  => '1.0.3',
		),

		array(
			'name'     => esc_html__( 'Vamtam Importers', 'wpv' ),
			'slug'     => 'vamtam-importers',
			'source'   => VAMTAM_PLUGINS . 'vamtam-importers.zip',
			'required' => false,
			'version'  => '1',
		),

		array(
			'name'     => esc_html__( 'Revolution Slider', 'wpv' ),
			'slug'     => 'revslider',
			'source'   => VAMTAM_PLUGINS . 'revslider.zip',
			'required' => false,
			'version'  => '5.1.6',
		),

		array(
			'name'     => esc_html__( 'foodpress', 'wpv' ),
			'slug'     => 'foodpress',
			'source'   => VAMTAM_PLUGINS . 'foodpress.zip',
			'required' => false,
			'version'  => '1.4.2',
		),
	);

	$config = array(
		'default_path' => '',    // Default absolute path to pre-packaged plugins
		'is_automatic' => true,  // Automatically activate plugins after installation or not
	);

	tgmpa( $plugins, $config );
}
add_action( 'tgmpa_register', 'vamtam_register_required_plugins' );
