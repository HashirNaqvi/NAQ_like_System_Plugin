<?php
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

?>