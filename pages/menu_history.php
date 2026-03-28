<?php
include '../config/database.php';
date_default_timezone_set('Asia/Jakarta');
$hari_ini = date('Y-m-d');

// Get all schools for filter dropdown
$query_sekolah = "SELECT * FROM sekolah ORDER BY nama_sekolah ASC";
$result_sekolah = mysqli_query($conn, $query_sekolah);

// Get all menu history data (both today and past)
$query_menu = "SELECT m.*, g.energi, g.protein, s.nama_sekolah 
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
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Menu - MBG Report</title>
    <link rel="stylesheet" href="../assets/css/fe_index.css">
    <link rel="stylesheet" href="../assets/css/history_style.css">
</head>
<body>

<nav class="navbar">
    <a href="../index.php" class="nav-logo">MBG REPORT</a>
    <button class="navbar-toggle" id="navbar-toggle">
        <span></span>
        <span></span>
        <span></span>
    </button>
    <ul id="navbar-menu">
        <li><a href="../index.php#home">Beranda</a></li>
        <li><a href="../index.php#menu">Menu Hari Ini</a></li>
        <li><a href="menu_history.php" class="active">Riwayat Menu</a></li>
        <li><a href="sppg_list.php">Tim SPPG</a></li>
        <li><a href="../index.php#pengaduan">Lapor Aduan</a></li>
        <li><a href="complaint_list.php">Daftar Aduan</a></li>
        <li><a href="login_pages.php" class="btn-login">Login Petugas</a></li>
    </ul>
</nav>

<header class="page-header">
    <h1>Riwayat Menu Pilihan</h1>
    <p>Lihat semua menu yang telah disajikan di berbagai sekolah hingga hari ini</p>
</header>

<main class="container">
    <section class="history-section">
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

        <div class="menu-history-grid" id="menu-container">
            <?php if(count($menu_data) > 0) : ?>
                <?php foreach($menu_data as $row) : ?>
                    <div class="history-card" data-date="<?php echo $row['tanggal']; ?>" data-school="<?php echo $row['nama_sekolah']; ?>">
                        <div class="card-header">
                            <span class="date-badge"><?php echo date('d M Y', strtotime($row['tanggal'])); ?></span>
                            <span class="school-badge"><?php echo $row['nama_sekolah']; ?></span>
                        </div>
                        
                        <div class="card-image">
                            <img src="../assets/uploads/menu/<?php echo $row['foto_url']; ?>" alt="<?php echo $row['nama_menu']; ?>">
                        </div>
                        
                        <div class="card-content">
                            <h3><?php echo $row['nama_menu']; ?></h3>
                            
                            <div class="nutrition-info">
                                <div class="nutrition-item">
                                    <span class="label">Energi</span>
                                    <span class="value"><?php echo $row['energi'] ?? '0'; ?> kkal</span>
                                </div>
                                <div class="nutrition-item">
                                    <span class="label">Protein</span>
                                    <span class="value"><?php echo $row['protein'] ?? '0'; ?>g</span>
                                </div>
                            </div>
                            
                            <a href="menu/menu_detail.php?id=<?php echo $row['id_menu']; ?>" class="btn-detail">Lihat Detail</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else : ?>
                <div class="empty-state">
                    <p>Belum ada data riwayat menu hingga hari ini.</p>
                </div>
            <?php endif; ?>
        </div>

        <div id="no-results" class="empty-state" style="display: none; grid-column: 1/-1;">
            <p>Tidak ada menu yang sesuai dengan filter yang dipilih.</p>
        </div>
    </section>
</main>

<footer>
    <div class="footer-grid">
        <div class="footer-about">
            <h3>MBG Report</h3>
            <p>Platform monitoring gizi digital untuk transparansi dan peningkatan kualitas SDM Indonesia. Memastikan setiap siswa mendapatkan hak gizi yang layak.</p>
        </div>

        <div class="footer-contact">
            <h3>Hubungi Kami</h3>
            <ul class="contact-list">
                <li>📍 Jl. Merdeka Barat No. 9, Jakarta Pusat</li>
                <li>📞 (021) 500-MBG-RI</li>
                <li>📧 layanan@mbg.go.id</li>
            </ul>
            <div class="contact-buttons">
                <a href="https://wa.me/6281234567890" target="_blank" class="btn-footer btn-wa">
                    💬 Chat WhatsApp
                </a>
                <a href="mailto:layanan@mbg.go.id" class="btn-footer btn-email">
                    ✉️ Kirim Email
                </a>
            </div>
        </div>

        <div class="footer-map">
            <h3>Lokasi Kantor</h3>
            <div class="map-frame">
                <iframe 
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3966.666427009756!2d106.82496417499002!3d-6.175392393812061!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f5d2e764587d%3A0x7c14e38e4e975458!2sMonumen%20Nasional!5e0!3m2!1sid!2sid!4v1706500000000!5m2!1sid!2sid" 
                    width="100%" 
                    height="150" 
                    style="border:0;" 
                    allowfullscreen="" 
                    loading="lazy" 
                    referrerpolicy="no-referrer-when-downgrade">
                </iframe>
            </div>
            <a href="https://maps.google.com" target="_blank" class="map-link">Buka di Google Maps &rarr;</a>
        </div>

        <div class="footer-agencies">
            <h3>Didukung Oleh</h3>
            <div class="agency-logos">
                <p>• Badan Gizi Nasional</p>
                <p>• Kementerian Kesehatan</p>
                <p>• Kemendikbud Ristek</p>
                <p>• Satuan Pelayanan (SPPG)</p>
            </div>
        </div>
    </div>

    <div class="footer-bottom">
        <p>&copy; 2026 MBG Report App | Dikembangkan untuk Sertifikasi Kompetensi RPL</p>
    </div>
</footer>

<script>
    // Filter data tanpa reload
    const filterDate = document.getElementById('filter-date');
    const filterSchool = document.getElementById('filter-school');
    const resetBtn = document.getElementById('reset-filter');
    const menuContainer = document.getElementById('menu-container');
    const noResults = document.getElementById('no-results');
    const filteredCount = document.getElementById('filtered-count');
    const allCards = document.querySelectorAll('.history-card');

    function filterMenu() {
        const selectedDate = filterDate.value;
        const selectedSchool = filterSchool.value;
        let visibleCount = 0;

        allCards.forEach(card => {
            const cardDate = card.dataset.date;
            const cardSchool = card.dataset.school;

            // Check if card matches filters
            const matchDate = !selectedDate || cardDate === selectedDate;
            const matchSchool = !selectedSchool || cardSchool === selectedSchool;

            if (matchDate && matchSchool) {
                card.style.display = '';
                visibleCount++;
            } else {
                card.style.display = 'none';
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
<script src="../assets/js/navbar.js"></script>

</body>
</html>
