<?php require_once "session.php";
   if(isset($_SESSION['userid']) || isset($_SESSION['regno'])) {
     session_unset();
     session_destroy();

     header("location: index.php");
     
   }
?>