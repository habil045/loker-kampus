<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - Loker Kampus</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

    <div class="container d-flex align-items-center justify-content-center" style="min-height: 100vh;">
        
        <div class="glass-card p-5" style="width: 100%; max-width: 400px;">
            
            <div class="text-center mb-4">
                <h3 class="fw-bold brand-text">🔐 Login Admin</h3>
                <p class="text-muted small">Silahkan masuk untuk mengelola data.</p>
            </div>

            <?php 
            if(isset($_GET['pesan'])){
                if($_GET['pesan'] == "gagal"){
                    echo "<div class='alert alert-danger py-2 small text-center'>Login gagal! Username/Password salah.</div>";
                } else if($_GET['pesan'] == "logout"){
                    echo "<div class='alert alert-success py-2 small text-center'>Anda telah berhasil logout.</div>";
                } else if($_GET['pesan'] == "belum_login"){
                    echo "<div class='alert alert-warning py-2 small text-center'>Eits, login dulu ya!</div>";
                }
            }
            ?>

            <form action="cek_login.php" method="post">
                <div class="mb-3">
                    <label class="form-label fw-bold">Username</label>
                    <input type="text" name="username" class="form-control" placeholder="Masukan username..." required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Password</label>
                    <div class="input-group">
                        <input type="password" name="password" id="passwordInput" class="form-control" placeholder="Masukan password..." required>
                    </div>
                    <div class="form-check mt-2">
                        <input class="form-check-input" type="checkbox" onclick="togglePassword()" id="showPass">
                        <label class="form-check-label small text-muted" for="showPass">
                            Lihat Password
                        </label>
                    </div>
                </div>

                <div class="mb-4 form-check">
                    <input type="checkbox" class="form-check-input" name="remember" id="remember">
                    <label class="form-check-label small" for="remember">Ingat Saya</label>
                </div>

                <button type="submit" class="btn btn-gradient w-100 shadow">MASUK DASHBOARD</button>
            </form>

            <div class="text-center mt-4">
                <a href="index.php" class="text-decoration-none small text-muted">← Kembali ke Website Utama</a>
            </div>
            
            <div class="text-center mt-3" style="font-size:12px; color:#aaa;">
                &copy; 2025 Loker Kampus
            </div>
        </div>
    </div>

    <script src="assets/js/script.js"></script>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>