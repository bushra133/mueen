<?php
// تسجيل الخروج من التطبيق
session_start();

if(isset($_SESSION['logged_in'])){
  $_SESSION = [];
  $_SESSION['success_messege'] = "You are logged out ";
  header('location: index.php');
  die();
}
?>
