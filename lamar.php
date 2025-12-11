<?php
session_start();
include 'config/koneksi.php';

// 1. Cek Login User
if(!isset($_SESSION['status_user'])){
    header("location:login_user.php?pesan=belum_login");
}

$id_loker = $_GET['id'];
$id_mhs   = $_SESSION['id_mhs'];

// 2. Ambil Data Loker (Buat Judul)
$q_loker = mysqli_query($conn, "SELECT * FROM loker WHERE id_loker='$id_loker'");
$loker = mysqli_fetch_array($q_loker);

// 3. Ambil Data Mahasiswa (Buat Auto-Fill Form)
$q_mhs = mysqli_query($conn, "SELECT * FROM mahasiswa WHERE id_mhs='$id_mhs'");
$mhs = mysqli_fetch_array($q_mhs);

// 4. PROSES KIRIM LAMARAN
if(isset($_POST['kirim'])){
    $tgl = date('Y-m-d');
    
    // Ambil inputan tambahan
    $hp_lamaran = $_POST['no_hp'];
    $pesan      = $_POST['pesan'];

    // Upload CV (PDF only)
    $filename = $_FILES['cv']['name'];
    $ext = pathinfo($filename, PATHINFO_EXTENSION);
    
    if($ext == "pdf"){
        // Rename file biar unik
        $nama_file = time().'_CV_'.$mhs['nama_lengkap'].'.pdf';
        
        // Pindahkan file
        move_uploaded_file($_FILES['cv']['tmp_name'], 'assets/cv/'.$nama_file);
        
        // Simpan ke Database (Update query dengan kolom baru)
        $query = "INSERT INTO lamaran (id_mhs, id_loker, tgl_lamar, file_cv, no_hp_lamaran, pesan_singkat, status_lamaran) 
                  VALUES ('$id_mhs', '$id_loker', '$tgl', '$nama_file', '$hp_lamaran', '$pesan', 'Pending')";
        
        if(mysqli_query($conn, $query)){
            echo "<script>alert('Lamaran Berhasil Terkirim!'); window.location='index.php';</script>";
        } else {
            echo "<script>alert('Gagal mengirim lamaran.');</script>";
        }

    } else {
        echo "<script>alert('Harap upload file format PDF!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <title>Form Lamaran Kerja</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="bg-light">

<div class="container d-flex justify-content-center align-items-center py-5" style="min-height:100vh;">
    <div class="glass-card p-5" style="width: 100%; max-width: 600px;">
        
        <div class="text-center mb-4">
            <h4 class="fw-bold text-primary">🚀 Kirim Lamaran</h4>
            <p class="text-muted">Posisi: <b><?php echo $loker['posisi']; ?></b> di <?php echo $loker['nama_perusahaan']; ?></p>
        </div>
        
        <form action="" method="post" enctype="multipart/form-data">
            
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label fw-bold small">Nama Lengkap</label>
                    <input type="text" class="form-control bg-light" value="<?php echo $mhs['nama_lengkap']; ?>" readonly>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold small">Email</label>
                    <input type="text" class="form-control bg-light" value="<?php echo $mhs['email']; ?>" readonly>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">No. WhatsApp / HP</label>
                <input type="text" name="no_hp" class="form-control" value="<?php echo $mhs['no_hp']; ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Promosi Diri (Cover Letter)</label>
                <textarea name="pesan" class="form-control" rows="3" placeholder="Contoh: Saya mahasiswa semester 5 yang teliti dan sudah berpengalaman menggunakan Excel..." required></textarea>
                <div class="form-text">Jelaskan singkat kenapa kamu cocok untuk posisi ini.</div>
            </div>

            <div class="mb-4">
                <label class="form-label fw-bold">Upload CV Terbaru (PDF)</label>
                <input type="file" name="cv" class="form-control" accept=".pdf" required>
            </div>
            
            <div class="d-flex gap-2">
                <a href="detail.php?id=<?php echo $id_loker; ?>" class="btn btn-secondary w-100 rounded-pill">Batal</a>
                <button type="submit" name="kirim" class="btn btn-gradient w-100 rounded-pill shadow">KIRIM SEKARANG</button>
            </div>
        </form>
    </div>
</div>

</body>
</html>