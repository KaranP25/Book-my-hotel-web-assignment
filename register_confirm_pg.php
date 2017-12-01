<!DOCTYPE html>
<html>
<head>
	<title>Register Confirmed</title>
	<link rel="stylesheet" type="text/css" href="css/styles.css<?php echo '?rnd_'.urlencode(time()).'='.urlencode(rand()); ?>"/>
	<script type="text/javascript" src="script/jscript.js<?php echo '?rnd_'.urlencode(time()).'='.urlencode(rand()); ?>"></script>
</head>
<body>

	<?php
		include_once "connection.php";
		date_default_timezone_set('Canada/Eastern');
		session_start();

		if(isset($_GET["gst_id"])){
			$guest_id = intval($_GET["gst_id"]);

			$sql="SELECT * FROM guest WHERE Gst_id='".$guest_id."' LIMIT 1";

			$get_login=mysqli_query($conn,$sql);

			$row = $get_login->fetch_assoc();

			if (mysqli_num_rows($get_login) > 0) {
				echo "<script type='text/javascript'>console.log('You have successfully logged in.');</script>";

				$_SESSION['ses_valid'] = 'valid';
				$_SESSION['gst_id'] = $row['Gst_id'];
				$_SESSION['gst_email'] = $row['Gst_email'];
				$_SESSION['gst_first_name'] = $row['Gst_first_name'];
				$_SESSION['gst_last_name'] = $row['Gst_last_name'];

			}else{
				echo "";
				echo "<script type='text/javascript'>console.log('Invalid registration Information.Please try again');</script>";//exit(); 
			}

		}

	?>

	<div class="reg_confirm">
		<p>Registration Complete!</p>
		<?php			
			if(isset($_GET['roomReserved'])){
				echo "<p>You can now reserve your room!</p>
					<h2>&#9786;</h2>";

				$pageToSendTo = "window.location.href='confirmation_pg.php?room=" . (string)$_GET['room'] . "&htl=" . (string)$_GET['htl'] . "&totPrice=" . (string)$_GET['totPrice'] ."'";
				echo "<button onclick=".$pageToSendTo.">Now Confirm your stay</button>";
			}else{
				echo "<p>You can now book a room!</p>
					<h2>&#9786;</h2>";
				$x = "window.location.href='index.php'";
				echo "<button onclick=".$x.">Go To Home Page</button>";
			}
		?>		
	</div>
</body>
</html>