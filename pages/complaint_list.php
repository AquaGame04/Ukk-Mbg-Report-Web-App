<?php
include '../config/database.php';
date_default_timezone_set('Asia/Jakarta');

// Pagination setup
$limit = 10;
$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$offset = ($page - 1) * $limit;

// Get all complaints count
$query_count = "SELECT COUNT(*) as total FROM pengaduan";
$result_count = mysqli_query($conn, $query_count);
$row_count = mysqli_fetch_assoc($result_count);
$total_complaints = $row_count['total'];
$total_pages = ceil($total_complaints / $limit);

// Get complaints with pagination (ALL statuses, ordered by newest first)
$query_pengaduan = "SELECT p.*, s.nama_sekolah 
                    FROM pengaduan p
                    JOIN sekolah s ON p.id_sekolah = s.id_sekolah
                    ORDER BY p.tanggal DESC
                    LIMIT $limit OFFSET $offset";
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
                        <option value="Pending">Pending</option>
                        <option value="Diproses">Diproses</option>
                        <option value="Selesai">Selesai</option>
                    </select>
                </div>
                
                <button id="reset-filter" class="btn-reset">Reset Filter</button>
            </div>
        </div>

        <div class="complaint-stats">
            <div class="stat-badge">
                Total Aduan: <strong id="total-count"><?php echo $total_complaints; ?></strong>
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
                                <a href="javascript:void(0);" class="evidence-badge view-evidence" 
                                data-src="../assets/uploads/pengaduan/<?php echo $complaint['foto_bukti']; ?>">
                                📷 Lihat Bukti Foto
                                </a>
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

        <!-- Pagination -->
        <?php if($total_pages > 1): ?>
        <div class="pagination">
            <?php if($page > 1): ?>
                <a href="?page=1" class="pagination-btn">« Pertama</a>
                <a href="?page=<?php echo $page - 1; ?>" class="pagination-btn">‹ Sebelumnya</a>
            <?php endif; ?>
            
            <div class="pagination-info">
                Halaman <strong><?php echo $page; ?></strong> dari <strong><?php echo $total_pages; ?></strong>
            </div>
            
            <?php if($page < $total_pages): ?>
                <a href="?page=<?php echo $page + 1; ?>" class="pagination-btn">Selanjutnya ›</a>
                <a href="?page=<?php echo $total_pages; ?>" class="pagination-btn">Terakhir »</a>
            <?php endif; ?>
        </div>
        <?php endif; ?>
    </section>

    <section class="info-box">
        <h2>Catatan Penting</h2>
        <ul>
            <li>Identitas pelapor dijaga kerahasiaannya untuk keamanan Anda</li>
            <li>Nomor referensi aduan dapat digunakan untuk melacak status pengaduan Anda</li>
            <li>Aduan baru akan langsung tampil dengan status Pending</li>
            <li>Respon petugas menunjukkan tindakan yang telah atau sedang diambil</li>
        </ul>
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

<div id="imageModal" class="modal-overlay">
    <span class="modal-close">&times;</span>
    <img class="modal-content" id="modalImage">
    <div id="caption"></div>
</div>

<script>
    const filterSchool = document.getElementById('filter-school');
    const filterStatus = document.getElementById('filter-status');
    const resetBtn = document.getElementById('reset-filter');
    const complaintContainer = document.getElementById('complaint-container');
    const noResults = document.getElementById('no-results');
    const filteredCount = document.getElementById('filtered-count');
    const allItems = document.querySelectorAll('.complaint-item');
    const modal = document.getElementById("imageModal");
    const modalImg = document.getElementById("modalImage");
    const closeBtn = document.getElementsByClassName("modal-close")[0];

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

    // Event Delegation agar tetap jalan meskipun setelah filter
    document.addEventListener('click', function(e) {
        if (e.target && e.target.classList.contains('view-evidence')) {
            modal.style.display = "block";
            modalImg.src = e.target.getAttribute('data-src');
        }
    });

    // Tutup saat tombol X ditekan
    closeBtn.onclick = function() { 
        modal.style.display = "none"; 
    }

    // Tutup saat area hitam di luar foto ditekan
    modal.onclick = function(e) {
        if (e.target === modal) {
            modal.style.display = "none";
        }
    }

    filterSchool.addEventListener('change', filterComplaints);
    filterStatus.addEventListener('change', filterComplaints);
    resetBtn.addEventListener('click', resetFilter);
</script>

</body>
</html>
