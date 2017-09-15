<?php
function understrap_remove_scripts() {
    wp_dequeue_style( 'understrap-styles' );
    wp_deregister_style( 'understrap-styles' );

    wp_dequeue_script( 'understrap-scripts' );
    wp_deregister_script( 'understrap-scripts' );

    // Removes the parent themes stylesheet and scripts from inc/enqueue.php
}
add_action( 'wp_enqueue_scripts', 'understrap_remove_scripts', 20 );

add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );
function theme_enqueue_styles() {

	// Get the theme data
	$the_theme = wp_get_theme();

    wp_enqueue_style( 'child-understrap-styles', get_stylesheet_directory_uri() . '/css/child-theme.min.css', array(), $the_theme->get( 'Version' ) );
    wp_enqueue_script( 'child-understrap-scripts', get_stylesheet_directory_uri() . '/js/child-theme.min.js', array(), $the_theme->get( 'Version' ), true );
}


require_once __DIR__ . '/vendor/autoload.php';
use PostTypes\PostType;

require_once('CPT/autoload.php');
require_once('functions/autoload.php');


add_filter( 'embed_defaults', 'change_embed_size' );

function change_embed_size() {
    // Adjust values
    return array('width' => 730, 'height' => 800);
}


add_filter('the_content', 'emd_content');

function emd_content( $content ) {
    $subtitle = get_field('soustitre');
    if(!$subtitle) {
        return $content;
    }
    if(is_array($subtitle)){
        $subtitle = $subtitle[0];
    }
    if(!is_string($subtitle)){
        return $content;
    }
    $content = "<h2 class='entry_subtitle'>".$subtitle."</h2>".$content;
    return $content;
}
