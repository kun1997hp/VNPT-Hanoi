<?php
function oxane_customize_register_miscscripts($wp_customize){
    $wp_customize->add_section(
        'oxane_sec_upgrade',
        array(
            'title'     => __('Upgrade to Oxane Plus','oxane'),
            'priority'  => 45,
        )
    );

    $wp_customize->add_setting(
        'oxane_upgrade',
        array( 'sanitize_callback' => 'esc_textarea' )
    );

    $wp_customize->add_control(
        new Oxane_WP_Customize_Upgrade_Control(
            $wp_customize,
            'oxane_upgrade',
            array(
                'label' => __('Boost your Website with Oxane Plus','oxane'),
                'description' => __('Oxane Plus offers a lot of new features like unlimited colors, multiple layouts, more featured areas, custom pages, blog layouts, advanced slider, more sidebar options, full woocommerce support and so much more. <a href="https://inkhive.com/product/oxane-plus/">Upgrade Now!</a> about this theme.','oxane'),
                'section' => 'oxane_sec_upgrade',
                'settings' => 'oxane_upgrade',
            )
        )
    );
}
add_action('customize_register', 'oxane_customize_register_miscscripts');