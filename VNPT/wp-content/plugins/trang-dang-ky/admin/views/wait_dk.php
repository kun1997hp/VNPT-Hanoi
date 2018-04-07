<script type="text/javascript">


	(function($){
		$(document).ready(function(){
			$('.duyet_btn').click(function(){
				$.ajax({
                    type : "post", //Phương thức truyền post hoặc get
                    dataType : "json", //Dạng dữ liệu trả về xml, json, script, or html
                    url : '<?php echo admin_url('admin-ajax.php');?>', //Đường dẫn chứa hàm xử lý dữ liệu. Mặc định của WP như vậy
                    data : {
                        action: "duyet", //Tên action
                        id_dk : $(this).val(),//Biến truyền vào xử lý. $_POST['website']
                    },
                    context: this,
                    beforeSend: function(){
                        //Làm gì đó trước khi gửi dữ liệu vào xử lý
                    },
                    success: function(response) {
                    },
                    error: function( jqXHR, textStatus, errorThrown ){
                        //Làm gì đó khi có lỗi xảy ra
                        console.log( 'The following error occured: ' + textStatus, errorThrown );
                    }
                })
				return false;
			})
			
			$('.cancel_btn').click(function(){
				$.ajax({
                    type : "post", //Phương thức truyền post hoặc get
                    dataType : "text", //Dạng dữ liệu trả về xml, json, script, or html
                    url : '<?php echo admin_url('admin-ajax.php');?>', //Đường dẫn chứa hàm xử lý dữ liệu. Mặc định của WP như vậy
                    data : {
                        action: "cancel", //Tên action
                        id_dk : $(this).val(),//Biến truyền vào xử lý. $_POST['website']
                    },
                    context: this,
                    beforeSend: function(){
                        //Làm gì đó trước khi gửi dữ liệu vào xử lý
                    },
                    success: function(response) {
                        //Làm gì đó khi dữ liệu đã được xử lý
                        /*if(response.success) {
                        	$('#status_'+$(this).val()).html(response.data);
                        }
                        else {
                        	alert('Đã có lỗi xảy ra');
                        }*/
                    },
                    error: function( jqXHR, textStatus, errorThrown ){
                        //Làm gì đó khi có lỗi xảy ra
                        console.log( 'The following error occured: ' + textStatus, errorThrown );
                    }
                })
				return false;
			})

			$('.delete_btn').click(function(){
				$.ajax({
					type : "post", //Phương thức truyền post hoặc get
                    dataType : "json", //Dạng dữ liệu trả về xml, json, script, or html
                    url : '<?php echo admin_url('admin-ajax.php');?>', //Đường dẫn chứa hàm xử lý dữ liệu. Mặc định của WP như vậy
                    data : {
                        action: "del", //Tên action
                        id_dk : $(this).val(),//Biến truyền vào xử lý. $_POST['website']
                    },
                    context: this,
                    beforeSend: function(){
                        //Làm gì đó trước khi gửi dữ liệu vào xử lý
                        
                    },
                    success: function(response) {
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
<?php 
global $wpdb;
$mylink = $wpdb->get_results( "SELECT distinct * FROM wp_loaidv,wp_dichvu,wp_dangky_dichvu,wp_khachhang,wp_dangky where
	wp_loaidv.id_loaidv=wp_dichvu.id_loaidv and
	wp_dichvu.id_dv=wp_dangky_dichvu.id_dv and
	wp_khachhang.id_kh=wp_dangky.id_kh and
	wp_dangky.id_dk=wp_dangky_dichvu.id_dk 
	order by wp_dangky.id_dk ASC
	" );

if(!$mylink) echo"truy van sai";
$mylinktemp = $mylink;
$temp2=0;
$i=-1;
foreach ($mylinktemp as $mylinktemp){
	if ($temp2!=$mylinktemp->id_dk){
		$i++;
		$ds_dangky[$i]=1;
		$temp2=$mylinktemp->id_dk;
	}
	else $ds_dangky[$i]++;
}
?>
<div >

	<table class="table " border="solid" style="border-collapse: collapse;border-width: 3px;">
		<tr style="border-bottom: solid">
			<th colspan="11" ><h2 align="center"><b> Danh sách Đăng Ký</b></h2></th>
		</tr>
		<tr >
			<th><b>ID</b></th>
			<th ><b>Tên KH</b></th>
			<th ><b>Địa chỉ</b></th>
			<th ><b>SĐT</b></th>
			<th ><b>Email</b></th>
			<th ><b>Dịch vụ<br>đăng ký</b></th>
			<th ><b>Ghi chú</b></th>
			<th ><b>Status</b></th>
			<th colspan="3"></th>
		</tr>
		<?php
		function truncateString($str)
		{
			if (strlen($str) > 40) {
				return trim(substr($str, 0, 40)) . "...";
			} else {
				return $str;
			}
		}
		$temp=0;
		$j=-1;
		foreach ($mylink as $mylink) {
			if ($temp != ($mylink->id_dk)) 
			{
				$j++;
				$ds_dichvu="";
				$temp=$mylink->id_dk;
			}
			
			if($ds_dangky[$j]>1) 
			{	
				$ds_dichvu.=$mylink->name_dv."<br>";
				$ds_dangky[$j]--;
			}
			else
			{
				?>

				<tr style="border-width: 3px;" valign="top" align="center" >
					<td width="5%"><?php echo $mylink->id_dk;
					$temp=$mylink->id_dk;

					?></td>
					<td width="13%" ><?=$mylink->name_kh?></td>
					<td width="17%"><?=$mylink->address_kh?></td>

					<td width="10%"><?=$mylink->phone_kh?></td>
					<td width="10%"><?=$mylink->email_kh?></td>
					<td width="20%"><b style="font-size: 20px;"><?=$ds_dichvu?></b></td>
					<td width="15%"><?php echo truncateString($mylink->note)?></td>
					<td width="10%" id="<?php echo 'tinhtrang'.$mylink->id_dk?>"><?=$mylink->status?></td>
					<td ><button name='duyet_btn' onclick="location.reload();" class="duyet_btn" value='<?php echo$mylink->id_dk  ?>' >Duyệt</button></td>
					<td ><button name='cancel_btn' onclick="location.reload();"  class="cancel_btn" value='<?php echo$mylink->id_dk  ?>' >Cancel</button></td>
					<td ><button name='delete_btn'  class="delete_btn" value='<?php echo$mylink->id_dk  ?>' >Delete</button></td>
				</tr>
				<?php
			}

		}

		?>
	</table>
</div>
<div id="result_123"> hh </div>


