<?php
/**
 * oxane functions and definitions
 *
 * @package oxane
 */

//Function to Trim Excerpt Length & more..
function oxane_excerpt_length( $length ) {
	return 23;
}
add_filter( 'excerpt_length', 'oxane_excerpt_length', 999 );

function oxane_excerpt_more( $more ) {
	return '...';
}
add_filter( 'excerpt_more', 'oxane_excerpt_more' );



/**
 * Include the Custom Functions of the Theme.
 */
require get_template_directory() . '/framework/theme-functions.php';

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Implement the Custom CSS Mods.
 */
require get_template_directory() . '/inc/css-mods.php';


/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/framework/customizer/init.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';

/**
 * Recommened Slider plugins
 */
require get_template_directory() . '/framework/tgmpa.php';

