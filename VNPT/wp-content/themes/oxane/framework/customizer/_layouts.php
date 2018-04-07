<?php
function oxane_customize_register_design_layouts( $wp_customize ){
    // Layout and Design
    $wp_customize->add_panel( 'oxane_design_layouts_panel', array(
        'priority'       => 40,
        'title'          => __('Design & Layout','oxane'),
    ) );

    $wp_customize->add_section(
        'oxane_design_options',
        array(
            'title'     => __('Blog Layout','oxane'),
            'priority'  => 0,
            'panel'     => 'oxane_design_layouts_panel'
        )
    );


    $wp_customize->add_setting(
        'oxane_blog_layout',
        array( 'sanitize_callback' => 'oxane_sanitize_blog_layout' )
    );

    function oxane_sanitize_blog_layout( $input ) {
        if ( in_array($input, array('grid','grid_2_column','grid_3_column','oxane','date', 'blogger') ) )
            return $input;
        else
            return '';
    }

    $wp_customize->add_control(
        'oxane_blog_layout',array(
            'label' => __('Select Layout','oxane'),
            'settings' => 'oxane_blog_layout',
            'section'  => 'oxane_design_options',
            'type' => 'select',
            'choices' => array(
                'oxane' => __('Oxane Theme Layout','oxane'),
                'date' => __('Date Layout','oxane'),
                'blogger' => __('Blogger Layout','oxane'),
                'grid' => __('Basic Blog Layout','oxane'),
                'grid_2_column' => __('Grid - 2 Column','oxane'),
                'grid_3_column' => __('Grid - 3 Column','oxane'),

            )
        )
    );

    $wp_customize->add_section(
        'oxane_sidebar_options',
        array(
            'title'     => __('Sidebar Layout','oxane'),
            'priority'  => 0,
            'panel'     => 'oxane_design_layouts_panel'
        )
    );

    $wp_customize->add_setting(
        'oxane_disable_sidebar',
        array( 'sanitize_callback' => 'oxane_sanitize_checkbox' )
    );

    $wp_customize->add_control(
        'oxane_disable_sidebar', array(
            'settings' => 'oxane_disable_sidebar',
            'label'    => __( 'Disable Sidebar Everywhere.','oxane' ),
            'section'  => 'oxane_sidebar_options',
            'type'     => 'checkbox',
            'default'  => false
        )
    );

    $wp_customize->add_setting(
        'oxane_disable_sidebar_home',
        array( 'sanitize_callback' => 'oxane_sanitize_checkbox' )
    );

    $wp_customize->add_control(
        'oxane_disable_sidebar_home', array(
            'settings' => 'oxane_disable_sidebar_home',
            'label'    => __( 'Disable Sidebar on Home/Blog.','oxane' ),
            'section'  => 'oxane_sidebar_options',
            'type'     => 'checkbox',
            'active_callback' => 'oxane_show_sidebar_options',
            'default'  => false
        )
    );

    $wp_customize->add_setting(
        'oxane_disable_sidebar_front',
        array( 'sanitize_callback' => 'oxane_sanitize_checkbox' )
    );

    $wp_customize->add_control(
        'oxane_disable_sidebar_front', array(
            'settings' => 'oxane_disable_sidebar_front',
            'label'    => __( 'Disable Sidebar on Front Page.','oxane' ),
            'section'  => 'oxane_sidebar_options',
            'type'     => 'checkbox',
            'active_callback' => 'oxane_show_sidebar_options',
            'default'  => false
        )
    );


    $wp_customize->add_setting(
        'oxane_sidebar_width',
        array(
            'default' => 4,
            'sanitize_callback' => 'oxane_sanitize_positive_number' )
    );

    $wp_customize->add_control(
        'oxane_sidebar_width', array(
            'settings' => 'oxane_sidebar_width',
            'label'    => __( 'Sidebar Width','oxane' ),
            'description' => __('Min: 25%, Default: 33%, Max: 40%','oxane'),
            'section'  => 'oxane_sidebar_options',
            'type'     => 'range',
            'active_callback' => 'oxane_show_sidebar_options',
            'input_attrs' => array(
                'min'   => 3,
                'max'   => 5,
                'step'  => 1,
                'class' => 'sidebar-width-range',
                'style' => 'color: #0a0',
            ),
        )
    );

    /* Active Callback Function */
    function oxane_show_sidebar_options($control) {

        $option = $control->manager->get_setting('oxane_disable_sidebar');
        return $option->value() == false ;

    }

    $wp_customize-> add_section(
        'oxane_custom_footer',
        array(
            'title'			=> __('Custom Footer Text','oxane'),
            'description'	=> __('Enter your Own Copyright Text.','oxane'),
            'priority'		=> 11,
            'panel'			=> 'oxane_design_layouts_panel'
        )
    );

    $wp_customize->add_setting(
        'oxane_footer_text',
        array(
            'default'		=> '',
            'sanitize_callback'	=> 'sanitize_text_field'
        )
    );

    $wp_customize->add_control(
        'oxane_footer_text',
        array(
            'section' => 'oxane_custom_footer',
            'settings' => 'oxane_footer_text',
            'type' => 'text'
        )
    );
}
add_action('customize_register', 'oxane_customize_register_design_layouts');