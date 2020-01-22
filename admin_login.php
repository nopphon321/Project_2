
<?php 
error_reporting(0);
session_start();

require_once 'controller_admin.php';
?>
<?php 
if(isset($_POST['login'])){
    $login = new Admin;
    $login->username = $_POST['username'];
    $login->password = $_POST['password'];
    $member_id = $login->login();

}
?>
<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>SB Admin - Login</title>

  <!-- Custom fonts for this template-->
  <link href="admin_framwork/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

  <!-- Custom styles for this template-->
  <link href="admin_framwork/css/sb-admin.css" rel="stylesheet">

</head>

<body class="bg-dark">
<div class="container">
    <div class="card card-login mx-auto mt-5">
      <div class="card-header">Login</div>
      <div class="card-body">
        <form action="admin_login.php" method="POST">
          <div class="form-group">
            <div class="form-label-group">
              <input type="text" id="inputusername" name="username" class="form-control" placeholder="Username" required="required" autofocus="autofocus">
              <label for="inputusername">Username</label>
            </div>
          </div>
          <div class="form-group">
            <div class="form-label-group">
              <input type="password" id="inputPassword" name="password" class="form-control" placeholder="Password" required="required">
              <label for="inputPassword">Password</label>
            </div>
          </div>
         
          <button class="btn btn-primary btn-block" type="submit" name="login" >Login</button>
        </form>
    
      </div>
    </div>
  </div>
  <!-- Bootstrap core JavaScript-->
  <script src="admin_framwork/vendor/jquery/jquery.min.js"></script>
  <script src="admin_framwork/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="admin_framwork/vendor/jquery-easing/jquery.easing.min.js"></script>

</body>

</html>
