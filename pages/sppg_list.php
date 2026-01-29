<?php
include '../config/database.php';
date_default_timezone_set('Asia/Jakarta');

// Get all SPPG teams with their school information
$query_sppg = "SELECT t.*, s.nama_sekolah, s.alamat, s.kontak 
               FROM sppg t 
               JOIN sekolah s ON t.id_sekolah = s.id_sekolah
               ORDER BY s.nama_sekolah ASC, t.nama_tim ASC";
$result_sppg = mysqli_query($conn, $query_sppg);

// Get list of schools for filter
$query_sekolah = "SELECT DISTINCT s.id_sekolah, s.nama_sekolah 
                  FROM sppg t
                  JOIN sekolah s ON t.id_sekolah = s.id_sekolah
                  ORDER BY s.nama_sekolah ASC";
$result_sekolah = mysqli_query($conn, $query_sekolah);

// Fetch all SPPG data
$sppg_data = [];
while($row = mysqli_fetch_assoc($result_sppg)) {
    $sppg_data[] = $row;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Tim SPPG - MBG Report</title>
    <link rel="stylesheet" href="../assets/css/fe_index.css">
    <link rel="stylesheet" href="../assets/css/sppg_list_style.css">
</head>
<body>

<nav class="navbar">
    <a href="../index.php" class="nav-logo">MBG REPORT</a>
    <ul>
        <li><a href="../index.php#home">Beranda</a></li>
        <li><a href="../index.php#menu">Menu Hari Ini</a></li>
        <li><a href="menu_history.php">Riwayat Menu</a></li>
        <li><a href="sppg_list.php" class="active">Tim SPPG</a></li>
        <li><a href="../index.php#pengaduan">Lapor Aduan</a></li>
        <li><a href="pages/complaint_list.php">Daftar Aduan</a></li>
        <li><a href="login_pages.php" class="btn-login">Login Petugas</a></li>
    </ul>
</nav>

<header class="page-header">
    <h1>Tim Satuan Pelayanan SPPG</h1>
    <p>Berkenalan dengan tim profesional yang menjamin kualitas makan bergizi di sekolah Anda</p>
</header>

<main class="container">
    <section class="sppg-section">
        <div class="filter-wrapper">
            <h2>Filter Tim SPPG</h2>
            
            <div class="filter-controls">
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

        <div class="sppg-stats">
            <div class="stat-badge">
                Total Tim: <strong id="total-count"><?php echo count($sppg_data); ?></strong>
            </div>
            <div class="stat-badge">
                Hasil Filter: <strong id="filtered-count"><?php echo count($sppg_data); ?></strong>
            </div>
        </div>

        <div class="sppg-list-container" id="sppg-container">
            <?php if(count($sppg_data) > 0) : ?>
                <?php foreach($sppg_data as $team) : ?>
                    <div class="sppg-team-card" data-school="<?php echo $team['nama_sekolah']; ?>">
                        <div class="team-header">
                            <div class="school-info">
                                <h3 class="school-name"><?php echo $team['nama_sekolah']; ?></h3>
                                <p class="school-address"><?php echo substr($team['alamat'], 0, 50); ?>...</p>
                            </div>
                            <div class="school-contact">
                                <span class="contact-info"><?php echo $team['kontak']; ?></span>
                            </div>
                        </div>

                        <div class="team-content">
                            <div class="team-photo-section">
                                <?php if(!empty($team['foto_tim'])): ?>
                                    <img src="../assets/uploads/sppg/<?php echo $team['foto_tim']; ?>" alt="<?php echo $team['nama_tim']; ?>" class="team-photo">
                                <?php else: ?>
                                    <div class="team-photo-placeholder">
                                        <span>Foto Tidak Tersedia</span>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <div class="team-info">
                                <h4 class="team-name"><?php echo $team['nama_tim']; ?></h4>
                                <p class="team-position">
                                    <span class="position-badge"><?php echo $team['jabatan']; ?></span>
                                </p>
                                
                                <?php if(!empty($team['kontak'])): ?>
                                    <div class="team-detail">
                                        <strong>Kontak:</strong> <?php echo $team['kontak']; ?>
                                    </div>
                                <?php endif; ?>

                                <div class="team-description">
                                    <p><?php echo !empty($team['deskripsi']) ? $team['deskripsi'] : 'Tim profesional yang berdedikasi untuk menjamin kualitas makan bergizi.'; ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else : ?>
                <div class="empty-state">
                    <p>Belum ada data tim SPPG.</p>
                </div>
            <?php endif; ?>
        </div>

        <div id="no-results" class="empty-state" style="display: none; grid-column: 1/-1;">
            <p>Tidak ada tim yang sesuai dengan filter yang dipilih.</p>
        </div>
    </section>

    <section class="info-section">
        <div class="info-box">
            <h2>Tentang Tim SPPG</h2>
            <p>Satuan Pelayanan Pangan Gizi (SPPG) adalah tim profesional yang bertanggung jawab atas kelancaran dan kualitas program makan bergizi di sekolah-sekolah. Tim ini terdiri dari:</p>
            <ul class="info-list">
                <li><strong>Koordinator SPPG:</strong> Mengelola seluruh aspek operasional program</li>
                <li><strong>Petugas Gizi:</strong> Memastikan kualitas dan kandungan gizi setiap menu</li>
                <li><strong>Petugas Dapur:</strong> Menjalankan proses masak-memasak dengan standar kebersihan tinggi</li>
                <li><strong>Petugas Distribusi:</strong> Memastikan makanan sampai ke tangan siswa dengan aman</li>
            </ul>
            <p>Anda dapat menghubungi tim SPPG di sekolah Anda untuk konsultasi atau pengaduan terkait program makan bergizi.</p>
        </div>
    </section>
</main>

<footer>
    <div class="footer-grid">
        <div class="footer-about">
            <h3>MBG Report</h3>
            <p>Platform monitoring gizi digital untuk transparansi dan peningkatan kualitas SDM Indonesia.</p>
        </div>
        <div class="footer-agencies">
            <h3>Didukung Oleh</h3>
            <div class="agency-logos">
                <p>• Badan Gizi Nasional</p>
                <p>• Kementerian Kesehatan</p>
                <p>• Kemendikbud Ristek</p>
            </div>
        </div>
    </div>
    <div class="footer-bottom">
        <p>&copy; 2026 MBG Report App | Sertifikasi Kompetensi RPL</p>
    </div>
</footer>

<script>
    const filterSchool = document.getElementById('filter-school');
    const resetBtn = document.getElementById('reset-filter');
    const sppgContainer = document.getElementById('sppg-container');
    const noResults = document.getElementById('no-results');
    const filteredCount = document.getElementById('filtered-count');
    const allCards = document.querySelectorAll('.sppg-team-card');

    function filterSPPG() {
        const selectedSchool = filterSchool.value;
        let visibleCount = 0;

        allCards.forEach(card => {
            const cardSchool = card.dataset.school;

            if (!selectedSchool || cardSchool === selectedSchool) {
                card.style.display = '';
                visibleCount++;
            } else {
                card.style.display = 'none';
            }
        });

        if (visibleCount === 0) {
            noResults.style.display = 'block';
        } else {
            noResults.style.display = 'none';
        }

        filteredCount.textContent = visibleCount;
    }

    function resetFilter() {
        filterSchool.value = '';
        filterSPPG();
    }

    filterSchool.addEventListener('change', filterSPPG);
    resetBtn.addEventListener('click', resetFilter);
</script>

</body>
</html>
