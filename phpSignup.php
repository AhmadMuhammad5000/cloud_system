<?php require_once "db/db.php";

// sanitizing and validating inputs
function validate($input) {
    $input = htmlspecialchars($input);
    $input = strip_tags($input);
    $input = stripcslashes($input);

    return $input;
}

if($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["signup"])) {
    $fullname = validate(trim($_POST['fullname']));
    $regno = validate(trim($_POST['regno']));
    $password = validate(trim($_POST['password']));
    $cpassword = validate(trim($_POST['cpassword']));

     //  COMFIRMING PASSWORD
     if($password == $cpassword) {
        // Hashing password
         $hashpassword = password_hash($password, PASSWORD_DEFAULT);

        // CHECK FOR AN EXISTING USER WITH SAME REG No
        $sql = $conn->prepare("SELECT regNo FROM users WHERE regNo = ?");
        $sql->bind_param('s', $regno);
        $sql->execute();
        $rs = $sql->get_result();

        if($rs->num_rows > 0) {
            echo '<script> alert("Reg No has been taking!"); </script>';
            echo '<script> window.location.href = "signup.php"; </script>';
        } else{
            $sql = $conn->prepare("INSERT INTO users(fullname,regNo,password) VALUES (?,?,?)");
            $sql->bind_param('sss',$fullname,$regno,$hashpassword);
            if($sql->execute()){
                header("location: index.php");
            } else{
             echo '<script> alert("Something went wrong!"); </script>';
             echo '<script> window.location.href = "signup.php"; </script>';
            }
        }
        
    } else{
        echo '<script> alert("Password Mismatch!"); </script>';
        echo '<script> window.location.href = "signup.php"; </script>';
    }
       
      }

?>