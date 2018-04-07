<?php
function oxane_customize_register_social_icons($wp_customize){
    // Social Icons
    $wp_customize->add_section('oxane_social_section', array(
        'title' => __('Social Icons','oxane'),
        'priority' => 44,
    ));

    $social_icon_styles = array(
        'default' => __('Default', 'oxane'),
        'style1' => __('Style 1', 'oxane'),
        'style2' => __('Style 2', 'oxane'),
    );

    $wp_customize->add_setting('oxane_social_icon_style', array(
        'default' => 'default',
        'sanitize_callback' => 'oxane_sanitize_social_style'
    ) );

    function oxane_sanitize_social_style($input) {
        $social_icon_styles = array(
            'default',
            'style1',
            'style2',
        );
        if ( in_array($input, $social_icon_styles))
            return $input;
        else
            return '';
    }

    $wp_customize->add_control('oxane_social_icon_style', array(
            'setting' => 'oxane_social_icon_style',
            'section' => 'oxane_social_section',
            'label' => __('Social Icon Effects', 'oxane'),
            'type' => 'select',
            'choices' => $social_icon_styles,
        )
    );

    $social_networks = array( //Redefinied in Sanitization Function.
        'none' => __('-','oxane'),
        'facebook' => __('Facebook','oxane'),
        'twitter' => __('Twitter','oxane'),
        'google-plus' => __('Google Plus','oxane'),
        'instagram' => __('Instagram','oxane'),
        'rss' => __('RSS Feeds','oxane'),
        'vine' => __('Vine','oxane'),
        'vimeo-square' => __('Vimeo','oxane'),
        'youtube' => __('Youtube','oxane'),
        'flickr' => __('Flickr','oxane'),
    );

    $social_count = count($social_networks);

    for ($x = 1 ; $x <= ($social_count - 3) ; $x++) :

        $wp_customize->add_setting(
            'oxane_social_'.$x, array(
            'sanitize_callback' => 'oxane_sanitize_social',
            'default' => 'none'
        ));

        $wp_customize->add_control( 'oxane_social_'.$x, array(
            'settings' => 'oxane_social_'.$x,
            'label' => __('Icon ','oxane').$x,
            'section' => 'oxane_social_section',
            'type' => 'select',
            'choices' => $social_networks,
        ));

        $wp_customize->add_setting(
            'oxane_social_url'.$x, array(
            'sanitize_callback' => 'esc_url_raw'
        ));

        $wp_customize->add_control( 'oxane_social_url'.$x, array(
            'settings' => 'oxane_social_url'.$x,
            'description' => __('Icon ','oxane').$x.__(' Url','oxane'),
            'section' => 'oxane_social_section',
            'type' => 'url',
            'choices' => $social_networks,
        ));

    endfor;

    function oxane_sanitize_social( $input ) {
        $social_networks = array(
            'none' ,
            'facebook',
            'twitter',
            'google-plus',
            'instagram',
            'rss',
            'vine',
            'vimeo-square',
            'youtube',
            'flickr'
        );
        if ( in_array($input, $social_networks) )
            return $input;
        else
            return '';
    }
}
add_action('customize_register', 'oxane_customize_register_social_icons');