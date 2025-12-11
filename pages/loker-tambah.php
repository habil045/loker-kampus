<?php
session_start();
if($_SESSION['status']!="login"){
	header("location:../login.php?pesan=belum_login");
}

include '../config/koneksi.php';

if(isset($_POST['simpan'])){
    $nama       = $_POST['nama_perusahaan'];
    $posisi     = $_POST['posisi'];
    $lokasi     = $_POST['lokasi'];
    $kategori   = $_POST['kategori'];
    $gaji       = $_POST['gaji'];
    $deskripsi  = $_POST['deskripsi'];
    $syarat     = $_POST['syarat'];
    $tanggal    = date('Y-m-d');
    $status     = "Open";

    $rand = rand();
    $ekstensi_diperbolehkan = array('png','jpg','jpeg','gif');
    $filename = $_FILES['foto']['name'];
    $ukuran = $_FILES['foto']['size'];
    $file_tmp = $_FILES['foto']['tmp_name'];
    
    if($filename != ""){
        $ext = pathinfo($filename, PATHINFO_EXTENSION);

        if(!in_array($ext, $ekstensi_diperbolehkan) ) {
            echo "<script>alert('Ekstensi gambar harus PNG, JPG, atau GIF!');</script>";
        }else{
            if($ukuran < 2044070){ 
                $nama_file_baru = $rand.'_'.$filename;
                
                move_uploaded_file($file_tmp, '../assets/images/'.$nama_file_baru);
                
                $query = "INSERT INTO loker (nama_perusahaan, posisi, lokasi, kategori, deskripsi, syarat, gaji, logo, status, tanggal_upload) 
                          VALUES ('$nama', '$posisi', '$lokasi', '$kategori', '$deskripsi', '$syarat', '$gaji', '$nama_file_baru', '$status', '$tanggal')";
                
                $result = mysqli_query($conn, $query);

                if($result){
                    echo "<script>alert('Data Berhasil Disimpan!');window.location='dashboard.php';</script>";
                } else {
                    echo "<script>alert('Gagal menyimpan ke database!');</script>";
                }

            }else{
                echo "<script>alert('Ukuran file terlalu besar (Max 2MB)!');</script>";
            }
        }
    } else {
        echo "<script>alert('Harap upload logo perusahaan!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
	<title>Tambah Loker - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f4f6f9; }
        .card { border: none; border-radius: 10px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
        .form-label { font-weight: 600; color: #555; }
    </style>
</head>
<body>

<div class="container mt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            
            <div class="card">
                <div class="card-header bg-primary text-white py-3">
                    <h4 class="mb-0">📝 Tambah Lowongan Baru</h4>
                </div>
                
                <div class="card-body p-4">
                    <form action="" method="post" enctype="multipart/form-data">
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Nama Perusahaan</label>
                                <input type="text" name="nama_perusahaan" class="form-control" placeholder="Contoh: PT Mencari Cinta" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Posisi / Jabatan</label>
                                <input type="text" name="posisi" class="form-control" placeholder="Contoh: Staff Admin" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label class="form-label">Lokasi Kerja</label>
                                <input type="text" name="lokasi" class="form-control" placeholder="Contoh: Jakarta / WFH" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Kategori</label>
                                <select name="kategori" class="form-select">
                                    <option value="Part-Time">Part-Time (Paruh Waktu)</option>
                                    <option value="Magang">Magang / Internship</option>
                                    <option value="Volunteer">Volunteer / Kepanitiaan</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Gaji / Benefit</label>
                                <input type="text" name="gaji" class="form-control" placeholder="Contoh: Rp 2.000.000" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Deskripsi Pekerjaan</label>
                            <textarea name="deskripsi" class="form-control" rows="4" placeholder="Jelaskan tanggung jawab pekerjaan ini..." required></textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Persyaratan / Kualifikasi</label>
                            <textarea name="syarat" class="form-control" rows="4" placeholder="Contoh: &#10;- Mahasiswa aktif semester 5&#10;- Menguasai Microsoft Office&#10;- Jujur dan teliti" required></textarea>
                            <div class="form-text text-muted">Gunakan tombol Enter untuk membuat baris baru.</div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Logo Perusahaan (Max 2MB)</label>
                            <input type="file" name="foto" class="form-control" required>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="dashboard.php" class="btn btn-secondary px-4">🔙 Kembali</a>
                            <button type="submit" name="simpan" class="btn btn-success px-5">💾 SIMPAN DATA</button>
                        </div>

                    </form>
                </div>
            </div>

        </div>
    </div>
</div>

</body>
</html>