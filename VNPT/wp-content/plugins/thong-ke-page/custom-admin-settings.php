<?php
/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the
 * plugin admin area. This file also defines a function that starts the plugin.
 *
 * @link              http://code.tutsplus.com/tutorials/creating-custom-admin-pages-in-wordpress-1
 * @since             1.0.0
 * @package           Custom_Admin_Settings
 *
 * @wordpress-plugin
 * Plugin Name:       Plugin thống kê
 * Plugin URI:        http://code.tutsplus.com/tutorials/creating-custom-admin-pages-in-wordpress-1
 * Description:       Demonstrates how to write custom administration pages in WordPress.
 * Version:           1.0.0
 * Author:            Giang Bùi
 * Author URI:        https://facebook.com/giang.bui.376
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 */
?>
<?php
 
// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
     die;
}
 
// Include the dependencies needed to instantiate the plugin.
foreach ( glob( plugin_dir_path( __FILE__ ) . 'admin/*.php' ) as $file ) {
    include_once $file;
}


 
// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
    die;
}

class Test_Options {
 
    function __construct() {
        add_action( 'admin_menu', array( $this, 'add_plugin_settings_menu' ) );
        add_action( 'admin_init', array( $this, 'register_settings' ) );
    }
 
    function add_plugin_settings_menu() {
        // add_options_page( $page_title, $menu_title, $capability, $menu_slug, $function )
        add_options_page( 'Trang Thống Kê', 'Trang Thống Kê', 'manage_options', 'test-plugin', array(
            $this,
            'create_plugin_settings_page'
        ) );
    }
 
    function create_plugin_settings_page() {
        ?>
        <div class="wrap">
            <h1><?php echo esc_html( get_admin_page_title() );?></h1>        
            <?php include('views.php'); ?>
        </div>
        <?php
    }
 
    function register_settings() {
 
        // add_settings_section( $id, $title, $callback, $page )
        add_settings_section(
            'main-settings-section',
            'Main Settings',
            array( $this, 'print_main_settings_section_info' ),
            'test-plugin-main-settings-section'
        );
 
        // add_settings_field( $id, $title, $callback, $page, $section, $args )
        add_settings_field(
            'some-setting',
            'Some Setting',
            array( $this, 'create_input_some_setting' ),
            'test-plugin-main-settings-section',
            'main-settings-section'
        );
 
        // register_setting( $option_group, $option_name, $sanitize_callback )
        register_setting( 'main-settings-group', 'test_plugin_main_settings_arraykey', array(
            $this,
            'plugin_main_settings_validate'
        ) );
    }
 
    function print_main_settings_section_info() {
        echo '<p>Main Settings Description.</p>';
    }
 
    function create_input_some_setting() {
        $options = get_option( 'test_plugin_main_settings_arraykey' );
        ?><input type="text" name="test_plugin_main_settings_arraykey[some-setting]"
                 value="<?php echo $options['some-setting']; ?>" /><?php
    }
 
    function plugin_main_settings_validate( $arr_input ) {
        $options                 = get_option( 'test_plugin_main_settings_arraykey' );
        $options['some-setting'] = trim( $arr_input['some-setting'] );
 
        return $options;
    }
 
}
 
new Test_Options();