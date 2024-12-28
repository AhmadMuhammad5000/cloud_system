<?php session_start();
   if(!isset($_SESSION['userid']) || !isset($_SESSION['regno'])) {
       header("location: index.php");
   }
?>