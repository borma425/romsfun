<?php


function get_customizer_image($mod_name, $default) {
    $image_id = get_theme_mod($mod_name);
  
    if ($image_id) {
        // Get the image URL using the image ID
        return wp_get_attachment_image_url($image_id, 'full') ?: $default;
    }
    
    return $default; // Return default if no image found
  }
  
  
  
  function convertNewlinesToParagraphs($text) {
    // Split the text into paragraphs based on newlines
    $paragraphs = explode("\n", $text);
  
    // Trim whitespace and filter out empty paragraphs
    $paragraphs = array_filter(array_map('trim', $paragraphs));
  
    // Wrap each paragraph in <p> tags
    $paragraphs = array_map(function($paragraph) {
        return '<p>' . $paragraph . '</p>';
    }, $paragraphs);
  
    // Join the paragraphs back into a single string
    return implode('', $paragraphs);
  }
  
  
  
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