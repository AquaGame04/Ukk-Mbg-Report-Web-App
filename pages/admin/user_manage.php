<?php
include '../../includes/auth_check.php';
include '../../config/database.php';

Login_Check();
Only_Allow(['Admin']);

$query = "SELECT * FROM users";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola User - MBG Report</title>
</head>
<body>
    <h1>Manajemen User</h1>
    <a href="../dashboard.php">Kembali ke Dashboard</a> |
    <a href="user_add.php" class="btn btn-add">Tambah User Baru</a>

    <table>
        <thead>
            <tr>
                <th>UID</th>
                <th>Nama Lengkap</th>
                <th>Role</th>
                <th>ID Sekolah</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = mysqli_fetch_assoc($result)) : ?>
            <tr>
                <td><?php echo $row['uid']; ?></td>
                <td><?php echo $row['nama']; ?></td>
                <td><?php echo $row['role']; ?></td>
                <td><?php echo $row['id_sekolah'] ?? '-'; ?></td>
                <td>
                    <a href="user_edit.php ? uid=<?php echo $row['uid']; ?>" class="btn btn-edit">Edit</a>
                    <a href="../../admin/users/user_delete_process.php ? uid=<?php echo $row['uid']; ?>" class="btn btn-delete" onclick="return confirm("Yakin hapus user ini?">Hapus</a>
                </td>
            </tr>
            <?php endwhile;?>
        </tbody>
    </table>
</body>
</html>