<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
include 'config/koneksi.php'; 
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <title>Portal Loker Kampus</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</head>
<body>

    <nav class="navbar navbar-custom fixed-top">
        <div class="container">
            <a class="navbar-brand brand-text" href="#">🚀 LokerKampus</a>
            <div class="d-flex gap-2">
                <?php 
                
                if(isset($_SESSION['status_user']) && $_SESSION['status_user'] == "login_user"){
                    echo '<span class="navbar-text me-3 fw-bold text-dark">Halo, '.$_SESSION['nama_mhs'].' 👋</span>';
                    
                    echo '<button type="button" class="btn btn-outline-danger rounded-pill px-4" data-bs-toggle="modal" data-bs-target="#modalLogoutUser">Logout</button>';
                } else {
                    echo '<a href="login.php" class="btn btn-outline-primary rounded-pill px-4">Admin</a>';
                    echo '<a href="login_user.php" class="btn btn-gradient px-4 shadow">Login / Daftar</a>';
                }
                ?>
            </div>
        </div>
    </nav>

    <div class="hero text-center text-white d-flex align-items-center justify-content-center" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding-top: 100px; padding-bottom: 60px; border-bottom-left-radius: 50px; border-bottom-right-radius: 50px;">
        <div class="container mt-5">
            <h1 class="display-4 fw-bold">Cari Cuan Sambil Kuliah 🎓</h1>
            <p class="lead opacity-75">Temukan lowongan Magang & Part-Time khusus mahasiswa.</p>
            
            <div class="mt-4">
                <a href="index.php" class="btn btn-light rounded-pill px-4 m-1 fw-bold text-primary">Semua</a>
                <a href="index.php?kategori=Part-Time" class="btn btn-outline-light rounded-pill px-4 m-1">⏳ Part-Time</a>
                <a href="index.php?kategori=Magang" class="btn btn-outline-light rounded-pill px-4 m-1">🏢 Magang</a>
            </div>
        </div>
    </div>

    <div class="container mt-5 mb-5">
        <h4 class="mb-4 fw-bold border-start border-4 border-primary ps-3">Lowongan Terbaru</h4>
        <div class="row">
            <?php 
            if(isset($_GET['kategori'])){
                $kategori = $_GET['kategori'];
                $query = "SELECT * FROM loker WHERE kategori='$kategori' ORDER BY id_loker DESC";
            } else {
                $query = "SELECT * FROM loker ORDER BY id_loker DESC";
            }
            $data = mysqli_query($conn, $query);

            while($d = mysqli_fetch_array($data)){
            ?>
            <div class="col-md-4 mb-4">
                <div class="glass-card h-100 p-4 position-relative top-hover">
                    <div class="d-flex align-items-center mb-3">
                        <img src="assets/images/<?php echo $d['logo']; ?>" class="rounded-circle border" width="50" height="50" style="object-fit:cover;">
                        <div class="ms-3">
                            <h5 class="mb-0 fw-bold"><?php echo $d['posisi']; ?></h5>
                            <small class="text-muted"><?php echo $d['nama_perusahaan']; ?></small>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <span class="badge bg-light text-dark border"><?php echo $d['kategori']; ?></span>
                        <span class="badge <?php echo ($d['status']=='Open') ? 'bg-success' : 'bg-secondary'; ?>">
                            <?php echo $d['status']; ?>
                        </span>
                    </div>

                    <h6 class="text-success fw-bold">💰 <?php echo $d['gaji']; ?></h6>
                    <p class="text-muted small mt-3" style="min-height: 60px;">
                        <?php echo substr($d['deskripsi'], 0, 90); ?>...
                    </p>

                    <div class="d-grid mt-3">
                        <a href="detail.php?id=<?php echo $d['id_loker']; ?>" class="btn btn-outline-primary rounded-pill mb-2">Lihat Detail & Syarat</a>
                        
                        <?php if($d['status'] != 'Open') { ?>
                            <div class="text-center text-danger small fw-bold">Lowongan Ditutup</div>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <?php } ?>
        </div>
    </div>

    <div class="modal fade" id="modalLogoutUser" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content glass-card border-0">
        <div class="modal-body text-center p-5">
            <div class="mb-3">
                👋
            </div>
            <h4 class="fw-bold mb-3">Ingin Berpisah?</h4>
            <p class="text-muted mb-4">Apakah kamu yakin ingin logout dari akun mahasiswa?</p>
            
            <div class="d-flex justify-content-center gap-2">
                <button type="button" class="btn btn-light rounded-pill px-4 border" data-bs-dismiss="modal">Batal</button>
                <a href="logout_user.php" class="btn btn-gradient rounded-pill px-4">Ya, Logout</a>
            </div>
        </div>
        </div>
    </div>
    </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>