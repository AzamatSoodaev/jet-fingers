<?php

require_once './config.php';

if (!isset($_POST['u']) || 
		!isset($_POST['s']) || 
		!isset($_POST['c']) ||
		!isset($_POST['ip'])
	) 
{
	exit();
}

$username = $_POST['u'];
$speed = $_POST['s'];
$user_text = $_POST['c'];
$user_text_id = $_POST['ip'];
$paragraph = $mysqli->query("SELECT * FROM `paragraphs` WHERE id = {$user_text_id}");

if ($paragraph->num_rows > 0) 
{
  $row = $paragraph->fetch_assoc();

  if ($row['para'] != $user_text || $row['id'] != $user_text_id) 
  {
  	exit();
  }
}

$sql = "SELECT id FROM users WHERE username = '$username'";

$id = $mysqli->query($sql)->fetch_array()['id'];

$sql = "INSERT INTO `score`(`user_id`, `speed`, `para_id`) VALUES ($id, $speed, $user_text_id)";

$mysqli->query($sql);
$mysqli->close(); 