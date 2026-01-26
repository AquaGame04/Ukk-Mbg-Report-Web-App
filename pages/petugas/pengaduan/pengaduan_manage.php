<?php
include '../../../includes/auth_check.php';
include '../../../config/database.php';
Login_Check();
Only_Allow(['Petugas Pengaduan', 'Admin']);

// Query untuk mengambil data aduan beserta nama sekolahnya
$query = "SELECT p.*, s.nama_sekolah 
          FROM pengaduan p
          JOIN sekolah s ON p.id_sekolah = s.id_sekolah
          ORDER BY p.tanggal DESC";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <title>Kelola Pengaduan - MBG Report</title>
</head>
<body>
    <h2>Daftar Pengaduan</h2>
    <a href="../../dashboard.php">Kembali</a>

    <table border="1">
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Pelapor</th>
                <th>Sekolah Terkait</th>
                <th>Isi Aduan</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = mysqli_fetch_assoc($result)): ?>
            <tr>
                <td><?php echo date('d/m/Y H:i', strtotime($row['tanggal'])); ?></td>
                <td>
                    <strong><?php echo $row['nama_pelapor']; ?></strong>
                    <small><?php echo $row['kontak']; ?></small>
                </td>
                <td><?php echo $row['nama_sekolah'];?></td>
                <td><?php echo substr($row['isi_pengaduan'], 0, 50) . '...'; ?></td>
                <td>
                    <span style="background: <?php 
                            if($row['status'] == 'Pending') echo '#ffcccc';
                            elseif($row['status'] == 'Diproses') echo '#fff0b3';
                            else echo '#ccffcc';
                        ?>">
                        <?php echo $row['status']; ?>
                    </span>
                </td>
                <td>
                    <a href="pengaduan_detail.php?id=<?php echo $row['id_pengaduan']; ?>">Detail & Tindak Lanjut</a> |
                    <a href="../../../process/pengaduan/pengaduan_delete_process.php?id=<?php echo $row['id_pengaduan']; ?>" onclick="return confirm('Hapus Aduan Ini?')"></a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</body>
</html>