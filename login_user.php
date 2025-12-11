<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Mahasiswa - Loker Kampus</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

    <div class="container d-flex align-items-center justify-content-center" style="min-height: 100vh;">
        <div class="glass-card p-5" style="width: 100%; max-width: 450px;">
            <div class="text-center mb-4">
                <h2 class="brand-text">🎓 Student Login</h2>
                <p class="text-muted">Masuk untuk melamar kerja.</p>
            </div>

            <?php 
            if(isset($_GET['pesan'])){
                if($_GET['pesan'] == "gagal"){
                    echo "<div class='alert alert-danger py-2 small'>Email atau Password salah!</div>";
                } else if($_GET['pesan'] == "belum_login"){
                    echo "<div class='alert alert-warning py-2 small'>Login dulu baru bisa melamar.</div>";
                } else if($_GET['pesan'] == "sukses_lamar"){
                    echo "<div class='alert alert-success py-2 small'>Lamaran Terkirim! Cek status nanti.</div>";
                }
            }
            ?>

            <form action="cek_login_user.php" method="post">
                <div class="mb-3">
                    <label class="form-label fw-bold">Email Kampus/Pribadi</label>
                    <input type="email" name="email" class="form-control" placeholder="nama@email.com" required>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold">Password</label>
                    <input type="password" name="password" class="form-control" placeholder="Password akun..." required>
                </div>

                <button type="submit" class="btn-gradient w-100">MASUK</button>
            </form>

            <div class="text-center mt-4">
                Belum punya akun? <a href="register.php" class="text-primary fw-bold" style="text-decoration:none;">Daftar Disini</a>
                <br>
                <a href="index.php" class="small text-muted">Kembali ke Beranda</a>
            </div>
        </div>
    </div>

</body>
</html>