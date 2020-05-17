<?php

require_once './config.php';

if ( !isset($_POST['username']) || !isset($_POST['speed']) ) 
{
	exit();
}

$username = $_POST['username'];
$speed = $_POST['speed'];

$sql = "SELECT id FROM users WHERE username = '$username'";

$id = $mysqli->query($sql)->fetch_array()['id'];

$sql = "INSERT INTO `score`(`user_id`, `speed`) VALUES ($id, $speed)";

$mysqli->query($sql);
$mysqli->close(); 