
	<b>Chọn năm&nbsp&nbsp&nbsp:</b>
	<select name="year_dk">
		<option value="0">--NULL--</option>
		<option value="2016">2016</option>
		<option value="2017">2017</option>
		<option value="2018">2018</option>
		<option value="2018">2019</option>
		<option value="2018">2020</option>

	</select>
	<br>
	<b>Chọn tháng :</b>
	<select name="month_dk">
		<option value="0">--NULL--</option>
		<option value="1">Tháng một</option>
		<option value="2">Tháng hai</option>
		<option value="3">Tháng ba</option>
		<option value="4">Tháng tư</option>
		<option value="5">Tháng năm</option>
		<option value="6">Tháng sáu</option>
		<option value="7">Tháng bảy</option>
		<option value="8">Tháng tám</option>
		<option value="9">Tháng chín</option>
		<option value="10">Tháng mười</option>
		<option value="11">Tháng mười một</option>
		<option value="12">Tháng mười hai</option>
	</select>
	<br>
	<b>Chọn ngày&nbsp&nbsp:</b>
	<select name="day_dk">
		<option value="0">--NULL--</option>
		<option value="1">1</option>
		<option value="2">2</option>
		<option value="3">3</option>
		<option value="4">4</option>
		<option value="5">5</option>
		<option value="6">6</option>
		<option value="7">7</option>
		<option value="8">8</option>
		<option value="9">9</option>
		<option value="10">10</option>
		<option value="11">11</option>
		<option value="12">12</option>
		<option value="13">13</option>
		<option value="14">14</option>
		<option value="15">15</option>
		<option value="16">16</option>
		<option value="17">17</option>
		<option value="18">18</option>
		<option value="19">19</option>
		<option value="20">20</option>
		<option value="21">21</option>
		<option value="22">22</option>
		<option value="23">23</option>
		<option value="24">24</option>
		<option value="25">25</option>
		<option value="26">26</option>
		<option value="27">27</option>
		<option value="28">28</option>
		<option value="29">29</option>
		<option value="30">30</option>
		<option value="31">31</option>
	</select>
	<br>
	<button class="btn btn-primary btn-sm" type="submit" name="submit_date">Submit</button>
	<br>
	<br/>
	<table border="" style="border-collapse: collapse;">
		<tr>
			<th>Năm</th>
			<th>Số lượng ĐK</th>
		</tr>
		<?php
		$link=mysqli_connect('localhost','root','','vnpt') or die("Không thể kết nối");
		mysqli_set_charset($link, 'UTF8');
		$year=2017;
		?>
		<tr>
			<?php
			for($i=0;$i<12;$i++){
				if ($i==5) echo "<td>".$year."</td>";
				echo"";
			}
			?>
		</tr>

	</table>
</div>