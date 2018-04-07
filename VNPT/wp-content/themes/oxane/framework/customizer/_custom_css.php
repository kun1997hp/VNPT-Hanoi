<?php
function oxane_customize_register_custom_css($wp_customize){
    $wp_customize-> add_section(
        'oxane_custom_codes',
        array(
            'title'			=> __('Custom CSS','oxane'),
            'description'	=> __('Enter your Custom CSS to Modify design.','oxane'),
            'priority'		=> 11,
            'panel'			=> 'oxane_design_panel'
        )
    );

    $wp_customize->add_setting(
        'oxane_custom_css',
        array(
            'default'		=> '',
            'capability'           => 'edit_theme_options',
            'sanitize_callback'    => 'wp_filter_nohtml_kses',
            'sanitize_js_callback' => 'wp_filter_nohtml_kses'
        )
    );

    $wp_customize->add_control(
        new Oxane_Custom_CSS_Control(
            $wp_customize,
            'oxane_custom_css',
            array(
                'section' => 'oxane_custom_codes',
                'settings' => 'oxane_custom_css'
            )
        )
    );
}
add_action('customize_register', 'oxane_customize_register_custom_css');