<script type="text/javascript">
	(function($){
		$(document).ready(function(){
			$("#id_loaidv").change(function(){
				$.ajax({
                    type : "post", //Phương thức truyền post hoặc get
                    dataType : "json", //Dạng dữ liệu trả về xml, json, script, or html
                    url : '<?php echo admin_url('admin-ajax.php');?>', //Đường dẫn chứa hàm xử lý dữ liệu. Mặc định của WP như vậy
                    data : {
                        action: "thongbao", //Tên action
                        id_loaidv : $('#id_loaidv').val(),//Biến truyền vào xử lý. $_POST['website']
                    },
                    context: this,
                    beforeSend: function(){
                        //Làm gì đó trước khi gửi dữ liệu vào xử lý
                    },
                    success: function(response) {
                        //Làm gì đó khi dữ liệu đã được xử lý
                        if(response.success) {
                        	$('#result').html(response.data);
                        }
                        else {
                        	alert('Đã có lỗi xảy ra');
                        }
                    },
                    error: function( jqXHR, textStatus, errorThrown ){
                        //Làm gì đó khi có lỗi xảy ra
                        console.log( 'The following error occured: ' + textStatus, errorThrown );
                    }
                })
				return false;
			})
		})
	})(jQuery)
</script>
<div class="wrap">
	<h1><?php echo esc_html( get_admin_page_title() );?></h1>
	<<?php include('dangky.php'); ?>
</div><!-- .wrap -->