<?php 

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "140wpm";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
 
// Check connection
if($conn->connect_error)
{
	echo json_encode(['status' => 0]);
	exit();
}