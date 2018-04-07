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
			width: 1000,
			height: 400,
			bar: {groupWidth: "80%"},
			legend: { position: "none" },
		};
		var chart = new google.visualization.ColumnChart(document.getElementById("columnchart_values2"));
		chart.draw(view, options);
	}
</script>
<div id="result_kv2">
	<div id="columnchart_values2" style=""></div>
</div>
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
<?php  ?>