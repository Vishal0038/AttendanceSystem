<?php
$servername = "localhost";
$username = "root";
$password = "";
$filename= "Employee";

// Create connection
$DB_Connection = new mysqli($servername, $username, $password,$filename);

// Check connection
// if ($DB_Connection->connect_error) {
//   die("Connection failed: " . $DB_Connection->connect_error);
// }
// echo "Connected successfully";
?>