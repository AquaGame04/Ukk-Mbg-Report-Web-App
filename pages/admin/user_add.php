<?php
include '../../includes/auth_check.php';
include '../../config/database.php';
Login_Check();
Only_Allow(['Admin']);

$query_sekolah = "SELECT id_sekolah, nama_sekolah FROM sekolah ORDER BY nama_sekolah ASC";
$daftar_sekolah = mysqli_query($conn, $query_sekolah);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah User - MBG Report</title>
    <link rel="stylesheet" href="../../assets/css/form_style.css">
</head>
<body>
    <div class="form-container">
        <div class="form-header">
            <h1>Tambah User Baru</h1>
            <p>Masukkan data lengkap pengguna sistem</p>
        </div>

        <form action="../../process/users/user_add_process.php" method="POST" class="form-content">
            <div class="form-group">
                <label for="uid">UID (User ID)</label>
                <input type="text" id="uid" name="uid" placeholder="Contoh: USR001" required>
                <small>ID unik untuk login pengguna</small>
            </div>

            <div class="form-group">
                <label for="nama">Nama Lengkap</label>
                <input type="text" id="nama" name="nama" placeholder="Masukkan nama lengkap" required>
            </div>

            <div class="form-group">
                <label for="role">Role / Peran</label>
                <select id="role" name="role" required>
                    <option value="">-- Pilih Role --</option>
                    <option value="Admin">Admin</option>
                    <option value="Petugas Gizi">Petugas Gizi</option>
                    <option value="Petugas Pengaduan">Petugas Pengaduan</option>
                </select>
            </div>

            <div class="form-group">
                <label for="id_sekolah">Penempatan Sekolah (Opsional untuk Admin)</label>
                <select id="id_sekolah" name="id_sekolah">
                    <option value="">-- Tidak Terikat Sekolah --</option>
                    <?php while($s = mysqli_fetch_assoc($daftar_sekolah)): ?>
                        <option value="<?php echo $s['id_sekolah']; ?>">
                            <?php echo $s['nama_sekolah']; ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Buat password yang kuat" required>
                <small>Minimal 6 karakter</small>
            </div>

            <div class="form-actions">
                <button type="submit" name="submit" class="btn-primary">Simpan User</button>
                <a href="user_manage.php" class="btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</body>
</html>