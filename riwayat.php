<?php
session_start();
include 'config/koneksi.php';

// Cek apakah User sudah login?
if(!isset($_SESSION['status_user'])){
    header("location:login_user.php?pesan=belum_login");
}

$id_mhs = $_SESSION['id_mhs'];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <title>Riwayat Lamaran - Loker Kampus</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

    <nav class="navbar navbar-custom mb-5">
        <div class="container">
            <a class="navbar-brand brand-text" href="index.php">← Kembali ke Beranda</a>
            <span class="navbar-text fw-bold text-dark">Halo, <?php echo $_SESSION['nama_mhs']; ?></span>
        </div>
    </nav>

    <div class="container">
        <h3 class="mb-4 fw-bold text-white">📂 Status Lamaran Saya</h3>

        <div class="row">
            <?php 
            // JOIN TABEL: Gabungkan tabel lamaran dengan loker
            // Supaya kita bisa ambil Nama Perusahaan & Posisi dari tabel loker
            $query = "SELECT lamaran.*, loker.nama_perusahaan, loker.posisi, loker.logo 
                      FROM lamaran 
                      JOIN loker ON lamaran.id_loker = loker.id_loker 
                      WHERE lamaran.id_mhs = '$id_mhs' 
                      ORDER BY lamaran.id_lamaran DESC";
            
            $data = mysqli_query($conn, $query);
            
            // Cek jika belum pernah melamar
            if(mysqli_num_rows($data) == 0){
                echo '
                <div class="col-12">
                    <div class="glass-card p-5 text-center">
                        <i class="bi bi-folder-x display-1 text-muted"></i>
                        <h4 class="mt-3 text-muted">Belum ada riwayat lamaran.</h4>
                        <a href="index.php" class="btn btn-gradient mt-3">Mulai Cari Kerja</a>
                    </div>
                </div>';
            }

            while($d = mysqli_fetch_array($data)){
            ?>
            
            <div class="col-md-6 mb-4">
                <div class="glass-card p-4 h-100 position-relative">
                    
                    <div class="d-flex align-items-center mb-3 border-bottom pb-3">
                        <img src="assets/images/<?php echo $d['logo']; ?>" class="rounded-circle border" width="60" height="60" style="object-fit:cover;">
                        <div class="ms-3">
                            <h5 class="mb-0 fw-bold"><?php echo $d['posisi']; ?></h5>
                            <span class="text-muted small"><?php echo $d['nama_perusahaan']; ?></span>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-6">
                            <small class="text-muted d-block">Tanggal Lamar</small>
                            <span class="fw-bold"><i class="bi bi-calendar"></i> <?php echo $d['tgl_lamar']; ?></span>
                        </div>
                        <div class="col-6 text-end">
                            <small class="text-muted d-block">Status Saat Ini</small>
                            
                            <?php if($d['status_lamaran'] == 'Pending') { ?>
                                <span class="badge bg-warning text-dark px-3 py-2 rounded-pill">
                                    <i class="bi bi-hourglass-split"></i> Sedang Direview
                                </span>
                            <?php } elseif($d['status_lamaran'] == 'Diterima') { ?>
                                <span class="badge bg-success px-3 py-2 rounded-pill">
                                    <i class="bi bi-check-circle-fill"></i> Diterima / Lolos
                                </span>
                            <?php } else { ?>
                                <span class="badge bg-danger px-3 py-2 rounded-pill">
                                    <i class="bi bi-x-circle-fill"></i> Ditolak
                                </span>
                            <?php } ?>

                        </div>
                    </div>

                    <div class="mt-4">
                        <small class="text-muted">Progres:</small>
                        <div class="progress mt-1" style="height: 6px;">
                            <?php if($d['status_lamaran'] == 'Pending') { ?>
                                <div class="progress-bar bg-warning" role="progressbar" style="width: 50%"></div>
                            <?php } elseif($d['status_lamaran'] == 'Diterima') { ?>
                                <div class="progress-bar bg-success" role="progressbar" style="width: 100%"></div>
                            <?php } else { ?>
                                <div class="progress-bar bg-danger" role="progressbar" style="width: 100%"></div>
                            <?php } ?>
                        </div>
                        <div class="d-flex justify-content-between small mt-1 text-muted">
                            <span>Terkirim</span>
                            <span>Review HRD</span>
                            <span>Keputusan</span>
                        </div>
                    </div>

                    <?php if($d['status_lamaran'] == 'Diterima') { ?>
                        <div class="alert alert-success mt-3 mb-0 small">
                            <i class="bi bi-emoji-smile"></i> <b>Selamat!</b> Silahkan cek email/WA untuk tahap interview.
                        </div>
                    <?php } elseif($d['status_lamaran'] == 'Ditolak') { ?>
                        <div class="alert alert-danger mt-3 mb-0 small">
                            <i class="bi bi-emoji-frown"></i> <b>Jangan menyerah!</b> Coba lamar di posisi lain.
                        </div>
                    <?php } ?>

                </div>
            </div>
            <?php } ?>
        </div>
    </div>

</body>
</html>