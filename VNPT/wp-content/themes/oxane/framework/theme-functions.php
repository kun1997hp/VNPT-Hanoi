<?php
/*
 * @package oxane, Copyright Rohit Tripathi, rohitink.com
 * This file contains Custom Theme Related Functions.
 */

//Import Admin Modules
require get_template_directory() . '/framework/admin_modules/register_styles.php';
require get_template_directory() . '/framework/admin_modules/register_widgets.php';
require get_template_directory() . '/framework/admin_modules/theme_setup.php';
require get_template_directory() . '/framework/admin_modules/nav_walkers.php';
require get_template_directory() . '/framework/admin_modules/admin_styles.php';
require get_template_directory() . '/framework/admin_modules/logo_compatibility.php';

/*
** Function to check if Sidebar is enabled on Current Page 
*/

function oxane_load_sidebar() {
	$load_sidebar = true;
	if ( get_theme_mod('oxane_disable_sidebar') ) :
		$load_sidebar = false;
	elseif( get_theme_mod('oxane_disable_sidebar_home') && is_home() )	:
		$load_sidebar = false;
	elseif( get_theme_mod('oxane_disable_sidebar_front') && is_front_page() ) :
		$load_sidebar = false;
	endif;
	
	return  $load_sidebar;
}

/*
**	Determining Sidebar and Primary Width
*/
function oxane_primary_class() {
	$sw = esc_html(get_theme_mod('oxane_sidebar_width',4));
	$class = "col-md-".(12-$sw);
	
	if ( !oxane_load_sidebar() ) 
		$class = "col-md-12";
	
	echo $class;
}
add_action('oxane_primary-width', 'oxane_primary_class');

function oxane_secondary_class() {
	$sw = esc_html(get_theme_mod('oxane_sidebar_width',4));
	$class = "col-md-".$sw;
	
	echo $class;
}
add_action('oxane_secondary-width', 'oxane_secondary_class');


/*
**	Helper Function to Convert Colors
*/
function oxane_hex2rgb($hex) {
   $hex = str_replace("#", "", $hex);
   if(strlen($hex) == 3) {
      $r = hexdec(substr($hex,0,1).substr($hex,0,1));
      $g = hexdec(substr($hex,1,1).substr($hex,1,1));
      $b = hexdec(substr($hex,2,1).substr($hex,2,1));
   } else {
      $r = hexdec(substr($hex,0,2));
      $g = hexdec(substr($hex,2,2));
      $b = hexdec(substr($hex,4,2));
   }
   $rgb = array($r, $g, $b);
   return implode(",", $rgb); // returns the rgb values separated by commas
   //return $rgb; // returns an array with the rgb values
}
function oxane_fade($color, $val) {
	return "rgba(".oxane_hex2rgb($color).",". $val.")";
}


/*
** Function to Get Theme Layout 
*/
function oxane_get_blog_layout(){
	$ldir = 'framework/layouts/content';
	if (get_theme_mod('oxane_blog_layout') ) :
		get_template_part( $ldir , get_theme_mod('oxane_blog_layout') );
	else :
		get_template_part( $ldir ,'oxane');	
	endif;	
}
add_action('oxane_blog_layout', 'oxane_get_blog_layout');

/*
** Function to Set Masonry Class 
*/
function oxane_set_masonry_class(){
	if ( get_theme_mod('oxane_blog_layout','oxane') != "oxane" ) :
		//DO NOTHING
	else :
		echo "masonry-main";	
	endif;	
}
add_action('oxane_masonry_class', 'oxane_set_masonry_class');

/*
** Load Custom Widgets
*/

require get_template_directory() . '/framework/widgets/recent-posts.php';


