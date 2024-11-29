<?php

$anotherLinksCount = 3;


# rom info Data

function callback_romInfo($post){
$rom_size            = get_post_meta($post->ID, 'rom_size', true);
$rom_rating_average  = get_post_meta($post->ID, 'rom_rating_average', true);
$rom_Downloads       = get_post_meta($post->ID, 'rom_Downloads', true);
$rom_Publisher       = get_post_meta($post->ID, 'rom_Publisher', true);
$rom_Genre           = get_post_meta($post->ID, 'rom_Genre', true);
$rom_Region          = get_post_meta($post->ID, 'rom_Region', true);
$rom_Released          = get_post_meta($post->ID, 'rom_Released', true);
$rom_os                = get_post_meta($post->ID, 'rom_os', true);
$rom_learn_how_work_title                = get_post_meta($post->ID, 'rom_learn_how_work_title', true);
$rom_learn_how_work_link                = get_post_meta($post->ID, 'rom_learn_how_work_link', true);

$rom_info = [
        'rom_size'                    =>  ( isset($rom_size['id']) ) ? $rom_size['id'] : '',
        'rom_rating_average'          =>  ( isset($rom_rating_average['id']) ) ? $rom_rating_average['id'] : '',
        'rom_Downloads'               =>  ( isset($rom_Downloads['id']) ) ? $rom_Downloads['id'] : '',
        'rom_Publisher'               =>  ( isset($rom_Publisher['id']) ) ? $rom_Publisher['id'] : '',
        'rom_Genre'                   =>  ( isset($rom_Genre['id']) ) ? $rom_Genre['id'] : '',
        'rom_Region'                  =>  ( isset($rom_Region['id']) ) ? $rom_Region['id'] : '',
        'rom_Released'                  =>  ( isset($rom_Released['id']) ) ? $rom_Released['id'] : '',
        'rom_os'                        =>  ( isset($rom_os['id']) ) ? $rom_os['id'] : '',
        'rom_learn_how_work_title'                        =>  ( isset($rom_learn_how_work_title['id']) ) ? $rom_learn_how_work_title['id'] : 'learn how to run this game',
        'rom_learn_how_work_link'                        =>  ( isset($rom_learn_how_work_link['id']) ) ? $rom_learn_how_work_link['id'] : '',






];

Timber::render('/acf/rom_info.twig', $rom_info);

}









function callback_downloadInfo($post){


    
    
    
    $app_download = [
    ];
    
    
    

    
    /* !!!!!!Another Download Links like last Versions !!!!! */
    global  $anotherLinksCount;
    
    $app_download["anotherLinksCount"] =  $anotherLinksCount;
    
    /* Text Links */
    for($i = 1; $i <= $anotherLinksCount; $i++) {
        ${"app_download_another_Title_$i"}                      = get_post_meta($post->ID, "app_download_another_Title_$i", true);
        ${"app_download_another_href_$i"}                       = get_post_meta($post->ID, "app_download_another_href_$i", true);
        ${"app_download_another_Size_$i"}                       = get_post_meta($post->ID, "app_download_another_Size_$i", true);
        ${"app_download_another_Type_$i"}                       = get_post_meta($post->ID, "app_download_another_Type_$i", true);
    
        $app_download["app_download_another_Title_$i"]          = ( isset(${"app_download_another_Title_$i"}['id']) ) ? ${"app_download_another_Title_$i"}['id'] : '';
        $app_download["app_download_another_href_$i"]           = ( isset(${"app_download_another_href_$i"}['id']) ) ? ${"app_download_another_href_$i"}['id'] : '';
        $app_download["app_download_another_Size_$i"]        = ( isset(${"app_download_another_Size_$i"}['id']) ) ? ${"app_download_another_Size_$i"}['id'] : '';
        $app_download["app_download_another_Type_$i"]        = ( isset(${"app_download_another_Type_$i"}['id']) ) ? ${"app_download_another_Type_$i"}['id'] : '';
    
    
    }
    
    
    /* !!!!!!!!!!! */
    
    
    Timber::render('/acf/downloadInfo.twig', $app_download);
    
    
    }
    
    
    
    





add_action( 'save_post', 'roms_meta_save' );
function roms_meta_save( $id ) {
    // Check if the request is an autosave and if the user has the required permissions
    if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
    if( ! current_user_can( 'edit_post', $id ) ) return;


    // Update rom_size field
    if(isset($_POST['rom_size']))
        update_post_meta( $id, "rom_size", $_POST['rom_size'] );

    // Update rom_rating_average field
    if(isset($_POST['rom_rating_average']))
        update_post_meta( $id, "rom_rating_average", $_POST['rom_rating_average'] );

    // Update rom_Downloads field
    if(isset($_POST['rom_Downloads']))
        update_post_meta( $id, "rom_Downloads", $_POST['rom_Downloads'] );

    // Update rom_Publisher field
    if(isset($_POST['rom_Publisher']))
        update_post_meta( $id, "rom_Publisher", $_POST['rom_Publisher'] );

    // Update rom_Genre field
    if(isset($_POST['rom_Genre']))
        update_post_meta( $id, "rom_Genre", $_POST['rom_Genre'] );

    // Update rom_Region field
    if(isset($_POST['rom_Region']))
        update_post_meta( $id, "rom_Region", $_POST['rom_Region'] );

    // Update rom_Released field
    if(isset($_POST['rom_Released']))
        update_post_meta( $id, "rom_Released", $_POST['rom_Released'] );


    if(isset($_POST['rom_os']))
        update_post_meta( $id, "rom_os", $_POST['rom_os'] );

    if(isset($_POST['rom_learn_how_work_title']))
        update_post_meta( $id, "rom_learn_how_work_title", $_POST['rom_learn_how_work_title'] );



    if(isset($_POST['rom_learn_how_work_link']))
        update_post_meta( $id, "rom_learn_how_work_link", $_POST['rom_learn_how_work_link'] );








global $anotherLinksCount;

for($i = 1; $i <= $anotherLinksCount; $i++) {

# Another Download Link
if(isset($_POST["app_download_another_Title_$i"]))
    update_post_meta( $id, "app_download_another_Title_$i", $_POST["app_download_another_Title_$i"] );

if(isset($_POST["app_download_another_href_$i"]))
    update_post_meta( $id, "app_download_another_href_$i", $_POST["app_download_another_href_$i"] );

if(isset($_POST["app_download_another_Size_$i"]))
    update_post_meta( $id, "app_download_another_Size_$i", $_POST["app_download_another_Size_$i"] );

if(isset($_POST["app_download_another_Type_$i"]))
    update_post_meta( $id, "app_download_another_Type_$i", $_POST["app_download_another_Type_$i"] );

} # end loop





}
