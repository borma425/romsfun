<?php
    
$current_tag = get_query_var('tag'); // Retrieve the tag from the URL
$current_post_type = get_query_var('post_type'); // Retrieve the CPT from the URL

// Get the tag by slug
$term = get_term_by('slug', $current_tag, 'post_tag');

$context = Timber::context();

$paged = get_query_var('paged') ? get_query_var('paged') : 1; // Get current page number

$args = [
    'post_type' => $current_post_type,           // The post type you're working with
    'posts_per_page' => 20,                       // Limit the number of posts
    'orderby' => 'meta_value_num',                // Order by numeric meta value
    'order' => 'DESC',                            // Highest first
    'meta_key' => 'rom_Downloads',                // Custom field to sort by
    'paged' => $paged,                            // For pagination
    'tax_query' => [
        [
            'taxonomy' => 'post_tag',
            'field'    => 'term_id',
            'terms'    => $term ? $term->term_id : 0,  // Taxonomy filter (if applicable)
        ],
    ],
];

// If search parameters are set
if (isset($_GET['s']) && isset($_GET['os'])) {
    $search = strip_tags(wp_unslash($_GET['s']));
    $value = strip_tags(wp_unslash($_GET['os']));

    $array_acf = [
        'meta_query' => [
            [
                'key'     => "rom_os",
                'value'   => $value,
                'compare' => 'LIKE',
            ],
        ],
    ];

    // Merge search with main arguments
    $args = array_merge($args, [
        's' => $search,
        'order' => 'ASC',
    ], $array_acf);
}







// Set up pagination
$CPT = CPT_Redirect_link($current_post_type);

// Get posts
$posts = Timber::get_posts($args);

$section_range = get_theme_mod('basic-rom_consoles-callout-range', 0);

$rom_image = "";
$rom_title = "";
$rom_headline = "";
$rom_description = "";
$defaultImage = "TTTTTTTT";

  // Prepare the image URL for the current tag
  for ($i = 0; $i <= $section_range; $i++) {
    $tag_name = get_theme_mod('basic-rom_consoles-callout-tag-' . $i);
  
    if ($tag_name === $current_tag) {
        $rom_image = get_customizer_image('basic-rom_consoles-callout-background-' . $i, $defaultImage);
        $rom_title = get_theme_mod('basic-rom_consoles-callout-title-' . $i);
        $rom_headline = get_theme_mod('basic-rom_consoles-callout-headline-' . $i);
        $rom_description = convertNewlinesToParagraphs( get_theme_mod('basic-rom_consoles-callout-description-' . $i) );
  
        break; // Exit loop once the matching tag is found
    }
  }



$context = Timber::context([
    'posts' => $posts,
    'pagination' => $posts,
    'current_cpt_link' =>  $CPT["link"],
    'current_cpt_type' => $CPT["type"],
    'current_tagname' => $current_tag,
    'consoles_section_range' => $section_range,
    'rom_image' => $rom_image,
    'rom_title' => $rom_title,
    'rom_headline' => $rom_headline,
    'rom_description' => $rom_description,

]);



// Additional context setup...

// Render the Twig template
Timber::render('components/grid/list_tag_consoles.twig', $context);