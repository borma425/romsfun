<?php

class emulators_consoles {
	public function __construct() {
		add_action( 'customize_register', array( $this, 'register_customize_emulators_consoles_sections' ) );
	}
	public function register_customize_emulators_consoles_sections( $wp_customize ) {
        /*
        * Add settings to sections.
        */
        $this->emulators_consoles_callout_section( $wp_customize );
    }

    /* Sanitize Inputs */
    public function sanitize_custom_option($input) {
        return ( $input === "No" ) ? "No" : "Yes";
    }
    public function sanitize_custom_text($input) {
        return filter_var($input, FILTER_SANITIZE_STRING);
    }
    public function sanitize_custom_url($input) {
        return filter_var($input, FILTER_SANITIZE_URL);
    }
    public function sanitize_custom_email($input) {
        return filter_var($input, FILTER_SANITIZE_EMAIL);
    }
    public function sanitize_hex_color( $color ) {
        if ( '' === $color ) {
            return '';
        }

        // 3 or 6 hex digits, or the empty string.
        if ( preg_match( '|^#([A-Fa-f0-9]{3}){1,2}$|', $color ) ) {
            return $color;
        }
    }

    /* emulators_consoles Section */
    private function emulators_consoles_callout_section( $wp_customize ) {
		// New panel for "Layout".
        $wp_customize->add_section('basic-emulators_consoles-callout-section', array(
            'title' => 'Emulator Consoles',
            'priority' => 2,
            'description' => __('emulators_consoles  section is  displayed on the Blog emulators_consoles.', 'Borma'),
        ));






/* Range of fields */

        $wp_customize->add_setting("basic-emulators_consoles-callout-range", array(
            'default' => 10,
            'sanitize_callback' => NULL
        ));
        $wp_customize->add_control(new WP_Customize_Control($wp_customize, "basic-emulators_consoles-callout-range", array(
            'label' => 'The range',
            'section' => 'basic-emulators_consoles-callout-section',
            'settings' => "basic-emulators_consoles-callout-range",
    'description' => '----------------------------',

            'type'              => 'number',
            'input_attrs'       => array(
                'min'           => 2,
                'max'           => 100,
                'step'          => 1,
            ),
        )));




$emulators_consoles_section_range = get_theme_mod('basic-emulators_consoles-callout-range');
$emulators_consoles_section_range = ( $emulators_consoles_section_range !== NULL) ? $emulators_consoles_section_range : 2;


for ($i=0; $i < $emulators_consoles_section_range; $i++) { 









/* Title */

$wp_customize->add_setting("basic-emulators_consoles-callout-title-$i", array(
    'default' => '',
    'sanitize_callback' => array( $this, 'sanitize_custom_text' )
));
$wp_customize->add_control(new WP_Customize_Control($wp_customize, "basic-emulators_consoles-callout-title-$i", array(
    'label' => 'title',
    'section' => 'basic-emulators_consoles-callout-section',
    'settings' => "basic-emulators_consoles-callout-title-$i",
    'type' => 'text'
)));





//  ==================================
//  = Featured Tags SELECTOR   =
//  ==================================
$wp_customize->add_setting("basic-emulators_consoles-callout-tag-$i", array(
    'capability' => 'edit_theme_options',
    'default' => 'uncategorized',
    'type'       => 'theme_mod',
  ));

  $tag_choices = array();
  $tags = get_tags();
  $selected_tag_index = get_theme_mod("basic-emulators_consoles-callout-tag-$i",'TT');
  foreach ($tags as $index => $tag) {
      $tag_choices[$tag->slug] = urldecode($tag->name);
      if($index == $selected_tag_index){
          set_theme_mod("basic-emulators_consoles-callout-tag-$i", $tag->slug);
      }
  }



  $wp_customize->add_control("basic-emulators_consoles-callout-tag-$i", [
    'label' => 'Section tag Belong',
    'section'    => 'basic-emulators_consoles-callout-section',
    'settings' => "basic-emulators_consoles-callout-tag-$i",
    'type'        => 'select',
    'choices' => $tag_choices   // combines all tags data
  ]);







/* Title */

$wp_customize->add_setting("basic-emulators_consoles-callout-headline-$i", array(
    'default' => '',
    'sanitize_callback' => array( $this, 'sanitize_custom_text' )
));
$wp_customize->add_control(new WP_Customize_Control($wp_customize, "basic-emulators_consoles-callout-headline-$i", array(
    'label' => 'headline',
    'section' => 'basic-emulators_consoles-callout-section',
    'settings' => "basic-emulators_consoles-callout-headline-$i",
    'type' => 'text'
)));



$wp_customize->add_setting("basic-emulators_consoles-callout-description-$i", array(
    'default' => '',
    'sanitize_callback' => array( $this, 'sanitize_custom_text' )
));
$wp_customize->add_control(new WP_Customize_Control($wp_customize, "basic-emulators_consoles-callout-description-$i", array(
    'label' => 'description',
    'section' => 'basic-emulators_consoles-callout-section',
    'settings' => "basic-emulators_consoles-callout-description-$i",
    'type' => 'textarea'
)));





# background Image

$wp_customize->add_setting("basic-emulators_consoles-callout-background-$i", array(
    'default' => 'red',
    'type' => 'theme_mod',
    'capability' => 'edit_theme_options',
    'sanitize_callback' => array( $this, 'sanitize_custom_url' )
));

$wp_customize->add_control(new WP_Customize_Cropped_Image_Control($wp_customize, "basic-emulators_consoles-callout-background-$i", array(
    'label' => "Image $i",
    'section' => 'basic-emulators_consoles-callout-section',
    'settings' => "basic-emulators_consoles-callout-background-$i",
    'width' => 150,
    'height' => 150
)));



} #end forLoop






    }




}