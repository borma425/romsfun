<?php
    
$current_tag = get_query_var('tag'); // Retrieve the tag from the URL
$current_post_type = get_query_var('post_type'); // Retrieve the CPT from the URL

// Get the tag by slug
$term = get_term_by('slug', $current_tag, 'post_tag');

$context = Timber::context();

$paged = get_query_var('paged') ? get_query_var('paged') : 1; // Get current page number

$args = [
    'post_type' => $current_post_type,
    'posts_per_page' => 6,
    'orderby' => 'date',
    'order' => 'DESC',
    'paged' => $paged, // Set pagination here
    'tax_query' => [
        [
            'taxonomy' => 'post_tag',
            'field'    => 'term_id',
            'terms'    => $term ? $term->term_id : 0,
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



$context = Timber::context([
    'posts' => $posts,
    'pagination' => $posts,
    'current_cpt_link' =>  $CPT["link"],
    'current_cpt_type' => $CPT["type"],
    'current_tagname' => $current_tag,

]);



// Additional context setup...

// Render the Twig template
Timber::render('components/grid/list_tag_consoles.twig', $context);