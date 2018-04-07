<?php
/*
    Our portfolio:  http://themeforest.net/user/tagDiv/portfolio
    Thanks for using our theme!
    tagDiv - 2017
*/


/**
 * Load the speed booster framework + theme specific files
 */

// load the deploy mode
require_once('td_deploy_mode.php');

// load the config
require_once('includes/td_config.php');
add_action('td_global_after', array('td_config', 'on_td_global_after_config'), 9); //we run on 9 priority to allow plugins to updage_key our apis while using the default priority of 10


// load the wp booster
require_once('includes/wp_booster/td_wp_booster_functions.php');


require_once('includes/td_css_generator.php');
require_once('includes/shortcodes/td_misc_shortcodes.php');
require_once('includes/widgets/td_page_builder_widgets.php'); // widgets


/*
 * mobile theme css generator
 * in wp-admin the main theme is loaded and the mobile theme functions are not included
 * required in td_panel_data_source
 * @todo - look for a more elegant solution(ex. generate the css on request)
 */
require_once('mobile/includes/td_css_generator_mob.php');


/* ----------------------------------------------------------------------------
 * Woo Commerce
 */

// breadcrumb
add_filter('woocommerce_breadcrumb_defaults', 'td_woocommerce_breadcrumbs');
function td_woocommerce_breadcrumbs() {
	return array(
		'delimiter' => ' <i class="td-icon-right td-bread-sep"></i> ',
		'wrap_before' => '<div class="entry-crumbs" itemprop="breadcrumb">',
		'wrap_after' => '</div>',
		'before' => '',
		'after' => '',
		'home' => _x('Home', 'breadcrumb', 'woocommerce'),
	);
}

// use own pagination
if (!function_exists('woocommerce_pagination')) {
	// pagination
	function woocommerce_pagination() {
		echo td_page_generator::get_pagination();
	}
}

// Override theme default specification for product 3 per row


// Number of product per page 8
add_filter('loop_shop_per_page', create_function('$cols', 'return 4;'));

if (!function_exists('woocommerce_output_related_products')) {
	// Number of related products
	function woocommerce_output_related_products() {
		woocommerce_related_products(array(
			'posts_per_page' => 4,
			'columns' => 4,
			'orderby' => 'rand',
		)); // Display 4 products in rows of 1
	}
}




/* ----------------------------------------------------------------------------
 * bbPress
 */
// change avatar size to 40px
function td_bbp_change_avatar_size($author_avatar, $topic_id, $size) {
	$author_avatar = '';
	if ($size == 14) {
		$size = 40;
	}
	$topic_id = bbp_get_topic_id( $topic_id );
	if ( !empty( $topic_id ) ) {
		if ( !bbp_is_topic_anonymous( $topic_id ) ) {
			$author_avatar = get_avatar( bbp_get_topic_author_id( $topic_id ), $size );
		} else {
			$author_avatar = get_avatar( get_post_meta( $topic_id, '_bbp_anonymous_email', true ), $size );
		}
	}
	return $author_avatar;
}
add_filter('bbp_get_topic_author_avatar', 'td_bbp_change_avatar_size', 20, 3);
add_filter('bbp_get_reply_author_avatar', 'td_bbp_change_avatar_size', 20, 3);
add_filter('bbp_get_current_user_avatar', 'td_bbp_change_avatar_size', 20, 3);



//add_action('shutdown', 'test_td');

function test_td () {
    if (!is_admin()){
        td_api_base::_debug_get_used_on_page_components();
    }

}


/**
 * tdStyleCustomizer.js is required
 */
if (TD_DEBUG_LIVE_THEME_STYLE) {
    add_action('wp_footer', 'td_theme_style_footer');
		// new live theme demos
	    function td_theme_style_footer() {
			    ?>
			    <div id="td-theme-settings" class="td-live-theme-demos td-theme-settings-small">
				    <div class="td-skin-body">
					    <div class="td-skin-wrap">
						    <div class="td-skin-container td-skin-buy"><a target="_blank" href="http://themeforest.net/item/newspaper/5489609?ref=tagdiv">BUY NEWSPAPER NOW!</a></div>
						    <div class="td-skin-container td-skin-header">GET AN AWESOME START!</div>
						    <div class="td-skin-container td-skin-desc">With easy <span>ONE CLICK INSTALL</span> and fully customizable options, our demos are the best start you'll ever get!!</div>
						    <div class="td-skin-container td-skin-content">
							    <div class="td-demos-list">
								    <?php
								    $td_demo_names = array();

								    foreach (td_global::$demo_list as $demo_id => $stack_params) {
									    $td_demo_names[$stack_params['text']] = $demo_id;
									    ?>
									    <div class="td-set-theme-style"><a href="<?php echo td_global::$demo_list[$demo_id]['demo_url'] ?>" class="td-set-theme-style-link td-popup td-popup-<?php echo $td_demo_names[$stack_params['text']] ?>" data-img-url="http://demo.tagdiv.com/demos_popup/newspaper/large/<?php echo $demo_id; ?>.jpg"></a></div>
								    <?php } ?>
									<div class="td-set-theme-style-empty"><a href="#" class="td-popup td-popup-empty1"></a></div>
								    <div class="clearfix"></div>
							    </div>
						    </div>
						    <div class="td-skin-scroll"><i class="td-icon-read-down"></i></div>
					    </div>
				    </div>
				    <div class="clearfix"></div>
				    <div class="td-set-hide-show"><a href="#" id="td-theme-set-hide"></a></div>
				    <div class="td-screen-demo" data-width-preview="380"></div>
				    <div class="td-screen-demo-extend"></div>
			    </div>
			    <?php
	    }

}
			


