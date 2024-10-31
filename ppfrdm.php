<?php
/**
 * @package ppfreedom
*/
/*
Plugin Name: PP Freedom
Plugin URI: https://zenoitech.com/pp-freedom-wordpress-plugin/
Description: By using PP Freedom you can easily show WordPress content like blog posts, custom blog posts, or woocommerce products in this site or any other WordPress or non-WordPress sites, in the form of widgets with all customizable options, and you can create unlimited private or public widgets.
Version: 2.8
Author: parshuram369
Author URI: https://zenoitech.com
License: GPLv2 or later
Text Domain: ppfrdm
Domain Path: /languages
*/
/*
This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.
 
This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.
 
You should have received a copy of the GNU General Public License
along with this program. If not, see {URI to Plugin License}.
*/

defined( 'ABSPATH' ) || exit;
define( 'ppfrdm_PLUGIN_VER', '2.4' );
define( 'ppfrdm_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'ppfrdm_PLUGIN_URL', plugins_url('/', __FILE__ ) );
define( 'ppfrdm_PLUGIN_ADMP', 'ppfrdm_admin' );

function ppfrdm_activation(){
  global $wpdb;
  $ppfrdm_table_publish = $wpdb->prefix . "ppfrdm_publish";
  $ppfrdm_table_pull = $wpdb->prefix . "ppfrdm_pull";
  $charset_collate = $wpdb->get_charset_collate();
  require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

  $sql = "CREATE TABLE IF NOT EXISTS $ppfrdm_table_publish (
    id int(9) NOT NULL AUTO_INCREMENT,
    options text NOT NULL,
    PRIMARY KEY  (id)
  ) $charset_collate;";
  dbDelta( $sql );

  $sql = "CREATE TABLE IF NOT EXISTS $ppfrdm_table_pull (
    id int(9) NOT NULL AUTO_INCREMENT,
    options text NOT NULL,
    PRIMARY KEY  (id)
  ) $charset_collate;";
  dbDelta( $sql );
}
register_activation_hook( __FILE__, 'ppfrdm_activation' );
function ppfrdm_deactivation(){}
register_deactivation_hook( __FILE__, 'ppfrdm_deactivation' );

require_once( ppfrdm_PLUGIN_DIR . 'ppfrdm-init.php' );
require_once( ppfrdm_PLUGIN_DIR . 'ppfrdm-admin.php' );
require_once( ppfrdm_PLUGIN_DIR . 'ppfrdm-admin-actions.php' );
require_once( ppfrdm_PLUGIN_DIR . 'ppfrdm-shortcoder.php' );
require_once( ppfrdm_PLUGIN_DIR . 'ppfrdm-theming.php' );

add_action("admin_menu", "ppfrdm_add_menu");
function ppfrdm_add_menu() {
    add_menu_page("PP Freedom", "PP Freedom", "edit_posts",
        ppfrdm_PLUGIN_ADMP, "ppfrdm_admin", 'dashicons-networking', 84);
}



/* Include CSS and Script for admin */
add_action('admin_enqueue_scripts','ppfrdm_css_js_scripts');
function ppfrdm_css_js_scripts() {
   // CSS
   wp_enqueue_style( 'ppfrdm-style-css', plugins_url( '/inc/admin/style.css', __FILE__ ), array('wp-color-picker'), ppfrdm_PLUGIN_VER );

   // JavaScript
   wp_enqueue_script( 'ppfrdm-script-js', plugins_url( '/inc/admin/script.js', __FILE__ ), array('jquery','wp-color-picker'), ppfrdm_PLUGIN_VER );

   // Pass ajax_url to script.js
   wp_localize_script( 'ppfrdm-script-js', 'ppfrdm_ajax_object',
   array( 'ajax_url' => admin_url( 'admin-ajax.php' )));
}

//Include Router
add_filter( 'init', function( $template ){
    if(!is_admin()){
      $uri_path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
      //$uri_segments = explode('/', $uri_path);
      if(strpos($uri_path, 'pp-frdm') !== false || strpos($uri_path, 'pp-freedom') !== false){
        header("Access-Control-Allow-Origin: *");
        include plugin_dir_path( __FILE__ ) . 'ppfrdm-router.php';
        die;
      }
    }
});