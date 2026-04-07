<?php
include '../../../includes/auth_check.php';
include '../../../config/database.php';
Login_Check();
Only_Allow(['Petugas Gizi', 'Admin']);

date_default_timezone_set('Asia/Jakarta');
$hari_ini = date('Y-m-d');

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
                        <li><a href="../../sppg/sppg_manage.php" class="menu-item">Kelola Tim SPPG</a></li>
                        <li><a href="menu_manage.php" class="menu-item active">Input Menu & Gizi</a></li>
                        <li><a href="menu_history.php" class="menu-item">Riwayat Menu</a></li>
                        <li><a href="../../petugas/pengaduan/pengaduan_manage.php" class="menu-item">Pengaduan List</a></li>
                    <?php endif; ?>
                    <?php if($_SESSION['role'] == 'Petugas Gizi'): ?>
                        <li><a href="../../sekolah/sekolah_manage.php" class="menu-item">Input Sekolah</a></li>
                        <li><a href="menu_manage.php" class="menu-item active">Input Menu & Gizi</a></li>
                        <li><a href="menu_history.php" class="menu-item">Riwayat Menu</a></li>
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
                    <?php if($_SESSION['role'] == 'Petugas Gizi'): ?>
                        <a href="menu_add.php" class="btn-primary">Tambah Menu Baru</a>
                    <?php endif; ?>
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
                                            <img src="../../../assets/uploads/menu/<?php echo $row['foto_url']; ?>" alt="Foto" style="width: 50px; height: 50px; object-fit: cover; border-radius: 5px; cursor: pointer;" onclick="openMenuDetail(<?php echo $row['id_menu']; ?>)">
                                        <?php else: ?>
                                            <span class="text-muted">-</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <div class="action-buttons">
                                            <a href="javascript:void(0)" class="btn-small btn-info" onclick="openMenuDetail(<?php echo $row['id_menu']; ?>)">Detail</a>
                                            <?php if($_SESSION['role'] == 'Petugas Gizi'): ?>
                                                <a href="menu_edit.php?id=<?php echo $row['id_menu']; ?>" class="btn-small btn-edit">Edit</a>
                                                <a href="../../../process/menu/menu_delete_process.php?id=<?php echo $row['id_menu']; ?>" class="btn-small btn-delete" onclick="return confirm('Apakah Anda yakin ingin menghapus menu ini?')">Hapus</a>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    <?php else : ?>
                        <div class="empty-state">
                            <?php if($_SESSION['role'] == 'Petugas Gizi'): ?>
                                <p>Belum ada data menu. <a href="menu_add.php">Tambah Menu Baru</a></p>
                            <?php else: ?>
                                <p>Belum ada data menu.</p>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </section>
        </main>
    </div>

    <!-- Menu Detail Modal -->
    <div id="menuModal" class="modal">
        <div class="modal-content-menu">
            <span class="modal-close" onclick="closeMenuDetail()">&times;</span>
            <div class="menu-detail-container">
                <div class="menu-detail-image">
                    <img id="menuDetailImage" src="" alt="Menu">
                </div>
                <div class="menu-detail-info">
                    <h2 id="menuDetailName"></h2>
                    <p class="menu-detail-meta">
                        <span id="menuDetailDate"></span> • <span id="menuDetailSchool"></span>
                    </p>
                    
                    <div class="nutrition-section">
                        <h3>Informasi Gizi</h3>
                        <div class="nutrition-grid">
                            <div class="nutrition-card">
                                <span class="nutrition-label">Kalori</span>
                                <span class="nutrition-value" id="menuDetailKalori">-</span>
                                <span class="nutrition-unit">kkal</span>
                            </div>
                            <div class="nutrition-card">
                                <span class="nutrition-label">Energi</span>
                                <span class="nutrition-value" id="menuDetailEnergi">-</span>
                                <span class="nutrition-unit">kkal</span>
                            </div>
                            <div class="nutrition-card">
                                <span class="nutrition-label">Protein</span>
                                <span class="nutrition-value" id="menuDetailProtein">-</span>
                                <span class="nutrition-unit">g</span>
                            </div>
                            <div class="nutrition-card">
                                <span class="nutrition-label">Karbohidrat</span>
                                <span class="nutrition-value" id="menuDetailKarbohidrat">-</span>
                                <span class="nutrition-unit">g</span>
                            </div>
                            <div class="nutrition-card">
                                <span class="nutrition-label">Lemak</span>
                                <span class="nutrition-value" id="menuDetailLemak">-</span>
                                <span class="nutrition-unit">g</span>
                            </div>
                            <div class="nutrition-card">
                                <span class="nutrition-label">Serat</span>
                                <span class="nutrition-value" id="menuDetailSerat">-</span>
                                <span class="nutrition-unit">g</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="../../../assets/js/menu-detail-modal.js"></script>
</body>
</html>