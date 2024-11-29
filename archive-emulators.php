<?php


$context = Timber::context();

$context['is_front_page'] = false;



Timber::render('archive-emulators.twig', $context);









