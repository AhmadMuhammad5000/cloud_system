<?php 
      session_start();
      require_once 'db/db.php';

// Sanitizing and validating inputs
function validate($input) {
    $input = htmlspecialchars($input);
    $input = filter_var($input, FILTER_SANITIZE_STRING);

    return $input;
}

   if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
           $regno = validate(trim($_POST['regno']));
           $password = validate(trim($_POST['password']));

           //    UNHASHING PASSWORD
           $sql = $conn->prepare("SELECT * FROM users WHERE regNo = ?");
           $sql->bind_param('s',$regno);
           $sql->execute();
           $rs = $sql->get_result();

           if($rs->num_rows > 0) {
               $fetch = $rs->fetch_assoc();
               $hashedpassword = $fetch['password'];

               $unhashedPass = password_verify($password, $hashedpassword);

               if($unhashedPass) {
                //    STORING USER IN SESSION
                     $_SESSION['userid'] = $fetch['id'];
                     $_SESSION['regno'] = $fetch['regNo'];

                   header("Location: dashboard.php");
               } else {
                   echo '<script> alert("Wrong Password!"); </script>';
                   echo '<script> window.location.href = "index.php"; </script>';
               }

           } else {
              echo '<script> alert("Invalid User!"); </script>';
              echo '<script> window.location.href = "index.php"; </script>';
           }

        } 
