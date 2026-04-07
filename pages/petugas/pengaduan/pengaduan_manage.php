<?php
include '../../../includes/auth_check.php';
include '../../../config/database.php';
Login_Check();
Only_Allow(['Petugas Pengaduan', 'Admin']);

$query = "SELECT p.*, s.nama_sekolah FROM pengaduan p
          JOIN sekolah s ON p.id_sekolah = s.id_sekolah
          ORDER BY p.tanggal DESC";
$result = mysqli_query($conn, $query);

$nama = $_SESSION['nama'];
$role = $_SESSION['role'];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Pengaduan - MBG Report</title>
    <link rel="stylesheet" href="../../../assets/css/dashboard_style.css">
    <link rel="stylesheet" href="../../../assets/css/table_style.css">
    <link rel="stylesheet" href="../../../assets/css/pengaduan_style.css">
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
                        <li><a href="../menu/menu_manage.php" class="menu-item">Input Menu & Gizi</a></li>
                        <li><a href="../menu/menu_history.php" class="menu-item">Riwayat Menu</a></li>
                        <li><a href="pengaduan_manage.php" class="menu-item active">Pengaduan List</a></li>
                    <?php else: ?>
                        <li><a href="pengaduan_manage.php" class="menu-item active">Kelola Pengaduan</a></li>
                    <?php endif; ?>
                    
                    <li><a href="../../../auth/logout_process.php" class="menu-item logout" onclick="return confirm('Apakah Anda Yakin Ingin Keluar?')">Logout</a></li>
                </ul>
            </nav>
        </aside>

        <main class="main-content">
            <header class="dashboard-header">
                <div>
                    <h1>Manajemen Pengaduan Masyarakat</h1>
                    <p>Kelola dan tindak lanjuti laporan dari masyarakat</p>
                </div>
            </header>

            <section class="filter-section">
                <div class="filter-controls">
                    <div class="filter-group">
                        <label>Filter Status:</label>
                        <select id="filter-status" onchange="filterByStatus(this.value)">
                            <option value="">Semua Status</option>
                            <option value="Pending">Pending</option>
                            <option value="Diproses">Diproses</option>
                            <option value="Selesai">Selesai</option>
                        </select>
                    </div>
                </div>
            </section>

            <section class="table-section">
                <div class="table-wrapper">
                    <?php if(mysqli_num_rows($result) > 0) : ?>
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Pelapor</th>
                                    <th>Sekolah</th>
                                    <th>Kontak</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while($row = mysqli_fetch_assoc($result)) : ?>
                                <tr class="status-<?php echo strtolower($row['status']); ?>">
                                    <td><strong><?php echo date('d M Y', strtotime($row['tanggal'])); ?></strong></td>
                                    <td><?php echo $row['nama_pelapor']; ?></td>
                                    <td><?php echo $row['nama_sekolah']; ?></td>
                                    <td><?php echo $row['kontak']; ?></td>
                                    <td>
                                        <span class="status-badge status-<?php echo strtolower($row['status']); ?>">
                                            <?php echo $row['status']; ?>
                                        </span>
                                    </td>
                                    <td>
                                        <div class="action-buttons">
                                            <a href="pengaduan_detail.php?id=<?php echo $row['id_pengaduan']; ?>" class="btn-small btn-info">Detail</a>
                                            <?php if($_SESSION['role'] == 'Petugas Pengaduan'): ?>
                                                <a href="../../../process/pengaduan/pengaduan_delete_process.php?id=<?php echo $row['id_pengaduan']; ?>" class="btn-small btn-delete" onclick="return confirm('Apakah Anda yakin ingin menghapus pengaduan ini?')">Hapus</a>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    <?php else : ?>
                        <div class="empty-state">
                            <p>Belum ada data pengaduan.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </section>
        </main>
    </div>

    <script>
        function filterByStatus(status) {
            const rows = document.querySelectorAll('tbody tr');
            rows.forEach(row => {
                if (status === '' || row.classList.contains('status-' + status.toLowerCase())) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }
    </script>
</body>
</html>