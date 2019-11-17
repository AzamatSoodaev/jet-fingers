<?php 
$mysqli = new mysqli("localhost", "root", "", "lost_and_found");
 
if($mysqli === false)
{
  die("ERROR: Could not connect. " .  $mysqli->connect_error);
}
