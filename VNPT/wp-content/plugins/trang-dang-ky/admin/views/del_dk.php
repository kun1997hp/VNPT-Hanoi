<?php 
$link=mysqli_connect('localhost','root','','vnpt') or die("Không thể kết nối");
mysqli_set_charset($link, 'UTF8');
$id_dk=$_GET['id_dk'];
$sql="DELETE FROM wp_loaidv,wp_dichvu,wp_dangky_dichvu,wp_khachhang,wp_dangky where
	wp_loaidv.id_loaidv=wp_dichvu.id_loaidv and
	wp_dichvu.id_dv=wp_dangky_dichvu.id_dv and
	wp_khachhang.id_kh=wp_dangky.id_kh and
	wp_dangky.id_dk=wp_dangky_dichvu.id_dk and
	wp_dangky.id_dk='".$id_dk"'";
$result = mysqli_query($link,$sql);
if(!$result){
	die('Truy vấn sai');
}
header('Location:settings.php');
?>