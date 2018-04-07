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
								<span style="color: #ff0000;"><b>ƯU ĐIỂM CỦA MEGAVNN</b></span><br>
Là dịch vụ truy nhập Internet băng rộng qua mạng cố định do Tập đoàn Bưu chính Viễn thông Việt Nam (VNPT) cung cấp, 
dịch vụ này cho phép khách hàng truy nhập Internet với tốc độ cao dựa trên công nghệ đường dây thuê bao số bất đối
 xứng ADSL. Tốc độ Download lên đến 10 Mbps.<br><br>

<span style="color: #ff0000;"><b>LỢI ÍCH CỦA KHÁCH HÀNG KHI SỬ DỤNG MEGAVNN</b></span><br>
* Truy nhập Internet tốc độ cao với chi phí thấp, đưa Internet thành dịch vụ phổ biến với người dùng.<br>
* Khách hàng vừa kết nối Internet vừa sử dụng Fax/điện thoại bình thường.<br>
* Dễ dùng, không còn phải quay số, không qua mạng điện thoại công cộng nên không phải trả cước điện thoại nội hạt.<br>
* Giá cước được tính theo dung lượng sử dụng nên tránh được tình trạng vẫn phải trả cước khi quên ngắt kết nối.<br>
* Cung cấp các gói cước với tốc độ kết nối đa dạng, đáp ứng nhu cầu sử dụng khác nhau.<br>
* Tốc độ kết nối cao, ổn định nên khách hàng có thể sử dụng Internet Vnpt vào những tác vụ mà trước đây khi dùng modem quay số rất khó thực hiện như xem phim/nghe nhạc trực tuyến, hội thảo video qua mạng, tải file kích thước lớn…
<br><br>
<span style="color: #ff0000;"><b>GÓI CƯỚC</b></span>
<br>
Mega VNN có nhiều gói cước với tốc độ kết nối khác nhau, đáp ứng nhu cầu đa dạng của các đối tượng khách hàng.
<br>
<img class=" wp-image-261 aligncenter" src="http://localhost/VNPT/wp-content/uploads/2017/11/megavnn.png" alt="" width="710" height="484" />
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