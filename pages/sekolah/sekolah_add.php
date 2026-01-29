<?php
include '../../includes/auth_check.php';
include '../../config/database.php';
Login_Check();
Only_Allow(['Admin']);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Sekolah - MBG Report</title>
    <link rel="stylesheet" href="../../assets/css/form_style.css">
</head>
<body>
    <div class="form-container">
        <div class="form-header">
            <h1>Tambah Data Sekolah Baru</h1>
            <p>Masukkan informasi lengkap sekolah</p>
        </div>

        <form action="../../process/sekolah/sekolah_add_process.php" method="POST" class="form-content">
            <div class="form-group">
                <label for="id_sekolah">ID Sekolah</label>
                <input type="text" id="id_sekolah" name="id_sekolah" placeholder="Contoh: SKL001" required>
                <small>ID unik untuk identitas sekolah</small>
            </div>

            <div class="form-group">
                <label for="nama_sekolah">Nama Sekolah</label>
                <input type="text" id="nama_sekolah" name="nama_sekolah" placeholder="Masukkan nama sekolah lengkap" required>
            </div>

            <div class="form-group">
                <label for="alamat">Alamat</label>
                <input type="text" id="alamat" name="alamat" rows="4" placeholder="Masukkan alamat lengkap sekolah" required></input>
            </div>

            <div class="form-group">
                <label for="kontak">Nomor Kontak</label>
                <input type="text" id="kontak" name="kontak" placeholder="Contoh: 081234567890 atau (021) 1234567" required>
            </div>

            <div class="form-group">
                <label for="koordinat">Koordinat (Opsional)</label>
                <input type="text" id="koordinat" name="koordinat" placeholder="Contoh: -6.1754,106.8272">
                <small>Format: latitude,longitude untuk peta Google Maps</small>
            </div>

            <div class="form-actions">
                <button type="submit" name="submit" class="btn-primary">Simpan Sekolah</button>
                <a href="sekolah_manage.php" class="btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</body>
</html>