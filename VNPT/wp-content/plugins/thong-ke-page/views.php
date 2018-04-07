<div>
<div>
<form name="thongke" method="post" enctype="multipart/form-data">
	<b>Từ ngày &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp :</b>
	<input type="date" name="d1" value=<?php if (isset($_POST['d1'])) echo $_POST['d1']; ?>>
	<br>
	<b>Đến ngày &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp:</b>
	<input type="date" name="d2" value=<?php if (isset($_POST['d2'])) echo $_POST['d2']; ?>>
	<br>
	<b>Thống kê theo:</b>
	<select name="type11"> 
	<option value=1 <?php if (isset($_POST['type11'])&& ($_POST['type11']==1 )) echo "selected=''"; ?>>Dịch vụ</option>
	<option value=2 <?php if (isset($_POST['type11'])&& ($_POST['type11']==2 )) echo "selected=''"; ?>>Khu vực</option>
	</select>
	<br>
	<button class="btn btn-primary btn-sm" name="submit" >Submit</button>
</form>
</div>

<?php
function date_12($str1,$str2){
  $d1=explode('-', $str1);
  $d2=explode('-', $str2);
  if($d1[2]<$d2[2]) {return 1;}
  elseif ($d1[2]=$d2[2]) {
    if ($d1[1]<$d2[1]) {return 1;}
    elseif ($d1[1]=$d2[1])  {
      if($d1[0]<$d2[0]) {return 1;}
      else return 0;
    }
    else return 0;
  }
  else return 0;
}
if(isset($_POST['submit'])){
	if($_POST['type11']==1) {
		$d1 = $_POST['d1'];
		$d2 = $_POST['d2'];
		$link=mysqli_connect('localhost','root','','vnpt') or die("Không thể kết nối");
		mysqli_set_charset($link, 'UTF8');
		$sql="SELECT * from wp_dangky";
		$result=mysqli_query($link,$sql);
		$khuvuc2="";
		while($row=mysqli_fetch_array($result)){
			if ((date_12($row['date_created'],$d1)!=1) &&
				(date_12($d2,$row['date_created'])!=1)){
				$khuvuc2.="'".$row['date_created']."'";
			$khuvuc2.=",";
		}

	}
	if ($khuvuc2!="") $khuvuc2=substr($khuvuc2,0,-1);
	else $khuvuc2=1000;
	?>
	<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
	google.charts.load("current", {packages:['corechart']});
	google.charts.setOnLoadCallback(drawChart2);
	function drawChart2() {
		var data = google.visualization.arrayToDataTable([
			["Element", "Số lượng", { role: "style" } ],
			<?php
			$link=mysqli_connect('localhost','root','','vnpt') or die("Không thể kết nối");
			mysqli_set_charset($link, 'UTF8');
			$sql="SELECT * FROM  wp_term_taxonomy,wp_terms where wp_term_taxonomy.term_id=wp_terms.term_id and wp_term_taxonomy.parent =9";
			$result=mysqli_query($link,$sql);
			if(!$result){
				die('Truy vấn sai');
			}
			$temp="";
			$html2="";
			$chuoi2="";
			if (isset($khuvuc2)&&$khuvuc2!="") {
				$chuoi2.="and wp_dangky.date_created in (".$khuvuc2.")";
			};
			while($row=mysqli_fetch_assoc($result)){
			/*$sql2="SELECT COUNT(*) FROM wp_loaidv,wp_dichvu where
			wp_loaidv.id_loaidv=wp_dichvu.id_loaidv and 
			wp_loaidv.id_loaidv='".$row['id_loaidv']."'";
			$result2=mysqli_query($link,$sql2);
			if(!$result2){  
				die('Truy vấn sai');
			}*/
			$sql3="SELECT * FROM  wp_term_taxonomy,wp_terms where wp_term_taxonomy.term_id=wp_terms.term_id and wp_term_taxonomy.parent=".$row['term_id'];
			$result3=mysqli_query($link,$sql3);
			while($row3=mysqli_fetch_assoc($result3)){
				$html2.="['".$row3['name']."',";
				$sql4="SELECT COUNT(*) FROM wp_term_taxonomy,wp_terms,wp_dangky_dichvu,wp_dangky WHERE
				wp_term_taxonomy.term_id=wp_terms.term_id and
				wp_dangky_dichvu.id_dv=wp_terms.term_id and
				wp_dangky.id_dk=wp_dangky_dichvu.id_dk and
				wp_terms.term_id='".$row3['term_id']."'";
				$sql4.=" ";
				$sql4.=$chuoi2;
				$result4=mysqli_query($link,$sql4);
				$row4=mysqli_fetch_assoc($result4);
				if($temp!=$row['name'])
				{
					//echo $row['name'];
					$temp=$row['name'];
				}
				$html2.=$row4['COUNT(*)'].",'#";
				$html2.=mt_rand(000000, 999999);
				$html2.="'],";
			}
		}
		echo substr($html2, 0, -1);
		?>])

		var view = new google.visualization.DataView(data);
		view.setColumns([0, 1,
			{ calc: "stringify",
			sourceColumn: 1,
			type: "string",
			role: "annotation" },
			2]);

		var options = {
			title: "Số lượng đăng ký theo dịch vụ",
			width: 1150,
			height: 400,
			bar: {groupWidth: "80%"},
			legend: { position: "none" },
		};
		var chart = new google.visualization.ColumnChart(document.getElementById("columnchart_values2"));
		chart.draw(view, options);
	}
</script>
<div>
<div id="result_kv2" width="800px" float="right">
	<div id="columnchart_values2" style=""></div>
</div>
<div width="300px;" float="right" align="center">
<table border="" style="border-collapse: collapse;">
	<tr>
		<th>Loại DV</th>
		<th>Dịch vụ</th>
		<th>Số lượng ĐK</th>
	</tr>
	<?php
	$link=mysqli_connect('localhost','root','','vnpt') or die("Không thể kết nối");
	mysqli_set_charset($link, 'UTF8');
	$sql="SELECT * FROM  wp_term_taxonomy,wp_terms where wp_term_taxonomy.term_id=wp_terms.term_id and wp_term_taxonomy.parent=9";
	$result=mysqli_query($link,$sql);
	if(!$result){
		die('Truy vấn sai');
	}
	$temp="";
	$chuoi2="";
	if (isset($khuvuc2)&&$khuvuc2!="") {
		$chuoi2.="and wp_dangky.date_created in (".$khuvuc2.")";
	};
	while($row=mysqli_fetch_assoc($result)){
			/*$sql2="SELECT COUNT(*) FROM wp_loaidv,wp_dichvu where
			wp_loaidv.id_loaidv=wp_dichvu.id_loaidv and 
			wp_loaidv.id_loaidv='".$row['id_loaidv']."'";
			$result2=mysqli_query($link,$sql2);
			if(!$result2){  
				die('Truy vấn sai');
			}*/
			$sql3="SELECT * FROM  wp_term_taxonomy,wp_terms where wp_term_taxonomy.term_id=wp_terms.term_id and wp_term_taxonomy.parent=".$row['term_id'];
			$result3=mysqli_query($link,$sql3);
			while($row3=mysqli_fetch_assoc($result3)){
				$sql4="SELECT COUNT(*) FROM wp_term_taxonomy,wp_terms,wp_dangky_dichvu,wp_dangky WHERE
				wp_term_taxonomy.term_id=wp_terms.term_id and
				wp_dangky_dichvu.id_dv=wp_terms.term_id and
				wp_dangky.id_dk=wp_dangky_dichvu.id_dk and
				wp_terms.term_id='".$row3['term_id']."'";
				$sql4.=" ";
				$sql4.=$chuoi2;
				$result4=mysqli_query($link,$sql4);
				$row4=mysqli_fetch_assoc($result4);
				echo"<tr><td>";
				if($temp!=$row['name'])
				{
					echo $row['name'];
					$temp=$row['name'];
				}
				echo "</td>";
				echo"<td>".$row3['name']."</td>
				<td>".$row4['COUNT(*)']."</td></tr>";
			}
		}
		?>
	</table>
</div>
<div> 
<?php  

}
if($_POST['type11']==2){
	$d1 = $_POST['d1'];
  $d2 = $_POST['d2'];
  $link=mysqli_connect('localhost','root','','vnpt') or die("Không thể kết nối");
  mysqli_set_charset($link, 'UTF8');
  $sql="SELECT * from wp_dangky";
  $result=mysqli_query($link,$sql);
  $khuvuc="";
  while($row=mysqli_fetch_array($result)){
    if ((date_12($row['date_created'],$d1)!=1) &&
      (date_12($d2,$row['date_created'])!=1)){
      $khuvuc.="'".$row['date_created']."'";
    $khuvuc.=",";
  }
  
}
if ($khuvuc!="") $khuvuc=substr($khuvuc,0,-1);
else $khuvuc=1000;
?>

<div id="result_kv">
  <div id="columnchart_values" style=""></div>
</div> 

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
  google.charts.load("current", {packages:['corechart']});
  google.charts.setOnLoadCallback(drawChart);
  function drawChart() {
    var data = google.visualization.arrayToDataTable([
      ["Element", "Số lượng", { role: "style" } ],
      <?php
      $link=mysqli_connect('localhost','root','','vnpt') or die("Không thể kết nối");
      mysqli_set_charset($link, 'UTF8');
      $sql="SELECT * FROM wp_khuvuc";
      $result=mysqli_query($link,$sql);
      if(!$result){
        die('Truy vấn sai');
      }
      $html1="";
      $chuoi1="";
      if (isset($khuvuc)&&$khuvuc!="") {
        $chuoi1.="and wp_dangky.date_created in (".$khuvuc.")";
      };
      while($row=mysqli_fetch_assoc($result)){
       $html1.="['".$row['name_kv']."',";
       $link=mysqli_connect('localhost','root','','vnpt') or die("Không thể kết nối");
       mysqli_set_charset($link, 'UTF8');
       $sql4="SELECT COUNT(*) FROM wp_khuvuc,wp_dangky WHERE
       wp_khuvuc.id_kv=wp_dangky.id_kv and
       wp_khuvuc.id_kv=".$row['id_kv'];
       $sql4.=" ";
       $sql4.=$chuoi1;
       $result4=mysqli_query($link,$sql4);
       $row4=mysqli_fetch_array($result4);

       $html1.=$row4['COUNT(*)'].",'#";
       $html1.=mt_rand(000000, 999999);
       $html1.="'],";
     }
     echo substr($html1, 0, -1);
     ?>])

    var view = new google.visualization.DataView(data);
    view.setColumns([0, 1,
     { calc: "stringify",
     sourceColumn: 1,
     type: "string",
     role: "annotation" },
     2]);

    var options = {
      title: "Số lượng đăng ký theo khu vực",
      width: 1150,
      height: 400,
      bar: {groupWidth: "80%"},
      legend: { position: "none" },
    };
    var chart = new google.visualization.ColumnChart(document.getElementById("columnchart_values"));
    chart.draw(view, options);
  }
</script>
<div align="center">
<table border="" style="border-collapse: collapse;">
  <tr>
    <th>Khu vực</th>
    <th>Số lượng ĐK</th>
  </tr>
  <?php


  $link=mysqli_connect('localhost','root','','vnpt') or die("Không thể kết nối");
  mysqli_set_charset($link, 'UTF8');
  $sql2="SELECT * FROM wp_khuvuc";
  $result2=mysqli_query($link,$sql2);
  if(!$result2){
    die('Truy vấn sai');
  }
  $chuoi1="";
  if (isset($khuvuc)&&$khuvuc!="") {
    $chuoi1.="and wp_dangky.date_created in (".$khuvuc.")";
  };
  while($row2=mysqli_fetch_assoc($result2)){
    ?>
    <tr>
      <td><?= $row2['name_kv']?></td>
      <?php
      $link=mysqli_connect('localhost','root','','vnpt') or die("Không thể kết nối");
      mysqli_set_charset($link, 'UTF8');
      $sql3="SELECT COUNT(*) FROM wp_khuvuc,wp_dangky WHERE
      wp_khuvuc.id_kv=wp_dangky.id_kv and
      wp_khuvuc.id_kv=".$row2['id_kv'];
      $sql3.=" ";
      $sql3.=$chuoi1;
      $result3=mysqli_query($link,$sql3);
      $row3=mysqli_fetch_array($result3);
      ?>
      <td><?php echo $row3['COUNT(*)'];?></td>
    </tr>
    <?php 
  }
  ?>
</table>
 
</div>
</div>
<?php 
}

}
?>
</div>



