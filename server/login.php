<?php

require_once './config.php';

if ( !isset($_POST['username']) ) 
{
	exit();
}

$username = trim($_POST['username']);
$sql = "SELECT id FROM users WHERE username = '$username'";
$status = 1;
$message = '';

$result = $mysqli->query($sql);

if ($result->num_rows != 0) 
{
	$message = "This username is already taken.";
  $status = 0;
}
else
{
	$sql = "INSERT INTO users (username) VALUES ('$username')";

	if ($mysqli->query($sql) === TRUE) 
	{
		$message = "Welcome $username!";
	}
	else 
	{
	  $message = "Something went wrong!";
	  $status = 0;
	}
}

echo json_encode([
	'status' => $status,
	'message' => $message
]);