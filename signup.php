<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <link rel="stylesheet" href="http://localhost/CloudSystem/CSS/bootstrap-5.1.3-dist/bootstrap-5.1.3-dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="http://localhost/CloudSystem/CSS/font-awesome-4.7.0/css/font-awesome.min.css">

  <title>SignUp</title>
  <style>
    body {
      background: radial-gradient(blue, black);
    }
  </style>

</head>

<body>
  <!-- Container -->
  <div class="container-fluid">
    <div class="signup d-flex flex-column align-items-center justify-content-center vh-100">
      <form method="POST" action="phpSignup.php" autocomplete="off" class="form-control w-25">
        <h2 class="text-center fs-5 text-dark">Sign Up</h2> <br>
        <div class="div">
          <label><b>Fullname</b></label> <br>
          <input type="text" name="fullname" class="form-control" placeholder="Fullname" required>
        </div>

        <div class="div">
          <label><b>Reg No</b></label> <br>
          <input type="text" name="regno" class="form-control" placeholder="Registration No" required>
        </div>

        <div class="div">
          <label><b>Password</b></label> <br>
          <input type="password" name="password" class="form-control" placeholder="Enter Password" required>
        </div>

        <div class="div">
          <label><b>Comfirm Password</b></label> <br>
          <input type="password" name="cpassword" class="form-control" placeholder="Comfirm Password" required>
        </div> <br>

        <div class="div">
          <button name='signup' class="form-control bg-secondary"> Signup </button>
        </div> <br>

        <p>Already have an account? <a href='index.php'>Login</a></p>

      </form>
    </div>
  </div>

</body>

</html>