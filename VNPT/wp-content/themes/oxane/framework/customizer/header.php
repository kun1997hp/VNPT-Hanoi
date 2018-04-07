<?php

function oxane_customize_register_header($wp_customize){
    //Logo Settings
    $wp_customize->add_section( 'title_tagline' , array(
        'title'      => __( 'Title, Tagline & Logo', 'oxane' ),
        'priority'   => 10,
    ) );


    $wp_customize->add_setting( 'oxane_logo_resize' , array(
        'default'     => 100,
        'sanitize_callback' => 'oxane_sanitize_positive_number',
    ) );
    $wp_customize->add_control(
        'oxane_logo_resize',
        array(
            'label' => __('Resize & Adjust Logo','oxane'),
            'section' => 'title_tagline',
            'settings' => 'oxane_logo_resize',
            'priority' => 6,
            'type' => 'range',
            'active_callback' => 'oxane_logo_enabled',
            'input_attrs' => array(
                'min'   => 30,
                'max'   => 200,
                'step'  => 5,
            ),
        )
    );

    function oxane_logo_enabled($control) {
        $option = $control->manager->get_setting('custom_logo');
        return $option->value() == true;
    }

    $wp_customize->add_panel('oxane_header_panel', array(
            'title' => __('Header Settings', 'oxane'),
            'priority' => 30,
        )
    );

    //Settings for Header Image
    $wp_customize->get_section('header_image')->panel = 'oxane_header_panel';

    $wp_customize->add_setting( 'oxane_himg_style' , array(
        'default'     => 'cover',
        'sanitize_callback' => 'oxane_sanitize_himg_style'
    ) );

    /* Sanitization Function */
    function oxane_sanitize_himg_style( $input ) {
        if (in_array( $input, array('contain','cover') ) )
            return $input;
        else
            return '';
    }

    $wp_customize->add_control(
        'oxane_himg_style', array(
        'label' => __('Header Image Arrangement','oxane'),
        'section' => 'header_image',
        'settings' => 'oxane_himg_style',
        'type' => 'select',
        'choices' => array(
            'contain' => __('Contain','oxane'),
            'cover' => __('Cover Completely (Recommended)','oxane'),
        )
    ) );

    $wp_customize->add_setting( 'oxane_himg_align' , array(
        'default'     => 'center',
        'sanitize_callback' => 'oxane_sanitize_himg_align'
    ) );

    /* Sanitization Function */
    function oxane_sanitize_himg_align( $input ) {
        if (in_array( $input, array('center','left','right') ) )
            return $input;
        else
            return '';
    }

    $wp_customize->add_control(
        'oxane_himg_align', array(
        'label' => __('Header Image Alignment','oxane'),
        'section' => 'header_image',
        'settings' => 'oxane_himg_align',
        'type' => 'select',
        'choices' => array(
            'center' => __('Center','oxane'),
            'left' => __('Left','oxane'),
            'right' => __('Right','oxane'),
        )
    ) );

    $wp_customize->add_setting( 'oxane_himg_repeat' , array(
        'default'     => true,
        'sanitize_callback' => 'oxane_sanitize_checkbox'
    ) );

    $wp_customize->add_control(
        'oxane_himg_repeat', array(
        'label' => __('Repeat Header Image','oxane'),
        'section' => 'header_image',
        'settings' => 'oxane_himg_repeat',
        'type' => 'checkbox',
    ) );


    //Settings For Logo Area

    $wp_customize->add_setting(
        'oxane_hide_title_tagline',
        array( 'sanitize_callback' => 'oxane_sanitize_checkbox' )
    );

    $wp_customize->add_control(
        'oxane_hide_title_tagline', array(
            'settings' => 'oxane_hide_title_tagline',
            'label'    => __( 'Hide Title and Tagline.', 'oxane' ),
            'section'  => 'title_tagline',
            'type'     => 'checkbox',
        )
    );

    $wp_customize->add_setting(
        'oxane_branding_below_logo',
        array( 'sanitize_callback' => 'oxane_sanitize_checkbox' )
    );

    $wp_customize->add_control(
        'oxane_branding_below_logo', array(
            'settings' => 'oxane_branding_below_logo',
            'label'    => __( 'Display Site Title and Tagline Below the Logo.', 'oxane' ),
            'section'  => 'title_tagline',
            'type'     => 'checkbox',
            'active_callback' => 'oxane_title_visible'
        )
    );

    function oxane_title_visible( $control ) {
        $option = $control->manager->get_setting('oxane_hide_title_tagline');
        return $option->value() == false ;
    }

    //Choices icons, menu, custom text
    $wp_customize->add_section('oxane_right_header_content_section', array(
        'title' => __('Right Header Content', 'oxane'),
        'priority' => 100,
        'panel' => 'oxane_header_panel',
    ));

    $wp_customize->add_setting('oxane_replace_search_bar', array(
        'sanitize_callback' => 'oxane_sanitize_checkbox',
    ));

    $wp_customize->add_control('oxane_replace_search_bar', array(
        'setting' => 'oxane_replace_search_bar',
        'section' => 'oxane_right_header_content_section',
        'label' => __('Replace Search Bar ', 'oxane'),
        'description' => __('You can Replace search bar with your custom short menu or contact text.', 'oxane'),
        'type' => 'checkbox',
        'default' => false
    ));

    $wp_customize->add_setting('oxane_short_menu', array(
        'default' => true,
        'sanitize_callback' => 'oxane_sanitize_checkbox',
    ));

    $wp_customize->add_control('oxane_short_menu', array(
        'setting' => 'oxane_short_menu',
        'section' => 'oxane_right_header_content_section',
        'label' => __('Enable Short Menu', 'oxane'),
        'description' => __('You can add a Short Menu here. Try to avoid menus which have more than 2 items.', 'oxane'),
        'type' => 'checkbox',
        'default' => false,
        'active_callback' => 'oxane_disable_search_bar',
    ));

    $wp_customize->add_setting('oxane_email_text', array(
        'default' => '',
        'sanitize_callback' => 'sanitize_text_field'
    ));

    $wp_customize->add_control('oxane_email_text', array(
        'setting' => 'oxane_email_text',
        'section' => 'oxane_right_header_content_section',
        'label' => __('Enter Your Email', 'oxane'),
        'description' => __('Enter email id to display.', 'oxane'),
        'type' => 'text',
        'active_callback' => 'oxane_disable_search_bar',
    ));

    $wp_customize->add_setting('oxane_mobile_text', array(
        'default' => '',
        'sanitize_callback' => 'sanitize_text_field'
    ));

    $wp_customize->add_control('oxane_mobile_text', array(
        'setting' => 'oxane_mobile_text',
        'section' => 'oxane_right_header_content_section',
        'label' => __('Enter Mobile/Phone Number', 'oxane'),
        'description' => __('Enter mobile number or phone number to display.', 'oxane'),
        'type' => 'text',
        'active_callback' => 'oxane_disable_search_bar',
    ));


    /* Active Callback Function */
    function oxane_disable_search_bar($control) {
        $option = $control->manager->get_setting('oxane_replace_search_bar');
        return $option->value() == true ;

    }

}
add_action('customize_register','oxane_customize_register_header');