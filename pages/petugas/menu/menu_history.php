<?php
include '../../../includes/auth_check.php';
include '../../../config/database.php';
Login_Check();
Only_Allow(['Petugas Gizi', 'Admin']);

date_default_timezone_set('Asia/Jakarta');
$hari_ini = date('Y-m-d');

// Get all schools for filter dropdown
$query_sekolah = "SELECT * FROM sekolah ORDER BY nama_sekolah ASC";
$result_sekolah = mysqli_query($conn, $query_sekolah);

// Get all menu history data with gizi info - include today's menu
$query_menu = "SELECT m.*, g.energi, g.protein, g.kalori, g.karbohidrat, g.lemak, g.serat, s.nama_sekolah 
               FROM menu_harian m
               LEFT JOIN gizi_menu g ON m.id_menu = g.id_menu
               JOIN sekolah s ON m.id_sekolah = s.id_sekolah
               WHERE m.tanggal <= '$hari_ini'
               ORDER BY m.tanggal DESC";
$result_menu = mysqli_query($conn, $query_menu);

// Fetch all data into array
$menu_data = [];
while($row = mysqli_fetch_assoc($result_menu)) {
    $menu_data[] = $row;
}

$nama = $_SESSION['nama'];
$role = $_SESSION['role'];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Menu - MBG Report</title>
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
                        <li><a href="menu_manage.php" class="menu-item">Input Menu & Gizi</a></li>
                        <li><a href="menu_history.php" class="menu-item">Riwayat Menu</a></li>
                        <li><a href="../../petugas/pengaduan/pengaduan_manage.php" class="menu-item">Pengaduan List</a></li>
                    <?php endif; ?>
                    <?php if($_SESSION['role'] == 'Petugas Gizi'): ?>
                        <li><a href="../../sekolah/sekolah_manage.php" class="menu-item">Input Sekolah</a></li>
                        <li><a href="menu_manage.php" class="menu-item">Input Menu & Gizi</a></li>
                        <li><a href="menu_history.php" class="menu-item active">Riwayat Menu</a></li>
                    <?php endif; ?>
                    
                    <li><a href="../../../auth/logout_process.php" class="menu-item logout" onclick="return confirm('Apakah Anda Yakin Ingin Keluar?')">Logout</a></li>
                </ul>
            </nav>
        </aside>

        <main class="main-content">
            <header class="dashboard-header">
                <div>
                    <h1>Riwayat Menu Pilihan</h1>
                    <p>Lihat semua menu yang telah disajikan hingga hari ini dan data gizi lengkapnya</p>
                </div>
                <div class="header-actions">
                    <?php if($_SESSION['role'] == 'Petugas Gizi'): ?>
                    <a href="menu_manage.php" class="btn-primary">Input Menu Baru</a>
                    <?php endif; ?>
                </div>
            </header>

            <section class="table-section">
                <div class="filter-wrapper">
                    <h2>Filter Riwayat Menu</h2>
                    
                    <div class="filter-controls">
                        <div class="filter-group">
                            <label for="filter-date">Tanggal</label>
                            <input type="date" id="filter-date" value="<?php echo $hari_ini; ?>">
                        </div>
                        
                        <div class="filter-group">
                            <label for="filter-school">Sekolah</label>
                            <select id="filter-school">
                                <option value="">-- Semua Sekolah --</option>
                                <?php 
                                mysqli_data_seek($result_sekolah, 0);
                                while($s = mysqli_fetch_assoc($result_sekolah)) : 
                                ?>
                                    <option value="<?php echo $s['nama_sekolah']; ?>">
                                        <?php echo $s['nama_sekolah']; ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        
                        <button id="reset-filter" class="btn-reset">Reset Filter</button>
                    </div>
                </div>

                <div class="menu-stats">
                    <div class="stat-badge">
                        Total Menu: <strong id="total-count"><?php echo count($menu_data); ?></strong>
                    </div>
                    <div class="stat-badge">
                        Hasil Filter: <strong id="filtered-count"><?php echo count($menu_data); ?></strong>
                    </div>
                </div>

                <div class="table-wrapper">
                    <?php if(count($menu_data) > 0) : ?>
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Nama Menu</th>
                                    <th>Sekolah</th>
                                    <th>Foto</th>
                                    <th>Kalori</th>
                                    <th>Protein</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="menu-table-body">
                                <?php foreach($menu_data as $row) : ?>
                                <tr class="history-row" data-date="<?php echo $row['tanggal']; ?>" data-school="<?php echo $row['nama_sekolah']; ?>">
                                    <td><strong><?php echo date('d M Y', strtotime($row['tanggal'])); ?></strong></td>
                                    <td><?php echo $row['nama_menu']; ?></td>
                                    <td><?php echo $row['nama_sekolah']; ?></td>
                                    <td>
                                        <?php if(!empty($row['foto_url'])): ?>
                                            <img src="../../../assets/uploads/menu/<?php echo $row['foto_url']; ?>" alt="Foto" style="width: 45px; height: 45px; object-fit: cover; border-radius: 5px; cursor: pointer;" onclick="openMenuDetail(<?php echo $row['id_menu']; ?>)">
                                        <?php else: ?>
                                            <span class="text-muted">-</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo $row['kalori'] ?? '-'; ?> kkal</td>
                                    <td><?php echo $row['protein'] ?? '-'; ?>g</td>
                                    <td>
                                        <div class="action-buttons">
                                            <a href="javascript:void(0)" class="btn-small btn-info" onclick="openMenuDetail(<?php echo $row['id_menu']; ?>)">Detail</a>
                                            <?php if($_SESSION['role'] == 'Petugas Gizi'): ?>
                                            <a href="menu_edit.php?id=<?php echo $row['id_menu']; ?>" class="btn-small btn-edit">Edit</a>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php else : ?>
                        <div class="empty-state">
                            <p>Belum ada data riwayat menu. <a href="menu_manage.php">Input Menu Baru</a></p>
                        </div>
                    <?php endif; ?>
                </div>

                <div id="no-results" class="empty-state" style="display: none;">
                    <p>Tidak ada menu yang sesuai dengan filter yang dipilih.</p>
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

        // Filter data tanpa reload
        const filterDate = document.getElementById('filter-date');
        const filterSchool = document.getElementById('filter-school');
        const resetBtn = document.getElementById('reset-filter');
        const noResults = document.getElementById('no-results');
        const filteredCount = document.getElementById('filtered-count');
        const allRows = document.querySelectorAll('.history-row');

        function filterMenu() {
            const selectedDate = filterDate.value;
            const selectedSchool = filterSchool.value;
            let visibleCount = 0;

            allRows.forEach(row => {
                const rowDate = row.dataset.date;
                const rowSchool = row.dataset.school;

                // Check if row matches filters
                const matchDate = !selectedDate || rowDate === selectedDate;
                const matchSchool = !selectedSchool || rowSchool === selectedSchool;

                if (matchDate && matchSchool) {
                    row.style.display = '';
                    visibleCount++;
                } else {
                    row.style.display = 'none';
                }
            });

            // Show/hide no results message
            if (visibleCount === 0) {
                noResults.style.display = 'block';
            } else {
                noResults.style.display = 'none';
            }

            // Update filtered count
            filteredCount.textContent = visibleCount;
        }

        function resetFilter() {
            filterDate.value = '<?php echo $hari_ini; ?>';
            filterSchool.value = '';
            filterMenu();
        }

        // Event listeners
        filterDate.addEventListener('change', filterMenu);
        filterSchool.addEventListener('change', filterMenu);
        resetBtn.addEventListener('click', resetFilter);
        
        // Auto-filter on page load to show today's menu
        window.addEventListener('load', filterMenu);
    </script>
</body>
</html>
