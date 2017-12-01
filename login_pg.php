<!DOCTYPE html>
<html>
<head>
	<title>Login</title>
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
	?><br><br>
	</div>
	
	<div class="reglogin_pg">
		<div class="reglogin_nav">
			<a href="javascript:history.go(-1)" ><img src="img/back_arrow.png"></a>
			<h1 style="text-decoration: underline;">Login to book a hotel</h1>
			<?php
			if(!isset($_GET['loggedInAfterReserve'])){
				echo "<a id='kk' href='login_pg.php'><img src='img/refresh.png'></a>";
			}?>
		</div>

		<?php 
			if(isset($_GET['loggedInAfterReserve'])){
				$rko = "login_sys.php?roomReserved=" .$_GET['loggedInAfterReserve']. "&room=" .$_GET['room']. "&htl=" .$_GET['htl']. "&totPrice=" .$_GET['totPrice'] ;
			}
		?>		
		<form id="login_form" method="post" action="<?php if(isset($_GET['loggedInAfterReserve'])){ echo($rko);}else{echo ("login_sys.php");}?>" onsubmit="return registerButton();" >
			<div class="log_form">

				<span id="login_msg" ></span><br>
				<?php
				if(isset($_GET['msg'])){
					$message = $_GET['msg'];
					$disp_msg = 'Invalid Login. Try Again.';
					if($message == 1){
						echo "<script type='text/javascript'>
							document.getElementById('login_msg').innerHTML = '$disp_msg';
							
						</script>";
					}
				}
				?>
				
				<label for="username">Enter Your Username: </label>
				<span class="fieldValid" id="username_valid">* Required</span><br>
				<input type="text" id="username" name="username" required placeholder="jhon23s" minlength="5" maxlength="15" onfocus="this.placeholder = ''" onblur="this.placeholder = 'jhon23s'">
				<br><br>

				<label for="password">Enter Your Password: </label>
				<input type="password" id="password" name="password" required placeholder="******" minlength="6" maxlength="12" onfocus="this.placeholder = ''" onblur="this.placeholder = '6-12 charcter long'" title="Enter a 6 - 12 digit long password [Case sensitivity]"><br>
				<span class="fieldValid" id="pass_valid">* Required. 6 - 12 Characters Long.</span>

				<div class="reg_btn_div">
					<input type="submit" id="login_btn" name="login_btn" value="Login" title='Make sure all fields are entered'><br>
					<?php
						if(isset($_GET['loggedInAfterReserve'])){
							$ref = "register.php?roomReserved=false&room=" .$_GET['room']. "&htl=" .$_GET['htl'] . "&totPrice=" .  $_GET['totPrice'];
							echo "<a href='$ref' >Dont Have an Account? Click Here to Register</a>";
						}else{
							echo "<a href='register.php'>Dont Have an Account? Click Here to Register</a>";
						}
					?>
					

					

				</div>
			</div>

		</form>		


	</div>
</body>
</html>