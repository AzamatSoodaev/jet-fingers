<?php 

$paraString = file_get_contents('para.json');
$paragraphs = json_decode($paraString, true);
$paraCount = count($paragraphs);
$randomNumber = rand(0, $paraCount);

echo json_encode($paragraphs[$randomNumber]);