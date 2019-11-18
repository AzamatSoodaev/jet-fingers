<?php 
$mysqli = new mysqli("localhost", "root", "", "140wpm");

if($mysqli === false)
{
	echo json_encode(['success' => 0]);
 	exit();
}