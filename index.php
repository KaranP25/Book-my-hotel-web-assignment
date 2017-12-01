<?php
include_once "connection.php";
date_default_timezone_set('Canada/Eastern');

function is_session_started()
{
    if ( php_sapi_name() !== 'cli' ) {
        if ( version_compare(phpversion(), '5.4.0', '>=') ) {
            return session_status() === PHP_SESSION_ACTIVE ? TRUE : FALSE;
        } else {
            return session_id() === '' ? FALSE : TRUE;
        }
    }
    return FALSE;
}

if ( is_session_started() === FALSE ) session_start();
?>

<!DOCTYPE html>
<html>
<head>
	<title>Hotel Booking</title>
	<link rel="stylesheet" type="text/css" href="css/styles.css<?php echo '?rnd_'.urlencode(time()).'='.urlencode(rand()); ?>"/>
	<script type="text/javascript" src="script/jscript.js<?php echo '?rnd_'.urlencode(time()).'='.urlencode(rand()); ?>"></script>

</head>
<body>  
	<script type="text/javascript">
		if(window.performance.navigation.type == 2){
			console.log(window.performance.navigation.type + " back pressed");
		    window.location.reload();
		}
	</script>

	<nav>
		<div class="section_1">
			<div class="logo_div">
				<a href="index.php"><img src="img/logo.png" id="logo"></a>
			</div>
			
			<?php
				if (isset($_SESSION['ses_valid'])) {
					echo "<button id='sign_out_btn' onclick='log_user_out()'>Sign Out</button>
						<p style='border:2px; border-style:dashed; border-color:#000000; padding: 0.5em;'>Welcome ".$_SESSION['gst_first_name']." ".$_SESSION['gst_last_name']."</p>
					";
				}else{
					echo "<button onclick='register_open()'>Register</button>
						<button onclick='login_open()'>Sign In</button>
						<h3 id='msg_to_nonuser'>* You are only allowed to look at the avalible room/hotel details.<br>To reserve a room please Sign-In or Register.</h3>
					";
				}
			?>

		</div>
	</nav>
	<div id="formWrap">
		<div class="section_2">
			<br>
			<table class="page_1_table">
				<tr class="page_1_table"  id="row_city">
					<td class="page_1_table" colspan="2">
						<label for="select_province">Province</label>
						<span class="fieldValid" id="prov_valid">* Required</span><br>
						<select name="Province" id="select_province" onchange="showCity(this.value)" required autofocus>
							<option id="prov_empty_opt">--Choose--</option>

							<?php
							$sql = "SELECT prv_id, prv_name FROM `province`";
							$result = $conn->query($sql);

							if ($result->num_rows > 0) {
	          				// output data of each row
								while($row = $result->fetch_assoc()) {
									echo "<option value=". $row["prv_id"].">" . $row['prv_name'] . "</option>";
								}
							} else {
								echo "0 results";
							}
							?>

						</select>			

					</td>
					<td id="city_td">
						<span id="resultProvinceValue"></span>
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<label for="check_in_date">Check-In</label>
						<span class="fieldValid" id="check_in">* Required</span><br>
						<input type="date" id="check_in_date" name="check_in_date" onclick="todayValid()" onchange="arrivalDateSet(this)" required>
					</td>
					<td>
						<label for="check_out_date">Check-Out</label>
						<span class="fieldValid" id="check_out">* Required</span><br>
						<input type="date" id="check_out_date" name="check_out_date" onclick="todayValid()" onchange="departureDateSet(this)" required>
					</td>
				</tr>

				<tr>
					<td>
						<label for="num_adults">Adults: </label><br>
						<select id="num_adults" required>
							<option value="1">1</option>
							<option value="2">2</option>
							<option value="3">3</option>
							<option value="4">4</option>
							<option value="5">5</option>
						</select>
					</td>
					<td>
						<label for="num_children">Children: </label><br>
						<select id="num_children" required> 
							<option value="0">0</option>
							<option value="1">1</option>
							<option value="2">2</option>
							<option value="3">3</option>
							<option value="4">4</option>
							<option value="5">5</option>
						</select>
					</td>
					<td style="text-align: center;">
						<input id="search" type="button" name="Search" value="Search" title='Please atleat select the province' onclick="submit()" >
					</td>
				</tr>
			</table>
		</div>
		<br><br><br><br> 
		<div id="section_3"></div>
	</div>

</body>
</html>