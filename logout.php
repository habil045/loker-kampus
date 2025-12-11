<?php 
session_start();
 
session_destroy();
 
setcookie('login_user', '', time() - 3600);

header("location:login.php?pesan=logout");
?>