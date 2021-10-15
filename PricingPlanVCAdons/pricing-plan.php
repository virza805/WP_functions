<?php 
/*
Plugin Name: PricingPlanVCAdons
Plugin URI: http://vir-za.com/
Description: This is PricingPlanVCAdons for Visual Composer / WPBakery Page Builder in WordPress theme.
Version: 1.20.5
Author: Tanvir Hasan
Author URI: https://vir-za.com/
License: 0.9531805
Text Domain: pricing-plan
*/

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
// Define
define( 'PRICING_PLAN_ACC_URL', WP_PLUGIN_URL . '/' . plugin_basename( dirname( __FILE__ ) ) . '/' ); 
define( 'PRICING_PLAN_ACC_PATH', plugin_dir_path( __FILE__ ) );

// How to Page according to list-style...function
function pricing_plan_get_page_as_list() {
    $args = wp_parse_args( array(
        'post_type' => 'page',
        'numberposts' => -1,
    ));

    $posts = get_posts( $args );

    $post_options = array(esc_html__('-- Select Page --', 'factory-founder')=> '');
    if( $posts ){
        foreach ( $posts as $post ) {
            $post_options[ $post->post_title ] = $post->ID;
        }
    }
    return $post_options;
}



// print shortcodes in widgets
add_filter('widget_text', 'do_shortcode');

// Loading VC addons
 require_once( PRICING_PLAN_ACC_PATH . 'vc-addons/vc-blocks-load.php' ); //  require dirname(__FILE__).'/elements/section-title.php';


// Theme ShortCodes
 require_once( PRICING_PLAN_ACC_PATH . 'theme-shortcodes/p-servic-shortcode.php' );
 require_once( PRICING_PLAN_ACC_PATH . 'theme-shortcodes/p-other-slid-shortcode.php' );
 require_once( PRICING_PLAN_ACC_PATH . 'theme-shortcodes/pricing-plan-box-shortcode.php' );

// Shortcodes depended on Visual Composer
include_once( ABSPATH .'wp-admin/includes/plugin.php' );
if (is_plugin_active('js_composer/js_composer.php')) {
    // require_once( PRICING_PLAN_ACC_PATH . 'theme-shortcodes/staff-shortcode.php' );
}

// Registering stock toolkit files
function pricing_plan_toolkit_files() {

    
    wp_enqueue_style('pricing-plan', plugin_dir_url(__FILE__) . 'assets/pricing-plan.css');
    
}
add_action('wp_enqueue_scripts', 'pricing_plan_toolkit_files');




?>