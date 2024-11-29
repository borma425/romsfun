<?php


$context = Timber::context();



$context['is_front_page'] = false;


$args = [
  'post_type' => 'article',
  'posts_per_page' => 6,
  'no_found_rows' => true,
  'orderby' => 'rand', // Changed to 'rand' for random posts
];

$context['related_posts'] = Timber::get_posts($args);





Timber::render('content/single-article.twig', $context);









