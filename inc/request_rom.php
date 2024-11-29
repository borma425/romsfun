<?php


add_action('template_redirect', 'handle_requires_rom_submission');

function handle_requires_rom_submission() {
    if (is_page('requires_rom') && $_SERVER['REQUEST_METHOD'] === 'POST') {
        // Check if the form was submitted and the field is set
        if (isset($_POST['requested_content'])) {
            // Sanitize and retrieve the form input
            $requested_content = sanitize_text_field($_POST['requested_content']);
            
            // Prepare the post data
            $new_post = array(
                'post_title'   => wp_strip_all_tags($requested_content), // Use the content as the title
                'post_content' => $requested_content, // Content from the form field
                'post_status'  => 'pending', // Set post status to 'pending'
                'post_type'    => 'requires-rom', // Custom post type
            );
            
            // Insert the post into the database
            $post_id = wp_insert_post($new_post);
            
            if ($post_id) {
                // Set a flag to indicate success
                set_transient('form_submission_success', true, 30); // Set for 30 seconds
            } else {
                set_transient('form_submission_error', true, 30); // Set error flag for 30 seconds
            }

            $context = Timber::context();
            Timber::render('pages/succ_form_submit.twig', $context);
            
            exit;
        }
    }
}
