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


function register_chicken(){
	wp_register_script( 'chicken-js', get_stylesheet_directory_uri() . '/chicken.js', array('jquery'), false, true );
}
add_action( 'wp_enqueue_scripts', 'register_chicken' );

function chicken_script() {
	wp_enqueue_script( 'chicken-js' );
}
add_action( 'wp_enqueue_scripts', 'chicken_script' );

function localize_chicken(){
$chicken_vars = array(
	'stylesheetDirUri' => get_stylesheet_directory_uri()
	// getting the category query variable doesn't work well here;
	// use JS variable chickenCat for that one
);
	wp_localize_script( 'chicken-js', 'chickenVars', $chicken_vars );
}
add_action( 'wp_enqueue_scripts', 'localize_chicken' );



// register post types if they don't yet exist

function register_animal_types() {

	// cows

	if( !post_type_exists('cows') ){
		$labels = array(
			"name" => __( 'cows', 'twenty-seventeen-child' ),
			"singular_name" => __( 'cow', 'twenty-seventeen-child' ),
		);
		$args = array(
			"label" => __( 'cows', 'twenty-seventeen-child' ),
			"labels" => $labels,
			"description" => "",
			"public" => true,
			"publicly_queryable" => true,
			"show_ui" => true,
			"show_in_rest" => false,
			"rest_base" => "",
			"has_archive" => false,
			"show_in_menu" => true,
			"exclude_from_search" => false,
			"capability_type" => "post",
			"map_meta_cap" => true,
			"hierarchical" => false,
			"rewrite" => array( "slug" => "cows", "with_front" => true ),
			"query_var" => true,
			"menu_icon" => "http://localhost/wordpress/wp-content/uploads/2017/05/cow_icon-1.png",
			"supports" => array( "title", "editor", "thumbnail" ),
			"taxonomies" => array( "category", "post_tag" ),
		);
		register_post_type( "cows", $args );
	}



	// pigs

	if( !post_type_exists('pigs') ){
		$labels = array(
			"name" => __( 'pigs', 'twenty-seventeen-child' ),
			"singular_name" => __( 'pig', 'twenty-seventeen-child' ),
		);
		$args = array(
			"label" => __( 'pigs', 'twenty-seventeen-child' ),
			"labels" => $labels,
			"description" => "",
			"public" => true,
			"publicly_queryable" => true,
			"show_ui" => true,
			"show_in_rest" => false,
			"rest_base" => "",
			"has_archive" => false,
			"show_in_menu" => true,
			"exclude_from_search" => false,
			"capability_type" => "post",
			"map_meta_cap" => true,
			"hierarchical" => false,
			"rewrite" => array( "slug" => "pigs", "with_front" => true ),
			"query_var" => true,
			"menu_icon" => "http://localhost/wordpress/wp-content/uploads/2017/05/pig_icon-1.png",
			"supports" => array( "title", "editor", "thumbnail" ),
			"taxonomies" => array( "category", "post_tag" ),
		);
		register_post_type( "pigs", $args );
	}



	// chickens

	if( !post_type_exists('chickens') ){
		$labels = array(
			"name" => __( 'chickens', 'twenty-seventeen-child' ),
			"singular_name" => __( 'chicken', 'twenty-seventeen-child' ),
		);
		$args = array(
			"label" => __( 'chickens', 'twenty-seventeen-child' ),
			"labels" => $labels,
			"description" => "",
			"public" => true,
			"publicly_queryable" => true,
			"show_ui" => true,
			"show_in_rest" => false,
			"rest_base" => "",
			"has_archive" => false,
			"show_in_menu" => true,
			"exclude_from_search" => false,
			"capability_type" => "post",
			"map_meta_cap" => true,
			"hierarchical" => false,
			"rewrite" => array( "slug" => "chickens", "with_front" => true ),
			"query_var" => true,
			"menu_icon" => "http://localhost/wordpress/wp-content/uploads/2017/05/chicken_icon-1.png",
			"supports" => array( "title", "editor", "thumbnail" ),
			"taxonomies" => array( "category", "post_tag" ),
		);
		register_post_type( "chickens", $args );
	}		
}

add_action( 'init', 'register_animal_types' );
