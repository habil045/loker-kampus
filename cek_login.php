<?php 
session_start();
 
include 'config/koneksi.php';
 
$username = $_POST['username'];
$password = md5($_POST['password']); 
 
$data = mysqli_query($conn, "SELECT * FROM users WHERE username='$username' AND password='$password'");
 
$cek = mysqli_num_rows($data);
 
if($cek > 0){
    $row = mysqli_fetch_array($data);
    $_SESSION['id_user'] = $row['id_user'];
	$_SESSION['username'] = $username;
    $_SESSION['nama_lengkap'] = $row['nama_lengkap'];
	$_SESSION['status'] = "login";

    if(isset($_POST['remember'])){
        setcookie('login_user', $username, time() + 3600); 
    }
 
	header("location:pages/dashboard.php");
}else{
	header("location:login.php?pesan=gagal");
}
?>