<?php 

require_once 'config.php';

if (isset($_POST['lang'])) {
	$lang = $_POST['lang'];
}

$sql = "SELECT * FROM `languages` WHERE `id` = $lang";

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


