<?php
include '../../includes/auth_check.php';
Login_Check();
Only_Allow(['Admin']);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <title>Tambah User - MBG Report</title>
</head>
<body>
    <h2>Tambah User Baru</h2>
    <form action="../../admin/users/user_add_process.php" method="POST">
        <input type="text" name="uid" placeholder="UID (Username)" required><br>
        <input type="text" name="nama" placeholder="Nama Lengkap" required><br>
        <select name="role">
            <option value="Petugas Gizi">Petugas Gizi</option>
            <option value="Petugas Pengaduan">Petugas Pengaduan</option>
            <option value="Admin">Admin</option>
        </select><br>
        <input type="text" name="password" placeholder="PTG123" required><br>
        <button type="submit" name="submit">Simpan User</button>
    </form>
    <p>Kembali ke <a href="user_manage.php">Daftar User</a></p>
</body>
</html>