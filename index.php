
<?php


$context = Timber::context();

$context['is_front_page'] = true;

$context['welcome'] = Timber::get_post(array(
      'name' => 'welcome',
      'post_type' => 'page',
  ));


  $context['related_posts'] = Timber::get_posts(array(
      'post_type'      => 'article',  // Replace with your custom post type
      'posts_per_page' => 4,           // Limit to 4 posts
      'orderby'        => 'date',      // Order by the post date
      'order'          => 'DESC',      // Get the latest posts
  ));



  $CPT = CPT_Redirect_link("roms");

  $context['current_cpt_link'] = $CPT["link"];
  $context['current_cpt_type'] = $CPT["type"];



$context['Latest_roms_Update'] = Timber::get_posts([
    'post_type'      => 'roms', // Custom post type 'roms'
    'posts_per_page' => 8,     // Number of posts to display
    'orderby'        => 'date', // Order by post date
    'order'          => 'DESC', // Show latest posts first

]);




$context['popular_roms'] = Timber::get_posts([
    'post_type'      => 'roms', // Custom post type 'roms'
    'posts_per_page' => 10,     // Number of popular ROMs to display
    'meta_key'       => 'rom_Downloads', // Custom field for sorting by downloads
    'orderby'        => 'meta_value_num', // Order by numeric value of downloads
    'order'          => 'DESC', // Highest downloads first
]);







Timber::render('index-home.twig', $context);




