<?php 

require_once './config.php';

$sql = 'SELECT users.username, score.speed, score.recorded_at
        FROM users, score
        WHERE users.id = score.user_id 
       	AND score.speed = (
          SELECT MAX(speed) 
          FROM score 
          WHERE score.user_id = users.id
        ) ORDER BY score.speed DESC LIMIT 20';
$score = '';
$i = 1;

$SKILL_LEVEL = [
  'Beginner'     => '1.png',
  'Intermediate' => '2.png',
  'Average'      => '3.png',
  'Pro'          => '4.png',
  'Typemaster'   => '5.png',
  'Megaracer'    => '6.png',
  'Jetfinger'    => 'signaling.png'
];

function getSckill($speed)
{
  if ($speed >= 0 && $speed < 25) $skill_level = 'Beginner';
  else if ($speed >= 25 && $speed < 31) $skill_level = 'Intermediate';
  else if ($speed >= 31 && $speed < 42) $skill_level = 'Average';
  else if ($speed >= 42 && $speed < 55) $skill_level = 'Pro';
  else if ($speed >= 55 && $speed < 80) $skill_level = 'Typemaster';
  else if ($speed >= 80 && $speed < 100) $skill_level = 'Megaracer';
  else if ($speed >= 100) $skill_level = 'Jetfinger';

  return $skill_level;
}

if ($result = $mysqli->query($sql))
{
  if($result->num_rows > 0)
  { 
    while($row = $result->fetch_array())
    {
      $skill = getSckill($row['speed']);
      $score .= "<tr>
                  <td>{$i}</td>
                  <td>{$row['username']} <img src='./images/awards/{$SKILL_LEVEL[$skill]}' alt='{$skill}'></td>
                  <td>{$row['speed']} wpm</td>
                  <td>{$row['recorded_at']}</td>
                </tr>";
      $i++;
    } 
    $result->free();
  }
} 

echo $score;

$mysqli->close();