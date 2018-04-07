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
								<span style="color: #ff0000;"><b>ƯU ĐIỂM CỦA MYTV</b></span><br>
MyTV - dịch vụ truyền hình đa phương tiện do Tập đoàn Bưu chính Viễn thông Việt Nam cung cấp, mang đến cho khách hàng hình thức giải trí khác biệt: TRUYỀN HÌNH THEO YÊU CẦU.<br>
<br>
<span style="color: #ff0000;"><b>LỢI ÍCH CỦA KHÁCH HÀNG KHI SỬ DỤNG MYTV</b></span><br>
* MyTV là sản phẩm của sự hội tụ, chỉ với một thiết bị đầu cuối, khách hàng có thể sử dụng rất nhiều dịch vụ khác nhau qua chiếc tivi.
<br>* Với MyTV, khách hàng không chỉ dừng lại ở việc xem truyền hình đơn thuần mà có thể xem bất cứ chương trình nào mình yêu thích vào bất kỳ thời điểm nào và sử dụng nhiều dịch vụ khác qua màn hình tivi như: xem phim theo yêu cầu, xem trực tiếp, xem lại các giải thể thao lớn, hát karaoke, chơi game, nghe nhạc….
<br>* Sự khác biệt lớn nhất giữa dịch vụ truyền hình của MyTV so với các dịch vụ truyền hình truyền thống trước đây là khách hàng có thể sử dụng các tính năng:
<br>- Khóa các chương trình có nội dung không phù hợp với trẻ em (Parental Lock).
<br>- Hướng dẫn chương trình điện tử (EPG): giúp tìm kiếm chương trình truyền hình, lấy thông tin chi tiết về chương trình theo từng thể loại, xem lịch phát sóng.
<br>* Kết hợp giữa dịch vụ truyền hình và dịch vụ theo yêu cầu cho phép bạn có thể tạm dừng hoặc tua lại chương trình truyền hình đang phát và tiếp tục xem lại sau đó kể từ thời điểm tạm dừng.
<br>* Giúp bạn lựa chọn, ghi và lưu trữ các chương trình phát sóng trên các kênh truyền hình, sau đó mở ra xem lại bất cứ khi nào. Đặc biệt bạn có thể vừa xem vừa ghi lại chương trình truyền hình mà mình yêu thích hay đặt chế độ ghi tự động khi có việc bận trùng với khung giờ phát sóng của chương trình.
<br><br>
<span style="color: #ff0000;"><b>GÓI CƯỚC</b></span>

<img class=" wp-image-269 aligncenter" src="http://localhost/VNPT/wp-content/uploads/2017/11/mytv.png" alt="" width="696" height="519" /><img class="alignleft size-full wp-image-295" src="http://localhost/VNPT/wp-content/uploads/2017/12/MYTVVVV.png" alt="" width="716" height="544" />

&nbsp;
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