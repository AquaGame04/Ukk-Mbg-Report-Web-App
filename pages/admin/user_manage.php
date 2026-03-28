<?php
include '../../includes/auth_check.php';
include '../../config/database.php';

Login_Check();
Only_Allow(['Admin']);

$query = "SELECT users.*, sekolah.nama_sekolah FROM users 
         LEFT JOIN sekolah ON users.id_sekolah = sekolah.id_sekolah
         ORDER BY users.uid DESC";
$result = mysqli_query($conn, $query);

$nama = $_SESSION['nama'];
$role = $_SESSION['role'];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola User - MBG Report</title>
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
                        <li><a href="user_manage.php" class="menu-item active">Kelola User</a></li>
                        <li><a href="../sekolah/sekolah_manage.php" class="menu-item">Kelola Sekolah</a></li>
                        <li><a href="../sppg/sppg_manage.php" class="menu-item">Kelola Tim SPPG</a></li>
                        <li><a href="../petugas/menu/menu_manage.php" class="menu-item">Input Menu & Gizi</a></li>
                        <li><a href="../petugas/menu/menu_history.php" class="menu-item">Riwayat Menu</a></li>
                        <li><a href="../petugas/pengaduan/pengaduan_manage.php" class="menu-item">Pengaduan List</a></li>
                    <?php endif; ?>
                    
                    <li><a href="../../auth/logout_process.php" class="menu-item logout" onclick="return confirm('Apakah Anda Yakin Ingin Keluar?')">Logout</a></li>
                </ul>
            </nav>
        </aside>

        <main class="main-content">
            <header class="dashboard-header">
                <div>
                    <h1>Manajemen User</h1>
                    <p>Kelola semua pengguna sistem MBG Report</p>
                </div>
                <div class="header-actions">
                    <a href="user_add.php" class="btn-primary">Tambah User Baru</a>
                </div>
            </header>

            <section class="table-section">
                <div class="table-wrapper">
                    <?php if(mysqli_num_rows($result) > 0) : ?>
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>UID</th>
                                    <th>Nama Lengkap</th>
                                    <th>Role</th>
                                    <th>Sekolah</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while($row = mysqli_fetch_assoc($result)) : ?>
                                <tr>
                                    <td><strong><?php echo $row['uid']; ?></strong></td>
                                    <td><?php echo $row['nama']; ?></td>
                                    <td>
                                        <span class="role-badge-table <?php echo strtolower(str_replace(' ', '-', $row['role'])); ?>">
                                            <?php echo $row['role']; ?>
                                        </span>
                                    </td>
                                    <td><?php echo $row['nama_sekolah'] ?? '<span class="text-muted">-</span>'; ?></td>
                                    <td>
                                        <div class="action-buttons">
                                            <a href="user_edit.php?uid=<?php echo $row['uid']; ?>" class="btn-small btn-edit">Edit</a>
                                            <a href="../../process/users/user_delete_process.php?uid=<?php echo $row['uid']; ?>" class="btn-small btn-delete" onclick="return confirm('Apakah Anda yakin ingin menghapus user ini?')">Hapus</a>
                                        </div>
                                    </td>
                                </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    <?php else : ?>
                        <div class="empty-state">
                            <p>Belum ada user terdaftar. <a href="user_add.php">Tambah User Baru</a></p>
                        </div>
                    <?php endif; ?>
                </div>
            </section>
        </main>
    </div>
</body>
</html>