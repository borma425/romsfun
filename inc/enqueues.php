<?php
function enqueues() {

$ver = DEV_MODE ? time() : false;


if( !is_admin() ) {

    wp_enqueue_style( 'bootstrap', asset_url('bootstrap.min.css','/css/'), [], $ver, 'all' );
    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css', [], $ver, 'all' );

    wp_enqueue_script("parent-js", asset_url('main.js','/js/'), [], $ver, true );

    }

}


add_action('wp_enqueue_scripts', 'enqueues', 999);








