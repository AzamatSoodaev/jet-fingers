<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <title>JetFingers</title>

  <link rel="icon" href="images/logo2.png" type="image/x-icon">

  <!-- Bootstrap core CSS -->
  <link rel="stylesheet" href="vendor/bootstrap.min.css">

  <!-- Fonts -->
  <script src="https://kit.fontawesome.com/f44c30b1fe.js" crossorigin="anonymous"></script>

  <!-- Custom styles for this template -->
  <link rel="stylesheet" href="css/style.css">
</head>

<body>

  <!-- Navigation -->
  <?php require_once 'components/header.php'; ?>

  <!-- Page Content -->
  <div class="container">
    <div class="row mt-5">
      <div class="col-lg-7 mx-auto"> 
        <div class="race">
          <img id="racecar" src="images/car_red.png" alt="racecar">
          <img id="finishline" src="images/finish_flag.svg" alt="finish">
        </div>
        <div class="card mb-4"> 
          <div class="card-body inline-shadow ">
            <div class="text-container">
              <p class="wpm-text unselectable" id="sourceText"></p> 
            </div>
            <div class="form-row mt-2">
              <div class="col-9">
                  <label for="inputfield" style="display: none"></label>
                  <input type="text" class="form-control" id="inputfield" maxlength="20">
              </div>
              <div class="col">
                <button class="btn btn-block btn-outline-secondary" id="count-down"></button>
              </div>
              <div class="col">
                <button class="btn btn-block btn-primary" id="reload-btn"><i class="fas fa-sync-alt"></i></button>
              </div>
            </div>
          </div>
          <div class="card-footer bg-white" id="chart">  
              <ul class="list-group list-group-flush">
                <li class="list-group-item">Your speed:<span class="badge badge-pill" id="user_score"></span>
                </li>
                <li class="list-group-item">Accuracy:<span class="badge badge-pill" id="accuracy"></span>
                </li>
                  <li class="list-group-item">Time:<span class="badge badge-pill" id="time"></span>
                </li>
              </ul>
          </div>
        </div>

        <div class="card mb-4"> 
          <div class="card-body inline-shadow">
            <table class="table table-borderless table-sm text-dark" style="font-size: 14px">
              <thead>
                <tr>
                  <th scope="col"></th>
                  <th scope="col">Name</th>
                  <th scope="col">Speed</th>
                  <th scope="col">Time</th>
                </tr>
              </thead>
              <tbody id="score"></tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- /Page Content -->
  
  <?php require_once 'components/footer.php'; ?>

  <script src="js/main.js"></script>
  <script src="js/copyright.js"></script>
  <script>  
    Main.start();
  </script>
</body>

</html>