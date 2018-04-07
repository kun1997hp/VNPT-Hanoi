<?php
/**
 * Plugin Name: Quản lý Website VNPT // Tên của plugin
 * Plugin URI: http://facebook.com/giang.bui.376 // Địa chỉ trang chủ của plugin
 * Description: Đây là plugin đầu tiên mà tôi viết dành riêng cho WP // Phần mô tả cho plugin
 * Version: 1.0 // Đây là phiên bản đầu tiên của plugin
 * Author: Giang Bui // Tên tác giả, người thực hiện plugin này
 * Author URI: http://facebook.com/giang.bui.376 // Địa chỉ trang chủ của tác giả
 * License: GPLv2 or later // Thông tin license của plugin, nếu không quan tâm thì bạn cứ để GPLv2 vào đây
 */

/*
if(!class_exists('My_First_Plugin_Demo')) {//Kiểm tra xem Class đã tồn tại hay chưa
        class My_First_Plugin_Demo {// Tạo một class mới với tên là tên của plugin
                function __construct() {
                        if(!function_exists('add_shortcode')) {
                                return;
                        }
                        add_shortcode( 'hello' , array(&$this, 'hello_func') );// Tạo shortcode với tên là Hello
                }
 
                function hello_func($atts = array(), $content = null) {// Hàm hello_func sử dụng cho Shortcode Hello 
                        extract(shortcode_atts(array('name' => 'World'), $atts));// bung các biến tùy chọn của  Shortcode
                        return '<div><p>Hello '.$name.'!!!</p></div>';// giá trị trả về của Shortcode 
                }
        }
}
function mfpd_load() {// Hàm load shortcode
        global $mfpd;
        $mfpd = new My_First_Plugin_Demo();// Khởi tạo 1 biến với giá trị là 1 MFPD
}
add_action( 'plugins_loaded', 'mfpd_load' ); // Dùng action chạy hàm  khởi tạo biến  $mfpd  khi plugin được tải
?>
<?php
function register_mysettings() {
        register_setting( 'mfpd-settings-group', 'mfpd_option_name' );
}
 
function mfpd_create_menu() {
        add_menu_page('My First Plugin Settings', 'MFPD Settings', 'administrator', __FILE__, 'mfpd_settings_page',plugins_url('/images/icon.png', __FILE__), 1);
        add_action( 'admin_init', 'register_mysettings' );
}
add_action('admin_menu', 'mfpd_create_menu'); 
 
function mfpd_settings_page() {
?>
<div class="wrap">
<h2>Tạo trang cài đặt cho plugin</h2>
<?php if( isset($_GET['settings-updated']) ) { ?>
    <div id="message" class="updated">
        <p><strong><?php _e('Settings saved.') ?></strong></p>
    </div>
<?php } ?>
<form method="post" action="options.php">
    <?php settings_fields( 'mfpd-settings-group' ); ?>
    <table class="form-table">
        <tr valign="top">
        <th scope="row">Tùy chọn cài đặt</th>
        <td><input type="text" name="mfpd_option_name" value="<?php echo get_option('mfpd_option_name'); ?>" /></td>
        </tr>
    </table>
    <?php submit_button(); ?>
</form>
</div>
<?php }

?>*/
//khai báo các biến version
global $table_loaidv_version;
$table_loaidv_version = '1.0';
global $table_dichvu_version;
$table_dichvu_version = '1.0';
global $table_dangky_version;
$table_dangky_version = '1.0';
//global $table_khachhang_version;
//$table_khachhang_version = '1.0';
global $table_khuvuc_version;
$table_khuvuc_version = '1.0';
global $table_dangky_dichvu_version;
$table_dangky_dichvu_version = '1.0';
function create_table()
{
	global $wpdb;
	//$table_loaidv= $wpdb->prefix ."loaidv";
	//$table_dichvu= $wpdb->prefix ."dichvu";
	$table_dangky= $wpdb->prefix ."dangky";
	//$table_khachhang= $wpdb->prefix ."khachhang";
	$table_khuvuc= $wpdb->prefix ."khuvuc";
	$table_dangky_dichvu= $wpdb->prefix ."dangky_dichvu";
	$charset_collate = $wpdb->get_charset_collate();//set kiểu kí tự
	//tạo bảng loại dịch vụ
	/*if ($wpdb->get_var("SHOW TABLES LIKE ".$table_loaidv) !=$table_loaidv)
	{
		$sql="CREATE TABLE ".$table_loaidv."(
			id_loaidv INTEGER(11) UNSIGNED AUTO_INCREMENT,
			name_loaidv VARCHAR(255) NOT NULL,
			describe_loaidv VARCHAR(1000) NULL,
			PRIMARY KEY (id_loaidv)
		)".$charset_collate.";";
		require_once(ABSPATH.'wp-admin/includes/upgrade.php' );
		dbDelta( $sql );
		add_option('table_loaidv_version',$table_loaidv_version);
	}


	//tạo bảng dịch vụ
	if ($wpdb->get_var("SHOW TABLES LIKE ".$table_dichvu) !=$table_dichvu)
	{
		$sql="CREATE TABLE ".$table_dichvu."(
			id_dv INTEGER(11) UNSIGNED AUTO_INCREMENT,
			id_loaidv INTEGER(11) NOT NULL,
			name_dv VARCHAR(255) NOT NULL,
			describe_dv VARCHAR(1000) NULL,
			PRIMARY KEY (id_dv)
		)".$charset_collate.";";
		require_once(ABSPATH.'wp-admin/includes/upgrade.php' );
		dbDelta( $sql );
		add_option('table_dichvu_version',$table_dichvu_version);
	}

*/
	//tạo bảng đăng ký
	if ($wpdb->get_var("SHOW TABLES LIKE ".$table_dangky) !=$table_dangky)
	{
		$sql="CREATE TABLE ".$table_dangky."(
			id_dk INTEGER(11) UNSIGNED AUTO_INCREMENT,
			name_kh VARCHAR(255) NOT NULL,
			address_kh VARCHAR(255) NOT NULL,
			id_kv INTEGER(11) NOT NULL,
			phone_kh VARCHAR(255) NOT NULL,
			email_kh VARCHAR(255) NOT NULL,
			note VARCHAR(1000) NULL,
			date_created DATE NOT NULL,
			status VARCHAR(30) NOT NULL,
			PRIMARY KEY (id_dk)
		)".$charset_collate.";";
		require_once(ABSPATH.'wp-admin/includes/upgrade.php' );
		dbDelta( $sql );
		add_option('table_dangky_version',$table_dangky_version);
	}


	//tạo bảng khách hàng
	/*
	if ($wpdb->get_var("SHOW TABLES LIKE ".$table_khachhang) !=$table_khachhang)
	{
		$sql="CREATE TABLE ".$table_khachhang."(
			id_kh INTEGER(11) UNSIGNED AUTO_INCREMENT,
			name_kh VARCHAR(255) NOT NULL,
			address_kh VARCHAR(255) NOT NULL,
			id_kv INTEGER(11) NOT NULL,
			phone_kh VARCHAR(255) NOT NULL,
			email_kh VARCHAR(255) NOT NULL,
			PRIMARY KEY (id_kh)
		)".$charset_collate.";";
		require_once(ABSPATH.'wp-admin/includes/upgrade.php' );
		dbDelta( $sql );
		add_option('table_khachhang_version',$table_khachhang_version);
	}
	*/


	//tạo bảng khu vực
	if ($wpdb->get_var("SHOW TABLES LIKE ".$table_khuvuc) !=$table_khuvuc)
	{
		$sql="CREATE TABLE ".$table_khuvuc."(
			id_kv INTEGER(11) UNSIGNED AUTO_INCREMENT,
			name_kv VARCHAR(255) NOT NULL,
			PRIMARY KEY (id_kv)
		)".$charset_collate.";";
		require_once(ABSPATH.'wp-admin/includes/upgrade.php' );
		dbDelta( $sql );
		add_option('table_khuvuc_version',$table_khuvuc_version);
	}

	//tạo bảng đăng ký _ dịch vụ
	if ($wpdb->get_var("SHOW TABLES LIKE ".$table_dangky_dichvu) !=$table_dangky_dichvu)
	{
		$sql="CREATE TABLE ".$table_dangky_dichvu."(
			id_dk INTEGER(11) NOT NULL,
			id_dv INTEGER(11) NOT NULL,
			PRIMARY KEY (id_dk,id_dv)
		)".$charset_collate.";";
		require_once(ABSPATH.'wp-admin/includes/upgrade.php' );
		dbDelta( $sql );
		add_option('table_dangky_dichvu_version',$table_dangky_dichvu_version);
	}

	//thêm dữ liệu vào bảng loại dịch vụ
	//
	/*
	$wpdb->insert( 
		$table_loaidv, 
		array( 
			'name_loaidv' =>"Điện thoại cố định",
		) 
	);
	$wpdb->insert( 
		$table_loaidv, 
		array( 
			'name_loaidv' =>"MegaVNN",
		) 
	);
	$wpdb->insert( 
		$table_loaidv, 
		array( 
			'name_loaidv' =>"FiberVNN",
		) 
	);
	$wpdb->insert( 
		$table_loaidv, 
		array( 
			'name_loaidv' =>"MyTV",
		) 
	);

	//thêm dữ liệu vào bằng dịch vụ 
	$wpdb->insert( 
		$table_dichvu, 
		array( 
			'id_loaidv' => "1",
			'name_dv' =>"Điện thoại cố định",
		) 
	);

	$wpdb->insert( 
		$table_dichvu, 
		array( 
			'id_loaidv' => "2",
			'name_dv' =>"Mega Basic",
		) 
	);

	$wpdb->insert( 
		$table_dichvu, 
		array( 
			'id_loaidv' => "2",
			'name_dv' =>"Mega Basic+",
		) 
	);

	$wpdb->insert( 
		$table_dichvu, 
		array( 
			'id_loaidv' => "2",
			'name_dv' =>"Mega Easy+",
		) 
	);

	$wpdb->insert( 
		$table_dichvu, 
		array( 
			'id_loaidv' => "2",
			'name_dv' =>"Mega Family+",
		) 
	);

	$wpdb->insert( 
		$table_dichvu, 
		array( 
			'id_loaidv' => "2",
			'name_dv' =>"Mega Office",
		) 
	);

	$wpdb->insert( 
		$table_dichvu, 
		array( 
			'id_loaidv' => "3",
			'name_dv' =>"Fiber 16",
		) 
	);

	$wpdb->insert( 
		$table_dichvu, 
		array( 
			'id_loaidv' => "3",
			'name_dv' =>"Fiber 20",
		) 
	);

	$wpdb->insert( 
		$table_dichvu, 
		array( 
			'id_loaidv' => "3",
			'name_dv' =>"Fiber 26Eco",
		) 
	);

	$wpdb->insert( 
		$table_dichvu, 
		array( 
			'id_loaidv' => "3",
			'name_dv' =>"Fiber 30",
		) 
	);

	$wpdb->insert( 
		$table_dichvu, 
		array( 
			'id_loaidv' => "3",
			'name_dv' =>"Fiber 40",
		) 
	);

	$wpdb->insert( 
		$table_dichvu, 
		array( 
			'id_loaidv' => "3",
			'name_dv' =>"FiberNET",
		) 
	);

	$wpdb->insert( 
		$table_dichvu, 
		array( 
			'id_loaidv' => "4",
			'name_dv' =>"MyTV Silver",
		) 
	);

	$wpdb->insert( 
		$table_dichvu, 
		array( 
			'id_loaidv' => "4",
			'name_dv' =>"MyTV Silver HD",
		) 
	);

	$wpdb->insert( 
		$table_dichvu, 
		array( 
			'id_loaidv' => "4",
			'name_dv' =>"MyTV Gold",
		) 
	);

	$wpdb->insert( 
		$table_dichvu, 
		array( 
			'id_loaidv' => "4",
			'name_dv' =>"MyTV Gold HD",
		) 
	);

*/
	$wpdb->insert( 
		$table_khuvuc, 
		array( 
			'name_kv' =>"Quận Ba Đình",
		) 
	);
	$wpdb->insert( 
		$table_khuvuc, 
		array( 
			'name_kv' =>"Quận Hoàn Kiếm",
		) 
	);
	$wpdb->insert( 
		$table_khuvuc, 
		array( 
			'name_kv' =>"Quận Hai Bà Trưng",
		) 
	);
	$wpdb->insert( 
		$table_khuvuc, 
		array( 
			'name_kv' =>"Quận Đống Đa",
		) 
	);
	$wpdb->insert( 
		$table_khuvuc, 
		array( 
			'name_kv' =>"Quận Tây Hồ",
		) 
	);
	$wpdb->insert( 
		$table_khuvuc, 
		array( 
			'name_kv' =>"Quận Cầu Giấy",
		) 
	);
	$wpdb->insert( 
		$table_khuvuc, 
		array( 
			'name_kv' =>"Quận Thanh Xuân",
		) 
	);
	$wpdb->insert( 
		$table_khuvuc, 
		array( 
			'name_kv' =>"Quận Hoàng Mai",
		) 
	);
	$wpdb->insert( 
		$table_khuvuc, 
		array( 
			'name_kv' =>"Quận Long Biên",
		) 
	);
	$wpdb->insert( 
		$table_khuvuc, 
		array( 
			'name_kv' =>"Quận Hà Đông",
		) 
	);
	$wpdb->insert( 
		$table_khuvuc, 
		array( 
			'name_kv' =>"Thị Xã Sơn Tây",
		) 
	);
}
	/*
	$wpdb->insert( 
		$table_khuvuc, 
		array( 
			'name_kv' =>"Huyện Từ Liêm",
		) 
	);
	$wpdb->insert( 
		$table_khuvuc, 
		array( 
			'name_kv' =>"Huyện Thanh Trì",
		) 
	);
	$wpdb->insert( 
		$table_khuvuc, 
		array( 
			'name_kv' =>"Huyện Gia Lâm",
		) 
	);
	$wpdb->insert( 
		$table_khuvuc, 
		array( 
			'name_kv' =>"Huyện Đông Anh",
		) 
	);
	$wpdb->insert( 
		$table_khuvuc, 
		array( 
			'name_kv' =>"Huyện Sóc Sơn",
		) 
	);
	$wpdb->insert( 
		$table_khuvuc, 
		array( 
			'name_kv' =>"Huyện Ba Vì",
		) 
	);
	$wpdb->insert( 
		$table_khuvuc, 
		array( 
			'name_kv' =>"Huyện Phúc Thọ",
		) 
	);
	$wpdb->insert( 
		$table_khuvuc, 
		array( 
			'name_kv' =>"Huyện Thạch Thất",
		) 
	);
	$wpdb->insert( 
		$table_khuvuc, 
		array( 
			'name_kv' =>"Huyện Quốc Oai",
		) 
	);
	$wpdb->insert( 
		$table_khuvuc, 
		array( 
			'name_kv' =>"Huyện Chương Mỹ",
		) 
	);
	$wpdb->insert( 
		$table_khuvuc, 
		array( 
			'name_kv' =>"Huyện Đan Phượng",
		) 
	);
	$wpdb->insert( 
		$table_khuvuc, 
		array( 
			'name_kv' =>"Huyện Hoài Đức",
		) 
	);
	$wpdb->insert( 
		$table_khuvuc, 
		array( 
			'name_kv' =>"Huyện Thanh Oai",
		) 
	);
	$wpdb->insert( 
		$table_khuvuc, 
		array( 
			'name_kv' =>"Huyện Mỹ Đức",
		) 
	);
	$wpdb->insert( 
		$table_khuvuc, 
		array( 
			'name_kv' =>"Huyện Ứng Hoà",
		) 
	);
	$wpdb->insert( 
		$table_khuvuc, 
		array( 
			'name_kv' =>"Huyện Thường Tín",
		) 
	);
	$wpdb->insert( 
		$table_khuvuc, 
		array( 
			'name_kv' =>"Huyện Phú Xuyên",
		) 
	);
	$wpdb->insert( 
		$table_khuvuc, 
		array( 
			'name_kv' =>"Huyện Mê Linh",
		) 
	);
	*/

function delete_table()
{
	global $wpdb;
	//$table_loaidv= $wpdb->prefix ."loaidv";
	//$table_dichvu= $wpdb->prefix ."dichvu";
	$table_khuvuc= $wpdb->prefix ."khuvuc";
	//$table_khachhang= $wpdb->prefix ."khachhang";
	$table_dangky= $wpdb->prefix ."dangky";
	$table_dangky_dichvu= $wpdb->prefix ."dangky_dichvu";

	//$wpdb->query ("DROP TABLE IF EXISTS ".$table_loaidv);
	//$wpdb->query ("DROP TABLE IF EXISTS ".$table_dichvu);
	$wpdb->query ("DROP TABLE IF EXISTS ".$table_khuvuc);
	//$wpdb->query ("DROP TABLE IF EXISTS ".$table_khachhang);
	//$wpdb->query ("DROP TABLE IF EXISTS ".$table_dangky);
	//$wpdb->query ("DROP TABLE IF EXISTS ".$table_dangky_dichvu);
}

register_activation_hook(__FILE__,'create_table');
register_deactivation_hook(__FILE__,'delete_table');