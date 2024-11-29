<?php


function custom_see_rewrite_rule() {
    add_rewrite_rule(
        '^see/([^/]*)/([^/]*)/page/([0-9]{1,})/?$',   // Matches /see/{post_type}/{tag}/page/{number}
        'index.php?post_type=$matches[1]&tag=$matches[2]&paged=$matches[3]',   // Capture post_type, tag, and page number
        'top'
    );

    // The original rule for /see/{post_type}/{tag}
    add_rewrite_rule(
        '^see/([^/]*)/([^/]*)/?$',   // Matches /see/{post_type}/{tag}
        'index.php?post_type=$matches[1]&tag=$matches[2]',   // Capture post_type and tag
        'top'
    );
}
add_action('init', 'custom_see_rewrite_rule');



// 2. Register 'post_type' and 'tag' Query Variables
function custom_register_query_vars($vars) {
    $vars[] = 'post_type';  // Add 'post_type' to query variables
    $vars[] = 'tag';        // Add 'tag' to query variables
    return $vars;
}
add_filter('query_vars', 'custom_register_query_vars');

// 3. Include 'tag-archive.php' Template When 'post_type' and 'tag' are Set
function custom_see_template($template) {
    $post_type = get_query_var('post_type');  // Get 'post_type' from query
    $tag = get_query_var('tag');              // Get 'tag' from query
    
    if ($post_type && $tag) {
        // Look for the custom template 'tag-archive.php' in the theme directory
        $new_template = locate_template('tag-archive.php');
        if ($new_template) {
            return $new_template;   // If found, use 'tag-archive.php' as the template
        }
    }
    return $template;  // Use default template if 'post_type' or 'tag' is not set
}
add_filter('template_include', 'custom_see_template');

// 4. Flush Rewrite Rules After Theme Switch (Only Needed Once)
function custom_flush_rewrite_rules() {
    custom_see_rewrite_rule();   // Ensure the rule is added
    flush_rewrite_rules();       // Flush rewrite rules
}
add_action('after_switch_theme', 'custom_flush_rewrite_rules');