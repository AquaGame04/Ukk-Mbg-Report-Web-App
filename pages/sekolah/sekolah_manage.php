<?php
include '../../includes/auth_check.php';
include '../../config/database.php';
Login_Check();
Only_Allow(['Admin', 'Petugas Gizi']);

$query = "SELECT * FROM sekolah ORDER BY nama_sekolah ASC";
$result = mysqli_query($conn, $query);

$nama = $_SESSION['nama'];
$role = $_SESSION['role'];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Sekolah - MBG Report</title>
    <link rel="stylesheet" href="../../assets/css/dashboard_style.css">
    <link rel="stylesheet" href="../../assets/css/table_style.css">
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
                    <li><a href="../dashboard.php" class="menu-item">Home</a></li>
                    
                    <?php if($_SESSION['role'] == 'Admin'): ?>
                        <li><a href="../admin/user_manage.php" class="menu-item">Kelola User</a></li>
                        <li><a href="sekolah_manage.php" class="menu-item active">Kelola Sekolah</a></li>
                        <li><a href="../sppg/sppg_manage.php" class="menu-item">Kelola Tim SPPG</a></li>
                        <li><a href="../petugas/menu/menu_manage.php" class="menu-item">Input Menu & Gizi</a></li>
                        <li><a href="../petugas/menu/menu_history.php" class="menu-item">Riwayat Menu</a></li>
                        <li><a href="../petugas/pengaduan/pengaduan_manage.php" class="menu-item">Pengaduan List</a></li>
                    <?php endif; ?>
                    <?php if($_SESSION['role'] == 'Petugas Gizi'): ?>
                        <li><a href="../../sekolah/sekolah_manage.php" class="menu-item active">Input Sekolah</a></li>
                        <li><a href="../petugas/menu/menu_manage.php" class="menu-item">Input Menu & Gizi</a></li>
                        <li><a href="../petugas/menu/menu_history.php" class="menu-item">Riwayat Menu</a></li>
                    <?php endif; ?>
                    
                    <li><a href="../../auth/logout_process.php" class="menu-item logout" onclick="return confirm('Apakah Anda Yakin Ingin Keluar?')">Logout</a></li>
                </ul>
            </nav>
        </aside>

        <main class="main-content">
            <header class="dashboard-header">
                <div>
                    <h1>Manajemen Data Sekolah</h1>
                    <p>Kelola informasi sekolah yang mengikuti program MBG</p>
                </div>
                <div class="header-actions">
                    <a href="sekolah_add.php" class="btn-primary">Tambah Sekolah Baru</a>
                </div>
            </header>

            <section class="table-section">
                <div class="table-wrapper">
                    <?php if(mysqli_num_rows($result) > 0) : ?>
                        <table class="data-table">
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
                                    <td><strong><?php echo $row['id_sekolah']; ?></strong></td>
                                    <td><?php echo $row['nama_sekolah']; ?></td>
                                    <td>
                                        <span class="address-text" title="<?php echo $row['alamat']; ?>">
                                            <?php echo substr($row['alamat'], 0, 40); ?>...
                                        </span>
                                    </td>
                                    <td><?php echo $row['kontak']; ?></td>
                                    <td>
                                        <?php if($_SESSION['role'] == 'Admin'): ?>
                                        <div class="action-buttons">
                                            <a href="sekolah_edit.php?id=<?php echo $row['id_sekolah']; ?>" class="btn-small btn-edit">Edit</a>
                                            <a href="../../process/sekolah/sekolah_delete_process.php?id=<?php echo $row['id_sekolah']; ?>" class="btn-small btn-delete" onclick="return confirm('Apakah Anda yakin ingin menghapus sekolah ini?')">Hapus</a>
                                        </div>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    <?php else : ?>
                        <div class="empty-state">
                            <p>Belum ada data sekolah. <a href="sekolah_add.php">Tambah Sekolah Baru</a></p>
                        </div>
                    <?php endif; ?>
                </div>
            </section>
        </main>
    </div>
</body>
</html>