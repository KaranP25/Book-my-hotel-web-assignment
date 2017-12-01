<!DOCTYPE html>
<html>
<head>
	<title>Hotel Booking pg 2</title>
	<link rel="stylesheet" type="text/css" href="css/styles.css<?php echo '?rnd_'.urlencode(time()).'='.urlencode(rand()); ?>"/>
	<script type="text/javascript" src="script/jscript.js<?php echo '?rnd_'.urlencode(time()).'='.urlencode(rand()); ?>"></script>
</head>
<body>
	<nav>
		<div class="section_1">
			<?php
				session_start();
				if (!isset($_SESSION['ses_valid'])) {
					echo "<div style='margin:auto;' class='logo_div_mid'>
							<a href='index.php'><img src='img/logo.png' class='mid_logo' id='logo_mid'></a>
						</div>
						<h3 id='msg_to_nonuser'>* You are only allowed to look at the avalible room/hotel details.<br>To reserve a room please Sign-In or Register.</h3>";				
				}else{
					echo "<div class='logo_div'>
							<a href='index.php'><img src='img/logo.png' id='logo'></a>
						</div>
						<button id='sign_out_btn' onclick='log_user_out()'>Sign Out</button>
						<p style='border:2px; border-style:dashed; border-color:#000000; padding: 0.5em;'>Welcome ".$_SESSION['gst_first_name']." ".$_SESSION['gst_last_name']."</p>";

				}
			?>

		<div ">
	</nav>
	<div class="pg2_div" >
		<h1>Viewing More Details:</h1>
		<br><br>
		<table class="page_2_table">
			
			<?php
			include_once "connection.php";
			date_default_timezone_set('Canada/Eastern');
			//session_start();

			//mon - thu -> weekdays ; fri - sun -> weekends
			//$gst_stay_weekday_nights = echo "<script>document.writeln(stayWeekdayDays);</script>";
			//$gst_stay_weekend_nights = ;
			//

			//echo "<script>document.writeln(getDays());</script>";

			$room_htl_id = intval($_GET['room']);
			$weekdays_stay = intval($_GET['weekday_days']);
			$weeknights_stay = intval($_GET['weekend_days']);

			$weekday_nights_stay = $weekdays_stay - 1;
			$weekend_nights_stay = $weeknights_stay;

			//echo "$weekday_nights_stay", '<br>',"$weekend_nights_stay";

			///////////////////////////////////////////////////////////////////////////////////////////////////////////////

			mysqli_select_db($conn,"room");
			$sql = "SELECT * FROM room WHERE Rm_Hotel_id ='" . $room_htl_id . "'";
			$result = mysqli_query($conn, $sql);

			if ($result->num_rows > 0) {
	          // output data of each row
				echo"<tr>
				<th>Room</th>
				<th>Info</th>
				<th>Price/Reserve</th>
				</tr>";

				while($row = $result->fetch_assoc()) {
					$room_type = intval($row['room_type_id']);
					$sqllll = "SELECT * FROM room_type WHERE Typ_id ='" . $room_type . "'" ;
					$type_room = $conn->query($sqllll);
					$type = $type_room->fetch_assoc();

					if(intval($row['Rm_status'] == 0)){ ///////////////// Check if the statsus of room is 0 before showing the

						$total_room_price = $weekday_nights_stay*($row["Rm_price"]) + $weekend_nights_stay*($row["Rm_price_weekend"]);

						$get_smoking = "";
						if($row['Rm_smoke'] == 0){$get_smoking = "Yes";}else{$get_smoking = "No";}

						$get_parking = "";
						if($row['Rm_free_barking'] == 1){$get_parking = "Yes";}else{$get_parking = "No";}

						$get_internet = "";
						if($row['Rm_free_internet'] == 1){$get_internet = "Yes";}else{$get_internet = "No";}

						$get_breakfast = "";
						if($row['Rm_free_breakfast'] == 1){$get_breakfast = "Yes";}else{$get_breakfast = "No";}
						echo "<tr>
						<td>
						<p value=". $row["Rm_name"].">" . $row['Rm_name'] . ":</p>
						</td>
						<td>
						<p value=". $type["Typ_description"].">" . $type["Typ_description"] . " room</p>

						<p>Non-smoking: " . $get_smoking . "</p>
						<p>Free-parking: " . $get_parking . " </p>
						<p>Free-internet: " . $get_internet . "</p>
						<p>Free-Breakfast: " . $get_breakfast . "</p>
						</td>

						<td id='price_display_col'>
						<p value=". $row["Rm_price"].">Price (Week Days): $ ". $row["Rm_price"]." x ".$weekday_nights_stay." nights</p>
						<p value=". $row["Rm_price"].">Price (Week Days): $ ". $row["Rm_price_weekend"]." x ".$weekend_nights_stay." nights</p>
						<p id='total_price_btax' value=". $row["Rm_price"].">Price (before tax): $ ". $total_room_price." </p>";

						if (isset($_SESSION['gst_first_name'])) {
							echo "<button id=". $row["Rm_id"]."  onclick='confirmStay(this.id, $room_htl_id, $total_room_price)' >Reserve</button>";
						}else{
							echo "<button id=". $row["Rm_id"]." onclick='confirmStayButNotLoggedIn(this.id, $room_htl_id, $total_room_price)'>Reserve</button>";
						}
						echo"</td>
						</tr>";
					}

				}


			}else {
				echo "<h2 style='text-align: center;' id='noRoom'>NO ROOMS AVAILABLE FOR THIS HOTEL :(</h2>";
				echo "<h3 style='text-align: center;' id='noRoom'>Please try another hotel...</h3>";
			}

			mysqli_close($conn);

			?>

		</table>
	</div>

</body>
</html>