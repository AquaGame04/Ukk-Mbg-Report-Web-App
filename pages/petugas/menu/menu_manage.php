<?php
include '../../../includes/auth_check.php';
include '../../../config/database.php';
Login_Check();
Only_Allow(['Petugas Gizi','Admin']);

$id_sekolah = $_SESSION['id_sekolah']; // Mengambil sekolah petugas dari session

$query = "SELECT m.*, g.*, s.nama_sekolah 
          FROM menu_harian m
          JOIN gizi_menu g ON m.id_menu = g.id_menu
          JOIN sekolah s ON m.id_sekolah = s.id_sekolah
          ORDER BY m.tanggal DESC";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <title>Kelola Menu Gizi</title>
</head>
<body>
    <h2>Daftar Menu Harian Sekolah</h2>
    <a href="../../dashboard.php">Kembali</a> | <a href="menu_add.php">Tambah Menu Hari Ini</a>

    <table border="1" cellpadding="10" cellspacing="0" style="width: 100%; margin-top: 20px;">
        <thead>
            <tr>
                <th>Nama Sekolah</th>
                <th>Tanggal</th>
                <th>Foto</th>
                <th>Nama Menu</th>
                <th>Detail Gizi</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = mysqli_fetch_assoc($result)) : ?>
            <tr>
                <td><strong><?php echo $row['nama_sekolah']; ?></strong><br><small>(ID: <?php echo $row['id_sekolah']; ?>)</small></td>

                <td><?php echo date('d-m-Y', strtotime($row['tanggal'])); ?></td>

                <td align="center">
                    <?php if (!empty($row['foto_url']) && file_exists("../../../assets/uploads/" . $row['foto_url'])): ?>
                        <img src="../../../assets/uploads/<?php echo $row['foto_url']; ?>" 
                            alt="Foto Menu" 
                            style="width: 100px; height: 100px; object-fit: cover; border-radius: 8px; border: 1px solid #ddd;">
                    <?php else: ?>
                        <div style="width: 100px; height: 100px; background: #eee; display: flex; align-items: center; justify-content: center; font-size: 10px; color: #999;">
                            Tidak ada foto
                        </div>
                    <?php endif; ?>
                </td>

                <td><?php echo $row['nama_menu']; ?></td>

                <td>
                    <ul style="margin: 0; padding-left: 15px; font-size: 0.9em;">
                        <li>Energi: <?php echo $row['energi']; ?> kkal</li>
                        <li>Kalori: <?php echo $row['kalori']; ?></li>
                        <li>Protein: <?php echo $row['protein']; ?>g</li>
                        <li>Karb: <?php echo $row['karbohidrat']; ?>g</li>
                        <li>Lemak: <?php echo $row['lemak']; ?>g</li>
                        <li>Serat: <?php echo $row['serat']; ?>g</li>
                    </ul>
                </td>

                <td align="center">
                    <?php 
                        $status = $row['riwayat'] == 1 ? 'Selesai (Riwayat)' : 'Aktif';
                        echo $status;
                    ?>
                </td>
                <td>
                    <a href="menu_edit.php?id=<?php echo $row['id_menu']; ?>">Edit</a> | 
                    <a href="../../../process/menu/menu_delete_process.php?id=<?php echo $row['id_menu']; ?>" 
                       onclick="return confirm('Hapus menu ini?')">Hapus</a>
                </td>
            </tr>
            <?php endwhile; ?>
            <?php if(mysqli_num_rows($result) == 0) : ?>
            <tr>
                <td colspan="7" align="center">Belum ada data menu harian.</td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>