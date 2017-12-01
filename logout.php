<?php
session_start();
session_destroy();
//echo 'You have been logged out. <a href="/">Go back</a>';
?>

<!DOCTYPE html>
<html>
<head>
	<title>LogOut Page</title>
	<link rel="stylesheet" type="text/css" href="css/styles.css<?php echo '?rnd_'.urlencode(time()).'='.urlencode(rand()); ?>"/>
	<script type="text/javascript" src="script/jscript.js<?php echo '?rnd_'.urlencode(time()).'='.urlencode(rand()); ?>"></script>
</head>
<body>

	<div class="logout_pg">
		<p>You have been logged out.</p>
		<p>See You Next Time.</p>
		<h2>&#9786;</h2>

		<button onclick="window.location.href='index.php'">Go To Home Page</button>
	</div>
	

</body>
</html>