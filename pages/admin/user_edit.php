<?php
include '../../includes/auth_check.php';
include '../../config/database.php';

Login_Check();
Only_Allow(['Admin']);

$uid = $_GET['uid'];
$query = "SELECT * FROM users WHERE uid = '$uid'";
$result = mysqli_query($conn, $query);
$users = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <title>Edit User - MBG Report</title>
</head>
<body>
    <h2>Edit Data</h2>
    <form action="../../admin/users/user_edit_process.php" method="POST">
        <input type="hidden" name="old_uid" value="<?php echo $users['uid']; ?>">
        <label>UID:</label><br>
        <input type="text" name="uid" value="<?php echo $users['uid']; ?>" required><br>
        <label>Nama:</label><br>
        <input type="text" name="nama" value="<?php echo $users['nama']; ?>" required><br>
        <label>Role:</label><br>
        <select name="role">
            <option value="Admin" <?php if($users['role'] == 'Admin') echo 'selected'; ?>>Admin</option>
            <option value="Petugas Gizi" <?php if($users['role'] == 'Petugas Gizi') echo 'selected'; ?>>Petugas Gizi</option>
            <option value="Petugas Pengaduan" <?php if($users['role'] == 'Petugas Pengaduan') echo 'selected'; ?>>Petugas Pengaduan</option>
        </select><br>
        <label>Password (Kosongkan jika tidak di ubah):</label><br>
        <input type="password" name="password"><br>
        <button type="submit" name="update">Update User</button>
    </form>
</body>
</html>