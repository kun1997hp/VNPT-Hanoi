<?php
/**
 * @param $wp_customize
 *
 * Front Page Builder
 */
function oxane_customize_register_front_pagebuilder($wp_customize) {
    $wp_customize->add_panel('oxane_fpage_builder',
        array(
            'title' => __('Front Page Builder', 'oxane'),
            'priority' => 40,
        )
    );


    //Basic Settings
    $wp_customize->add_section('oxane_basic_settings_section',
        array(
            'title' => __('Basic Settings', 'oxane'),
            'priority' => 10,
            'panel' => 'oxane_fpage_builder',
        )
    );

    //Basic Setting Info
    $wp_customize->add_setting(
        'oxane_fpb',
        array( 'sanitize_callback' => 'esc_textarea' )
    );

    $wp_customize->add_control(
        new oxane_WP_Customize_Upgrade_Control(
            $wp_customize,
            'oxane_fpb',
            array(
                'label' => __('Note','oxane'),
                'description' => __('You need to set your homepage to a Static Front page in order to use any of these settings.','oxane'),
                'section' => 'oxane_basic_settings_section',
                'settings' => 'oxane_fpb',
            )
        )
    );

    $wp_customize->add_setting('oxane_page_title',
        array(
            'sanitize_callback' => 'oxane_sanitize_checkbox'
        ));
    $wp_customize->add_control('oxane_page_title',
        array(
            'setting' => 'oxane_page_title',
            'section' => 'oxane_basic_settings_section',
            'label' => __('Disable Page Title', 'oxane'),
            'description' => __('Default: Enabled. Check to Disable Page Title.', 'oxane'),
            'type' => 'checkbox'
        )
    );

    $wp_customize->add_setting('oxane_disable_comments',
        array(
            'sanitize_callback' => 'oxane_sanitize_checkbox'
        )
    );

    $wp_customize->add_control('oxane_disable_comments',
        array(
            'setting' => 'oxane_disable_comments',
            'section' => 'oxane_basic_settings_section',
            'label' => __('Enable Comments Box', 'oxane'),
            'description' => __('Comment Box will be enabled from your Static Page', 'oxane'),
            'type' => 'checkbox',
            'default' => false,
        )
    );


    //font size
    $font_size = array(
        '14px' => 'Default',
        'initial' => 'Initial',
        'small' => 'Small',
        'medium' => 'Medium',
        'large' => 'Large',
        'larger' => 'Larger',
        'x-large' => 'Extra Large',
    );

    $wp_customize->add_setting(
        'oxane_content_font_size', array(
            'default' => '14px',
            'sanitize_callback' => 'oxane_sanitize_fontsize'
        )
    );

    function oxane_sanitize_fontsize( $input ) {
        if ( in_array($input, array('14px','initial','small','medium','large','larger','x-large') ) )
            return $input;
        else
            return '';
    }



    $wp_customize->add_control(
        'oxane_content_font_size', array(
            'settings' => 'oxane_content_font_size',
            'label' => __( 'Content Font Size','oxane' ),
            'description' => __('Select Font Size. This is only for the content on Static Page area. Not for Blog Posts, Pages or Archives.', 'oxane'),
            'section'  => 'oxane_basic_settings_section',
            'type'     => 'select',
            'choices' => $font_size
        )
    );


    //HERO 1
    $wp_customize->add_section('oxane_hero1_section',
        array(
            'title' => __('HERO (Above Content)', 'oxane'),
            'priority' => 20,
            'panel' => 'oxane_fpage_builder',
        )
    );

    $wp_customize->add_setting('oxane_hero_enable',
        array(
            'sanitize_callback' => 'oxane_sanitize_checkbox'
        ));
    $wp_customize->add_control('oxane_hero_enable',
        array(
            'setting' => 'oxane_hero_enable',
            'section' => 'oxane_hero1_section',
            'label' => __('Enable HERO', 'oxane'),
            'type' => 'checkbox',
            'default' => false,
        )
    );

    $wp_customize->add_setting('oxane_hero_background_image',
        array(
            'sanitize_callback' => 'esc_url_raw',
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Image_Control(
            $wp_customize, 'oxane_hero_background_image',
            array (
                'setting' => 'oxane_hero_background_image',
                'section' => 'oxane_hero1_section',
                'label' => __('Background Image', 'oxane'),
                'description' => __('Upload an image to display in background of HERO', 'oxane'),
                'active_callback' => 'oxane_hero_active_callback'
            )
        )
    );

    $wp_customize->add_setting('oxane_hero1_selectpage',
        array(
            'sanitize_callback' => 'absint'
        )
    );

    $wp_customize->add_control('oxane_hero1_selectpage',
        array(
            'setting' => 'oxane_hero1_selectpage',
            'section' => 'oxane_hero1_section',
            'label' => __('Title', 'oxane'),
            'description' => __('Select a Page to display Title', 'oxane'),
            'type' => 'dropdown-pages',
            'active_callback' => 'oxane_hero_active_callback'
        )
    );


    $wp_customize->add_setting('oxane_hero1_full_content',
        array(
            'sanitize_callback' => 'oxane_sanitize_checkbox'
        )
    );

    $wp_customize->add_control('oxane_hero1_full_content',
        array(
            'setting' => 'oxane_hero1_full_content',
            'section' => 'oxane_hero1_section',
            'label' => __('Show Full Content insted of excerpt', 'oxane'),
            'type' => 'checkbox',
            'default' => false,
            'active_callback' => 'oxane_hero_active_callback'
        )
    );

    $wp_customize->add_setting('oxane_hero1_button',
        array(
            'sanitize_callback' => 'sanitize_text_field'
        )
    );

    $wp_customize->add_control('oxane_hero1_button',
        array(
            'setting' => 'oxane_hero1_button',
            'section' => 'oxane_hero1_section',
            'label' => __('Button Name', 'oxane'),
            'description' => __('Leave blank to disable Button.', 'oxane'),
            'type' => 'text',
            'active_callback' => 'oxane_hero_active_callback'
        )
    );

    function oxane_hero_active_callback( $control ) {
        $option = $control->manager->get_setting('oxane_hero_enable');
        return $option->value() == true;
    }

    //HERO 2
    $wp_customize->add_section('oxane_hero2_section',
        array(
            'title' => __('HERO (Below Content)', 'oxane'),
            'priority' => 25,
            'panel' => 'oxane_fpage_builder',
        )
    );

    $wp_customize->add_setting('oxane_hero_eta_enable',
        array(
            'sanitize_callback' => 'oxane_sanitize_checkbox'
        )
    );

    $wp_customize->add_control('oxane_hero_eta_enable',
        array(
            'setting' => 'oxane_hero_eta_enable',
            'section' => 'oxane_hero2_section',
            'label' => __('Enable HERO', 'oxane'),
            'type' => 'checkbox',
            'default' => false
        )
    );

    $wp_customize->add_setting('oxane_hero2_background_image',
        array(
            'sanitize_callback' => 'esc_url_raw',
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Image_Control(
            $wp_customize, 'oxane_hero2_background_image',
            array (
                'setting' => 'oxane_hero2_background_image',
                'section' => 'oxane_hero2_section',
                'label' => __('Background Image', 'oxane'),
                'description' => __('Upload an image to display in background of HERO', 'oxane'),
                'active_callback' => 'oxane_hero_eta_active_callback'
            )
        )
    );

    $wp_customize->add_setting('oxane_hero2_selectpage',
        array(
            'sanitize_callback' => 'absint'
        )
    );

    $wp_customize->add_control('oxane_hero2_selectpage',
        array(
            'setting' => 'oxane_hero2_selectpage',
            'section' => 'oxane_hero2_section',
            'label' => __('Title', 'oxane'),
            'description' => __('Select a Page to display Title', 'oxane'),
            'type' => 'dropdown-pages',
            'active_callback' => 'oxane_hero_eta_active_callback'
        )
    );

    $wp_customize->add_setting('oxane_hero2_full_content',
        array(
            'sanitize_callback' => 'oxane_sanitize_checkbox'
        )
    );

    $wp_customize->add_control('oxane_hero2_full_content',
        array(
            'setting' => 'oxane_hero2_full_content',
            'section' => 'oxane_hero2_section',
            'label' => __('Show Full Content instead of excerpt', 'oxane'),
            'type' => 'checkbox',
            'default' => false,
            'active_callback' => 'oxane_hero_eta_active_callback'
        )
    );

    $wp_customize->add_setting('oxane_hero2_button',
        array(
            'sanitize_callback' => 'sanitize_text_field'
        )
    );
    $wp_customize->add_control('oxane_hero2_button',
        array(
            'setting' => 'oxane_hero2_button',
            'section' => 'oxane_hero2_section',
            'label' => __('Button Name', 'oxane'),
            'description' => __('Leave blank to disable Button.', 'oxane'),
            'type' => 'text',
            'active_callback' => 'oxane_hero_eta_active_callback'
        )
    );

    function oxane_hero_eta_active_callback( $control ) {
        $option = $control->manager->get_setting('oxane_hero_eta_enable');
        return $option->value() == true;
    }
}
add_action('customize_register', 'oxane_customize_register_front_pagebuilder');