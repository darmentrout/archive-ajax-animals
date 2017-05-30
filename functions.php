<?php
function my_theme_enqueue_styles() {

    $parent_style = 'parent-style'; 

    wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'child-style',
        get_stylesheet_directory_uri() . '/style.css',
        array( $parent_style ),
        wp_get_theme()->get('Version')
    );
}
add_action( 'wp_enqueue_scripts', 'my_theme_enqueue_styles' );


wp_register_script( 'chicken-js', get_stylesheet_directory_uri() . '/chicken.js', array('jquery'), false, true );
function chicken_script() {
	wp_enqueue_script( 'chicken-js' );
}
add_action( 'wp_enqueue_scripts', 'chicken_script' );
$chicken_vars = array(
	'stylesheetDirUri' => get_stylesheet_directory_uri()
	// getting the category query variable doesn't work well here;
	// use JS variable chickenCat for that one
);
wp_localize_script( 'chicken-js', 'chickenVars', $chicken_vars );