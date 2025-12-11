<?php

$server = "sql107.infinityfree.com";
$user = "if0_40652126";
$pass = "121225Habil";
$database = "if0_40652126_loker";

$conn = mysqli_connect($server, $user, $pass, $database);

if (!$conn) {
    die("<script>alert('Gagal tersambung dengan database.')</script>");
}
?>