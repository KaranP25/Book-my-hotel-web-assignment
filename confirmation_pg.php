<!DOCTYPE html>
<html>
<head>
	<title>Confirm your Stay</title>
	<link rel="stylesheet" type="text/css" href="css/styles.css<?php echo '?rnd_'.urlencode(time()).'='.urlencode(rand()); ?>"/>
	<script type="text/javascript" src="script/jscript.js<?php echo '?rnd_'.urlencode(time()).'='.urlencode(rand()); ?>"></script>
</head>
<body>
	<?php
		session_start();
		//echo ($_SESSION['gst_email']);

		$room_id = intval($_GET['room']);
		$htl_id = intval($_GET['htl']);
		$total_price = intval($_GET['totPrice']);

		//echo "$room_id";
		//echo "<br>";
		//echo "$htl_id";
	?>
	<div class="confirm_pg">
		<div class="reglogin_nav">
			<a href="javascript:history.go(-1)" ><img src="img/back_arrow.png"></a>
			<h1 style="text-decoration: underline;">Confirm Your Stay</h1>
			<!--<a id="kk" href="register.php" ><img src="img/refresh.png"></a>-->
		</div>
		<form id="confirm_form" method="post" action="confirming_booking.php?" onsubmit="return confirmButton('<?php echo ($_SESSION['gst_email']);?>');">
			<br><br>
			<div id="confirm_email_div">
				<label for="confirm_email">Enter your Email to confirm stay:</label><br>
				<span class="fieldValid" id="confirm_email_valid" style="font-size: 12px;">* Required</span><br>
				<input type="email" id="confirm_email" name="confirm_email" required placeholder="unknown@ree.com" minlength="3" onfocus="this.placeholder = ''" onblur="this.placeholder = 'unknown@ree.com'">

				<br><br>
				<input type="hidden" name="room" value="<?php echo ($room_id); ?>" />
				<input type="hidden" name="htl" value="<?php echo ($htl_id); ?>" />
				<input type="hidden" name="totPrice" value="<?php echo ($total_price); ?>" />

				<input type="submit" id="confirm_stay_btn" name="confirm_stay_btn" value="Confirm Stay" title='confirm your email to book your stay' onclick=""><br>

			</div>
		</form>
	</div>
</body>
</html>