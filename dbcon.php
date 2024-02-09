<?php 

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbName = "registration";
    // Create connection
    $conn =new mysqli($servername, $username, $password, $dbName);
    if (!$conn) {
        die("Connection failed: ");
      }

    else{
        echo "Connected successfully";
    }
     

?>