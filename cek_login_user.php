<?php 
session_start();
include 'config/koneksi.php';
 
$email = $_POST['email'];
$password = md5($_POST['password']);
 
$data = mysqli_query($conn, "SELECT * FROM mahasiswa WHERE email='$email' AND password='$password'");
$cek = mysqli_num_rows($data);
 
if($cek > 0){
    $row = mysqli_fetch_array($data);
    
    $_SESSION['id_mhs'] = $row['id_mhs'];
    $_SESSION['nama_mhs'] = $row['nama_lengkap'];
    $_SESSION['status_user'] = "login_user";
    
	header("location:index.php");
}else{
	header("location:login_user.php?pesan=gagal");
}
?>