<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun - Loker Kampus</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

    <div class="container d-flex align-items-center justify-content-center" style="min-height: 100vh;">
        <div class="glass-card p-5" style="width: 100%; max-width: 500px;">
            <div class="text-center mb-4">
                <h2 class="brand-text">🚀 Join LokerKampus</h2>
                <p class="text-muted">Buat akun untuk mulai melamar kerja.</p>
            </div>

            <form action="proses_register.php" method="post">
                <div class="mb-3">
                    <label class="form-label fw-bold">Nama Lengkap</label>
                    <input type="text" name="nama" class="form-control" placeholder="Contoh: Budi Santoso" required>
                </div>
                
                <div class="mb-3">
                    <label class="form-label fw-bold">Email Kampus/Pribadi</label>
                    <input type="email" name="email" class="form-control" placeholder="nama@mahasiswa.ac.id" required>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Jurusan</label>
                        <select name="jurusan" class="form-select form-control" required>
                            <option value="">Pilih...</option>
                            <option value="Informatika">Informatika</option>
                            <option value="Sistem Informasi">Sistem Informasi</option>
                            <option value="DKV">DKV</option>
                            <option value="Manajemen">Manajemen</option>
                            </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">No. HP (WA)</label>
                        <input type="text" name="hp" class="form-control" placeholder="0812..." required>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold">Password</label>
                    <input type="password" name="password" class="form-control" placeholder="Minimal 6 karakter" required>
                </div>

                <button type="submit" name="daftar" class="btn-gradient w-100">DAFTAR SEKARANG</button>
            </form>

            <div class="text-center mt-4">
                Sudah punya akun? <a href="login_user.php" class="text-primary fw-bold" style="text-decoration:none;">Login Disini</a>
                <br>
                <a href="index.php" class="small text-muted">Kembali ke Beranda</a>
            </div>
        </div>
    </div>

</body>
</html>