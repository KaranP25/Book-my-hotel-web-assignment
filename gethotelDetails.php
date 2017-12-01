<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" type="text/css" href="css/styles.css<?php echo '?rnd_'.urlencode(time()).'='.urlencode(rand()); ?>"/>
	<script type="text/javascript" src="script/jscript.js<?php echo '?rnd_'.urlencode(time()).'='.urlencode(rand()); ?>"></script>
</head>
<body>
	<table class="table_hotel_details">
		<?php
		include_once "connection.php";

		$htl = intval($_GET['htl']);

		mysqli_select_db($conn,"hotel");
		$sql = "SELECT * FROM hotel WHERE Htl_city_id ='" . $htl . "'";
		$result = mysqli_query($conn, $sql);

		if ($result->num_rows > 0) {
	          // output data of each row
			while($row = $result->fetch_assoc()) {
				$hotel_id = intval($row['Htl_id']);
				$sqllll = "SELECT * FROM pictures WHERE hotel_id ='" . $hotel_id . "'" ;
      			$new_img = $conn->query($sqllll);
      			$img = $new_img->fetch_assoc();
				echo "<tr>
							<td>
								<img id='hotel_images' src='data:image/jpeg;base64,".base64_encode( $img['image'] )."'/>
							</td>
							<td>
								<p value=". $row["Htl_name"].">" . $row['Htl_name'] . "</p>
								<p value=". $row["Htl_address"].">" . $row['Htl_address'] . "</p>
								<p value=". $row["Htl_postalCode"].">" . $row['Htl_postalCode'] . "</p>
							</td>
							<td>
								<button id=". $row["Htl_id"]." onclick='updateSessionWithDates(this.id)'>View Deals</button>
							</td>
					</tr>";				
			}
		} else {
			echo "<h1 id='noRoom'>NO HOTELS AVAILABLE</h1>";
		}

		mysqli_close($conn);

		?>
	</table>
</body>
</html>
