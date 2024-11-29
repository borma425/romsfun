<?php


$context = Timber::context();

$context['is_front_page'] = false;


$context['related_posts'] = Timber::get_posts(array(
    'post_type'      => 'article',  // Replace with your custom post type
    'posts_per_page' => 4,           // Limit to 4 posts
    'orderby'        => 'date',      // Order by the post date
    'order'          => 'DESC',      // Get the latest posts
));


Timber::render('archive-articles.twig', $context);









