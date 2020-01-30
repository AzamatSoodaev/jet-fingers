<!DOCTYPE html>
<html lang="en">

<head>
  <link rel="icon" href="images/logo2.png" type="image/x-icon">
  <?php 
    $title = 'JetFingers';
    require_once 'includes/head.php'; 
  ?>
  
  <link rel="stylesheet" href="css/style.css">

</head>

<body>

  <!-- Navigation -->
  <?php require_once 'includes/nav.php'; ?>
  
  <!-- Page Content -->
  <div class="container">
    <div class="row mt-5">
      <div class="col-lg-7 mx-auto"> 
        <div class="race">
          <img id="racecar" src="images/car_red.png" alt="racecar">
          <img id="finishline" src="https://image.flaticon.com/icons/svg/148/148882.svg">
        </div>
        <div class="card"> 
          <div class="card-body inline-shadow ">
            <div class="text-container">
              <p class="wpm-text unselectable" id="sourceText"></p> 
            </div>
            <div class="form-row mt-2">
              <div class="col-9">
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
      </div>
    </div>
  </div>
  <!-- /Page Content -->
  
  <?php require_once 'includes/footer.php'; ?>

  <script src="js/Wpm-Module.js"></script>
  <script>  
    WpmText.start();
  </script>
</body>

</html>