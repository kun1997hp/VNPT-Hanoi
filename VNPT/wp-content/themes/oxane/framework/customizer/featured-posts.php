<?php
function oxane_customize_register_featured_posts($wp_customize){
    //FEATURED POSTS

    $wp_customize->add_section(
        'oxane_postslider',
        array(
            'title'     => __('Featured Posts Slider','oxane'),
            'priority'  => 35,
        )
    );

    $wp_customize->add_setting(
        'oxane_postslider_enable',
        array( 'sanitize_callback' => 'oxane_sanitize_checkbox' )
    );

    $wp_customize->add_control(
        'oxane_postslider_enable', array(
            'settings' => 'oxane_postslider_enable',
            'label'    => __( 'Enable', 'oxane' ),
            'section'  => 'oxane_postslider',
            'type'     => 'checkbox',
        )
    );


    $wp_customize->add_setting(
        'oxane_postslider_title',
        array( 'sanitize_callback' => 'sanitize_text_field' )
    );

    $wp_customize->add_control(
        'oxane_postslider_title', array(
            'settings' => 'oxane_postslider_title',
            'label'    => __( 'Title', 'oxane' ),
            'section'  => 'oxane_postslider',
            'type'     => 'text',
        )
    );



    $wp_customize->add_setting(
        'oxane_postslider_cat',
        array( 'sanitize_callback' => 'oxane_sanitize_category' )
    );


    $wp_customize->add_control(
        new Oxane_WP_Customize_Category_Control(
            $wp_customize,
            'oxane_postslider_cat',
            array(
                'label'    => __('Category For Featured Posts Slider','oxane'),
                'settings' => 'oxane_postslider_cat',
                'section'  => 'oxane_postslider'
            )
        )
    );


    //FEATURED POSTS

    $wp_customize->add_section(
        'oxane_featposts',
        array(
            'title'     => __('Featured Posts','oxane'),
            'priority'  => 35,
        )
    );

    $wp_customize->add_setting(
        'oxane_featposts_enable',
        array( 'sanitize_callback' => 'oxane_sanitize_checkbox' )
    );

    $wp_customize->add_control(
        'oxane_featposts_enable', array(
            'settings' => 'oxane_featposts_enable',
            'label'    => __( 'Enable', 'oxane' ),
            'section'  => 'oxane_featposts',
            'type'     => 'checkbox',
        )
    );


    $wp_customize->add_setting(
        'oxane_featposts_title',
        array( 'sanitize_callback' => 'sanitize_text_field' )
    );

    $wp_customize->add_control(
        'oxane_featposts_title', array(
            'settings' => 'oxane_featposts_title',
            'label'    => __( 'Title', 'oxane' ),
            'section'  => 'oxane_featposts',
            'type'     => 'text',
        )
    );



    $wp_customize->add_setting(
        'oxane_featposts_cat',
        array( 'sanitize_callback' => 'oxane_sanitize_category' )
    );


    $wp_customize->add_control(
        new Oxane_WP_Customize_Category_Control(
            $wp_customize,
            'oxane_featposts_cat',
            array(
                'label'    => __('Category For Featured Posts','oxane'),
                'settings' => 'oxane_featposts_cat',
                'section'  => 'oxane_featposts'
            )
        )
    );

    $wp_customize->add_setting(
        'oxane_featposts_rows',
        array( 'sanitize_callback' => 'oxane_sanitize_positive_number' )
    );

    $wp_customize->add_control(
        'oxane_featposts_rows', array(
            'settings' => 'oxane_featposts_rows',
            'label'    => __( 'Max No. of Rows.', 'oxane' ),
            'section'  => 'oxane_featposts',
            'type'     => 'number',
            'default'  => '0'
        )
    );
}
add_action('customize_register', 'oxane_customize_register_featured_posts');