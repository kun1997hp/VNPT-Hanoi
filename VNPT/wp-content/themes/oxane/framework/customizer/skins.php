<?php
function oxane_customize_register_skin($wp_customize){
    $wp_customize->get_section('colors')->title = __('Theme Skin & Colors','oxane');
    $wp_customize->get_control('header_textcolor')->label = __('Site Title Color','oxane');

    $wp_customize->add_setting('oxane_header_desccolor', array(
        'default'     => '#000000',
        'sanitize_callback' => 'sanitize_hex_color',
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control(
            $wp_customize,
            'oxane_header_desccolor', array(
            'label' => __('Site Tagline Color','oxane'),
            'section' => 'colors',
            'settings' => 'oxane_header_desccolor',
            'type' => 'color'
        ) )
    );

    $wp_customize->add_setting(
        'oxane_skin',
        array(
            'default'=> 'default',
            'sanitize_callback' => 'oxane_sanitize_skin'
        )
    );

    $skins = array( 'default' => __('Default(oxane)','oxane'),
        'green' => __('Green','oxane'),
        'brown' => __('Brown', 'oxane'),
    );

    $wp_customize->add_control(
        'oxane_skin',array(
            'settings' => 'oxane_skin',
            'section'  => 'colors',
            'label' => __('Choose Skin','oxane'),
            'description' => __('Free Version of oxane Supports 3 Different Skin Colors.','oxane'),
            'type' => 'select',
            'choices' => $skins,
        )
    );

    function oxane_sanitize_skin( $input ) {
        if ( in_array($input, array('default','orange','green', 'brown') ) )
            return $input;
        else
            return '';
    }
}
add_action('customize_register', 'oxane_customize_register_skin');