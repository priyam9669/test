<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <title>Atrium</title>
      <link rel="stylesheet" type="text/css" href="assets/roadmap-automation/adminlte/css/adminlte.min.css">
      <link rel="stylesheet" type="text/css" href="assets/roadmap-automation/bootstrap/css/bootstrap.min.css">
      <link rel="stylesheet" type="text/css" href="assets/roadmap-automation/fontawesome-free/css/all.min.css">
   </head>
   <body class="hold-transition login-page">
      <div class="login-box">
         <div class="login-logo">
            <h3>Welcome to Atrium!</h3>
         </div>
         <?php 
            if(!empty($login_error)) {
                ?>
         <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= isset($login_error) ? $login_error : '' ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <?php
            }
            ?>
         <!-- /.login-logo -->
         <div class="card">
            <div class="card-body login-card-body">
               <p class="login-box-msg">Sign in to start your session</p>
               <form method="post" action="sessions">
                  <div class="input-group mb-3">
                     <input type="text" class="form-control" name="username" id="username" autocomplete="off" placeholder="Username" required> 
                     <div class="input-group-append">
                        <div class="input-group-text">
                           <span class="fas fa-envelope"></span>
                        </div>
                     </div>
                  </div>
                  <div class="input-group mb-3">
                     <input type="password" class="form-control" name="password" id="password" autocomplete="off" placeholder="Password" required>
                     <div class="input-group-append">
                        <div class="input-group-text">
                           <span class="fas fa-lock"></span>
                        </div>
                     </div>
                  </div>
                  <div class="row">
                     <!-- /.col -->
                     <div class="col-12">
                        <button type="submit" class="btn btn-primary btn-block">Sign In</button>
                     </div>
                     <!-- /.col -->
                  </div>
               </form>
               <div class="social-auth-links text-center mb-3">
                  <p>- OR -</p>
               </div>
               <!-- /.social-auth-links -->
               <p class="mb-1">
                  <a href="#">I forgot my password</a>
               </p>
            </div>
            <!-- /.login-card-body -->
            <div class="border-top my-3"></div>
            <p class="login-box-msg">Page rendered in <strong>{elapsed_time}</strong> seconds</p>
         </div>
      </div>
      <!-- /.login-box -->
      <script src="assets/roadmap-automation/jquery/jquery.min.js"></script>
      <script type="text/javascript" src="assets/roadmap-automation/adminlte/js/adminlte.min.js"></script>
      <script type="text/javascript" src="assets/roadmap-automation/bootstrap/js/bootstrap.min.js"></script>
   </body>
</html>