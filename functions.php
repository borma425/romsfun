<?php

require_once __DIR__ . '/vendor/autoload.php';

define('DEV_MODE', true);

// Initialize Timber.
Timber\Timber::init();

require(get_theme_file_path('inc/view-page-source.php'));

require(get_theme_file_path('inc/setup.php'));
require(get_theme_file_path('inc/enqueues.php'));
require(get_theme_file_path('inc/custom_post_type.php'));
require(get_theme_file_path('inc/acf/main.php'));
require(get_theme_file_path('inc/customizer/main.php'));
require(get_theme_file_path('inc/request_rom.php'));
require(get_theme_file_path('inc/help_center.php'));

require(get_theme_file_path('inc/custom_cpt_tag_path.php'));
require(get_theme_file_path('inc/custom_code_manager.php'));


function remove_trash_from_custom_post_type( $actions, $post ) {
    // Specify your custom post type
    $custom_post_types = array( 'help_center' , 'requires-rom' );

    // Check if the current post type is in the specified custom post types array
    if ( in_array( $post->post_type, $custom_post_types ) ) {
        unset( $actions['inline hide-if-no-js'] ); // Remove Quick Edit action
        unset( $actions['edit'] );       // Remove Edit action
    }
    return $actions;
}
add_filter( 'post_row_actions', 'remove_trash_from_custom_post_type', 10, 2 );
