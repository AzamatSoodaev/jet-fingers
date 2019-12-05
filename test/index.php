<?php 
if ($_GET['wpm']) 
{
  require_once 'config.php';

  $sql = 'SELECT * FROM `game` WHERE `game_id`=? AND `is_active`=?';

  if ($statement = $conn->prepare($sql))
  {
    $statement->bind_param("ii", $game_id, $is_active);

    // set parameters and execute
    $game_id = $_GET['wpm'];
    $is_active = 1;

    $statement->execute();
    $result = $statement->get_result();

    if($result->num_rows)
    {
      $users_num = $result->fetch_assoc()['users_num'];

      // Attempt insert query execution
      $sql = 'UPDATE `game` SET `users_num`=? WHERE `game_id`=?';

      // prepare and bind
      $statement = $conn->prepare($sql);
      $statement->bind_param("ii", $me, $game_id);

      // set parameters and execute
      $me = ++$users_num;
      $game_id = $_GET['wpm'];

      if($statement->execute())
      {
        echo 'hello'; 
      }
    }
    else
    {
      echo 'Page does not exist';
    }

    $statement->close();
  }

  $conn->close();

  exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Test</title> 
</head>

<body>
  <a id="link" href="javascript:void(0);">Create new race</a>
  <a id="join" href="javascript:void(0);">join</a>
  <p id="score">Loading...</p>

  <script src="../node_modules/jquery/dist/jquery.min.js"></script>
  <script>
    let pageId = -1;
    let isSomebodyJoined = false;

    $('#join').hide();
    $('#score').hide();

    $('#link').on('click', () => {
      $.ajax({
        type: "POST",
        url: './start_game.php',
        success: function(response) {
          const game = JSON.parse(response);

          if (game.status === 1) {
            alert('http://140wpm/test/?wpm=' + game.pageId);

            pageId = game.pageId;
            console.log(pageId);

            $('#link').hide();
            $('#join').show();
          } else {
            alert('something went wrong');
          }
        }
      }); 
    });

    $('#join').on('click', () => {
      if (pageId !== -1) 
      {  
        $.ajax({
          type: "POST",
          url: './join_game.php',
          data: {
            game_id: pageId
          },
          success: function(response) {
            const game = JSON.parse(response);

            if (game.status === 1) {
              $('#score').show();
              $('#join').hide();
              console.log('success');
            } else { 
              alert('something went wrong');
            }
          }
        }); 

        let timeInterval = setInterval( () => {
          $.ajax({
            type: "POST",
            url: './dashboard.php',
            data: {
              game_id: pageId
            },
            success: function(response) {
              const game = JSON.parse(response); 

              if (game.status === 1) {
                if (game.users_num !== 1) {
                  $('#score').text('users num: ' + game.users_num); 

                  if (!isSomebodyJoined) {

                    setTimeout( () => {
                      clearInterval(timeInterval);
                      console.log('timer stopped');
                    }, 10000);

                    isSomebodyJoined = true;
                  } 
                } 
              } else {
                clearInterval(timeInterval);
                alert('something went wrong');
              }

              console.log('dash');
            }
          });

        }, 1000);  
      }
    });
  </script>
</body>

</html>