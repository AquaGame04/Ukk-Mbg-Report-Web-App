<?php
include '../../includes/auth_check.php';
include '../../config/database.php';
Login_Check();
Only_Allow(['Admin']);

$query = "SELECT * FROM sekolah";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Kelola Sekolah - MBG Report</title>
</head>
<body>
    <h2>Manajemen Data Sekolah</h2>
    <a href="../dashboard.php">Kembali</a> |
    <a href="sekolah_add.php">Tambah Sekolah</a>

    <table>
        <thead>
            <tr>
                <th>ID Sekolah</th>
                <th>Nama Sekolah</th>
                <th>Alamat</th>
                <th>Kontak</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = mysqli_fetch_assoc($result)) : ?>
            <tr>
                <td><?php echo $row['id_sekolah']; ?></td>
                <td><?php echo $row['nama_sekolah']; ?></td>
                <td><?php echo $row['alamat']; ?></td>
                <td><?php echo $row['kontak']; ?></td>
                <td>
                    <a href="sekolah_edit.php?id=<?php echo $row['id_sekolah']; ?>">Edit</a> |
                    <a href="../../process/sekolah/sekolah_delete_process.php?id=<?php echo $row['id_sekolah']; ?>" onclick="return confirm ('Hapus Sekolah ini?')">Hapus</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</body>
</html>