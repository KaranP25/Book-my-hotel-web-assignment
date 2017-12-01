<!DOCTYPE html>
<html>
<head>
	<title>Hotel Booked!</title>
	<link rel="stylesheet" type="text/css" href="css/styles.css<?php echo '?rnd_'.urlencode(time()).'='.urlencode(rand()); ?>"/>
	<script type="text/javascript" src="script/jscript.js<?php echo '?rnd_'.urlencode(time()).'='.urlencode(rand()); ?>"></script>
</head>
<body>
	<div class="booked_hotel">
		<?php
		include_once "connection.php";
		date_default_timezone_set('Canada/Eastern');
		session_start();

		if(isset($_POST["confirm_stay_btn"])){
			$book_date_in = $_SESSION['check_in_date'];
			$book_date_out = $_SESSION['check_out_date'];
			$book_gst_fname = $_SESSION['gst_first_name'];
			$book_gst_lname = $_SESSION['gst_last_name'];
			$book_gst_id = (int)$_SESSION['gst_id'];
			$book_num_of_nights = (int)$_SESSION['total_night_stay'];
			$book_date = date("Y-m-d");

			$book_room_id = intval($_POST["room"]);
			$htl_id = intval($_POST["htl"]);

		//echo "$book_room_id";
		//echo "$book_num_of_nights";

			mysqli_select_db($conn,"booking");

			$sql = "SELECT Bok_id FROM booking";
			$result = $conn->query($sql);

			if($result->num_rows <= 0){
				$book_id = 1;
			}
			else{
				$book_id = 1 + $result->num_rows;
			}

		//ADDING TO BOOKINGS
			$book_fullname = $book_gst_fname. ' ' .$book_gst_lname;

		//echo "$book_fullname";
		//echo "$book_date";

			$sql_addTo = "INSERT INTO booking (Bok_id, Bok_date_in, Bok_date_out, Bok_made_by, Bok_guest_id, Bok_number_of_nights, Bok_Booking_date, Bok_room_id)  VALUES ($book_id, '$book_date_in', '$book_date_out', '$book_fullname', $book_gst_id, $book_num_of_nights, '$book_date', $book_room_id)";

			if ($conn->query($sql_addTo) === TRUE) {
				echo '<p>Your booking has been complete.</p>';
			} else {
				echo '<p>Error: " . $sql_addTo . "<br>" . $conn -> error "</p>';
			}

		//UPDATED BOOKED ROOM STATUS
			$status_room_sql = "UPDATE room SET Rm_status='1' WHERE Rm_id=" . $book_room_id;

			if ($conn->query($status_room_sql) === TRUE) {
				echo '<p>Room reserved: &#x2713;</p><br>
				<p>See You Soon!</p>
				<h2>&#9786;</h2>';
			} else {
				echo '<p>Error: " . $sql_addTo . "<br>" . $conn -> error "</p>';
			}
		}

		?>


		<button onclick="window.location.href='index.php'">Go To Home Page</button>
		<button id='sign_out_btn' onclick='log_user_out()'>Sign Out</button>
	</div>
</body>
</html>

