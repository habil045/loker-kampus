<?php 
include '../config/koneksi.php';

$id = $_GET['id'];

$data = mysqli_query($conn, "SELECT logo FROM loker WHERE id_loker='$id'");
$d = mysqli_fetch_array($data);
$foto = $d['logo'];

if(file_exists("../assets/images/$foto")){
    unlink("../assets/images/$foto");
}

mysqli_query($conn, "DELETE FROM loker WHERE id_loker='$id'");
 
header("location:dashboard.php");
?>