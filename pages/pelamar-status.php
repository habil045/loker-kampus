<?php
include '../config/koneksi.php';

$id = $_GET['id'];
$status = $_GET['status'];

if(isset($id) && isset($status)){
    $query = "UPDATE lamaran SET status_lamaran='$status' WHERE id_lamaran='$id'";
    mysqli_query($conn, $query);

    header("location:pelamar.php");
} else {
    header("location:pelamar.php");
}
?>