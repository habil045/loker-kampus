<?php 
session_start();
if($_SESSION['status']!="login"){
	header("location:../login.php?pesan=belum_login");
}
include '../config/koneksi.php';

$id = $_SESSION['id_user'];
$query = mysqli_query($conn, "SELECT * FROM users WHERE id_user='$id'");
$d = mysqli_fetch_array($query);

// PROSES UPDATE PROFIL
if(isset($_POST['update'])){
    $nama = $_POST['nama'];
    $user = $_POST['username'];
    $pass = $_POST['password']; // Password baru

    // Cek apakah user mau ganti password?
    if($pass != ""){
        // Kalau kolom password diisi, update semua termasuk password (MD5)
        $pass_md5 = md5($pass);
        mysqli_query($conn, "UPDATE users SET nama_lengkap='$nama', username='$user', password='$pass_md5' WHERE id_user='$id'");
    } else {
        // Kalau kosong, berarti cuma ganti nama/username (Password lama tetap)
        mysqli_query($conn, "UPDATE users SET nama_lengkap='$nama', username='$user' WHERE id_user='$id'");
    }

    // Update Session biar nama di sidebar langsung berubah
    $_SESSION['nama_lengkap'] = $nama;
    
    echo "<script>alert('Profil Berhasil Diupdate!'); window.location='profil.php';</script>";
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <title>Profil Saya - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
        body { background-color: #f4f6f9; }
        .sidebar { min-height: 100vh; background: #343a40; color: white; }
        .sidebar a { color: #ccc; text-decoration: none; display: block; padding: 10px 20px; border-radius: 5px; margin-bottom: 5px; }
        .sidebar a:hover, .sidebar a.active { background: #0d6efd; color: white; }
    </style>
</head>
<body>

<div class="d-flex">
    <div class="sidebar p-3 d-none d-md-block" style="width: 250px;">
        <h4 class="text-center mb-4 border-bottom pb-3">Admin Panel</h4>
        <p class="small text-center">Halo, <b><?php echo $_SESSION['nama_lengkap']; ?></b></p>
        
        <a href="dashboard.php"><i class="bi bi-speedometer2"></i> Data Loker</a>
        <a href="pelamar.php"><i class="bi bi-people"></i> Data Pelamar</a>
        
        <a href="profil.php" class="active"><i class="bi bi-person-circle"></i> Profil Saya</a>
        
        <a href="../index.php" target="_blank"><i class="bi bi-globe"></i> Lihat Website</a>
        <a href="#" class="text-danger mt-5" data-bs-toggle="modal" data-bs-target="#modalLogoutAdmin"><i class="bi bi-box-arrow-right"></i> Logout</a>
    </div>

    <div class="p-4 w-100">
        <h2 class="mb-4">👤 Pengaturan Akun</h2>
        
        <div class="card shadow-sm border-0" style="max-width: 600px;">
            <div class="card-body p-4">
                <form action="" method="post">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Nama Lengkap</label>
                        <input type="text" name="nama" class="form-control" value="<?php echo $d['nama_lengkap']; ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Username</label>
                        <input type="text" name="username" class="form-control" value="<?php echo $d['username']; ?>" required>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold">Password Baru</label>
                        <input type="password" name="password" class="form-control" placeholder="Kosongkan jika tidak ingin mengganti password">
                        <div class="form-text text-muted">Hanya isi jika ingin mengubah password login.</div>
                    </div>

                    <button type="submit" name="update" class="btn btn-primary px-4">💾 Simpan Perubahan</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalLogoutAdmin" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header border-0">
        <h5 class="modal-title">Konfirmasi Keluar</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body text-center">Yakin ingin keluar?</div>
      <div class="modal-footer justify-content-center border-0">
        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
        <a href="../logout.php" class="btn btn-danger btn-sm">Ya, Keluar</a>
      </div>
    </div>
  </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>