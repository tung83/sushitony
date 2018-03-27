<?php

function child_styles() {
	wp_enqueue_style( 'my-child-theme-style', get_stylesheet_directory_uri() . '/style.css', array('front-all'), false, 'all' );
    wp_enqueue_script( 'script-name', 'https://cdnjs.cloudflare.com/ajax/libs/jquery.matchHeight/0.7.2/jquery.matchHeight-min.js', array('jquery'), '1.0.0', true );

}
add_action('wp_enqueue_scripts', 'child_styles', 11);
add_filter( 'loop_shop_per_page', create_function( '$cols', 'return 9999;' ), 20 );