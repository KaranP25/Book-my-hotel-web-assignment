<!DOCTYPE html>
<html>
<head>
<title>Images</title>
</head>
<body>
  <?php 
  	include_once "connection.php";

    $id=$_GET['id'];
    $sql = "SELECT * FROM pictures WHERE image_id = $id ";
    $result = $conn->query($sql);

  	if ($result->num_rows > 0) {
  		while($row = $result->fetch_assoc()) {
  			echo '<img src="data:image/jpeg;base64,'.base64_encode( $row['image'] ).'"/>';
  		}
  	} 
  	else {
      echo "<h1 style='text-align: center;'>Image not found...</h1>";
    }
          
    $conn->close();
  ?>
</body>
</html>