<?php


  
  
  $current_tagname = $current_tag;
  $context['current_tagname'] = $current_tagname;
  
  // Get the consoles section range from the Customizer
  $section_range = get_theme_mod('basic-rom_consoles-callout-range', 0);
  $context['consoles_section_range'] = $section_range;
  
  // Prepare the image URL for the current tag
  for ($i = 0; $i <= $section_range; $i++) {
    $tag_name = get_theme_mod('basic-rom_consoles-callout-tag-' . $i);
  
    if ($tag_name === $current_tagname) {
        $context['rom_image'] = get_customizer_image('basic-rom_consoles-callout-background-' . $i, $context['defaultimg']);
        $context['rom_title'] = get_theme_mod('basic-rom_consoles-callout-title-' . $i);
        $context['rom_headline'] = get_theme_mod('basic-rom_consoles-callout-headline-' . $i);
         $context['rom_description'] = convertNewlinesToParagraphs( get_theme_mod('basic-rom_consoles-callout-description-' . $i) );
  
        break; // Exit loop once the matching tag is found
    }
  }