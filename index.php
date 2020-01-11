<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>140 Wpm</title>

  <!-- Bootstrap core CSS -->
  <link rel="stylesheet" href="node_modules/bootstrap/dist/css/bootstrap.min.css">

  <!-- Fonts -->
  <script src="https://kit.fontawesome.com/f44c30b1fe.js" crossorigin="anonymous"></script>

  <!-- Custom styles for this template -->
  <link rel="stylesheet" href="css/main.css">
  <link rel="stylesheet" href="css/style.css">

</head>

<body class="bg-light">

  <!-- Navigation -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top">
    <div class="container">
      <a class="navbar-brand" href="/">140wpm</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav ml-auto">
         <!--  <li class="nav-item active">
            <a class="nav-link" href="#">Home
              <span class="sr-only">(current)</span>
            </a>
          </li> -->
          <li class="nav-item">
            <a class="nav-link" href="#">Sign in</a>
          </li> 
        </ul>
      </div>
    </div>
  </nav>
  <!-- /Navigation -->

  <!-- Page Content -->
  <div class="container">
    <div class="row mt-4">
      <div class="col-lg-7 mx-auto"> 
        <div class="race">
          <img id="racecar" src="images/car_red.png" alt="racecar">
          <img id="finishline" src="https://image.flaticon.com/icons/svg/148/148882.svg">
        </div>
        <div class="card"> 
          <div class="card-body">
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
                <button class="btn btn-block btn-outline-primary" id="reload-btn"><i class="fas fa-sync-alt"></i></button>
              </div>
            </div>
          </div>
          <div class="card-footer" id="chart">
            <p class="mb-0 text-center">
              Your speed: <code id="user_score"></code>
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- /Page Content -->

  <script src="node_modules/jquery/dist/jquery.min.js"></script>
  <script src="node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <script src="js/Wpm-Module.js"></script>
  <script>  
    WpmText.start();
  </script>
</body>

</html>