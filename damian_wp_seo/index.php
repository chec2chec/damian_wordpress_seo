<?php
/*
Plugin Name: Damian Wp Seo
Plugin URI: http://petrovkartini.com
Description: Display paintings organized in exhibitions.
Author: Ivan Simeonov
Version: 0.1
Author URI: http://ivansimeonoff.wordpress.com
*/

include_once('includes/frontend.php');

add_action( 'init', 'initiate_damian_wp_seo');
function initiate_damian_wp_seo() {
    add_action('admin_menu', 'dmp_create_menu');
    register_taxonomy_for_object_type('post_tag', 'page'); 
    wp_enqueue_script('clean_seo_meta', plugins_url('/js/clean_seo_meta.js',__FILE__), array( 'jquery' ) );
    add_action( 'wp_head', 'manipulate_wp_head' );
};