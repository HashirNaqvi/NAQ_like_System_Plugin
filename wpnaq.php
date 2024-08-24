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


    
    // creating like and dislike buttons
    function NAQ_like_dislike_button($content) {
        // Retrieve button labels from options, with defaults of 'Like' and 'Dislike'
        $like_btn_label = get_option('NAQ_like_btn_label', 'Like');
        $dislike_btn_label = get_option('NAQ_dislike_btn_label', 'Dislike');
    
        // Get logged-in user ID
        $user_id = get_current_user_id();
        
        // Get post ID
        $post_id = get_the_ID();
    
        // Check if user ID and post ID are valid before proceeding
        if ($user_id && $post_id) {
            // Create the button container and buttons using the retrieved labels
            $like_btn_wrap = '<div class="NAQ_buttons_container">';
            $like_btn = '<a href="javascript:void(0);" onclick="NAQ_like_btn_ajax(' . esc_attr($post_id) . ', ' . esc_attr($user_id) . ')" class="NAQ_btn like-btn">' . esc_html($like_btn_label) . '</a>';
            $dislike_btn = '<a href="javascript:void(0);" class="NAQ_btn dislike-btn">' . esc_html($dislike_btn_label) . '</a>';
            $like_btn_wrap_end = '</div>';
            
            // For response
            $NAQ_ajax_response = '<div id="NAQAjaxResponse" class="NAQ-ajax-response"><span></span></div>';
            
            // Append the buttons to the content
            $content .= $like_btn_wrap . $like_btn . $dislike_btn . $like_btn_wrap_end . $NAQ_ajax_response;
        }
        
        return $content;
    }
    add_filter('the_content', 'NAQ_like_dislike_button');
    
// NAQ plugin Ajax function
function NAQ_like_btn_ajax_action() {
    echo 'ajax success';
    wp_die(); // This function is used to properly terminate the AJAX request
}

// Use wp_ajax with your function name
add_action('wp_ajax_NAQ_like_btn_ajax_action', 'NAQ_like_btn_ajax_action');
add_action('wp_ajax_nopriv_NAQ_like_btn_ajax_action', 'NAQ_like_btn_ajax_action');

?>