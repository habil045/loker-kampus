<?php
include 'config/koneksi.php';

if(isset($_POST['daftar'])){
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $jurusan = $_POST['jurusan'];
    $hp = $_POST['hp'];
    $password = md5($_POST['password']);

    $cek = mysqli_query($conn, "SELECT * FROM mahasiswa WHERE email='$email'");
    if(mysqli_num_rows($cek) > 0){
        echo "<script>alert('Email sudah terdaftar! Silahkan login.');window.location='login_user.php';</script>";
    } else {

        $query = "INSERT INTO mahasiswa (nama_lengkap, email, password, jurusan, no_hp) 
                  VALUES ('$nama', '$email', '$password', '$jurusan', '$hp')";
        
        if(mysqli_query($conn, $query)){
            echo "<script>alert('Pendaftaran Berhasil! Silahkan Login.');window.location='login_user.php';</script>";
        } else {
            echo "<script>alert('Gagal Mendaftar.');</script>";
        }
    }
}
?>