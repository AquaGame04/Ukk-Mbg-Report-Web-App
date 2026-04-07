<?php
include '../../includes/auth_check.php';
include '../../config/database.php';

Login_Check();
Only_Allow(['Admin']);

// Query User
$uid = $_GET['uid'];
$query_user = "SELECT * FROM users WHERE uid = '$uid'";
$result_user = mysqli_query($conn, $query_user);
$user = mysqli_fetch_assoc($result_user);

// Query Sekolah
$query_sekolah = "SELECT id_sekolah, nama_sekolah FROM sekolah ORDER BY nama_sekolah ASC";
$daftar_sekolah = mysqli_query($conn, $query_sekolah);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User - MBG Report</title>
    <link rel="stylesheet" href="../../assets/css/form_style.css">
</head>
<body>
    <div class="form-container">
        <div class="form-header">
            <h1>Edit Data User</h1>
            <p>Perbarui informasi pengguna sistem</p>
        </div>

        <form action="../../process/users/user_edit_process.php" method="POST" class="form-content">
            <input type="hidden" name="old_uid" value="<?php echo $user['uid']; ?>">

            <div class="form-group">
                <label for="uid">UID (User ID)</label>
                <input type="text" id="uid" name="uid" value="<?php echo $user['uid']; ?>" required>
                <small>ID unik untuk login pengguna</small>
            </div>

            <div class="form-group">
                <label for="nama">Nama Lengkap</label>
                <input type="text" id="nama" name="nama" value="<?php echo $user['nama']; ?>" required>
            </div>

            <div class="form-group">
                <label for="role">Role / Peran</label>
                <select id="role" name="role" required>
                    <option value="Admin" <?php if($user['role'] == 'Admin') echo 'selected'; ?>>Admin</option>
                    <option value="Petugas Gizi" <?php if($user['role'] == 'Petugas Gizi') echo 'selected'; ?>>Petugas Gizi</option>
                    <option value="Petugas Pengaduan" <?php if($user['role'] == 'Petugas Pengaduan') echo 'selected'; ?>>Petugas Pengaduan</option>
                </select>
            </div>

            <div class="form-group">
                <label for="id_sekolah">Penempatan Sekolah</label>
                <select id="id_sekolah" name="id_sekolah">
                    <option value="">-- Tidak Terikat Sekolah --</option>
                    <?php while($s = mysqli_fetch_assoc($daftar_sekolah)): ?>
                        <option value="<?php echo $s['id_sekolah']; ?>" <?php if($user['id_sekolah'] == $s['id_sekolah']) echo 'selected'; ?>>
                            <?php echo $s['nama_sekolah']; ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="password">Password Baru (Kosongkan jika tidak diubah)</label>
                <input type="password" id="password" name="password" placeholder="Buat password baru">
                <small>Biarkan kosong jika tidak ingin mengubah password</small>
            </div>

            <div class="form-actions">
                <button type="submit" name="update" class="btn-primary">Update User</button>
                <a href="user_manage.php" class="btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</body>
</html>