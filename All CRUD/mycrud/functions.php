<?php
/**
 * Astra Child Theme functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Astra Child
 * @since 1.0.0
 */

/**
 * Define Constants
 */
define( 'CHILD_THEME_ASTRA_CHILD_VERSION', '1.0.0' );
require_once "class.dbdemousers.php";
/**
 * Enqueue styles
 */
function child_enqueue_styles() {

	wp_enqueue_style( 'astra-child-theme-css', get_stylesheet_directory_uri() . '/style.css', array('astra-theme-css'), CHILD_THEME_ASTRA_CHILD_VERSION, 'all' );

}

add_action( 'wp_enqueue_scripts', 'child_enqueue_styles', 15 );

add_filter( 'site_transient_update_plugins', 'remove_update_notifications' );
function remove_update_notifications( $value ) {

    if ( isset( $value ) && is_object( $value ) ) {
        unset( $value->response[ 'elementor-pro/elementor-pro.php' ] );
        unset( $value->response[ 'elementor/elementor.php' ] );
    }

    return $value;
}

add_filter('use_block_editor_for_post', '__return_false', 10); // user old post editor
add_filter( 'use_widgets_block_editor', '__return_false' ); // user for old widgets panel

// remove updated widgets style
function example_theme_support() {
    remove_theme_support( 'widgets-block-editor' );
}






