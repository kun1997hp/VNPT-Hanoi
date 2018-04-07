<?php
function oxane_customize_register_googlefonts($wp_customize){
    $wp_customize->add_section(
        'oxane_typo_options',
        array(
            'title'     => __('Google Web Fonts','oxane'),
            'priority'  => 41,
        )
    );

    $font_array = array('HIND','Khula','Open Sans','Droid Sans','Droid Serif','Roboto','Roboto Condensed','Lato','Bree Serif','Oswald','Slabo','Lora','Source Sans Pro','Arimo','Bitter','Noto Sans');
    $fonts = array_combine($font_array, $font_array);

    $wp_customize->add_setting(
        'oxane_title_font',
        array(
            'default'=> 'HIND',
            'sanitize_callback' => 'oxane_sanitize_gfont'
        )
    );

    function oxane_sanitize_gfont( $input ) {
        if ( in_array($input, array('HIND','Khula','Open Sans','Droid Sans','Droid Serif','Roboto','Roboto Condensed','Lato','Bree Serif','Oswald','Slabo','Lora','Source Sans Pro','Arimo','Bitter','Noto Sans') ) )
            return $input;
        else
            return '';
    }

    $wp_customize->add_control(
        'oxane_title_font',array(
            'label' => __('Title','oxane'),
            'settings' => 'oxane_title_font',
            'section'  => 'oxane_typo_options',
            'type' => 'select',
            'choices' => $fonts,
        )
    );

    $wp_customize->add_setting(
        'oxane_body_font',
        array(	'default'=> 'Open Sans',
            'sanitize_callback' => 'oxane_sanitize_gfont' )
    );

    $wp_customize->add_control(
        'oxane_body_font',array(
            'label' => __('Body','oxane'),
            'settings' => 'oxane_body_font',
            'section'  => 'oxane_typo_options',
            'type' => 'select',
            'choices' => $fonts
        )
    );
}
add_action('customize_register', 'oxane_customize_register_googlefonts');