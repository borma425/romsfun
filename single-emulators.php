<?php


$redirect_to = isset($_GET['download'])
 ? true
 : false;

 $counter_download = isset($_GET['select'])
 ? true
 : false;



$context = Timber::context();
$context['redirect'] = $redirect_to;
$context['counter_download'] = $counter_download;
$context['select'] = isset($_GET['select']) ? $_GET['select'] : 'Parameter not found';;



$context['popular_roms'] = Timber::get_posts([
    'post_type'      => 'emulators', // Custom post type 'roms'
    'posts_per_page' => 10,     // Number of popular ROMs to display
    'meta_key'       => 'rom_Downloads', // Custom field for sorting by downloads
    'orderby'        => 'meta_value_num', // Order by numeric value of downloads
    'order'          => 'DESC', // Highest downloads first
]);



Timber::render('content/single-rom.twig', $context);









