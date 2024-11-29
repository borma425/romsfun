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

// Get posts
$context["posts"] = Timber::get_posts($args);

// Set up pagination
$CPT = CPT_Redirect_link($current_post_type);
$current_page = get_query_var('paged') ? get_query_var('paged') : 1; // Current page number
$total_pages = 3; // Example total pages, you can calculate this based on your query results

// Base URL for pagination
$base_url = $context['current_url'] . '/page/';

$base_url = home_url("/see/{$CPT["type"]}/{$current_tag}/page/");


// Construct the pagination links
$pagination_links = [];
for ($i = 1; $i <= $total_pages; $i++) {
    $pagination_links[] = [
        'number' => $i,
        'link' => "{$base_url}{$i}/",
        'current' => ($i === $current_page),
    ];
}

// Create prev and next links
$prev_link = $current_page > 1 ? "{$base_url}" . ($current_page - 1) . '/' : '';
$next_link = $current_page < $total_pages ? "{$base_url}" . ($current_page + 1) . '/' : '';

$context['pagination'] = [
    'prev' => $prev_link,
    'next' => $next_link,
    'pages' => $pagination_links,
];





$context['current_cpt_link'] = $CPT["link"];
$context['current_cpt_type'] = $CPT["type"];
$context['current_tagname'] = $current_tag;

// Additional context setup...

// Render the Twig template
Timber::render('components/grid/list_tag_consoles.twig', $context);