
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
      width: 500,
      height: 400,
      bar: {groupWidth: "80%"},
      legend: { position: "none" },
    };
    var chart = new google.visualization.ColumnChart(document.getElementById("columnchart_values"));
    chart.draw(view, options);
  }
</script>

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

<?php  ?>