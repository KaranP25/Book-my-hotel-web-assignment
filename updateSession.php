<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" type="text/css" href="css/styles.css<?php echo '?rnd_'.urlencode(time()).'='.urlencode(rand()); ?>"/>
	<script type="text/javascript" src="script/jscript.js<?php echo '?rnd_'.urlencode(time()).'='.urlencode(rand()); ?>"></script>
</head>
<body>
	<?php
	include_once "connection.php";

	session_start();

	$room_htl_id = intval($_GET['room']);
	$check_in_date = strval($_GET['checkIn']);
	$check_out_date = strval($_GET['checkOut']);
	$weekdays_stay = intval($_GET['weekday_days']);
	$weeknights_stay = intval($_GET['weekend_days']);

	$_SESSION['check_in_date'] = $check_in_date;
	$_SESSION['check_out_date'] = $check_out_date;
	$_SESSION['total_night_stay'] = ($weekdays_stay - 1) + $weeknights_stay;

	//echo $check_in_date;
	//echo  $check_out_date;

	echo "<script type='text/javascript'>viewHtlDetails($room_htl_id, $weekdays_stay, $weeknights_stay);</script>";
	//echo "<button onclick='goBack()'>click me</button>";
		mysqli_close($conn);

	?>
</body>
</html>
