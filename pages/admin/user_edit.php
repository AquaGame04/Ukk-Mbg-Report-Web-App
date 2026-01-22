<?php
include '../../includes/auth_check.php';
include '../../config/database.php';

Login_Check();
Only_Allow(['Admin']);

// query User
$uid = $_GET['uid'];
$query_user = "SELECT * FROM users WHERE uid = '$uid'";
$result_user = mysqli_query($conn, $query_user);
$user = mysqli_fetch_assoc($result_user);

// query Sekolah
$query_sekolah = "SELECT id_sekolah, nama_sekolah FROM sekolah";
$daftar_sekolah = mysqli_query($conn, $query_sekolah);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <title>Edit User - MBG Report</title>
</head>
<body>
    <h2>Edit Data</h2>
    <form action="../../process/users/user_edit_process.php" method="POST">
        <input type="hidden" name="old_uid" value="<?php echo $user['uid']; ?>">
        <label>UID:</label><br>
        <input type="text" name="uid" value="<?php echo $user['uid']; ?>" required><br>
        <label>Nama:</label><br>
        <input type="text" name="nama" value="<?php echo $user['nama']; ?>" required><br>
        <label>Role:</label><br>
        <select name="role">
            <option value="Admin" <?php if($user['role'] == 'Admin') echo 'selected'; ?>>Admin</option>
            <option value="Petugas Gizi" <?php if($user['role'] == 'Petugas Gizi') echo 'selected'; ?>>Petugas Gizi</option>
            <option value="Petugas Pengaduan" <?php if($user['role'] == 'Petugas Pengaduan') echo 'selected'; ?>>Petugas Pengaduan</option>
        </select><br>
        <label for="">Penempatan Sekolah:</label><br>
        <select name="id_sekolah">
            <option value="">-- Tidak Terikat Sekolah --</option>
            <?php while($s = mysqli_fetch_assoc($daftar_sekolah)): ?>
                <option value="<?php echo $s['id_sekolah']; ?>" <?php if($user['id_sekolah'] == $s['id_sekolah']) echo 'selected'; ?>>
                    <?php echo $s['nama_sekolah'] ?>
                </option>
            <?php endwhile; ?>
        </select><br>
        <label>Password (Kosongkan jika tidak di ubah):</label><br>
        <input type="password" name="password"><br>
        <button type="submit" name="update">Update User</button><br>
    </form>
    <p><a href="user_manage.php">Batal</a></p>
</body>
</html>

<!-- <option value="<?php //echo $s['id_sekolah']; if($user['id_sekolah'] == $s['id_sekolah']) echo 'selected'; ?> ">
        <?php //echo $s['nama_sekolah']; ?>
    </option> -->