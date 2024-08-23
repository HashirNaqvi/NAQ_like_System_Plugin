<?php 
/*
 * Plugin Name:       wpnaq
 * Description:       Handle the basics with this plugin.
 * Version:           1.0.0
 * Author:            Hashir Naqvi
 * Author URI:        https://icodeguru.com
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 */

 if (!defined('WPINC')) {
    die;
}

if (!defined("NAQ_Plugin_VERSION")) {
    define("NAQ_Plugin_VERSION", "1.0.0");
}

if (!defined ("NAQ_Plugin_DIR")) {
    define("NAQ_Plugin_DIR", plugin_dir_url(__FILE__));
}

 function NAQ_plugin_scripts() {
        wp_enqueue_style('main-style', NAQ_Plugin_DIR . 'assets/css/style.css');
        wp_enqueue_script('main-script', NAQ_Plugin_DIR . 'assets/js/main.js');
    }
    add_action('wp_enqueue_scripts', 'NAQ_plugin_scripts');

    require plugin_dir_path(__FILE__) .'inc/settings.php';

    function NAQ_likes_table() {
        global $wpdb;
        $table_name = $wpdb->prefix . "NAQ_like_system"; 
        $charset_collate = $wpdb->get_charset_collate();
        
        $sql = "CREATE TABLE IF NOT EXISTS $table_name (
          id mediumint(9) NOT NULL AUTO_INCREMENT,
          time timestamp DEFAULT CURRENT_TIMESTAMP NOT NULL,
          user_id mediumint(9) NOT NULL,
          post_id mediumint(9) NOT NULL,
          like_count mediumint(9) NOT NULL,
          dislike_count mediumint(9) NOT NULL,
          PRIMARY KEY  (id)
        ) $charset_collate;";
        
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    }
    
    register_activation_hook(__FILE__, 'NAQ_likes_table');
    
?>