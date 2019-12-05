<?php  

if ($_SERVER['REQUEST_METHOD'] != 'POST' || empty($_POST['game_id'])) exit();

// include database file
require_once 'config.php';

// Attempt insert query execution
$sql = 'UPDATE `game` SET `users_num`=? WHERE `game_id`=?';

// prepare and bind
$statement = $conn->prepare($sql);
$statement->bind_param("ii", $me, $game_id);

// set parameters and execute
$me = 1;
$game_id = $_POST['game_id'];

if($statement->execute())
{
  echo json_encode(['status' => 1]);
} 
else
{
	echo json_encode(['status' => 0]);
}
 
$statement->close();
$conn->close();