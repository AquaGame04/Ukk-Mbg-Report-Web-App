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

// Fetch user data for mapping anggota_tim
$user_map = [];
$query_users = "SELECT uid, nama FROM users";
$result_users = mysqli_query($conn, $query_users);
while($u = mysqli_fetch_assoc($result_users)) {
    $user_map[$u['uid']] = $u['nama'];
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
        <li><a href="complaint_list.php">Daftar Aduan</a></li>
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
                    <?php
                        $anggota_names = [];
                        if (!empty($team['anggota_tim'])) {
                            $anggota_ids = array_filter(array_map('trim', explode(',', $team['anggota_tim'])));
                            foreach ($anggota_ids as $uid) {
                                if (!empty($user_map[$uid])) {
                                    $anggota_names[] = $user_map[$uid];
                                } else {
                                    $anggota_names[] = $uid;
                                }
                            }
                        }
                        $anggota_display = !empty($anggota_names) ? implode(', ', $anggota_names) : '-';

                        $ketua_name = '-';
                        if (!empty($team['ketua_tim'])) {
                            if (!empty($user_map[$team['ketua_tim']])) {
                                $ketua_name = $user_map[$team['ketua_tim']];
                            } else {
                                $ketua_name = $team['ketua_tim'];
                            }
                        }

                        $sppg_detail = $team;
                        $sppg_detail['anggota_nama'] = $anggota_display;
                        $sppg_detail['ketua_nama'] = $ketua_name;
                    ?>
                    <div class="sppg-team-card" data-school="<?php echo $team['nama_sekolah']; ?>" data-detail="<?php echo htmlspecialchars(json_encode($sppg_detail, JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_UNESCAPED_UNICODE), ENT_QUOTES, 'UTF-8'); ?>">
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
                                <button class="btn-detail" type="button">Lihat Detail</button>
                            </div>

                            <div class="team-info">
                                <h4 class="team-name"><?php echo $team['nama_tim']; ?></h4>
                                <p class="team-position">
                                    <span class="position-badge"><?php echo $team['jabatan'] ? $team['jabatan'] : 'Jabatan tim belum diset'; ?></span>
                                </p>

                                <div class="team-summary">
                                    <p><strong>Ketua Tim:</strong> <?php echo $ketua_name; ?></p>
                                    <p><strong>Kontak Tim:</strong> <?php echo !empty($team['kontak_tim']) ? $team['kontak_tim'] : '-'; ?></p>
                                    <p><strong>Anggota (singkat):</strong> <?php echo !empty($anggota_display) ? (strlen($anggota_display) > 80 ? substr($anggota_display, 0, 80).'...' : $anggota_display) : '-'; ?></p>
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

<div id="sppg-detail-overlay" class="detail-overlay" style="display: none;">
    <div class="overlay-card">
        <button id="overlay-close" class="overlay-close" aria-label="Tutup detail">&times;</button>
        <h3>Detail Tim SPPG</h3>
        <div class="overlay-content three-col">
            <div class="overlay-photo" id="ov-photo">
                <span class="no-photo">Foto tidak tersedia</span>
            </div>
            <div class="overlay-meta">
                <div class="overlay-panels">
                    <div class="overlay-panel panel-left">
                        <p><strong>ID SPPG:</strong> <span id="ov-id"></span></p>
                        <p><strong>Nama Tim:</strong> <span id="ov-nama"></span></p>
                        <p><strong>Nama Sekolah:</strong> <span id="ov-nama-sekolah"></span></p>
                        <p><strong>Alamat Sekolah:</strong> <span id="ov-alamat"></span></p>
                        <p><strong>Kontak Sekolah:</strong> <span id="ov-kontak-sekolah"></span></p>
                    </div>
                    <div class="overlay-divider"></div>
                    <div class="overlay-panel panel-right">
                        <p><strong>Ketua Tim:</strong> <span id="ov-ketua"></span></p>
                        <p><strong>Jabatan:</strong> <span id="ov-jabatan"></span></p>
                        <p><strong>Kontak Tim:</strong> <span id="ov-kontak-tim"></span></p>
                        <p><strong>Anggota Tim:</strong></p>
                        <strong><ul class="ov-anggota-list" id="ov-anggota"></ul></strong>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="photo-preview-overlay" class="photo-preview-overlay" aria-hidden="true" role="dialog" aria-label="Pratinjau Foto Tim">
    <div class="photo-preview-content">
        <button id="photo-preview-close" class="photo-preview-close" aria-label="Tutup pratinjau">×</button>
        <img id="photo-preview-img" src="" alt="" />
    </div>
</div>

<script src="../assets/js/sppg_list.js"></script>

</body>
</html>
