<?php  

if ($_SERVER['REQUEST_METHOD'] != 'POST') exit();

// include database file
require_once 'config.php';

// Attempt insert query execution
$sql = "INSERT INTO `game`(`is_active`) VALUES (?)";

// prepare and bind
$statement = $conn->prepare($sql);
$statement->bind_param("i", $is_active);

// set parameters and execute
$is_active = 1;

if($statement->execute())
{
  echo json_encode(['status' => 1, 'pageId' => $conn->insert_id]);
} 
else
{
	echo json_encode(['status' => 0]);
}
 
$statement->close();
$conn->close();