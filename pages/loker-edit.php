<?php
session_start();
if($_SESSION['status']!="login"){
	header("location:../login.php?pesan=belum_login");
}

include '../config/koneksi.php';

$id = $_GET['id'];
$query = mysqli_query($conn, "SELECT * FROM loker WHERE id_loker='$id'");
$d = mysqli_fetch_array($query);

if(isset($_POST['update'])){
    $nama       = $_POST['nama_perusahaan'];
    $posisi     = $_POST['posisi'];
    $lokasi     = $_POST['lokasi'];
    $kategori   = $_POST['kategori'];
    $gaji       = $_POST['gaji'];
    $deskripsi  = $_POST['deskripsi'];
    $syarat     = $_POST['syarat'];
    $status     = $_POST['status'];
    $foto_lama  = $_POST['foto_lama'];

    $filename = $_FILES['foto']['name'];
    
    if($filename != ""){
        $rand = rand();
        $ekstensi_diperbolehkan = array('png','jpg','jpeg','gif');
        $ext = pathinfo($filename, PATHINFO_EXTENSION);

        if(!in_array($ext,$ekstensi_diperbolehkan) ) {
            echo "<script>alert('Format foto salah!');</script>";
        }else{
            $nama_file_baru = $rand.'_'.$filename;
            
            move_uploaded_file($_FILES['foto']['tmp_name'], '../assets/images/'.$nama_file_baru);
            
            if(file_exists("../assets/images/$foto_lama")){
                unlink("../assets/images/$foto_lama");
            }

            mysqli_query($conn, "UPDATE loker SET nama_perusahaan='$nama', posisi='$posisi', lokasi='$lokasi', kategori='$kategori', deskripsi='$deskripsi', syarat='$syarat', gaji='$gaji', status='$status', logo='$nama_file_baru' WHERE id_loker='$id'");
            
            echo "<script>alert('Data Berhasil Diupdate!');window.location='dashboard.php';</script>";
        }
    } else {
        mysqli_query($conn, "UPDATE loker SET nama_perusahaan='$nama', posisi='$posisi', lokasi='$lokasi', kategori='$kategori', deskripsi='$deskripsi', syarat='$syarat', gaji='$gaji', status='$status' WHERE id_loker='$id'");
        
        echo "<script>alert('Data Berhasil Diupdate!');window.location='dashboard.php';</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
	<title>Edit Loker - Admin</title>
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
                <div class="card-header bg-warning text-dark py-3">
                    <h4 class="mb-0">✏️ Edit Lowongan</h4>
                </div>
                
                <div class="card-body p-4">
                    <form action="" method="post" enctype="multipart/form-data">
                        
                        <input type="hidden" name="foto_lama" value="<?php echo $d['logo']; ?>">

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Nama Perusahaan</label>
                                <input type="text" name="nama_perusahaan" class="form-control" value="<?php echo $d['nama_perusahaan']; ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Posisi / Jabatan</label>
                                <input type="text" name="posisi" class="form-control" value="<?php echo $d['posisi']; ?>" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label class="form-label">Lokasi Kerja</label>
                                <input type="text" name="lokasi" class="form-control" value="<?php echo $d['lokasi']; ?>" required>
                            </div>
                            
                            <div class="col-md-3">
                                <label class="form-label">Status</label>
                                <select name="status" class="form-select">
                                    <option value="Open" <?php if($d['status']=="Open") echo "selected"; ?>>🟢 Open</option>
                                    <option value="Interview" <?php if($d['status']=="Interview") echo "selected"; ?>>🔵 Interview</option>
                                    <option value="Closed" <?php if($d['status']=="Closed") echo "selected"; ?>>🔴 Closed</option>
                                </select>
                            </div>

                            <div class="col-md-3">
                                <label class="form-label">Kategori</label>
                                <select name="kategori" class="form-select">
                                    <option value="Part-Time" <?php if($d['kategori']=="Part-Time") echo "selected"; ?>>Part-Time</option>
                                    <option value="Magang" <?php if($d['kategori']=="Magang") echo "selected"; ?>>Magang</option>
                                    <option value="Volunteer" <?php if($d['kategori']=="Volunteer") echo "selected"; ?>>Volunteer</option>
                                </select>
                            </div>

                            <div class="col-md-3">
                                <label class="form-label">Gaji</label>
                                <input type="text" name="gaji" class="form-control" value="<?php echo $d['gaji']; ?>" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Deskripsi Pekerjaan</label>
                            <textarea name="deskripsi" class="form-control" rows="4" required><?php echo $d['deskripsi']; ?></textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Persyaratan / Kualifikasi</label>
                            <textarea name="syarat" class="form-control" rows="4" required><?php echo $d['syarat']; ?></textarea>
                        </div>

                        <div class="mb-4">
                            <label class="form-label d-block">Logo Saat Ini</label>
                            <img src="../assets/images/<?php echo $d['logo']; ?>" width="120" class="img-thumbnail mb-2">
                            
                            <label class="form-label d-block text-muted small">Ganti Logo (Biarkan kosong jika tidak ingin mengganti)</label>
                            <input type="file" name="foto" class="form-control">
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="dashboard.php" class="btn btn-secondary px-4">🔙 Batal</a>
                            <button type="submit" name="update" class="btn btn-warning px-5">🔄 UPDATE DATA</button>
                        </div>

                    </form>
                </div>
            </div>

        </div>
    </div>
</div>

</body>
</html>