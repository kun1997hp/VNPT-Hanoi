<?php
/*  ----------------------------------------------------------------------------
    the blog index template
 */

get_header();

global $loop_module_id, $loop_sidebar_position;

$current_category_id = get_query_var('cat');
$current_category_obj = get_category($current_category_id);


//read the per category setting
$tdc_layout = td_util::get_category_option($current_category_id, 'tdc_layout');//swich by RADU A, get_tax_meta($cur_cat_id, 'tdc_layout');
$tdc_sidebar_pos = td_util::get_category_option($current_category_id, 'tdc_sidebar_pos');////swich by RADU A,  get_tax_meta($cur_cat_id, 'tdc_sidebar_pos');

// sidebar position used to align the breadcrumb on sidebar left + sidebar first on mobile issue
$td_sidebar_position = '';
if($loop_sidebar_position == 'sidebar_left') {
	$td_sidebar_position = 'td-sidebar-left';
}

//set the template id, used to get the template specific settings
$template_id = 'category';

//prepare the loop variables

$loop_module_id = td_util::get_option('tds_' . $template_id . '_page_layout', 1); //module 1 is default
$loop_sidebar_position = td_util::get_option('tds_' . $template_id . '_sidebar_pos'); //sidebar right is default (empty)

//override the category global template with the category specific settings
if (!empty($tdc_layout)) {
    $loop_module_id = $tdc_layout;
}

if (!empty($tdc_sidebar_pos)) {
    $loop_sidebar_position = $tdc_sidebar_pos;
}

// sidebar position used to align the breadcrumb on sidebar left + sidebar first on mobile issue
$td_sidebar_position = '';
if($loop_sidebar_position == 'sidebar_left') {
	$td_sidebar_position = 'td-sidebar-left';
}

// make the category pulldown filter list to be equal
td_js_buffer::add_to_footer (
    'jQuery().ready(function() {' . "\r\n" .
    'var pulldown_size = jQuery(".td-category-pulldown-filter:first").width();' . "\r\n" .
    'if (pulldown_size > 113) { jQuery(".td-category-pulldown-filter .td-pulldown-filter-list").css({"min-width": pulldown_size, "border-top": "1px solid #444"}); }' . "\r\n" .
    '});'
);

?>



<?php td_api_category_template::_helper_show_category_template() ?>
<?php td_api_category_top_posts_style::_helper_show_category_top_posts_style() ?>

<div class="td-main-content-wrap">
    <div class="td-container">
		
        <!-- content -->
        <div class="td-pb-row">
		
            <?php
                switch ($loop_sidebar_position) {

                    default: //default: sidebar right
                        ?>
                            <div class="td-pb-span8 td-main-content">
                                <div class="td-ss-main-content">
								<span style="color: #ff0000;"><b>ƯU ĐIỂM CỦA ĐIỆN THOẠI CỐ ĐỊNH VNPT</b></span><br>
* Dịch vụ điện thoại cố định của VNPT giúp khách hàng có thể dùng máy điện thoại cố định thực hiện các cuộc gọi nội hạt, gọi liên tỉnh và quốc tế theo phương thức trực tiếp truyền thống IDD, gọi liên tỉnh và quốc tế VoIP, gọi di động và sử dụng các dịch vụ giá trị gia tăng khác.<br>
* Chất lượng dịch vụ ổn định, liên lạc tiện lợi<br>
* Triển khai lắp đặt nhanh<br>
* Chăm sóc và hỗ trợ giải đáp khách hàng 24h/7 ngày<br>
<br>
<span style="color: #ff0000;"><b>LỢI ÍCH CỦA KHÁCH HÀNG KHI SỬ DỤNG ĐIỆN THOẠI CỐ ĐỊNH VNPT</b></span><br>
* Cách tính cước thấp và hợp lý: Tính cước theo từng giây (từ giây thứ 7) cho các dịch vụ<br>
* Khi sử dụng dịch vụ Điện thoại cố định, Quý khách có sẵn cơ sở hạ tầng để kết hợp lắp đặt các dịch vụ khác của VNPT Hà Nội như ADSL hoặc truyền hình MyTV, vừa tiết kiệm đường dây lắp đặt, vừa đảm bảo chất lượng và mỹ thuật cho gia đình, văn phòng.
<br><br>
<span style="color: #ff0000;"><b>GIÁ CƯỚC</b></span>
<br>
<img class="td-animation-stack-type0-2" src="http://localhost/www/Do_an/images/giaDT.png" width="760" height="600" />
                                    <?php //locate_template('loop.php', true);?>
                                    <?php td_page_generator::get_pagination(); ?>
                                </div>
                            </div>

                            <div class="td-pb-span4 td-main-sidebar">
                                <div class="td-ss-main-sidebar">
                                    <?php get_sidebar(); ?>
                                </div>
                            </div>
                        <?php
                        break;


                    case 'sidebar_left':
                        ?>
                        <div class="td-pb-span8 td-main-content <?php echo $td_sidebar_position; ?>-content">
                            <div class="td-ss-main-content">
                                <?php locate_template('loop.php', true);?>
                                <?php td_page_generator::get_pagination(); ?>
                            </div>
                        </div>
	                    <div class="td-pb-span4 td-main-sidebar">
		                    <div class="td-ss-main-sidebar">
			                    <?php get_sidebar(); ?>
		                    </div>
	                    </div>
                        <?php

                        break;


                    case 'no_sidebar':
                        ?>
                        <div class="td-pb-span12 td-main-content">
                            <div class="td-ss-main-content">
                                <?php locate_template('loop.php', true);?>
                                <?php td_page_generator::get_pagination(); ?>
                            </div>
                        </div>
                        <?php
                        break;
                }
            ?>
        </div> <!-- /.td-pb-row -->
    </div> <!-- /.td-container -->
</div> <!-- /.td-main-content-wrap -->

<?php

get_footer();