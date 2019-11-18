<?php 

require_once 'config.php';

$distance = $_POST['distance'];

$sql = "UPDATE `game_score` SET `distance` = $distance WHERE user_id=1 and `game_session`=1";

if($mysqli->query($sql))
{
	$sql = "SELECT * FROM `game_score` WHERE user_id=1 and `game_session`=1";

	if ($result = $mysqli->query($sql)) {
		$info = mysqli_fetch_assoc($result);
		$distance = $info['distance'];
		echo json_encode(
			[
				'success' => 1,
				'distance' => $distance
			]
		);
	}
	else
	{
		echo json_encode(['success' => 0]);
	}
} 
else
{
	echo json_encode(['success' => 0]);
}


