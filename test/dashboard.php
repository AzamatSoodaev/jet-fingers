<?php  

if ($_SERVER['REQUEST_METHOD'] != 'POST' || empty($_POST['game_id'])) exit();

// include database file
require_once 'config.php';

// Attempt insert query execution
$sql = "SELECT * FROM `game` WHERE `game_id`=?";

// prepare and bind
$statement = $conn->prepare($sql);
$statement->bind_param("i", $game_id);

// set parameters and execute
$game_id = $_POST['game_id'];

if($statement->execute())
{
	$result = $statement->get_result()->fetch_assoc();
  echo json_encode(['status' => 1, 'users_num' => $result['users_num']]);
} 
else
{
	echo json_encode(['status' => 0]);
}
 
$statement->close();
$conn->close();