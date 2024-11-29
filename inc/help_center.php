<?php

add_action('template_redirect', 'handle_help_center_submission');

function handle_help_center_submission() {
    // Check if on the correct page and the request method is POST
    if (is_archive('help_center') && $_SERVER['REQUEST_METHOD'] === 'POST' ) {
        // Verify nonce for security
            // Sanitize and retrieve the form inputs
            $url_report = sanitize_text_field($_POST['url-report']);
            $user_email = sanitize_email($_POST['user-email']);
            $report_type = sanitize_text_field($_POST['report-type']);
            $report_content = sanitize_textarea_field($_POST['report-content']);

            // Prepare the post data
            $new_post = array(
                'post_title'   => wp_strip_all_tags($report_type), // Use the report type as the title
                'post_content' => "Report URL: <a href='$url_report'>$url_report</a>\n" . 
                                 "User Email: $user_email\n" . 
                                 "Report Type: $report_type\n\n" . 
                                 "Feedback:\n$report_content",
                'post_status'  => 'pending', // Set post status to 'pending'
                'post_type'    => 'help_center', // Custom post type
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


