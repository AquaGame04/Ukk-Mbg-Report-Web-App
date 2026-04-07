<?php
// session_start();

// if(!isset($_SESSION['login'])) {
//     header("Location: ../pages/login_pages.php");
//     exit;
// }

include '../includes/auth_check.php';
Login_Check();
include '../config/database.php';

$nama = $_SESSION['nama'];
$role = $_SESSION['role'];

// Get total users count
$query_total_users = "SELECT COUNT(*) as total FROM users";
$result_total_users = mysqli_query($conn, $query_total_users);
$data_total_users = mysqli_fetch_assoc($result_total_users);
$total_users = $data_total_users['total'];

// Get total pengaduan count
$query_total_pengaduan = "SELECT COUNT(*) as total FROM pengaduan";
$result_total_pengaduan = mysqli_query($conn, $query_total_pengaduan);
$data_total_pengaduan = mysqli_fetch_assoc($result_total_pengaduan);
$total_pengaduan = $data_total_pengaduan['total'];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - MBG Report</title>
    <link rel="stylesheet" href="../assets/css/dashboard_style.css">
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
                    <li><a href="dashboard.php" class="menu-item active">Home</a></li>
                    
                    <?php if($_SESSION['role'] == 'Admin'): ?>
                        <li><a href="admin/user_manage.php" class="menu-item">Kelola User</a></li>
                        <li><a href="sekolah/sekolah_manage.php" class="menu-item">Kelola Sekolah</a></li>
                        <li><a href="sppg/sppg_manage.php" class="menu-item">Kelola Tim SPPG</a></li>
                        <li><a href="petugas/menu/menu_manage.php" class="menu-item">Input Menu & Gizi</a></li>
                        <li><a href="petugas/menu/menu_history.php" class="menu-item">Riwayat Menu</a></li>
                        <li><a href="petugas/pengaduan/pengaduan_manage.php" class="menu-item">Pengaduan List</a></li>
                    <?php endif; ?>

                    <?php if($_SESSION['role'] == 'Petugas Gizi'): ?>
                        <li><a href="sekolah/sekolah_manage.php" class="menu-item">Input Sekolah</a></li>
                        <li><a href="petugas/menu/menu_manage.php" class="menu-item">Input Menu & Gizi</a></li>
                        <li><a href="petugas/menu/menu_history.php" class="menu-item">Riwayat Menu</a></li>
                    <?php endif; ?>

                    <?php if($_SESSION['role'] == 'Petugas Pengaduan'): ?>
                        <li><a href="petugas/pengaduan/pengaduan_manage.php" class="menu-item">Kelola Pengaduan</a></li>
                    <?php endif; ?>
                    
                    <li><a href="../auth/logout_process.php" class="menu-item logout" onclick="return confirm('Apakah Anda Yakin Ingin Keluar?')">Logout</a></li>
                </ul>
            </nav>
        </aside>

        <main class="main-content">
            <header class="dashboard-header">
                <div>
                    <h1>Dashboard <?php echo $role; ?></h1>
                    <p>Selamat datang kembali, <strong><?php echo $nama; ?></strong>. Apa yang ingin Anda lakukan hari ini?</p>
                </div>
                <div class="header-time">
                    <p id="current-time"></p>
                </div>
            </header>

            <section class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon" style="background: #27ae60;">D</div>
                    <div class="stat-content">
                        <h3>Status Sistem</h3>
                        <p class="stat-value">Aktif</p>
                        <p class="stat-subtitle">Database Terhubung</p>
                    </div>
                </div>

                <?php if($role == 'Admin'): ?>
                    <div class="stat-card">
                        <div class="stat-icon" style="background: #f39c12;">U</div>
                        <div class="stat-content">
                            <h3>Total User</h3>
                            <p class="stat-value"><?php echo $total_users; ?></p>
                            <p class="stat-subtitle">Pengguna Terdaftar</p>
                        </div>
                    </div>
                    
                    <div class="stat-card">
                        <div class="stat-icon" style="background: #e74c3c;">R</div>
                        <div class="stat-content">
                            <h3>Total Pengaduan</h3>
                            <p class="stat-value"><?php echo $total_pengaduan; ?></p>
                            <p class="stat-subtitle">Laporan Masuk</p>
                        </div>
                    </div>
                <?php endif; ?>
            </section>

            <section class="info-section">
                <div class="info-card welcome-card">
                    <h2>Selamat Datang di MBG Report</h2>
                    <p>Platform monitoring Program Makan Bergizi Gratis dengan transparansi penuh dan sistem pelaporan yang terintegrasi.</p>
                    <a href="../index.php" class="btn-secondary">Kembali ke Beranda</a>
                </div>
            </section>
        </main>
    </div>

    <script>
        // Reset modals and body overflow on page load
        window.addEventListener('DOMContentLoaded', function() {
            // Reset body overflow
            document.body.style.overflow = 'auto';
            
            // Close any open modals
            const allModals = document.querySelectorAll('.modal, [id*="Modal"]');
            allModals.forEach(modal => {
                modal.style.display = 'none';
            });
        });

        // Update waktu real-time
        function updateTime() {
            const now = new Date();
            document.getElementById('current-time').textContent = now.toLocaleString('id-ID', {
                weekday: 'long',
                year: 'numeric',
                month: 'long',
                day: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            });
        }
        updateTime();
        setInterval(updateTime, 1000);
    </script>
</body>
</html>