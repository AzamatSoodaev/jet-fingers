<?php 

require_once './config.php';

$sql = "SELECT users.username, score.speed, score.recorded_at
        FROM users, score
        WHERE users.id = score.user_id 
       	AND score.speed = (
          SELECT MAX(speed) 
          FROM score 
          WHERE score.user_id = users.id
        ) ORDER BY score.speed DESC LIMIT 20";
$score = '';
$i = 1;

if ($result = $mysqli->query($sql))
{
  if($result->num_rows > 0)
  { 
    while($row = $result->fetch_array())
    {  
      $score .= "<tr>
                  <th scope=\"row\">{$i}</th>
                  <td>{$row['username']}</td>
                  <td>{$row['speed']}</td>
                  <td>{$row['recorded_at']}</td>
                </tr>";
      $i++;
    } 
    $result->free();
  }
} 

echo $score;

$mysqli->close();