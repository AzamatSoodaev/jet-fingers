<?php 

require_once 'config.php';

if (isset($_POST['id'])) {
	$id = $_POST['id'];
}

$sql = "SELECT * FROM `texts` 
				WHERE id=$id 
				LIMIT 1";

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


