<?php
include '../../includes/auth_check.php';
include '../../config/database.php';
Login_Check();
Only_Allow(['Admin']);

$query = "SELECT t.*, s.nama_sekolah FROM sppg t
          JOIN sekolah s ON t.id_sekolah = s.id_sekolah
          ORDER BY s.nama_sekolah ASC, t.nama_tim ASC";
$result = mysqli_query($conn, $query);

$nama = $_SESSION['nama'];
$role = $_SESSION['role'];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Tim SPPG - MBG Report</title>
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
                        <li><a href="../sekolah/sekolah_manage.php" class="menu-item">Kelola Sekolah</a></li>
                        <li><a href="sppg_manage.php" class="menu-item active">Kelola Tim SPPG</a></li>
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
                    <h1>Manajemen Tim SPPG</h1>
                    <p>Kelola data tim Satuan Pelayanan Pangan Gizi di setiap sekolah</p>
                </div>
                <div class="header-actions">
                    <a href="sppg_add.php" class="btn-primary">Tambah Tim SPPG</a>
                </div>
            </header>

            <section class="table-section">
                <div class="table-wrapper">
                    <?php if(mysqli_num_rows($result) > 0) : ?>
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Foto</th>
                                    <th>Nama Tim</th>
                                    <th>Jabatan</th>
                                    <th>Ketua Tim</th>
                                    <th>Anggota Tim</th>
                                    <th>Kontak</th>
                                    <th>Sekolah</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while($row = mysqli_fetch_assoc($result)) : ?>
                                <tr>
                                    <td>
                                        <div class="foto-wrapper">
                                            <?php if(!empty($row['foto_tim'])): ?>
                                                <img src="../../assets/uploads/sppg/<?php echo $row['foto_tim']; ?>" alt="<?php echo $row['nama_tim']; ?>" class="team-thumbnail" onclick="openModal('../../assets/uploads/sppg/<?php echo $row['foto_tim']; ?>', '<?php echo addslashes($row['nama_tim']); ?>')">
                                            <?php else: ?>
                                                <div class="team-thumbnail-placeholder">
                                                    <span>-</span>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                    <td><strong><?php echo $row['nama_tim']; ?></strong></td>
                                    <td>
                                        <span class="role-badge-table">
                                            <?php echo $row['jabatan']; ?>
                                        </span>
                                    </td>
                                    <td>
                                        <?php 
                                        if (!empty($row['ketua_tim'])) {
                                            $query_ketua = "SELECT nama FROM users WHERE uid = '" . mysqli_real_escape_string($conn, $row['ketua_tim']) . "'";
                                            $result_ketua = mysqli_query($conn, $query_ketua);
                                            $ketua_data = mysqli_fetch_assoc($result_ketua);
                                            if ($ketua_data) {
                                                echo '<span class="ketua-badge">' . $ketua_data['nama'] . '<br><small>(' . $row['ketua_tim'] . ')</small></span>';
                                            } else {
                                                echo '<span class="text-muted">-</span>';
                                            }
                                        } else {
                                            echo '<span class="text-muted">-</span>';
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <div class="anggota-list">
                                            <?php 
                                            if (!empty($row['anggota_tim'])) {
                                                $uids = explode(',', $row['anggota_tim']);
                                                foreach ($uids as $uid) {
                                                    $uid_clean = trim($uid);
                                                    $query_user = "SELECT nama, role FROM users WHERE uid = '$uid_clean'";
                                                    $result_user = mysqli_query($conn, $query_user);
                                                    $user_data = mysqli_fetch_assoc($result_user);
                                                    if ($user_data) {
                                                        echo '<span class="anggota-badge">' . $user_data['nama'] . '<br><small>(' . $user_data['role'] . ')</small></span>';
                                                    }
                                                }
                                            } else {
                                                echo '<span class="text-muted">-</span>';
                                            }
                                            ?>
                                        </div>
                                    </td>
                                    <td><?php echo $row['kontak_tim'] ?? '-'; ?></td>
                                    <td><?php echo $row['nama_sekolah']; ?></td>
                                    <td>
                                        <div class="action-buttons">
                                            <a href="sppg_edit.php?id=<?php echo $row['id_sppg']; ?>" class="btn-small btn-edit">Edit</a>
                                            <a href="../../process/sppg/sppg_delete_process.php?id=<?php echo $row['id_sppg']; ?>" class="btn-small btn-delete" onclick="return confirm('Apakah Anda yakin ingin menghapus tim ini?')">Hapus</a>
                                        </div>
                                    </td>
                                </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    <?php else : ?>
                        <div class="empty-state">
                            <p>Belum ada data tim SPPG. <a href="sppg_add.php">Tambah Tim SPPG</a></p>
                        </div>
                    <?php endif; ?>
                </div>
            </section>
        </main>
    </div>

    <!-- Image Modal -->
    <div id="imageModal" class="modal">
        <span class="modal-close" onclick="closeModal()">&times;</span>
        <img class="modal-content" id="modalImage">
        <div id="caption"></div>
    </div>

    <script src="../../assets/js/modal.js"></script>
</body>
</html>
