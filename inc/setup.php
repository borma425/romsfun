<?php

global $paged;

if (!isset($paged) || !$paged){
    $paged = 1;
}



function setup_theme(){

  register_nav_menu('sidebar_menu_1','Primary Header Menu');
  register_nav_menu('footer_menu_1','Primary Footer Menu');

add_theme_support( 'post-thumbnails' );

}




add_action('after_setup_theme','setup_theme');

add_filter( 'show_admin_bar', '__return_false' );
add_filter( 'rest_allow_anonymous_comments', '__return_true' );



function post_remove ()      //creating functions post_remove for removing menu item
{
remove_menu_page('edit.php');
}

add_action('admin_menu', 'post_remove');   //adding action for triggering function call





add_action('admin_menu', 'move_cpt_menus_after_dashboard');

function move_cpt_menus_after_dashboard() {
    global $menu;

    // Define your custom post types
    $cpt_menus = array(
        'edit.php?post_type=roms',
        'edit.php?post_type=emulators',
        'edit.php?post_type=article'

    );

    // Create an array to hold the menu items to move
    $menus_to_move = array();

    // Loop through the global menu and find your custom post type menus
    foreach ($menu as $key => $item) {
        // Check if the menu item is one of the CPTs you want to move
        if (in_array($item[2], $cpt_menus)) {
            // Store the menu item to move
            $menus_to_move[] = $menu[$key];
            // Remove it from the original position
            unset($menu[$key]);
        }
    }

    // Find the position of the Dashboard menu
    $dashboard_position = null;
    foreach ($menu as $key => $item) {
        if ($item[2] === 'index.php') { // Dashboard menu slug
            $dashboard_position = $key;
            break;
        }
    }

    // Insert the CPT menus after the Dashboard menu
    if ($dashboard_position !== null) {
        foreach (array_reverse($menus_to_move) as $menu_item) {
            array_splice($menu, $dashboard_position + 1, 0, array($menu_item));
            $dashboard_position++; // Move the position down for the next item
        }
    }
}









add_filter( 'timber/context', function( $context ) {

  global $paged , $post;

    $context['sidebar_menu']             =  Timber::get_menu('sidebar_menu_1');
    $context['footer_menu']              =  Timber::get_menu('footer_menu_1');


  $CPT        = CPT_Redirect_link();

  $context['current_cpt_link']   =  $CPT["link"];
  $context['current_cpt_type']   =  $CPT["type"];
    


    $context['current_url'] = Timber\URLHelper::get_current_url();


    $context['favicon'] = get_site_icon_url();





# All context of Custom Post Types 

$categories      = json_decode('[]', TRUE);

$categories[] = [


"related_roms" => [
    'post_type' => 'roms',
    'posts_per_page' => ( wp_is_mobile() ) ? 6 : 12 ,
    'orderby'   => 'rand',
    'post__not_in' => array($post->ID),



],




];

$categories = json_decode(  json_encode($categories) , true);
$categories = current($categories);



$context['related_roms']           = Timber::get_posts( $categories["related_roms"] );









    return $context;

} );







# extract full path of IMAGE dir
function asset_url( $filename ,  $path="/images/" ){

  $Path_url =  get_template_directory_uri() . '/assets/' . $path ;

  if(is_array($filename) && count($filename) > 1){

  $IMGarray = [];

  foreach( $filename as $item){
  array_push( $IMGarray, esc_url( $Path_url . $item ) );
  }

  $result   = $IMGarray;

  } else{

  $result   = esc_url( $Path_url . $filename ) ;

  }

  return   $result;

};




/* Get Link Of current Custom Post Time  */

function CPT_Redirect_link($cpt_slug=""){


  $cpt_slug         = ( !empty($cpt_slug) ) ? $cpt_slug : get_post_type( get_queried_object_id() );
  $cpt_slug         = $cpt_slug ?? "";
  
  
      switch ($cpt_slug) {
  
  
          case "roms":
          $path = "roms/";
            break;
          case "emulators":
          $path = "emulators/";
            break;
          case "help_center":
          $path = "help_center/";
            break;
          case "requires_rom":
          $path = "requires-rom/";
            break;
          case "article":
          $path = "article/";
            break;
            default:
            $path = "/";
  
      }
  
  $link = esc_url ( home_url('/' . ($path)) );
  
  $CPT_info        = json_decode('[]', TRUE);
  $CPT_info[]      = [
  "link"=> $link,
  "status"=> ( $path == "/" ) ? false : true,
  "type"=> $cpt_slug,
  
  ];
  
  return current($CPT_info);
  
  
  }







# get current tag of tags option list with index number

function get_tag_name_with_index($i){

  $tag_choices = array();
  $tags = get_tags();
  foreach ($tags as $index => $tag) {
      $tag_choices[$tag->slug] = urldecode($tag->name);
  }


return esc_html__( $tag_choices[$i] );

}




function getConsoleInfo($cpt, $tag_name) {
    // Get the term object by tag name in the default 'post_tag' taxonomy
    $term = get_term_by('name', $tag_name, 'post_tag');

    // If the term doesn't exist, return 0 for both post count and downloads
    if (!$term) {
        return [
            'total_posts' => 0,
            'total_downloads' => 0
        ];
    }

    // Set up a query to get the posts
    $query = new WP_Query(array(
        'post_type' => $cpt,
        'tax_query' => array(
            array(
                'taxonomy' => 'post_tag', // Default taxonomy for tags
                'field'    => 'term_id',
                'terms'    => $term->term_id,
            ),
        ),
        'posts_per_page' => -1, // Get all posts
        'fields' => 'ids', // Only get post IDs for efficiency
    ));

    // Initialize counters
    $total_posts = $query->post_count;
    $total_downloads = 0;

    // Loop through the posts and sum the downloads
    if ($total_posts > 0) {
        foreach ($query->posts as $post_id) {
            // Get the 'rom_Downloads' meta value as an array
            $downloads = get_post_meta($post_id, 'rom_Downloads', true);

            // Check if the downloads array and 'id' value exist
            if (!empty($downloads['id'])) {
                // Remove commas from the string and convert to integer
                $downloads_cleaned = str_replace(',', '', $downloads['id']);

                // Check if the cleaned value is numeric before adding
                if (is_numeric($downloads_cleaned)) {
                    $total_downloads += (int) $downloads_cleaned;
                }
            }
        }
    }

    // Return the total posts and total downloads
    return [
        'total_posts' => $total_posts,
        'total_downloads' => $total_downloads
    ];
}