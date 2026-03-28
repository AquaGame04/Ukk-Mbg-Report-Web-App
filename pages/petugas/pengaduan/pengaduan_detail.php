<?php
include '../../../includes/auth_check.php';
include '../../../config/database.php';
Login_Check();
Only_Allow(['Petugas Pengaduan', 'Admin']);

$id = mysqli_real_escape_string($conn, $_GET['id']);
$query = "SELECT p.*, s.nama_sekolah 
          FROM pengaduan p
          JOIN sekolah s ON p.id_sekolah = s.id_sekolah
          WHERE p.id_pengaduan = '$id'";
$result = mysqli_query($conn, $query);
$data = mysqli_fetch_assoc($result);

if (!$data) {
    header("Location: pengaduan_manage.php");
    exit;
}

$nama = $_SESSION['nama'];
$role = $_SESSION['role'];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pengaduan - MBG Report</title>
    <link rel="stylesheet" href="../../../assets/css/dashboard_style.css">
    <link rel="stylesheet" href="../../../assets/css/pengaduan_detail_style.css">
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
                        <li><a href="pengaduan_manage.php" class="menu-item active">Pengaduan List</a></li>
                    <?php else: ?>
                        <li><a href="pengaduan_manage.php" class="menu-item active">Kelola Pengaduan</a></li>
                    <?php endif; ?>
                    
                    <li><a href="../../../auth/logout_process.php" class="menu-item logout" onclick="return confirm('Apakah Anda Yakin Ingin Keluar?')">Logout</a></li>
                </ul>
            </nav>
        </aside>

        <main class="main-content">
            <a href="pengaduan_manage.php" class="breadcrumb-back">← Kembali ke Daftar Pengaduan</a>

            <div class="detail-container">
                <!-- Complaint Info Section -->
                <section class="info-section">
                    <h1>Detail Pengaduan #<?php echo $data['id_pengaduan']; ?></h1>
                    
                    <div class="info-grid">
                        <div class="info-card">
                            <h3>Informasi Pelapor</h3>
                            <div class="info-item">
                                <span class="info-label">Nama Pelapor</span>
                                <span class="info-value"><?php echo $data['nama_pelapor']; ?></span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Kontak</span>
                                <span class="info-value"><?php echo $data['kontak']; ?></span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Sekolah Terkait</span>
                                <span class="info-value"><?php echo $data['nama_sekolah']; ?></span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Tanggal Pengaduan</span>
                                <span class="info-value"><?php echo date('d F Y H:i', strtotime($data['tanggal'])); ?></span>
                            </div>
                        </div>

                        <div class="info-card">
                            <h3>Status Pengaduan</h3>
                            <div class="status-display">
                                <span class="status-badge status-<?php echo strtolower($data['status']); ?> large">
                                    <?php echo $data['status']; ?>
                                </span>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Complaint Content -->
                <section class="content-section">
                    <h2>Isi Pengaduan</h2>
                    <div class="complaint-text">
                        <?php echo nl2br(htmlspecialchars($data['isi_pengaduan'])); ?>
                    </div>

                    <?php if(!empty($data['foto_bukti'])): ?>
                        <div class="evidence-section">
                            <h2>Bukti Foto</h2>
                            <div class="evidence-image">
                                <img src="../../../assets/uploads/pengaduan/<?php echo $data['foto_bukti']; ?>" alt="Bukti Foto">
                            </div>
                        </div>
                    <?php endif; ?>
                </section>

                <!-- Follow-up Form -->
                <section class="followup-section">
                    <h2>Tindak Lanjut Petugas</h2>
                    <?php if($_SESSION['role'] == 'Petugas Pengaduan'): ?>
                        <form action="../../../process/pengaduan/pengaduan_update_status_process.php" method="POST" class="followup-form">
                            <input type="hidden" name="id_pengaduan" value="<?php echo $data['id_pengaduan']; ?>">

                            <div class="form-group">
                                <label for="status">Status Pengaduan</label>
                                <select id="status" name="status" required>
                                    <option value="Pending" <?php if($data['status'] == 'Pending') echo 'selected'; ?>>Pending (Menunggu Proses)</option>
                                    <option value="Diproses" <?php if($data['status'] == 'Diproses') echo 'selected'; ?>>Diproses (Sedang Ditangani)</option>
                                    <option value="Selesai" <?php if($data['status'] == 'Selesai') echo 'selected'; ?>>Selesai (Tindakan Selesai)</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="catatan_petugas">Catatan / Respon Petugas</label>
                                <textarea id="catatan_petugas" name="catatan_petugas" rows="6" placeholder="Tuliskan tindakan yang sudah dilakukan atau jawaban untuk pelapor..."><?php echo htmlspecialchars($data['catatan_petugas'] ?? ''); ?></textarea>
                                <small>Catatan ini akan membantu tracking progres pengaduan</small>
                            </div>

                            <div class="form-actions">
                                <button type="submit" name="update" class="btn-primary">Simpan Perubahan</button>
                                <a href="pengaduan_manage.php" class="btn-secondary">Batal</a>
                            </div>
                        </form>
                    <?php else: ?>
                        <div class="info-note">
                            <p><strong>Catatan:</strong> Hanya <em>Petugas Pengaduan</em> yang dapat mengubah status dan menambahkan catatan tindak lanjut.</p>
                            <div class="form-group">
                                <label><b>Status Pengaduan:</b></label>
                                <div class="readonly-field"><?php echo $data['status']; ?></div>
                            </div>
                            <div class="form-group">
                                <label><b>Catatan Petugas:</b></label>
                                <div class="readonly-field"><?php echo nl2br(htmlspecialchars($data['catatan_petugas'] ?? '-')); ?></div>
                            </div>
                        </div>
                    <?php endif; ?>
                </section>
            </div>
        </main>
    </div>
</body>
</html>