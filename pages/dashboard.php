<?php
session_start();
if($_SESSION['status']!="login"){
    header("location:../login.php?pesan=belum_login");
}

include '../config/koneksi.php';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <title>Dashboard Admin - Loker Kampus</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    
    <link rel="stylesheet" href="../assets/css/style.css">
    
    <style>
        body { background-color: #f4f6f9; }
        .sidebar { min-height: 100vh; background: #343a40; color: white; }
        .sidebar a { color: #ccc; text-decoration: none; display: block; padding: 10px 20px; border-radius: 5px; margin-bottom: 5px; }
        .sidebar a:hover, .sidebar a.active { background: #0d6efd; color: white; }
        .content { width: 100%; padding: 20px; }
    </style>
</head>
<body>

<div class="d-flex">
    <div class="sidebar p-3 d-none d-md-block" style="width: 250px; flex-shrink: 0;">
        <h4 class="text-center mb-4 border-bottom pb-3">Admin Panel</h4>
        <p class="small text-center">Halo, <b><?php echo $_SESSION['nama_lengkap']; ?></b></p>
        
        <a href="dashboard.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'dashboard.php' ? 'active' : ''; ?>">
            <i class="bi bi-speedometer2"></i> Data Loker
        </a>
        
        <a href="pelamar.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'pelamar.php' ? 'active' : ''; ?>">
            <i class="bi bi-people"></i> Data Pelamar
        </a>

        <a href="profil.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'profil.php' ? 'active' : ''; ?>">
            <i class="bi bi-person-circle"></i> Profil Saya
        </a>

        <a href="../index.php" target="_blank"><i class="bi bi-globe"></i> Lihat Website</a>
        
        <a href="#" class="text-danger mt-5" data-bs-toggle="modal" data-bs-target="#modalLogoutAdmin">
            <i class="bi bi-box-arrow-right"></i> Logout
        </a>
    </div>

    <div class="content">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2>Manajemen Lowongan</h2>
                <p class="text-muted">Kelola data lowongan magang dan part-time di sini.</p>
            </div>
            <a href="loker-tambah.php" class="btn btn-success shadow-sm">
                <i class="bi bi-plus-lg"></i> Tambah Lowongan
            </a>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-striped align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th width="5%">No</th>
                                <th>Perusahaan</th>
                                <th>Posisi</th>
                                <th>Kategori</th>
                                <th>Gaji</th>
                                <th>Status</th>
                                <th width="15%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $no = 1;
                            $data = mysqli_query($conn,"SELECT * FROM loker ORDER BY id_loker DESC");
                            
                            while($d = mysqli_fetch_array($data)){
                            ?>
                            <tr>
                                <td><?php echo $no++; ?></td>
                                <td>
                                    <img src="../assets/images/<?php echo $d['logo']; ?>" style="width: 35px; height: 35px; object-fit: cover; border-radius: 50%; vertical-align: middle; margin-right: 5px;">
                                    <?php echo $d['nama_perusahaan']; ?>
                                </td>
                                <td><?php echo $d['posisi']; ?></td>
                                <td><span class="badge bg-secondary"><?php echo $d['kategori']; ?></span></td>
                                <td><?php echo $d['gaji']; ?></td>
                                <td>
                                    <?php 
                                    if($d['status'] == 'Open'){
                                        echo "<span class='badge bg-success'>Open</span>";
                                    } elseif($d['status'] == 'Interview'){
                                        echo "<span class='badge bg-info text-dark'>Interview</span>";
                                    } else {
                                        echo "<span class='badge bg-danger'>Closed</span>";
                                    }
                                    ?>
                                </td>
                                <td>
                                    <a href="loker-edit.php?id=<?php echo $d['id_loker']; ?>" class="btn btn-sm btn-warning text-white"><i class="bi bi-pencil"></i></a>
                                    <a href="loker-hapus.php?id=<?php echo $d['id_loker']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus data ini?')"><i class="bi bi-trash"></i></a>
                                </td>
                            </tr>
                            <?php 
                            } 
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalLogoutAdmin" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header border-0">
        <h5 class="modal-title fw-bold">Konfirmasi Keluar</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-center py-4">
        <i class="bi bi-exclamation-circle text-warning display-1 mb-3"></i>
        <p class="mb-0 text-muted">Apakah Anda yakin ingin keluar dari halaman Admin?</p>
      </div>
      <div class="modal-footer border-0 justify-content-center">
        <button type="button" class="btn btn-secondary px-4 rounded-pill" data-bs-dismiss="modal">Batal</button>
        <a href="../logout.php" class="btn btn-danger px-4 rounded-pill">Ya, Keluar</a>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>