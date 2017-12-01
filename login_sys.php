<?php
	include_once "connection.php";
	session_start();
	session_set_cookie_params(0);


	if (isset($_POST['username'])) {
		$username=$_POST['username'];
		$password=$_POST['password'];

		$sql="SELECT * FROM guest WHERE Gst_username='".$username."' AND Gst_password='".$password."' LIMIT 1";

		$get_login=mysqli_query($conn,$sql);

		$row = $get_login->fetch_assoc();

		if (mysqli_num_rows($get_login) > 0) {

			echo "You have successfully logged in.\n";

			$_SESSION['ses_valid'] = 'valid';
			$_SESSION['gst_id'] = $row['Gst_id'];
			$_SESSION['gst_email'] = $row['Gst_email'];
			$_SESSION['gst_first_name'] = $row['Gst_first_name'];
			$_SESSION['gst_last_name'] = $row['Gst_last_name'];
			

			echo (strval($row['Gst_id']));
			echo ($_SESSION['gst_first_name']);
			echo "\n";
			echo (strval($row['Gst_last_name']));

			//session_destroy();
			if(!isset($_GET['roomReserved'])){
				header("Location:index.php");
			}else{
				$rko = "Location:confirmation_pg.php?room=" . (string)$_GET['room'] . "&htl=" . (string)$_GET['htl'] . "&totPrice=" . (string)$_GET['totPrice'] ."'";
				echo "$rko";
				header("$rko");
			}
			
			//exit();
		}
		else{
			header("Location:login_pg.php?msg=1");
			echo "Invalid Login Information.Please try again";
			//exit(); 
		}
	}

?>