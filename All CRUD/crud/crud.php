<?php 

/*

Plugin Name: WP CRUD main

Plugin URI: http://vir-za.com/

Description: This is CRUD plugin for every WordPress theme.

Version: 1.1

Author: Tanvir Md. Al-Amin

Author URI: https://www.linkedin.com/in/1mdalamin1/

License: GPLv2 or later

Text Domain: database-demo

*/

// Exit if accessed directly

// if ( ! defined( 'ABSPATH' ) ) {

//     exit;

// }

// Define

// define( 'P_W_P_S_ACC_URL', WP_PLUGIN_URL . '/' . plugin_basename( dirname( __FILE__ ) ) . '/' );

// define( 'P_W_P_S_ACC_PATH', plugin_dir_path( __FILE__ ) );


// ######## >>>> Custom Post Register <<<< ########

// add_action( 'init', 'p_w_p_slider_custom_post' );

// function p_w_p_slider_custom_post() {

//     // For Our Project/Work/Protfolio

//     register_post_type( 'protfolio',

//     array(

//         'labels'    => array(
//             'name' => __('OurWork'),
//             'all_items' => __('All'),
//             'edit_item' => __('use this code [protfolio_slid count="5"] for Divi [project_slid]'),
//             'singular_name' => __('Work')
//             ),

//         'supports'  => array('title', 'editor', 'author', 'thumbnail', 'comments', 'excerpt', 'page-attributes'),

//         'public'    => true,
//         'menu_icon' => 'dashicons-pressthis', // Right side bar menu icon. https://developer.wordpress.org/resource/dashicons/#heart 
//         // 'menu_icon' => 'https://service24.vir-za.com/wp-content/uploads/2021/07/arwo.png', // this is Right side bar menu icon as image

//         )
//     );
// }


// ######## >>>> Custom Post-taxonomy Register <<<< ########

// function p_w_p_slider_custom_post_taxonomy() {

//     register_taxonomy(

//         'project_cat',  

//         'protfolio',                  

//         array(

//             'hierarchical'          => true,

//             'label'                 => 'Project Category',  

//             'query_var'             => true,

//             'show_admin_column'     => true,

//             'rewrite'               => array(

//                 'slug'              => 'project-category', 

//                 'with_front'        => true 

//                 )

//             )

//     );

// }

// add_action( 'init', 'p_w_p_slider_custom_post_taxonomy');


// print shortcodes in widgets

// add_filter('widget_text', 'do_shortcode');

//   require_once( P_W_P_S_ACC_PATH . 'theme-shortcodes/project-slid-shortcode.php' );

//   require_once( P_W_P_S_ACC_PATH . 'theme-shortcodes/protfolio-slid-shortcode.php' );


// Registering Project Slider files

// function project_slider_files() {

//     wp_enqueue_style('crud', plugin_dir_url(__FILE__) . 'assets/style.css');
//     wp_enqueue_style('font-awesome', plugin_dir_url(__FILE__) . 'assets/font-awesome.min.css');
//     wp_enqueue_style('owl-carousel', plugin_dir_url(__FILE__) . 'assets/owl.carousel.css');



//     wp_enqueue_script('Jquery', plugin_dir_url(__FILE__) . 'assets/jquery-1.12.5.js', array('jquery'), '20120206', true );
//     wp_enqueue_script('owl-carousel', plugin_dir_url(__FILE__) . 'assets/owl.carousel.min.js', array('jquery'), '20120206', true );
//     wp_enqueue_script('custom-slider-active', plugin_dir_url(__FILE__) . 'assets/custom.js', array('jquery'), '20120206', true );

// }

// add_action('wp_enqueue_scripts', 'project_slider_files');


// ######## >>>> Start WP CRUD <<<< ######## \\

define("DBDEMO_DB_VERSION", "1.3");
function dbdemo_init(){
    global $wpdb;
    $table_name = $wpdb->prefix.'persons';
    $sql = "CREATE TABLE {$table_name} (
        id INT NOT NULL AUTO_INCREMENT,
        name VARCHAR(250),
        email VARCHAR(250),
        PRIMARY KEY (id)
    );";
    require_once (ABSPATH."wp-admin/includes/upgrade.php");
    dbDelta($sql);

    add_option("dbdemo_db_version",DBDEMO_DB_VERSION);

    if(get_option("dbdemo_db_version")!=DBDEMO_DB_VERSION){
        $sql = "CREATE TABLE {$table_name} (
            id INT NOT NULL AUTO_INCREMENT,
            name VARCHAR(250),
            email VARCHAR(250),
            age INT,
            PRIMARY KEY (id)
            );";
            dbDelta($sql);
            update_option("dbdemo_db_version",DBDEMO_DB_VERSION);
    }

}
register_activation_hook(__FILE__, "dbdemo_init");


// this is for column remove

// function dbdemo_drop_column(){
//     global $wpdb;
//     $table_name = $wpdb->prefix.'persons';
//     if(get_option("dbdemo_db_version") !=DBDEMO_DB_VERSION){
//         $query = "ALTER TABLE {$table_name} DROP COLUMN age";
//         $wpdb->query($query);
//     }
//     update_option("dbdemo_db_version", DBDEMO_DB_VERSION);

// }
// add_action("plugins_loaded","dbdemo_drop_column");




















?>