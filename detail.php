<?php
session_start();
include 'config/koneksi.php';

$id = $_GET['id'];
$query = mysqli_query($conn, "SELECT * FROM loker WHERE id_loker='$id'");
$d = mysqli_fetch_array($query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <title>Detail Lowongan - <?php echo $d['posisi']; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="bg-light">

    <nav class="navbar navbar-custom mb-4">
        <div class="container">
            <a class="navbar-brand brand-text" href="index.php">← Kembali ke Beranda</a>
        </div>
    </nav>

    <div class="container mb-5">
        <div class="row">
            
            <div class="col-md-8">
                <div class="glass-card p-5 mb-4">
                    <div class="d-flex align-items-center mb-4 border-bottom pb-4">
                        <img src="assets/images/<?php echo $d['logo']; ?>" class="rounded-circle border shadow-sm" width="80" height="80" style="object-fit:cover;">
                        <div class="ms-4">
                            <h2 class="fw-bold mb-1"><?php echo $d['posisi']; ?></h2>
                            <h5 class="text-muted"><?php echo $d['nama_perusahaan']; ?></h5>
                            <span class="badge bg-primary"><?php echo $d['kategori']; ?></span>
                            <span class="badge bg-secondary"><i class="bi bi-geo-alt"></i> <?php echo $d['lokasi']; ?></span>
                        </div>
                    </div>

                    <h5 class="fw-bold text-primary mb-3"><i class="bi bi-list-task"></i> Deskripsi Pekerjaan</h5>
                    <p class="text-secondary" style="line-height: 1.8;">
                        <?php echo nl2br($d['deskripsi']); ?>
                    </p>

                    <hr class="my-4 opacity-10">

                    <h5 class="fw-bold text-primary mb-3"><i class="bi bi-check-circle"></i> Persyaratan / Kualifikasi</h5>
                    <div class="alert alert-light border">
                        <p class="mb-0" style="line-height: 1.8;">
                            <?php echo nl2br($d['syarat']); ?>
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="glass-card p-4 position-sticky" style="top: 20px;">
                    <h5 class="fw-bold mb-3">Ringkasan</h5>
                    
                    <ul class="list-group list-group-flush mb-4 bg-transparent">
                        <li class="list-group-item bg-transparent d-flex justify-content-between">
                            <span class="text-muted">Gaji / Benefit</span>
                            <span class="fw-bold text-success"><?php echo $d['gaji']; ?></span>
                        </li>
                        <li class="list-group-item bg-transparent d-flex justify-content-between">
                            <span class="text-muted">Lokasi</span>
                            <span class="fw-bold"><?php echo $d['lokasi']; ?></span>
                        </li>
                        <li class="list-group-item bg-transparent d-flex justify-content-between">
                            <span class="text-muted">Status</span>
                            <span class="fw-bold text-<?php echo ($d['status']=='Open') ? 'success':'danger'; ?>">
                                <?php echo $d['status']; ?>
                            </span>
                        </li>
                        <li class="list-group-item bg-transparent d-flex justify-content-between">
                            <span class="text-muted">Diposting</span>
                            <span><?php echo $d['tanggal_upload']; ?></span>
                        </li>
                    </ul>

                    <?php if($d['status'] == 'Open') { ?>
                        <?php if(isset($_SESSION['status_user'])){ ?>
                            <a href="lamar.php?id=<?php echo $d['id_loker']; ?>" class="btn btn-gradient w-100 py-3 shadow">🚀 KIRIM LAMARAN</a>
                        <?php } else { ?>
                            <a href="login_user.php?pesan=belum_login" class="btn btn-gradient w-100 py-3 shadow">🔒 Login untuk Melamar</a>
                        <?php } ?>
                    <?php } else { ?>
                        <button disabled class="btn btn-secondary w-100 py-3">⛔ Lowongan Ditutup</button>
                    <?php } ?>

                </div>
            </div>

        </div>
    </div>

</body>
</html>