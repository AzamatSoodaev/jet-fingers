<?php 
// require_once 'model/verify.php'; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <?php 
    $title = 'Sign in';
    require_once 'includes/head.php'; 
  ?>

  <link rel="stylesheet" href="css/sign_in_up.css">
</head>
<body class="body text-center">

  <?php require_once 'includes/nav.php'; ?>

  <form class="form-signin" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
    
    <h1 class="h4 mb-3 font-weight-normal">Sign in</h1>
    
    <div style="<?php echo !$error ? 'display: none' : ''; ?>" class="alert alert-danger alert-dismissible fade show small" role="alert">
      Неверное имя пользователя или пароль
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    
    <label for="username" class="sr-only">Username</label>
    <input type="text" name="username" class="form-control" placeholder="Username" autofocus>
    
    <label for="password" class="sr-only">Password</label>
    <input type="password" name="password" class="form-control" placeholder="password"> 
    
    <button class="btn primary-btn pl-4 pr-4 mt-2" type="submit">Submit</button>
    
  </form>

  <?php require_once 'includes/footer.php'; ?>

</body>
</html>