<?php
session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once '../autoload.php';

if(isset($_SESSION['admin'])) {
  header('Location:index.php');
}

if($_SERVER['REQUEST_METHOD'] == 'POST')
{
  $emailOrPhone = $_POST['email'];
  $password = $_POST['password'];

  $user = new \App\Models\Model('admins');

  $user = $user->where('email', $emailOrPhone)->orWhere('phone', $emailOrPhone)->first();

  if (empty($user)) {
    $errorMessage = 'You are not at registered as an admin';
  }else {
    if ($user['active'] && password_verify($password, $user['password'])) {
      $_SESSION['admin']['id'] = $user['id'];
      $_SESSION['admin']['email'] = $emailOrPhone;
      $_SESSION['admin']['role'] = 'admin';
      $_SESSION['unique_id'] = uniqid('session_');
      header('Location:index.php');
    } else {
      $errorMessage = 'Invalid credentials';
    }
  }
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Admin Log in</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/adminlte.min.css">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="hold-transition login-page">
<div class="login-box">
    <div class="login-logo">
        <a href="index2.html"><b>Admin</b>Panel</a>
    </div>
    <!-- /.login-logo -->
    <div class="card">
        <div class="card-body login-card-body">

          <?php
          if(isset($errorMessage)) {
            echo '<p class="text-danger login-box-msg">'.$errorMessage.'</p>';
          }
          ?>
            <p class="login-box-msg">Sign in to start your session</p>

            <form action="login.php" method="POST">
                <div class="input-group mb-3">
                    <input type="email" name="email" value="<?php echo $emailOrPhone ?? '' ?>" class="form-control" placeholder="Email">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input type="password" class="form-control" name="password" value="<?php echo $password ?? '' ?>" placeholder="Password">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-8">
                        <div class="icheck-primary">
                            <input type="checkbox" id="remember">
                            <label for="remember">
                                Remember Me
                            </label>
                        </div>
                    </div>
                    <!-- /.col -->
                    <div class="col-4">
                        <button type="submit" class="btn btn-primary btn-block">Sign In</button>
                    </div>
                    <!-- /.col -->
                </div>
            </form>
            
        </div>
        <!-- /.login-card-body -->
    </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>

</body>
</html>