//print_r(td_global::$all_theme_panels_list);
///* Đăng ký script có trong theme. */
	add_action( 'wp_enqueue_scripts', 'theme_register_scripts', 1 );
	function theme_register_scripts() {
		/* Đăng ký file script sẽ có trong theme */
		wp_register_script( 'functions-js',esc_url( trailingslashit( get_template_directory_uri() ) . 'functions.js'), array( 'jquery' ), '1.0', true );

		/* Localize Scripts - Phần này hiểu đơn giản là lấy giá trị script từ PHP */
		$php_array = array( 
			'language' => get_bloginfo( 'language' ), 
			'URLhome' => get_bloginfo( 'home' ) 
		);
		wp_localize_script( 'functions-js', 'php_array', $php_array );

	}
	/** Gọi file script. */
	add_action( 'wp_enqueue_scripts', 'theme_enqueue_scripts' );
	function theme_enqueue_scripts() {
		/* Gọi file script đã đăng ký ở trên */
		wp_enqueue_script( 'functions-js' );
	}
	add_action( 'wp_ajax_thongbao', 'thongbao_init' );
	add_action( 'wp_ajax_nopriv_thongbao', 'thongbao_init' );
	function thongbao_init() 
	{

    //do bên js để dạng json nên giá trị trả về dùng phải encode


		$id_loaidv = (isset($_POST['id_loaidv']))?esc_attr($_POST['id_loaidv']) : '';

		$link=mysqli_connect('localhost','root','','vnpt') or die("Không thể kết nối");
		mysqli_set_charset($link, 'UTF8');
		$sql="SELECT * FROM wp_dichvu where id_loaidv='".$id_loaidv."'";
		$result=mysqli_query($link,$sql);
		$chuoihtml="<select name='id_dv'>";
		while($row=mysqli_fetch_assoc($result)){
			$chuoihtml.="<option value='";
			$chuoihtml.= $row['id_dv'];	
			$chuoihtml.= "'>";
			$chuoihtml.= $row['name_dv'];
			$chuoihtml.="</option>";
		}
		$chuoihtml.="</select>";

		wp_send_json_success($chuoihtml);
	}
	add_action( 'wp_ajax_duyet', 'duyet_init' );
	function duyet_init(){
		$id_dk = (isset($_POST['id_dk']))?esc_attr($_POST['id_dk']) : '';
		$link=mysqli_connect('localhost','root','','vnpt') or die("Không thể kết nối");
		mysqli_set_charset($link, 'UTF8');
		$sql="UPDATE wp_dangky set status='Đợi lắp đặt' where id_dk='".$id_dk."'";
		$result=mysqli_query($link,$sql);
		$sql="SELECT * from wp_dangky where id_dk='".$id_dk."'";
		$result=mysqli_query($link,$sql);
		$row=mysqli_fetch_array($result);
		$to = $row['email_kh'];
        $subject = 'Thay Đổi Trạng Thái Đăng Ký';
        $body = "Đăng ký của khách hàng ".$row['name_kh']." đã chuyển trạng thái sang 'Đợi lắp đặt'";
        $headers = array('Content-Type: text/html; charset=UTF-8','From: My Site Name &lt;support@example.com');
		wp_mail( $to, $subject, $body, $headers );
	}
	add_action( 'wp_ajax_cancel', 'cancel_init' );
	function cancel_init(){
		$id_dk = (isset($_POST['id_dk']))?esc_attr($_POST['id_dk']) : '';
		$link=mysqli_connect('localhost','root','','vnpt') or die("Không thể kết nối");
		mysqli_set_charset($link, 'UTF8');
		$sql="UPDATE wp_dangky set status='Bị từ chối' where id_dk='".$id_dk."'";
		$result=mysqli_query($link,$sql);
		$sql="SELECT * from wp_dangky where id_dk='".$id_dk."'";
		$result=mysqli_query($link,$sql);
		$row=mysqli_fetch_array($result);
		$to = $row['email_kh'];
        $subject = 'Thay Đổi Trạng Thái Đăng Ký';
        $body = "Đăng ký của khách hàng ".$row['name_kh']." đã chuyển trạng thái sang 'Bị từ chối'";
        $headers = array('Content-Type: text/html; charset=UTF-8','From: My Site Name &lt;support@example.com');
		wp_mail( $to, $subject, $body, $headers );
	}
	add_action( 'wp_ajax_delete', 'delete_init' );
	function delete_init(){
		$id_dk = (isset($_POST['id_dk']))?esc_attr($_POST['id_dk']) : '';
		$link=mysqli_connect('localhost','root','','vnpt') or die("Không thể kết nối");
		mysqli_set_charset($link, 'UTF8');
		$sql="UPDATE wp_dangky set status='Hoàn thành' where id_dk='".$id_dk."'";
		$result=mysqli_query($link,$sql);
		$sql="SELECT * from wp_dangky where id_dk='".$id_dk."'";
		$result=mysqli_query($link,$sql);
		$row=mysqli_fetch_array($result);
		$to = $row['email_kh'];
        $subject = 'Thay Đổi Trạng Thái Đăng Ký';
        $body = "Đăng ký của khách hàng ".$row['name_kh']." đã chuyển trạng thái sang 'Hoàn Thành'";
        $headers = array('Content-Type: text/html; charset=UTF-8','From: My Site Name &lt;support@example.com');
		wp_mail( $to, $subject, $body, $headers );
	}
	add_action( 'wp_ajax_checkdk', 'checkdk_init' );
	function checkdk_init(){
		$info_dk = (isset($_POST['info_dk']))?esc_attr($_POST['info_dk']) : '';
		$output="<?php include('";
		$output.=$info_dk;
		$output.="'); ?>";
		wp_send_json_success('hehe123');
	}
	add_action( 'wp_ajax_thongke', 'thongke_init' );
	function thongke_init() 
	{

    //do bên js để dạng json nên giá trị trả về dùng phải encode


		$id_loaidv = (isset($_POST['id_loaidv']))?esc_attr($_POST['id_loaidv']) : '';

		$link=mysqli_connect('localhost','root','','vnpt') or die("Không thể kết nối");
		mysqli_set_charset($link, 'UTF8');
		$sql="SELECT * FROM wp_term_taxonomy,wp_terms where
		wp_term_taxonomy.term_id=wp_terms.term_id and
		wp_term_taxonomy.parent in (SELECT wp_terms.term_id FROM  wp_term_taxonomy,wp_terms where
		wp_term_taxonomy.term_id=wp_terms.term_id and
		wp_term_taxonomy.parent=9) and 
		wp_term_taxonomy.parent='".$id_loaidv."'";
		$result=mysqli_query($link,$sql);
		$chuoihtml="<select name='id_dv'>";

		while($row=mysqli_fetch_assoc($result)){

			$chuoihtml.="<option value='";
			$chuoihtml.= $row['term_id'];	
			$chuoihtml.= "'>";
			$chuoihtml.= $row['name'];
			$chuoihtml.="</option>";
		}
		$chuoihtml.="<option value='0'>--NULL--</option>";
		$chuoihtml.="</select>";
		wp_send_json_success($chuoihtml);
	}
	add_action( 'wp_ajax_khuvuc', 'khuvuc_init' );
	function khuvuc_init() 
	{

	}
	add_action('init', 'myStartSession', 1);
	add_action('wp_logout', 'myEndSession');
	add_action('wp_login', 'myEndSession');

	function myStartSession() {
		if(!session_id()) {
			session_start();
		}
	}

	function myEndSession() {
		session_destroy ();
	}
	add_action( 'wp_ajax_status_dk', 'status_dk_init' );
	function status_dk_init() 
	{
		$status_dk = (isset($_POST['status_dk']))?esc_attr($_POST['status_dk']) : '';
		if ($status_dk == 0){
			$_SESSION['status']="";
		}
		elseif ($status_dk==1) {
			$_SESSION['status']="Đợi duyệt";
		}
		elseif ($status_dk==2) {
			$_SESSION['status']="Đợi lắp đặt";
		}
		elseif ($status_dk==3) {
			$_SESSION['status']="Bị từ chối";
		}
		elseif ($status_dk==4) {
			$_SESSION['status']="Hoàn thành";
		}
		elseif ($status_dk==5) {
			$_SESSION['status']="";
		}
	}
add_filter( 'wp_mail_from', 'my_mail_from' );
	function my_mail_from( $email )
	{
		return "maidangthanh4880@gmail.com";
	}

	add_filter( 'wp_mail_from_name', 'my_mail_from_name' );
	function my_mail_from_name( $name )
	{
		return "VNPT Hà Nội";
	}
//print_r(td_global::$all_theme_panels_list);