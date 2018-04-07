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
<?php
date_default_timezone_set('Asia/Ho_Chi_Minh');
if(isset($_SERVER['REQUEST_METHOD'])=='POST'){
    $errors=array();
    $errors_num = '';
    $errors_len = '';
    $errors_id = '';
    $errors_phone = '';
    $err_id_contain_bw = '';
    $err_addr_contain_bw = '';
    $err_email_contain_bw = '';
    $errors_checkpass = '';
    $banned_id = array("DROP","drop","ALTER","alter","DELETE","delete"," ");
    $banned = array("DROP","drop","ALTER","alter","DELETE","delete");

    if(isset($_POST['name_kh'])) {
        foreach ($banned as $bw) {
            if (stripos($_POST['name_kh'],$bw) !== false) {
               $err_name_contain_bw = 'Không được chứa khoảng trắng hoặc các kí tự DROP, ALTER, DELETE...';

           }
       }
   }
   if(isset($_POST['address_kh'])) {
    foreach ($banned as $bw) {
        if (stripos($_POST['address_kh'],$bw) !== false) {
           $err_addr_contain_bw= 'Không được chứa các kí tự DROP, ALTER, DELETE...';

       }
   }
}

if(isset($_POST['email_kh'])) {
    foreach ($banned as $bw) {
        if (stripos($_POST['email_kh'],$bw) !== false) {
           $err_email_contain_bw = 'Không được chứa các kí tự DROP, ALTER, DELETE...';
       }
   }
}

}
if(isset($_POST['name_kh'])) {
    if(strlen($_POST['name_kh']) < 6 ) {
        $errors_name= "Không đúng định dạng Họ tên";
    }
    else $name_kh = $_POST['name_kh'];
}

if(isset($_POST['phone_kh'])) {
    $err_phone = preg_match('/^[0-9]+$/',$_POST['phone_kh']);
    if(!$err_phone || strlen($_POST['phone_kh'])<10 || strlen($_POST['phone_kh'])>11 ) {
        $errors_phone = "Không đúng định dạng số điện thoại!";          

    }
    else  {
        $phone_kh=$_POST['phone_kh'];

    }

}

if(empty($_POST['address_kh'])){
    array_push($errors,"&nbspĐịa chỉ");  
}
else{
    $address_kh=$_POST['address_kh'];
}
if(empty($_POST['id_kv'])){
    array_push($errors,"&nbspKhu vực");  
}
else{
    $id_kv=$_POST['id_kv'];
}
if(empty($_POST['name_kh'])){
    array_push($errors,"&nbspHọ tên"); 
}
else{
    $name_kh=$_POST['name_kh'];
}
if(empty($_POST['phone_kh'])){
    array_push($errors,"&nbspSố điện thoại");
}
else{
    $phone_kh=$_POST['phone_kh'];
}

if(empty($errors) && empty($errors_len) && empty($errors_num) && empty($errors_phone) && empty($errors_id) && empty($err_name_contain_bw) && empty($err_address_contain_bw) && empty($err_email_contain_bw) ){
    $link=mysqli_connect('localhost','root','','vnpt') or die("Không thể kết nối");
    mysqli_set_charset($link, 'UTF8');
    $today=date('Y-m-d');
    $query="INSERT INTO wp_dangky(note,status,date_created,name_kh,address_kh,id_kv,phone_kh,email_kh) VALUES ('".$note_kh."','Đợi duyệt','".$today."','".$name_kh."','".$address_kh."','".$id_kv."','".$phone_kh."','".$email_kh."')";
    if(mysqli_query($link,$query)){
        $id_dk=mysqli_insert_id($link);
    }
    $strSQL = "SELECT COUNT(*) FROM  wp_term_taxonomy,wp_terms where wp_term_taxonomy.term_id=wp_terms.term_id and wp_term_taxonomy.parent =9";
    $result=mysqli_query($link,$strSQL);
    $row=mysqli_fetch_array($result);
    $n=$row[0];
    $check=0;
    for($i=0;$i<$n;$i++){
        if($_POST['id_dv_loai'.$i] !=0){
            $query="INSERT INTO wp_dangky_dichvu(id_dk,id_dv) VALUES ('".$id_dk."','".$_POST['id_dv_loai'.$i]."')";
            $result=(mysqli_query($link,$query));
            if ($result&&$check==0) {
                echo " Đăng kí thành công";
                $check=1;
            }
        }
    }

}
else{
    $m="<a style='color: blue; margin-left: 15px; font-size: 18px;' >Bạn hãy nhập đầy đủ thông tin.</a>";
}

