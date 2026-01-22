<?php
include '../../includes/auth_check.php';
include '../../config/database.php';
Login_Check();
Only_Allow(['Admin']);

$query_sekolah = "SELECT id_sekolah, nama_sekolah FROM sekolah";
$daftar_sekolah = mysqli_query($conn, $query_sekolah);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <title>Tambah User - MBG Report</title>
</head>
<body>
    <h2>Tambah User Baru</h2>
    <form action="../../process/users/user_add_process.php" method="POST">
        <label for="">UID:</label><br>
        <input type="text" name="uid" placeholder="UID (Username)" required><br>
        <label for="">Nama:</label><br>
        <input type="text" name="nama" placeholder="Nama Lengkap" required><br>
        <label for="">Role:</label><br>
        <select name="role">
            <option value="Petugas Gizi">Petugas Gizi</option>
            <option value="Petugas Pengaduan">Petugas Pengaduan</option>
            <option value="Admin">Admin</option>
        </select><br>
        <label for="">Penempatan Sekolah:</label><br>
        <select name="id_sekolah">
            <option value="">-- Pilih Sekolah (Opsional Untuk Admin) --</option>
            <?php while($s = mysqli_fetch_assoc($daftar_sekolah)): ?>
                <option value="<?php echo $s['id_sekolah']; ?>">
                    <?php echo $s['nama_sekolah']; ?>
                </option>
            <?php endwhile; ?>
        </select><br>
        <label for="">Password:</label><br>
        <input type="text" name="password" placeholder="PTG123" required><br>
        <button type="submit" name="submit">Simpan User</button>
    </form>
    <p>Kembali ke <a href="user_manage.php">Daftar User</a></p>
</body>
</html>