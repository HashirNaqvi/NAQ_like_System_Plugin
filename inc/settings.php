
<?php
// Register menu
function NAQ_settings_page_html() {
    if (!is_admin()) {
        return;
    }
    ?>
     <div class="wrap">
        <form action="options.php" method="post"> 
           <?php
            settings_fields('NAQ_settings'); // Generates hidden fields for security and to handle the settings
            do_settings_sections('NAQ_setting'); // Outputs settings sections and their fields
            submit_button('Save Changes'); // Creates the submit button
            ?>
        </form>
     </div>
    // <?php
}

function NAQ_submenu_page_html() {
    // HTML for submenu page
    echo '<h1>NAQ Submenu</h1>';
}

function NAQ_register_menu_page() {
    // Add the main menu page
    add_menu_page('NAQ Like System', 'NAQ Settings', 'manage_options', 'NAQ_setting', 'NAQ_settings_page_html', 'dashicons-superhero', 30);

    // Add the submenu page
    add_submenu_page('NAQ_setting', 'NAQ Submenu', 'NAQ Submenu', 'manage_options', 'NAQ_submenu', 'NAQ_submenu_page_html');
}

add_action('admin_menu', 'NAQ_register_menu_page');

function NAQ_plugin_settings() {
    // Register settings

    // register_setting(option_group, option_name);
    //parameters of register_setting 
    //option_group: string
    //option_name: string
    register_setting('NAQ_settings', 'NAQ_like_btn_label');
    register_setting('NAQ_settings', 'NAQ_dislike_btn_label');

    // Add settings section

    //add_settings_section(id, title, callback, page);
    //parameters of add_settings_section
    //id: string
    //title: string
    // callback function 
    //page: string

    add_settings_section('NAQ_label_settings', 'NAQ Button Labels', 'NAQ_section_cb', 'NAQ_setting');
    
    // Add settings field

    //add_settings_field(id , title, callback, page , section );
    //arameters of add_settings_field
    //id: string
    //title: string
    // callback function
    //page: string
    // section 
    add_settings_field('NAQ_like_label_field', 'Like Button Label', 'NAQ_field_cb', 'NAQ_setting', 'NAQ_label_settings');
    add_settings_field('NAQ_dislike_label_field', 'DisLike Button Label', 'NAQ_field_cb', 'NAQ_setting', 'NAQ_label_settings');
}

add_action('admin_init', 'NAQ_plugin_settings');

function NAQ_section_cb() {
    echo '<p>Define the button labels:</p>';
}

function NAQ_field_cb() {
    // Retrieve the stored option from the WordPress database
    $setting = get_option('NAQ_like_btn_label');
    ?>
    <!-- Output of the field -->
    <input type="text" id="NAQ_like_label_field" name="NAQ_like_label_field" value="<?php echo isset($setting) ? esc_attr($setting) : ''; ?>">
    <?php
}
function NAQ_dislike_field_cb() {
    // Retrieve the stored option from the WordPress database
    $setting = get_option('NAQ_like_btn_label');
    ?>
    <!-- Output of the field -->
    <input type="text" id="NAQ_dislike_label_field" name="NAQ_dislike_label_field" value="<?php echo isset($setting) ? esc_attr($setting) : ''; ?>">
    <?php
}

?>