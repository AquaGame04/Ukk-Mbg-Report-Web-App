<?php
include '../../includes/auth_check.php';
Login_Check();
Only_Allow(['Admin']);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <title>Tambah Sekolah</title>
</head>
<body>
    <h2>Tambah Sekolah Baru</h2>
    <form action="../../process/sekolah/sekolah_add_process.php" method="POST">
        <label>ID Sekolah:</label><br>
        <input type="text" name="id_sekolah" placeholder="Contoh: SCH01" required><br><br>
        
        <label>Nama Sekolah:</label><br>
        <input type="text" name="nama_sekolah" required><br><br>
        
        <label>Alamat:</label><br>
        <textarea name="alamat" required></textarea><br><br>
        
        <label>Kontak (Telepon/WA):</label><br>
        <input type="text" name="kontak"><br><br>
        
        <label>Koordinat (Latitude, Longitude):</label><br>
        <input type="text" name="koordinat" placeholder="-7.xxx, 110.xxx"><br><br>
        
        <button type="submit" name="submit">Simpan Sekolah</button>
    </form>
    <p><a href="sekolah_manage.php">Batal</a></p>
</body>
</html>