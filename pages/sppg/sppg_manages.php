<?php
include '../../includes/auth_check.php';
include '../../config/database.php';

Login_Check();
Only_Allow(['Admin']);

$query = "SELECT sppg.*, sekolah.nama_sekolah FROM sppg LEFT JOIN sekolah ON sppg.id_sekolah = sekolah.id_sekolah";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Kelola Tim SPPG - MBG Report</title>
</head>
<body>
    <h2>Manajemen Tim SPPG</h2>
    <a href="../dashboard.php">Kembali</a> | <a href="sppg_add.php">Tambah Tim Baru</a>

    <table>
        <thead>
            <tr>
                <th>ID SPPG</th>
                <th>Nama Tim</th>
                <th>Foto Tim</th>
                <th>Sekolah Tugas</th>
                <th>Ketua Tim</th>
                <th>Anggota Tim</th>
                <th>Kontak</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?php echo $row['id_sppg']; ?></td>
                    <td>
                        <strong><?php echo $row['nama_tim']; ?></strong><br>
                        <small>Jabatan: <?php echo $row['jabatan']; ?></small><br>
                        <small>Ketua: <?php echo $row['ketua_tim']; ?></small>
                    </td>
                    <td align="center">
                        <?php if(!empty($row['foto_tim'])): ?>
                            <img src="../../assets/uploads/sppg/<?php echo $row['foto_tim']; ?>" width="80" style="border-radius: 5px;">
                        <?php else: ?>
                            <small>No Image Found</small>
                        <?php endif; ?>
                    </td>
                    <td><?php echo $row['nama_sekolah'] ?? 'Belum Ditentukan'; ?></td>
                    <td><?php echo $row['ketua_tim']; ?></td>
                    <td>
                        <?php 
                            if(!empty($row['anggota_tim'])) {
                                $uids = explode(',', $row['anggota_tim']); //memecah string jadi array 
                                $nama_anggota = [];

                                foreach($uids as $uid) {
                                    $uid = mysqli_real_escape_string($conn, trim($uid));
                                    $res = mysqli_query($conn, "SELECT nama FROM users WHERE uid = '$uid'");
                                    if($u = mysqli_fetch_assoc($res)) {
                                        $nama_anggota[] = $u['nama'];
                                    }
                                }
                                echo implode(', ', $nama_anggota); //menampilkan nama, dipisah pakai koma
                            } else {
                                echo "-";
                            }
                        ?>
                    </td>
                    <td><?php echo $row['kontak_tim']; ?></td>
                    <td>
                        <a href="sppg_edit.php?id=<?php echo $row['id_sppg']; ?>">Edit</a> |
                        <a href="../../process/sppg/sppg_delete_process.php?id=<?php echo $row['id_sppg']; ?>" onclick="return confirm('Hapus Tim Ini?')">Hapus</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</body>
</html>