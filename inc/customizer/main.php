<?php

require(get_theme_file_path('inc/customizer/logos.php'));
require(get_theme_file_path('inc/customizer/hero_header.php'));
require(get_theme_file_path('inc/customizer/footer.php'));
require(get_theme_file_path('inc/customizer/rom_consoles.php'));
require(get_theme_file_path('inc/customizer/emulators_consoles.php'));


new hero_header();
new logos();
new footerPlus();

new rom_consoles();

new emulators_consoles();

