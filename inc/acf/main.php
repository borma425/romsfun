<?php


function remove_tags_meta_box() {
    $cpt_id = ['roms','emulators','article'];
        remove_meta_box('categorydiv', $cpt_id, 'normal');
        remove_meta_box('postcustom', $cpt_id, 'normal');
        remove_meta_box('authordiv', $cpt_id, 'normal');
        remove_meta_box('revisionsdiv', $cpt_id, 'normal');
        remove_meta_box('pageparentdiv', $cpt_id, 'normal');
        remove_meta_box('formatdiv', $cpt_id, 'normal');


    }

add_action('admin_menu', 'remove_tags_meta_box');





$custom_types = ['roms','emulators'];

add_action( 'add_meta_boxes', 'my_meta_box' );

function my_meta_box() {
global $custom_types;

add_meta_box('romInfo',  __( 'Rom info ', 'roms' ), 'callback_romInfo', $custom_types, 'normal');  

add_meta_box('downloadInfo',  __( ' Download Links ', 'roms' ), 'callback_downloadInfo', $custom_types, 'normal');  

}


include_once get_theme_file_path('inc/acf/rom-info.php');


include_once get_theme_file_path('inc/acf/multiple_featured_images.php');

