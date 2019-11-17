<?php 

$mysqli = new mysqli("localhost", "root", "", "140wpm");

if($mysqli === false)
{
	echo json_encode(['success' => 0]);
 	exit();
}

$sql = 'SELECT * FROM `texts` WHERE id=1';
$result = $mysqli->query($sql);

if($result)
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


