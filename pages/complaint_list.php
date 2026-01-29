<?php
include '../config/database.php';
date_default_timezone_set('Asia/Jakarta');

// Get all complaints (without identitas pelapor)
$query_pengaduan = "SELECT p.*, s.nama_sekolah 
                    FROM pengaduan p
                    JOIN sekolah s ON p.id_sekolah = s.id_sekolah
                    WHERE p.status IN ('Diproses', 'Selesai')
                    ORDER BY p.tanggal DESC";
$result_pengaduan = mysqli_query($conn, $query_pengaduan);

// Fetch all data
$complaint_data = [];
while($row = mysqli_fetch_assoc($result_pengaduan)) {
    $complaint_data[] = $row;
}

// Get unique schools for filter
$query_sekolah = "SELECT DISTINCT s.id_sekolah, s.nama_sekolah 
                  FROM pengaduan p
                  JOIN sekolah s ON p.id_sekolah = s.id_sekolah
                  WHERE p.status IN ('Diproses', 'Selesai', 'Pending')
                  ORDER BY s.nama_sekolah ASC";
$result_sekolah = mysqli_query($conn, $query_sekolah);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Aduan Publik - MBG Report</title>
    <link rel="stylesheet" href="../assets/css/fe_index.css">
    <link rel="stylesheet" href="../assets/css/complaint_list_style.css">
</head>
<body>

<nav class="navbar">
    <a href="../index.php" class="nav-logo">MBG REPORT</a>
    <ul>
        <li><a href="../index.php#home">Beranda</a></li>
        <li><a href="../index.php#menu">Menu Hari Ini</a></li>
        <li><a href="menu_history.php">Riwayat Menu</a></li>
        <li><a href="sppg_list.php">Tim SPPG</a></li>
        <li><a href="../index.php#pengaduan">Lapor Aduan</a></li>
        <li><a href="complaint_list.php" class="active">Daftar Aduan</a></li>
        <li><a href="login_pages.php" class="btn-login">Login Petugas</a></li>
    </ul>
</nav>

<header class="page-header">
    <h1>Daftar Aduan Publik</h1>
    <p>Pantau status pengaduan yang telah diproses dan ditindaklanjuti</p>
</header>

<main class="container">
    <section class="complaint-section">
        <div class="filter-wrapper">
            <h2>Filter Aduan</h2>
            
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
                
                <div class="filter-group">
                    <label for="filter-status">Status</label>
                    <select id="filter-status">
                        <option value="">-- Semua Status --</option>
                        <option value=Pending">Pending</option>
                        <option value="Diproses">Diproses</option>
                        <option value="Selesai">Selesai</option>
                    </select>
                </div>
                
                <button id="reset-filter" class="btn-reset">Reset Filter</button>
            </div>
        </div>

        <div class="complaint-stats">
            <div class="stat-badge">
                Total Aduan: <strong id="total-count"><?php echo count($complaint_data); ?></strong>
            </div>
            <div class="stat-badge">
                Hasil Filter: <strong id="filtered-count"><?php echo count($complaint_data); ?></strong>
            </div>
        </div>

        <div class="complaint-list" id="complaint-container">
            <?php if(count($complaint_data) > 0) : ?>
                <?php foreach($complaint_data as $complaint) : ?>
                    <div class="complaint-item" data-school="<?php echo $complaint['nama_sekolah']; ?>" data-status="<?php echo $complaint['status']; ?>">
                        <div class="complaint-header">
                            <div class="complaint-meta">
                                <span class="ticket-badge">Aduan #<?php echo $complaint['id_pengaduan']; ?></span>
                                <span class="date-badge"><?php echo date('d M Y H:i', strtotime($complaint['tanggal'])); ?></span>
                                <span class="school-badge"><?php echo $complaint['nama_sekolah']; ?></span>
                            </div>
                            <div class="status-display">
                                <span class="status-badge status-<?php echo strtolower($complaint['status']); ?>">
                                    <?php echo $complaint['status']; ?>
                                </span>
                            </div>
                        </div>

                        <div class="complaint-body">
                            <div class="complaint-text">
                                <h3>Keluhan</h3>
                                <p><?php echo substr($complaint['isi_pengaduan'], 0, 150); ?>...</p>
                            </div>

                            <?php if(!empty($complaint['catatan_petugas'])): ?>
                                <div class="response-section">
                                    <h3>Respon Petugas</h3>
                                    <p><?php echo $complaint['catatan_petugas']; ?></p>
                                </div>
                            <?php endif; ?>

                            <?php if(!empty($complaint['foto_bukti'])): ?>
                                <div class="evidence-badge">
                                    📎 Ada bukti foto
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else : ?>
                <div class="empty-state">
                    <p>Belum ada aduan yang ditampilkan.</p>
                </div>
            <?php endif; ?>
        </div>

        <div id="no-results" class="empty-state" style="display: none;">
            <p>Tidak ada aduan yang sesuai dengan filter yang dipilih.</p>
        </div>
    </section>

    <section class="info-box">
        <h2>Catatan Penting</h2>
        <ul>
            <li>Identitas pelapor dijaga kerahasiaannya untuk keamanan Anda</li>
            <li>Nomor referensi aduan dapat digunakan untuk melacak status pengaduan Anda</li>
            <li>Hanya aduan yang sedang diproses atau sudah selesai yang ditampilkan</li>
            <li>Respon petugas menunjukkan tindakan yang telah atau sedang diambil</li>
        </ul>
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
    const filterStatus = document.getElementById('filter-status');
    const resetBtn = document.getElementById('reset-filter');
    const complaintContainer = document.getElementById('complaint-container');
    const noResults = document.getElementById('no-results');
    const filteredCount = document.getElementById('filtered-count');
    const allItems = document.querySelectorAll('.complaint-item');

    function filterComplaints() {
        const selectedSchool = filterSchool.value;
        const selectedStatus = filterStatus.value;
        let visibleCount = 0;

        allItems.forEach(item => {
            const itemSchool = item.dataset.school;
            const itemStatus = item.dataset.status;

            const matchSchool = !selectedSchool || itemSchool === selectedSchool;
            const matchStatus = !selectedStatus || itemStatus === selectedStatus;

            if (matchSchool && matchStatus) {
                item.style.display = '';
                visibleCount++;
            } else {
                item.style.display = 'none';
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
        filterStatus.value = '';
        filterComplaints();
    }

    filterSchool.addEventListener('change', filterComplaints);
    filterStatus.addEventListener('change', filterComplaints);
    resetBtn.addEventListener('click', resetFilter);
</script>

</body>
</html>
