<?php
$host = "localhost";
$dbname = "student_mgmt_system";
$username = "root";  
$password = "";      

// Create connection
$conn = mysqli_connect($host, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

//echo "Database connected successfully";
?>
