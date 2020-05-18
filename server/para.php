<?php 

require_once 'config.php';

$randomNumber = rand(1, 2012);

$sql = "SELECT * FROM `paragraphs` WHERE id = {$randomNumber}";

$paragraph = $mysqli->query($sql);

if ($paragraph->num_rows > 0) 
{
	$row = $paragraph->fetch_assoc();
	
  echo json_encode([
  	'id' => $row['id'],
  	'para' => $row['para']
  ]);
}

$mysqli->close();