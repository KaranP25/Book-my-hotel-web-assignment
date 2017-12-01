<!DOCTYPE html>
<html>
<body>
	<link rel="stylesheet" type="text/css" href="css/styles.css<?php echo '?rnd_'.urlencode(time()).'='.urlencode(rand()); ?>"/>
	<script type="text/javascript" src="script/jscript.js<?php echo '?rnd_'.urlencode(time()).'='.urlencode(rand()); ?>"></script>
	
	
		<?php
		include_once "connection.php";
		
		/*$conn = mysqli_connect('localhost','hbs@localhost','hbs','hotel_booking');
		if (!$conn) {
			die('Could not connect: ' . mysqli_error($conn));
		}*/

		$q = intval($_GET['q']);
		'<br>';

		mysqli_select_db($conn,"city");
		$sql="SELECT * FROM city WHERE Cty_province_id = '".$q."'";
		$result = mysqli_query($conn,$sql);


		if ($result->num_rows > 0) {
          // output data of each row
			echo "<label for='city_select'>City</label>
					<span class='fieldValid' id='city_valid'>* Required</span><br>
					<select name='city' id='city_select' onchange='cityChange()''>
					<option id='city_empty_opt'>--Choose--</option>";
			while($row = $result->fetch_assoc()) {
				if($result != 0){
					echo "<option value=". $row["Cty_id"].">" . $row['Cty_Name'] . "</option>";
				}
			}
			echo "</select>";
		} else {
			echo "<p id='nocities_msg'>No Cities</p>";
		}

		mysqli_close($conn);
		?>	
</body>
</html>




