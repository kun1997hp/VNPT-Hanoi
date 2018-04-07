<script type="text/javascript">
	(function($){
		$(document).ready(function(){
			$('.duyet').click(function(){
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
                    success: function(response) {/*
                        //Làm gì đó khi dữ liệu đã được xử lý
                        if(response.success) {
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

			$('.cancel').click(function(){
				$.ajax({
                    type : "post", //Phương thức truyền post hoặc get
                    dataType : "json", //Dạng dữ liệu trả về xml, json, script, or html
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
                     /*   if(response.success) {
                        	alert('#status_'+$(this).val());
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

			$('.delete').click(function(){
				$.ajax({
                    type : "post", //Phương thức truyền post hoặc get
                    dataType : "json", //Dạng dữ liệu trả về xml, json, script, or html
                    url : '<?php echo admin_url('admin-ajax.php');?>', //Đường dẫn chứa hàm xử lý dữ liệu. Mặc định của WP như vậy
                    data : {
                        action: "delete", //Tên action
                        id_dk : $(this).val(),//Biến truyền vào xử lý. $_POST['website']
                    },
                    context: this,
                    beforeSend: function(){
                        //Làm gì đó trước khi gửi dữ liệu vào xử lý
                    },
                    success: function(response) {
                        //Làm gì đó khi dữ liệu đã được xử lý
                        if(response.success) {
                        }
                        else {
                        }
                    },
                    error: function( jqXHR, textStatus, errorThrown ){
                        //Làm gì đó khi có lỗi xảy ra
                        console.log( 'The following error occured: ' + textStatus, errorThrown );
                    }
                })
				return false;
			})
			$("#status_dk").change(function(){
				$.ajax({
                    type : "post", //Phương thức truyền post hoặc get
                    dataType : "json", //Dạng dữ liệu trả về xml, json, script, or html
                    url : '<?php echo admin_url('admin-ajax.php');?>', //Đường dẫn chứa hàm xử lý dữ liệu. Mặc định của WP như vậy
                    data : {
                        action: "status_dk", //Tên action
                        status_dk : $('#status_dk').val(),//Biến truyền vào xử lý. $_POST['website']
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
$page_num = isset( $_GET['pagenum'] ) ? absint( $_GET['pagenum'] ) : 1;
$limit = 20; // Number of rows in page
$offset = ( $page_num - 1 ) * $limit;
$total = $wpdb->get_var( "SELECT COUNT(`id_dk`) FROM `wp_dangky`" );
$num_of_pages = ceil( $total / $limit );
$lists = $wpdb->get_results("SELECT * FROM `wp_dangky` ORDER BY id_dk ASC LIMIT $offset,$limit" );
$page_links = paginate_links( array(
	'base' => add_query_arg( 'pagenum', '%#%' ),
	'format' => '',
	'prev_text' => __( '«', 'text-domain' ),
	'next_text' => __( '»', 'text-domain' ),
	'total' => $num_of_pages,
	'current' => $pagenum
) );
?>
<?php 
global $wpdb;
$html="";
if (isset($_SESSION['status'])&&$_SESSION['status']!="") {$html="and v1.status='".$_SESSION['status']."' ";};
$hehe="SELECT distinct * FROM wp_term_taxonomy,wp_terms,wp_dangky_dichvu,(select * from wp_dangky order by wp_dangky.id_dk ASC limit $offset,$limit )as V1,wp_khuvuc where wp_term_taxonomy.term_id=wp_terms.term_id and wp_term_taxonomy.parent in (SELECT wp_terms.term_id FROM wp_term_taxonomy,wp_terms where wp_term_taxonomy.term_id=wp_terms.term_id and wp_term_taxonomy.parent=9) and wp_terms.term_id=wp_dangky_dichvu.id_dv and v1.id_kv=wp_khuvuc.id_kv and v1.id_dk=wp_dangky_dichvu.id_dk";"  order by v1.id_dk ASC";
$hehe.=$html;
$hehe.="";
$mylink = $wpdb->get_results($hehe);

if(!$mylink) echo"<b color:red;><i>Không có bản đăng ký nào!!</i></b>";
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
				<th><b>Ngày Đăng ký</b></th>
				<th ><b>Ghi chú</b></th>
				<th ><b>Status</b>
					<select id="status_dk" onchange="location.reload();">
						<option value="0">--NULL--</option>
						<option value="1">Đợi duyệt</option>
						<option value="2">Đợi lắp đặt</option>
						<option value="3">Bị từ chối</option>
						<option value="4">Hoàn thành</option>
						<option value="5">Tất cả</option>
					</select></th>
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
				$j=0;
				$ds_dichvu="";
				foreach ($mylink as $mylink) {
					if($ds_dangky[$j]>1) 
					{	
						$ds_dichvu.=$mylink->name."<br>";
						$ds_dangky[$j]--;
					}
					else
						{	$ds_dichvu.=$mylink->name."<br>";
					?>

					<tr style="border-width: 3px;" valign="top" align="center" >
						<td width="5%"><?php echo $mylink->id_dk;
						$temp=$mylink->id_dk;

						?></td>
						<td width="13%" ><?=$mylink->name_kh?></td>
						<td width="17%"><?php echo $mylink->address_kh.",&nbsp".$mylink->name_kv;?></td>

						<td width="10%"><?=$mylink->phone_kh?></td>
						<td width="10%"><?=$mylink->email_kh?></td>
						<td width="20%"><b style="font-size: 16px;"><?=$ds_dichvu?></b></td>
						<td width="10%"><?=$mylink->date_created?></td>
						<td width="15%"><?php echo truncateString($mylink->note)?></td>
						<td width="10%" id="<?php echo 'tinhtrang'.$mylink->id_dk?>"><?=$mylink->status?></td>
						<?php if (($mylink->status)=="Đợi duyệt"){?>
						<td ><button name='duyet' onclick="location.reload();" class="duyet" value='<?php echo$mylink->id_dk  ?>' >Duyệt<br>&nbsp</button></td>
						<td ><button name='cancel' onclick="location.reload();" class="cancel" value='<?php echo$mylink->id_dk  ?>' >Từ chối</button></td>
						<td></td>
						<?php ;};
						if (($mylink->status)=="Đợi lắp đặt"){?>
						<td ><button name='delete' onclick="location.reload();" class="delete" value='<?php echo$mylink->id_dk  ?>' >Hoàn Thành</button></td>
						<td ><button name='cancel' onclick="location.reload();" class="cancel" value='<?php echo$mylink->id_dk  ?>' >Từ chối</button></td>
						<td></td>
						<?php ;};
						if (($mylink->status)=="Hoàn thành"){?>
						<td></td>
						<td></td>
						<td></td>
						<?php ;};
						if (($mylink->status)=="Bị từ chối"){?>
						<td ><button name='duyet' onclick="location.reload();" class="duyet" value='<?php echo$mylink->id_dk  ?>' >Khôi phục</button></td>
						<td></td>
						<td></td>
						<?php ;}?>
					</tr>
					<?php
					$ds_dangky[$j]--;
					$ds_dichvu="";
					$j++;
				}
			}
			?>
		</table>
	</div>

	<?php
	if ( $page_links ) {
		echo '<div class="tablenav"><div class="tablenav-pages" style="margin: 1em 0;">' . $page_links . '</div></div>';
	}
	?>
