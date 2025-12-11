<?php 
session_start();
if($_SESSION['status']!="login"){ header("location:../login.php?pesan=belum_login"); }
include '../config/koneksi.php';
?>

<!DOCTYPE html>
<html lang="id">
<head>
	<title>Data Pelamar - Admin</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        body { background-color: #f4f6f9; }
        .sidebar { min-height: 100vh; background: #343a40; color: white; }
        .sidebar a { color: #ccc; text-decoration: none; display: block; padding: 10px 20px; border-radius: 5px; margin-bottom: 5px; }
        .sidebar a:hover, .sidebar a.active { background: #0d6efd; color: white; }
    </style>
</head>
<body>

<div class="d-flex">
    <div class="sidebar p-3 d-none d-md-block" style="width: 250px; flex-shrink: 0;">
        <h4 class="text-center mb-4 border-bottom pb-3">Admin Panel</h4>
        <p class="small text-center">Halo, <b><?php echo $_SESSION['nama_lengkap']; ?></b></p>
        
        <a href="dashboard.php"><i class="bi bi-speedometer2"></i> Data Loker</a>
        <a href="pelamar.php" class="active"><i class="bi bi-people"></i> Data Pelamar</a>
        <a href="profil.php"><i class="bi bi-person-circle"></i> Profil Saya</a>
        <a href="../index.php" target="_blank"><i class="bi bi-globe"></i> Lihat Website</a>
        <a href="#" class="text-danger mt-5" data-bs-toggle="modal" data-bs-target="#modalLogoutAdmin"><i class="bi bi-box-arrow-right"></i> Logout</a>
    </div>

    <div class="p-4 w-100">
        <h2 class="mb-4">📂 Masuk Lamaran Kerja</h2>

        <div class="card shadow-sm border-0">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th>No</th>
                                <th>Tgl</th>
                                <th>Info Pelamar</th>
                                <th>Pesan & Posisi</th>
                                <th>CV</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            // Query Join (Sama kayak sebelumnya, cuma nambah kolom pesan)
                            $query = "SELECT lamaran.*, mahasiswa.nama_lengkap, mahasiswa.jurusan, loker.posisi, loker.nama_perusahaan 
                                      FROM lamaran 
                                      INNER JOIN mahasiswa ON lamaran.id_mhs = mahasiswa.id_mhs
                                      INNER JOIN loker ON lamaran.id_loker = loker.id_loker
                                      ORDER BY lamaran.id_lamaran DESC";
                            
                            $data = mysqli_query($conn, $query);
                            $no = 1;
                            
                            while($d = mysqli_fetch_array($data)){
                            ?>
                            <tr>
                                <td><?php echo $no++; ?></td>
                                <td><small><?php echo $d['tgl_lamar']; ?></small></td>
                                <td>
                                    <div class="fw-bold"><?php echo $d['nama_lengkap']; ?></div>
                                    <div class="small text-muted"><i class="bi bi-whatsapp"></i> <?php echo $d['no_hp_lamaran']; ?></div>
                                    <span class="badge bg-light text-dark border"><?php echo $d['jurusan']; ?></span>
                                </td>
                                <td width="30%">
                                    <span class="text-primary fw-bold"><?php echo $d['posisi']; ?></span>
                                    <div class="bg-light p-2 rounded small mt-1 border">
                                        <em>"<?php echo $d['pesan_singkat']; ?>"</em>
                                    </div>
                                </td>
                                <td>
                                    <a href="../assets/cv/<?php echo $d['file_cv']; ?>" target="_blank" class="btn btn-sm btn-outline-danger">
                                        <i class="bi bi-file-pdf"></i> PDF
                                    </a>
                                </td>
                                <td>
                                    <?php 
                                    if($d['status_lamaran'] == 'Pending'){
                                        echo "<span class='badge bg-warning text-dark'>Menunggu</span>";
                                    } elseif($d['status_lamaran'] == 'Diterima'){
                                        echo "<span class='badge bg-success'>Diterima</span>";
                                    } else {
                                        echo "<span class='badge bg-danger'>Ditolak</span>";
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?php if($d['status_lamaran'] == 'Pending') { ?>
                                        <div class="d-flex gap-1">
                                            <a href="pelamar-status.php?id=<?php echo $d['id_lamaran']; ?>&status=Diterima" class="btn btn-sm btn-success" onclick="return confirm('Terima pelamar ini?')">✔</a>
                                            <a href="pelamar-status.php?id=<?php echo $d['id_lamaran']; ?>&status=Ditolak" class="btn btn-sm btn-danger" onclick="return confirm('Tolak pelamar ini?')">✖</a>
                                        </div>
                                    <?php } else { ?>
                                        <i class="bi bi-check-all text-muted"></i>
                                    <?php } ?>
                                </td>
                            </tr>
                            <?php } ?>
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