<!DOCTYPE html>
<html>
<head>
	<title>Register</title>
	<link rel="stylesheet" type="text/css" href="css/styles.css<?php echo '?rnd_'.urlencode(time()).'='.urlencode(rand()); ?>"/>
	<script type="text/javascript" src="script/jscript.js<?php echo '?rnd_'.urlencode(time()).'='.urlencode(rand()); ?>"></script>
</head>
<body>
	<div style="width: 50%; margin: auto; margin-top: 2%; ">
	<?php
		session_start();
		if (!isset($_SESSION['ses_valid'])) {
			echo "<div style='margin:auto;' class='logo_div_mid'>
					<a href='index.php'><img src='img/logo.png' class='mid_logo' id='logo_mid'></a>
				</div>
				<h3 id='msg_to_nonuser'>* You are only allowed to look at the avalible room/hotel details.<br>To reserve a room please Sign-In or Register.</h3>";				
		}
	?><br>
	</div>


	<?php
	include_once "connection.php";

	date_default_timezone_set('Canada/Eastern');

	##########Initial output to Jscript array#############
	$sql_check = "SELECT * FROM guest";
	$result_check = $conn->query($sql_check);
	
	if ($result_check->num_rows > 0) {
          // output data of each row
		while($row = $result_check->fetch_assoc()) {

			$all_usernames[] = strval($row['Gst_username']);
			$all_emails[] =  strval($row['Gst_email']);
		}
	}
	######################################################
	
	echo (isset($_POST["register_btn"]));

	if(isset($_POST["register_btn"])){
		$reg_gst_fname = $_POST["first_name"];
		$reg_gst_lname = $_POST["last_name"];
		$reg_gst_email = $_POST["email"];
		$reg_date_today = date("Y-m-d");
		$reg_gst_username = $_POST["username"];
		$reg_gst_pass = $_POST["password"];

		mysqli_select_db($conn,"guest");

		$sql = "SELECT Gst_id FROM guest";
		$result = $conn->query($sql);

		$sql_check = "SELECT * FROM guest";
		$result_check = $conn->query($sql_check);


		if ($result_check->num_rows > 0) {
          // output data of each row
			while($row = $result_check->fetch_assoc()) {
				
				$Gst_username = strval($row['Gst_username']);
				$Gst_email =  strval($row['Gst_email']);

				if($Gst_username == $reg_gst_username || $Gst_email == $reg_gst_email){
					$same_found = true;
					if($Gst_username == $reg_gst_username && $Gst_email == $reg_gst_email){
						console('Username and Email Already Exist in database...\nPlease Enter a different email and username.');
					}else if($Gst_username == $reg_gst_username){
						console('Username Already Exist in database...\nPlease Enter another one.');
					}else if($Gst_email == $reg_gst_email){
						console('Email Already Exist in database...\nPlease Enter a new Email.');
					}
					break;					
				}else{
					$same_found = false;	
				}

			}

			if(!$same_found){
				addToDatabase($conn, $sql, $result, $reg_gst_fname, $reg_gst_lname, $reg_gst_email, $reg_date_today, $reg_gst_username, $reg_gst_pass);
			}
		}else if ($result->num_rows <= 0) {
			addToDatabase($conn, $sql, $result, $reg_gst_fname, $reg_gst_lname, $reg_gst_email, $reg_date_today, $reg_gst_username, $reg_gst_pass);
		}

	}
	$conn->close();

	function console($msg) {
		echo "<script type='text/javascript'>console.log('$msg');</script>";
	}

	function addToDatabase($conn, $sql, $result, $reg_gst_fname, $reg_gst_lname, $reg_gst_email, $reg_date_today, $reg_gst_username, $reg_gst_pass){
		if($result->num_rows <= 0){
			$Gst_id = 1;
		}
		else{
			$Gst_id = 1 + $result->num_rows;
		}

		$sql_addTo = "INSERT INTO guest (Gst_id, Gst_first_name, Gst_last_name, Gst_member_since, Gst_username, Gst_email, Gst_password)  VALUES ($Gst_id, '$reg_gst_fname', '$reg_gst_lname', '$reg_date_today', '$reg_gst_username', '$reg_gst_email', '$reg_gst_pass')";

		if ($conn->query($sql_addTo) === TRUE) {
			//echo "New record created successfully";
			if(isset($_GET['roomReserved'])){
				header ("Location: register_confirm_pg.php?gst_id=" . $Gst_id . "&roomReserved=" .$_GET['roomReserved'] . "&room=" .$_GET['room']. "&htl=" .$_GET['htl'] . "&totPrice=" .  $_GET['totPrice']);
			}else{
				header ("Location: register_confirm_pg.php?gst_id=" . $Gst_id);
			}
			
		} else {
			echo "Error: " . $sql_addTo . "<br>" . $conn -> error;
		}
	}

	?>


	<div class="reglogin_pg">
		<div class="reglogin_nav">
			<a href="javascript:history.go(-1)" ><img src="img/back_arrow.png"></a>
			<h1 style="text-decoration: underline;">Register to book a hotel</h1>

			<?php
			if(!isset($_GET['roomReserved'])){
				echo "<a id='kk' href='register.php'><img src='img/refresh.png'></a>";
			}?>
		</div>
		<?php 
			if(isset($_GET['roomReserved'])){
				$rko = "register.php?roomReserved=" .$_GET['roomReserved']. "&room=" .$_GET['room']. "&htl=" .$_GET['htl']. "&totPrice=" .$_GET['totPrice'] ;
			}
		?>
		<form id="reg_form" method="post" action="<?php if(isset($_GET['roomReserved'])){ echo($rko);}else{echo ("register.php");}?>" onsubmit="return registerButton();">

			

			<div class="register_form">
				<label for="first_name">Enter your First Name: </label>
				<span class="fieldValid" id="fname_valid">* Required</span><br>
				<input type="text" id="first_name" name="first_name" autofocus required placeholder="John" onblur="this.placeholder = 'John'" pattern="[a-zA-Z ]{3,10}" title="Please enter more than three letter for the first name. &#10;ex. John &#10;&#10;Input only charcters that are at least 3 charcters long."><br><br>

				<label for="last_name">Enter your Last Name: </label>
				<span class="fieldValid" id="lname_valid">* Required</span><br>
				<input type="text" id="last_name" name="last_name" required placeholder="Smith" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Smith'" pattern="[a-zA-Z ]{3,15}" title="Please enter more than three letter for the last name. &#10;ex. Smith &#10;&#10;Input only charcters that are at least 3 charcters long."><br><br>

				<label for="email">Enter your Email Address:</label>
				<span class="fieldValid" id="email_valid">* Required</span><br>
				<input type="email" id="email" name="email" required placeholder="unknown@ree.com" minlength="3" onfocus="this.placeholder = ''" onblur="this.placeholder = 'unknown@ree.com'"><br><br>

				<label for="username">Creat a Username: </label>
				<span class="fieldValid" id="username_valid">* Required</span><br>
				<input type="text" id="username" name="username" required placeholder="jhon23s" minlength="5" maxlength="15" onfocus="this.placeholder = ''" onblur="this.placeholder = 'jhon23s'">
			</div>

			<table id="register_tbl">
				<tr>
					<td>
						<label for="password">Create a Password: </label>
						<input type="password" id="password" name="password" required placeholder="******" minlength="6" maxlength="12" onfocus="this.placeholder = ''" onblur="this.placeholder = '6-12 charcter long'" title="Enter a 6 - 12 digit long password [Case sensitivity]"><br>
						<span class="fieldValid" id="pass_valid">* Required. 6 - 12 Characters Long.</span>
					</td>

					<td>
						<label for="re_password">Confirm your Password: </label>
						<input type="password" id="re_password" name="re_password" required placeholder="******" minlength="6" maxlength="12" onfocus="this.placeholder = ''" onblur="this.placeholder = '6-12 charcter long'" title="Enter the same pass as above. &#10;Enter a 6 - 12 digit long password [Case sensitivity]"><br>
						<span class="fieldValid" id="repass_valid">* Required. 6 - 12 Characters Long.</span>
					</td>
				</tr>
				<tr >
					<td colspan="2">
						<div class="reg_btn_div">

							<input type="submit" id="register_btn" name="register_btn" value="Register" title='Make sure all fields are entered'><br>
							<?php
								if(!isset($_GET['roomReserved'])){
									echo "<a href='login_pg.php'>Already registered? Click Here to Login</a>";
								}
							?>
							
						</div>
					</td>
				</tr>

			</table>

		</form>		

	</div>

	<script type="text/javascript">
		var js_array_database_username = <?php echo json_encode($all_usernames); ?>; // php array to jscript
		var js_array_database_email = <?php echo json_encode($all_emails); ?>; // php array to jscript

		console.log(js_array_database_username);
		console.log(js_array_database_email);
	</script>
</body>
</html>