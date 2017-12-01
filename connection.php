<?php
    $servername = "ca-cdbr-azure-east-a.cloudapp.net";
    $username =   "bd9fd31126a687";
    $password =   "c6e7e46d";
    $dbname =     "myhoteldb";
    $conn = new mysqli($servername, $username, $password, $dbname);

        // Check connection
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }

?>