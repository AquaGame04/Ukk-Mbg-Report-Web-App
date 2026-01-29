<?php
include '../../../includes/auth_check.php';
include '../../../config/database.php';
Login_Check();
Only_Allow(['Petugas Gizi', 'Admin']);

$query = "SELECT m.*, s.nama_sekolah FROM menu_harian m 
          JOIN sekolah s ON m.id_sekolah = s.id_sekolah 
          WHERE m.riwayat = 0
          ORDER BY m.tanggal DESC";
$result = mysqli_query($conn, $query);

$nama = $_SESSION['nama'];
$role = $_SESSION['role'];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Menu - MBG Report</title>
    <link rel="stylesheet" href="../../../assets/css/dashboard_style.css">
    <link rel="stylesheet" href="../../../assets/css/table_style.css">
</head>
<body>
    <div class="dashboard-wrapper">
        <aside class="sidebar">
            <div class="sidebar-header">
                <h2 class="logo">MBG REPORT</h2>
            </div>
            
            <div class="profile-section">
                <div class="profile-avatar"><?php echo strtoupper(substr($nama, 0, 1)); ?></div>
                <div class="profile-info">
                    <p class="profile-name"><?php echo $nama; ?></p>
                    <span class="role-badge"><?php echo $role; ?></span>
                </div>
            </div>
            
            <nav class="menu">
                <ul>
                    <li><a href="../../dashboard.php" class="menu-item">Home</a></li>
                    
                    <?php if($_SESSION['role'] == 'Admin'): ?>
                        <li><a href="../../admin/user_manage.php" class="menu-item">Kelola User</a></li>
                        <li><a href="../../sekolah/sekolah_manage.php" class="menu-item">Kelola Sekolah</a></li>
                        <li><a href="../../sppg/sppg_manages.php.php" class="menu-item">Kelola Tim SPPG</a></li>
                        <li><a href="menu_manage.php" class="menu-item active">Input Menu & Gizi</a></li>
                        <li><a href="../../petugas/pengaduan/pengaduan_manage.php" class="menu-item">Pengaduan List</a></li>
                    <?php endif; ?>
                    <?php if($_SESSION['role'] == 'Petugas Gizi'): ?>
                        <li><a href="../../sekolah/sekolah_manage.php" class="menu-item">Input Sekolah</a></li>
                        <li><a href="menu_manage.php" class="menu-item">Input Menu & Gizi</a></li>
                    <?php endif; ?>
                    
                    <li><a href="../../../auth/logout_process.php" class="menu-item logout" onclick="return confirm('Apakah Anda Yakin Ingin Keluar?')">Logout</a></li>
                </ul>
            </nav>
        </aside>

        <main class="main-content">
            <header class="dashboard-header">
                <div>
                    <h1>Manajemen Menu Harian</h1>
                    <p>Kelola menu makan bergizi dan data gizi setiap hari</p>
                </div>
                <div class="header-actions">
                    <a href="menu_add.php" class="btn-primary">Tambah Menu Baru</a>
                </div>
            </header>

            <section class="table-section">
                <div class="table-wrapper">
                    <?php if(mysqli_num_rows($result) > 0) : ?>
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Nama Menu</th>
                                    <th>Sekolah</th>
                                    <th>Foto</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while($row = mysqli_fetch_assoc($result)) : ?>
                                <tr>
                                    <td><strong><?php echo date('d M Y', strtotime($row['tanggal'])); ?></strong></td>
                                    <td><?php echo $row['nama_menu']; ?></td>
                                    <td><?php echo $row['nama_sekolah']; ?></td>
                                    <td>
                                        <?php if(!empty($row['foto_url'])): ?>
                                            <img src="../../../assets/uploads/menu/<?php echo $row['foto_url']; ?>" alt="Foto" style="width: 50px; height: 50px; object-fit: cover; border-radius: 5px;">
                                        <?php else: ?>
                                            <span class="text-muted">-</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <div class="action-buttons">
                                            <a href="menu_edit.php?id=<?php echo $row['id_menu']; ?>" class="btn-small btn-edit">Edit</a>
                                            <a href="menu_gizi.php?id=<?php echo $row['id_menu']; ?>" class="btn-small btn-info">Gizi</a>
                                            <a href="../../../process/menu/menu_delete_process.php?id=<?php echo $row['id_menu']; ?>" class="btn-small btn-delete" onclick="return confirm('Apakah Anda yakin ingin menghapus menu ini?')">Hapus</a>
                                        </div>
                                    </td>
                                </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    <?php else : ?>
                        <div class="empty-state">
                            <p>Belum ada data menu. <a href="menu_add.php">Tambah Menu Baru</a></p>
                        </div>
                    <?php endif; ?>
                </div>
            </section>
        </main>
    </div>
</body>
</html>