?>
<form name="signin" method="post" enctype="multipart/form-data">
    <h2><b>ĐĂNG KÝ SỬ DỤNG DỊCH VỤ CỦA VNPT HÀ NỘI</b></h2>
    <b>Họ tên</b> : <br/>
    <input type='text' name='name_kh' placeholder='VD: Bùi Văn Giang'><br>
    <span style="text-align:left"><p style="font:Cambria, 'Hoefler Text', 'Liberation Serif', Times, 'Times New Roman', serif; color:red; font-size:15px" id = "errors"><?php echo $errors_name; ?></p></span>
    <span style="text-align:left"><p style="font:Cambria, 'Hoefler Text', 'Liberation Serif', Times, 'Times New Roman', serif; color:red; font-size:15px" id = "errors"><?php echo $err_name_contain_bw; ?></p></span>
    <b>Địa chỉ</b> : <br/>
    <input style="width: 50%;" type='text' name='address_kh' placeholder='VD: Số 12/274 Bạch Mai'>

    <?php
    $link=mysqli_connect('localhost','root','','vnpt') or die("Không thể kết nối");
    mysqli_set_charset($link, 'UTF8');
    $sql="SELECT * FROM wp_khuvuc";
    $result=mysqli_query($link,$sql);
    if(!$result){
        die('Truy vấn sai');
    }
    ?>
    <select style="margin-left: 25px;" name='id_kv'>
        <?php
        while($row=mysqli_fetch_assoc($result)){
            echo"<option value='".$row['id_kv']."'>".$row['name_kv']."</option>";

        }
        echo"</select>";


    /*<select style="margin-left: 25px;" name='address_kh_quan'>
        <option value="Quận Ba Đình">Quận Ba Đình</option>
        <option value="Quận Hoàn Kiếm">Quận Hoàn Kiếm</option>
        <option value="Quận Hai Bà Trưng" selected="">Quận Hai Bà Trưng</option>
        <option value="Quận Đống Đa">Quận Đống Đa</option>
        <option value="Quận Tây Hồ">Quận Tây Hồ</option>
        <option value="Quận Cầu Giấy">Quận Cầu Giấy</option>
        <option value="Quận Thanh Xuân">Quận Thanh Xuân</option>
        <option value="Quận Hoàng Mai">Quận Hoàng Mai</option>
        <option value="Quận Long Biên">Quận Long Biên</option>
        <option value="Quận Hà Đông">Quận Hà Đông</option>
        <option value="Thị Xã Sơn Tây">Thị Xã Sơn Tây</option>
        <option value="Huyện Từ Liêm">Huyện Từ Liêm</option>
        <option value="Huyện Thanh Trì">Huyện Thanh Trì</option>
        <option value="Huyện Gia Lâm">Huyện Gia Lâm</option>
        <option value="Huyện Đông Anh">Huyện Đông Anh</option>
        <option value="Huyện Sóc Sơn">Huyện Sóc Sơn</option>
        <option value="Huyện Ba Vì">Huyện Ba Vì</option>
        <option value="Huyện Phúc Thọ">Huyện Phúc Thọ</option>
        <option value="Huyện Thạch Thất">Huyện Thạch Thất</option>
        <option value="Huyện Quốc Oai">Huyện Quốc Oai</option>
        <option value="Huyện Chương Mỹ">Huyện Chương Mỹ</option>
        <option value="Huyện Đan Phượng">Huyện Đan Phượng</option>
        <option value="Huyện Hoài Đức">Huyện Hoài Đức</option>
        <option value="Huyện Thanh Oai">Huyện Thanh Oai</option>
        <option value="Huyện Mỹ Đức">Huyện Mỹ Đức</option>
        <option value="Huyện Ứng Hoà">Huyện Ứng Hoà</option>
        <option value="Huyện Thường Tín">Huyện Thường Tín</option>
        <option value="Huyện Phú Xuyên">Huyện Phú Xuyên</option>
        <option value="Huyện Mê Linh">Huyện Mê Linh</option>
    </select>
    */
    ?>
    <br>
    <span style="text-align:left"><p style="font:Cambria, 'Hoefler Text', 'Liberation Serif', Times, 'Times New Roman', serif; color:red; font-size:15px" id = "errors"><?php echo $err_addr_contain_bw; ?></p></span>
    <b>Điện thoại</b> : <br/>
    <input type="text" name="phone_kh"  placeholder="VD: 0123456789"><br/>
    <span style="text-align:left"><p style="font:Cambria, 'Hoefler Text', 'Liberation Serif', Times, 'Times New Roman', serif; color:red; font-size:15px" id = "errors"><?php echo $errors_phone; ?></p></span>
    <b>Email</b> : <br/>
    <input type="email" name="email_kh" placeholder="VD: giangbv@gmail.com"><br/>
    <span style="text-align:left"><p style="font:Cambria, 'Hoefler Text', 'Liberation Serif', Times, 'Times New Roman', serif; color:red; font-size:15px" id = "errors"><?php echo $err_email_contain_bw; ?></p></span>
    <b>Chọn Dịch vụ</b> :<br/>
	<br>
    <?php
    
    $link=mysqli_connect('localhost','root','','vnpt') or die("Không thể kết nối");
    mysqli_set_charset($link, 'UTF8');
    $sql="SELECT * FROM  wp_term_taxonomy,wp_terms where wp_term_taxonomy.term_id=wp_terms.term_id and wp_term_taxonomy.parent =9";
    $result=mysqli_query($link,$sql);
    if(!$result){
        die('Truy vấn sai');
    }
    $j=0;
    while($row=mysqli_fetch_assoc($result)){
        echo "<span style= 'width:200px;float:left'> + &nbsp".$row['name']."</span>";
        $sql2="SELECT * FROM  wp_term_taxonomy,wp_terms where wp_term_taxonomy.term_id=wp_terms.term_id and wp_term_taxonomy.parent='".$row['term_id']."'";
        $result2=mysqli_query($link,$sql2);
        if(!$result2){
            die('Truy vấn sai');
        }
        echo"<select name='id_dv_loai".$j."'>";
        echo"<option selected='' value='abcxyz'> --không chọn-- </option>";
        while($row2=mysqli_fetch_assoc($result2)){
            ?>
            <option value=<?php echo $row2['term_id'] ?> ><b><?php echo $row2['name'] ?></b></option>
            <?php
        }
        echo"</select><br/><br/>";
        $j++;
    }

    ?>
	<br>
    <b>Ghi chú</b> :<br/><br>
    <textarea name="note_kh" style="width: 400px;" placeholder="Viết ghi chú ..."></textarea>
    <br/>
	<br>
    <input type="submit" name="signin" value="Đăng ký" class="btn btn-lg btn-primary"/>

</form>


</select>
<?php
/*
Chọn loại dịch vụ đăng ký :<br/>
    <select id="id_loaidv" onchange="load_ajax()">

        <?php
        $link=mysqli_connect('localhost','root','','vnpt') or die("Không thể kết nối");
        mysqli_set_charset($link, 'UTF8');
        $sql="SELECT * FROM wp_loaidv";
        $result=mysqli_query($link,$sql);
        if(!$result){
            die('Truy vấn sai');
        }
        while($row=mysqli_fetch_assoc($result)){
            ?>  
            <option value=<?php echo $row['id_loaidv'] ?> ><?php echo $row['name_loaidv'] ?></option>
            <?php
        }
        ?>
    </select>
    Chọn dịch vụ đăng kí:
    <span id="result">
        <select>
            <option disabled="" selected=""><i>--Chưa chọn loại dịch vụ--</i></option>
        </select>
    </span>
    <br/>
    */
   ?>
