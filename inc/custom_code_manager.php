<?php
// Add admin menu for custom code
function custom_code_menu() {
    add_menu_page(
        'Head & Footer',       // Page title
        'Head & Footer',       // Menu title
        'administrator',     // Capability
        'custom_code',       // Menu slug
        'custom_code_page',  // Function to display the settings page
        'dashicons-editor-code'  // Icon
    );
}
add_action('admin_menu', 'custom_code_menu');

// Create the custom code settings page
function custom_code_page() {
    ?>
    <div class="wrap">
        <h1>Custom Code for Head and Footer</h1>
        <form method="post" action="options.php">
            <?php
            settings_fields('custom_code_options_group');
            do_settings_sections('custom_code');
            ?>
            <h2>Head Section Code</h2>
            <textarea name="custom_code_textarea" rows="10" cols="50"><?php echo esc_textarea(get_option('custom_code_textarea')); ?></textarea>
            
            <h2>Footer Section Code</h2>
            <textarea name="custom_code_footer_textarea" rows="10" cols="50"><?php echo esc_textarea(get_option('custom_code_footer_textarea')); ?></textarea>
            
            <p class="submit">
                <input type="submit" name="submit" class="button-primary" value="Save Changes">
            </p>
        </form>
    </div>
    <?php
}

// Register settings to save custom code
function custom_code_settings() {
    register_setting('custom_code_options_group', 'custom_code_textarea'); // For head
    register_setting('custom_code_options_group', 'custom_code_footer_textarea'); // For footer
}
add_action('admin_init', 'custom_code_settings');

// Output the custom code in the head section
function insert_custom_code_in_head() {
    $custom_code = get_option('custom_code_textarea');
    if ($custom_code) {
        echo $custom_code; // Output the custom code in the head section
    }
}
add_action('wp_head', 'insert_custom_code_in_head');

// Output the custom code in the footer section
function insert_custom_code_in_footer() {
    $custom_footer_code = get_option('custom_code_footer_textarea');
    if ($custom_footer_code) {
        echo $custom_footer_code; // Output the custom code in the footer section
    }
}
add_action('wp_footer', 'insert_custom_code_in_footer');

// Hook to add the menu page
add_action('admin_menu', 'add_telegram_settings_menu');

function add_telegram_settings_menu() {
    add_menu_page(
        'Telegram URL',         // Page title
        'Telegram URL',         // Menu title
        'manage_options',            // Capability
        'telegram-settings',         // Menu slug
        'telegram_settings_page',    // Callback function
        'dashicons-admin-links',     // Icon (optional)
        100                          // Position (optional)
    );
}

// Callback function to display the settings page
function telegram_settings_page() {
    // Check if the user has submitted the form
    if (isset($_POST['submit_telegram_settings'])) {
        // Verify the nonce for security
        if (isset($_POST['_wpnonce']) && wp_verify_nonce($_POST['_wpnonce'], 'save_telegram_settings')) {
            // Sanitize and save the Telegram URL
            $telegram_url = sanitize_text_field($_POST['telegram_url']);
            update_option('telegram_url', $telegram_url);

            // Sanitize and save the Telegram button title
            $telegram_button_title = sanitize_text_field($_POST['telegram_button_title']);
            update_option('telegram_button_title', $telegram_button_title);

            echo '<div class="updated"><p>Settings saved successfully!</p></div>';
        } else {
            echo '<div class="error"><p>Security check failed. Please try again.</p></div>';
        }
    }

    // Retrieve the saved values
    $saved_telegram_url = get_option('telegram_url', '');
    $saved_telegram_button_title = get_option('telegram_button_title', '');
    ?>
    <div class="wrap">
        <h1>Telegram Settings</h1>
        <form method="POST" action="">
            <?php wp_nonce_field('save_telegram_settings'); ?>
            <table class="form-table">
                <tr valign="top">
                    <th scope="row"><label for="telegram_url">Telegram URL</label></th>
                    <td>
                        <input type="url" id="telegram_url" name="telegram_url" 
                               value="<?php echo esc_attr($saved_telegram_url); ?>" 
                               class="regular-text" required>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row"><label for="telegram_button_title">Button Title</label></th>
                    <td>
                        <input type="text" id="telegram_button_title" name="telegram_button_title" 
                               value="<?php echo esc_attr($saved_telegram_button_title); ?>" 
                               class="regular-text" required>
                    </td>
                </tr>
            </table>
            <?php submit_button('Save Settings', 'primary', 'submit_telegram_settings'); ?>
        </form>
    </div>
    <?php
}






