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
								<span style="color: #ff0000;"><b>ƯU ĐIỂM CỦA CÁP QUANG VNPT</b></span><br>
* Đường truyền Internet tốc độ cao ổn định nhất hiện nay với giá cước hợp lý.<br>
* Ít bị suy hao và không bị ảnh hưởng bởi từ trường, thời tiết mưa gió.<br>
* Thủ tục đăng ký đơn giản, hỗ trợ làm hợp đồng tại nhà<br>
* Dễ dàng nâng cấp băng thông. Tích hợp nhiều ứng dụng đi kèm: camera, truyền hình...<br>
* Hỗ trợ triển khai lắp đặt nhanh 24 đến 48 giờ.<br><br>

<span style="color: #ff0000;"><b>LỢI ÍCH CỦA KHÁCH HÀNG KHI SỬ DỤNG CÁP QUANG VNPT</b></span><br>
* Miễn phí cước hòa mạng khi khách hàng lắp đặt mới đăng ký các gói cước 6 tháng, 12 tháng, 18 tháng, 24 tháng.<br>
* Miễn phí chuyển đổi từ cáp đồng MegaVNN sang FiberVNN.<br>
* Được trang bị miễn phí 01 bộ Modem Wifi khi đăng ký lắp đặt mới<br>
* Khách hàng đang sử dụng dịch vụ nếu đóng tiếp cước 6 tháng sẽ được tặng thêm 1 tháng cước sử dụng.<br><br>

<span style="color: #ff0000;"><b>GÓI CƯỚC</b></span><br>

Cáp quang VNPT với gói cước ưu đãi cực kỳ hấp dẫn dành cho mọi đối tượng khách hàng. Quý khách xem chi tiết khuyến mãi bên dưới và hãy chọn cho mình gói cước cáp quang VNPT phù hợp nhất với nhu cầu sử dụng và đăng ký ngay để được tư vấn và làm hợp đồng trong thời gian sớm nhất.

<img class=" wp-image-263 aligncenter" src="http://localhost/VNPT/wp-content/uploads/2017/11/fibervnn.png" alt="" width="707" height="463" />
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