<?php 

require_once 'config.php';

$id = $_POST['text_id'];

$sql = "SELECT * FROM `texts` 
				WHERE id=$id";

if($result = $mysqli->query($sql))
{
	$post = mysqli_fetch_assoc($result);
	$text = $post['text'];
	echo json_encode(
		[
			'success' => 1,
			'text' => $text
		]
	);
} 
else
{
	echo json_encode(['success' => 0]);
}


