<?php
include 'config/database.php';
date_default_timezone_set('Asia/Jakarta');
$hari_ini = date('Y-m-d');

// --- LOGIKA 2: AMBIL MENU HARI INI (POIN 18) ---
$query_menu = "SELECT m.*, g.energi, g.protein, s.nama_sekolah 
               FROM menu_harian m
               LEFT JOIN gizi_menu g ON m.id_menu = g.id_menu
               JOIN sekolah s ON m.id_sekolah = s.id_sekolah
               WHERE m.tanggal = '$hari_ini' AND m.riwayat = 0
               ORDER BY m.id_menu DESC LIMIT 3";
$result_menu = mysqli_query($conn, $query_menu);

// --- LOGIKA 3: AMBIL TIM SPPG (POIN 21) ---
$query_sppg = "SELECT t.*, s.nama_sekolah 
               FROM sppg t 
               JOIN sekolah s ON t.id_sekolah = s.id_sekolah 
               ORDER BY RAND() LIMIT 5";
$result_sppg = mysqli_query($conn, $query_sppg);

// --- LOGIKA 4: DATA SEKOLAH (Untuk Dropdown Pengaduan) ---
$result_sekolah = mysqli_query($conn, "SELECT * FROM sekolah");
?>

<!DOCTYPE html>
<html lang="id" style="scroll-behavior: smooth;">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MBG Report - Transparansi & Gizi</title>
    <link rel="stylesheet" href="assets/css/fe_index.css">
</head>
<body>

<nav class="navbar">
    <a href="index.php" class="nav-logo">MBG REPORT</a>
    <ul>
        <li><a href="#home">Beranda</a></li>
        <li><a href="#menu">Menu Hari Ini</a></li>
        <li><a href="pages/menu_history.php">Riwayat Menu</a></li>
        <li><a href="pages/sppg_list.php">Tim SPPG</a></li>
        <li><a href="#pengaduan">Lapor Aduan</a></li>
        <li><a href="pages/complaint_list.php">Daftar Aduan</a></li>
        <li><a href="pages/login_pages.php" class="btn-login">Login Petugas</a></li>
    </ul>
</nav>

<header id="home" class="hero">
    <h1>Sistem Transparansi MBG</h1>
    <p>Monitoring Program Makan Bergizi Gratis untuk Generasi Unggul</p>
</header>

<main class="container">
    
    <section id="menu" class="section-wrapper">
        <div class="section-title">
            <h2>Menu Pilihan Hari Ini</h2>
            <p>Sajian gizi terbaik tanggal <strong><?php echo date('d F Y'); ?></strong></p>
        </div>

        <div class="menu-grid">
            <?php if(mysqli_num_rows($result_menu) > 0) : ?>
                <?php while($row = mysqli_fetch_assoc($result_menu)) : ?>
                    <div class="menu-card">
                        <div class="img-wrapper">
                            <img src="assets/uploads/menu/<?php echo $row['foto_url']; ?>" alt="Foto Menu">
                            <span class="badge-sekolah"><?php echo $row['nama_sekolah']; ?></span>
                        </div>
                        <div class="menu-info">
                            <h3><?php echo $row['nama_menu']; ?></h3>
                            <div class="mini-gizi">
                                <span>⚡ <?php echo $row['energi'] ?? '0'; ?> kkal</span>
                                <span>🥩 <?php echo $row['protein'] ?? '0'; ?>g Protein</span>
                            </div>
                            <a href="pages/menu/menu_detail.php?id=<?php echo $row['id_menu']; ?>" class="btn-detail">Lihat Rincian</a>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else : ?>
                <div class="empty-state">
                    <div style="font-size: 3rem; margin-bottom: 10px; opacity: 0.5;">📦</div>
                    <p>Belum ada data menu untuk hari ini.</p>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <section id="sppg" class="section-wrapper">
        <div class="section-title">
            <h2>Tim Satuan Pelayanan</h2>
            <p>Pahlawan gizi yang bertugas memastikan kualitas makanan di sekolah</p>
        </div>

        <div class="sppg-grid">
            <?php while($team = mysqli_fetch_assoc($result_sppg)) : ?>
            <div class="team-card">
                <div class="team-photo">
                    <?php if(!empty($team['foto_tim'])): ?>
                        <img src="assets/uploads/sppg/<?php echo $team['foto_tim']; ?>" alt="Foto Tim">
                    <?php else: ?>
                        <div class="no-photo">Tim</div>
                    <?php endif; ?>
                </div>
                <h3><?php echo $team['nama_tim']; ?></h3>
                <span class="jabatan"><?php echo $team['jabatan']; ?></span>
                <p class="lokasi">📍 <?php echo $team['nama_sekolah']; ?></p>
            </div>
            <?php endwhile; ?>
        </div>
    </section>

    <section id="pengaduan" class="report-cta">
        <div class="form-container">
            <h2>📢 Form Pengaduan Masyarakat</h2>
            <p>Identitas pelapor aman. Sampaikan keluhan Anda untuk perbaikan layanan.</p>
            
            <div id="alert-container"></div>
            
            <form id="complaint-form" class="contact-form" enctype="multipart/form-data">
                <div class="form-group">
                    <label>Nama Pelapor (Boleh Inisial)</label>
                    <input type="text" name="nama_pelapor" required placeholder="Masukkan nama Anda">
                </div>
                
                <div class="form-group">
                    <label>Kontak (WA/Email)</label>
                    <input type="text" name="kontak" required placeholder="08xxxxxxxxxx atau email@contoh.com">
                </div>

                <div class="form-group">
                    <label>Sekolah Terkait</label>
                    <select name="id_sekolah" required>
                        <option value="">-- Pilih Sekolah --</option>
                        <?php while($sek = mysqli_fetch_assoc($result_sekolah)) : ?>
                            <option value="<?php echo $sek['id_sekolah']; ?>"><?php echo $sek['nama_sekolah']; ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label>Isi Keluhan (Minimal 10 karakter)</label>
                    <textarea name="isi_pengaduan" rows="4" required placeholder="Jelaskan masalah yang ditemukan..."></textarea>
                </div>

                <div class="form-group">
                    <label>Bukti Foto (Opsional - Max 5MB)</label>
                    <input type="file" name="foto_bukti" accept="image/*">
                    <small>Format: JPG, PNG, GIF</small>
                </div>

                <button type="submit" name="kirim_aduan" class="btn-submit">Kirim Laporan</button>
            </form>
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

<script src="assets/js/complaint-form.js"></script>

</body>
</html>