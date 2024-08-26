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
       // Enqueue the AJAX JavaScript file
        wp_enqueue_script('Ajax-javascript', NAQ_Plugin_DIR . 'assets/js/ajax.js', array('jquery'), null, true);
    
    // Localize the script to pass the AJAX URL
    wp_localize_script('Ajax-javascript', 'NAQ_ajax_url', 
        array(
            'ajax_url' => admin_url('admin-ajax.php'),
        )
    );
}
    add_action('wp_enqueue_scripts', 'NAQ_plugin_scripts');

    require plugin_dir_path(__FILE__) .'inc/settings.php';
    require plugin_dir_path(__FILE__) .'inc/db.php';
    require plugin_dir_path(__FILE__) .'inc/btn.php';

  
    

// Function to handle AJAX request for liking a post
function NAQ_like_btn_ajax_action() {
    global $wpdb; // Access the global $wpdb object for database operations
    
    // Include the WordPress upgrade functions for database-related operations
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    
    // Define the table name for storing likes, using the WordPress table prefix
    $table_name = $wpdb->prefix . "NAQ_like_system"; 


    // Check if 'pid' (post ID) and 'uid' (user ID) are set in the POST request
    if(isset($_POST['pid']) && isset($_POST['uid'])) {

        $post_id =$_POST['pid'];
        $user_id = $_POST['uid'];
        $check_like= $wpdb->get_var( "SELECT COUNT(*) FROM $table_name WHERE user_id = '$user_id' AND post_id = '$post_id' AND like_count =1" );
        if($check_like > 0){
            echo " Sorry, but you already liked this post!";
        }
        else{
            // Insert the like data into the custom table
        $wpdb->insert(
            $table_name, // The name of the table
            array(
                'post_id' => intval($_POST['pid']), // Sanitize and assign the post ID
                'user_id' => intval($_POST['uid']), // Sanitize and assign the user ID
                'like_count' => 1 // Set the like count to 1
            ),
            array(
                '%d', // Format post_id as integer
                '%d', // Format user_id as integer
                '%d'  // Format like_count as integer
            )
        );
        }
        
    } 
    
    // Display a custom message if the insertion was successful
    if($wpdb->insert_id) {
        echo "Thank you for loving this post"; // Typo corrected: "Thanks you" to "Thank you"
    }
   
    wp_die(); // Properly terminate the AJAX request
}

// Register the AJAX action for logged-in users
add_action('wp_ajax_NAQ_like_btn_ajax_action', 'NAQ_like_btn_ajax_action');
// Register the AJAX action for non-logged-in users
add_action('wp_ajax_nopriv_NAQ_like_btn_ajax_action', 'NAQ_like_btn_ajax_action');


?>