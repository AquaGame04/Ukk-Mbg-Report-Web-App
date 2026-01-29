<?php
include '../../config/database.php';
date_default_timezone_set('Asia/Jakarta');

// Get menu ID from URL
$id_menu = isset($_GET['id']) ? mysqli_real_escape_string($conn, $_GET['id']) : 0;

// Query menu details with nutrition info
$query_menu = "SELECT m.*, g.*, s.nama_sekolah 
               FROM menu_harian m
               LEFT JOIN gizi_menu g ON m.id_menu = g.id_menu
               JOIN sekolah s ON m.id_sekolah = s.id_sekolah
               WHERE m.id_menu = '$id_menu'";
$result_menu = mysqli_query($conn, $query_menu);
$menu = mysqli_fetch_assoc($result_menu);

// Check if menu exists
if (!$menu) {
    header("Location: ../index.php");
    exit;
}

// Calculate nutrition percentages (based on daily requirements)
$daily_calories = 2000;
$daily_protein = 50;
$daily_carbs = 300;
$daily_fat = 65;
$daily_fiber = 25;

$cal_percent = round(($menu['kalori'] / $daily_calories) * 100, 1);
$protein_percent = round(($menu['protein'] / $daily_protein) * 100, 1);
$carbs_percent = round(($menu['karbohidrat'] / $daily_carbs) * 100, 1);
$fat_percent = round(($menu['lemak'] / $daily_fat) * 100, 1);
$fiber_percent = round(($menu['serat'] / $daily_fiber) * 100, 1);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $menu['nama_menu']; ?> - MBG Report</title>
    <link rel="stylesheet" href="../../assets/css/fe_index.css">
    <link rel="stylesheet" href="../../assets/css/menu_detail_style.css">
</head>
<body>

<nav class="navbar">
    <a href="../../index.php" class="nav-logo">MBG REPORT</a>
    <ul>
        <li><a href="../../index.php#home">Beranda</a></li>
        <li><a href="../../index.php#menu">Menu Hari Ini</a></li>
        <li><a href="../menu_history.php">Riwayat Menu</a></li>
        <li><a href="../../index.php#sppg">Tim SPPG</a></li>
        <li><a href="../../index.php#pengaduan">Lapor Aduan</a></li>
        <li><a href="../login_pages.php" class="btn-login">Login Petugas</a></li>
    </ul>
</nav>

<main class="container">
    <a href="javascript:history.back()" class="breadcrumb-back">← Kembali</a>

    <section class="detail-wrapper">
        <!-- Menu Image & Header -->
        <div class="detail-header">
            <div class="menu-image-section">
                <img src="../../assets/uploads/menu/<?php echo $menu['foto_url']; ?>" alt="<?php echo $menu['nama_menu']; ?>" class="menu-image">
                <div class="image-overlay">
                    <span class="date-label"><?php echo date('d M Y', strtotime($menu['tanggal'])); ?></span>
                </div>
            </div>

            <div class="menu-header-info">
                <h1><?php echo $menu['nama_menu']; ?></h1>
                <div class="header-meta">
                    <span class="school-info">
                        <strong>Sekolah:</strong> <?php echo $menu['nama_sekolah']; ?>
                    </span>
                    <span class="date-info">
                        <strong>Tanggal:</strong> <?php echo date('d F Y', strtotime($menu['tanggal'])); ?>
                    </span>
                </div>

                <div class="calories-highlight">
                    <div class="calorie-badge">
                        <span class="cal-value"><?php echo round($menu['kalori']); ?></span>
                        <span class="cal-label">kkal</span>
                    </div>
                    <p class="calorie-text">Kalori total dalam sajian ini</p>
                </div>
            </div>
        </div>

        <!-- Nutrition Facts -->
        <section class="nutrition-section">
            <h2>Informasi Gizi</h2>
            <div class="nutrition-grid">
                <!-- Makronutrisi -->
                <div class="nutrition-card">
                    <h3>Makronutrisi</h3>
                    
                    <div class="nutrition-item">
                        <div class="nutrition-header">
                            <span class="nutrient-name">Protein</span>
                            <span class="nutrient-value"><?php echo round($menu['protein'], 2); ?>g</span>
                        </div>
                        <div class="progress-bar">
                            <div class="progress-fill protein-color" style="width: <?php echo min($protein_percent, 100); ?>%"></div>
                        </div>
                        <span class="percent-text"><?php echo $protein_percent; ?>% dari kebutuhan harian</span>
                    </div>

                    <div class="nutrition-item">
                        <div class="nutrition-header">
                            <span class="nutrient-name">Karbohidrat</span>
                            <span class="nutrient-value"><?php echo round($menu['karbohidrat'], 2); ?>g</span>
                        </div>
                        <div class="progress-bar">
                            <div class="progress-fill carbs-color" style="width: <?php echo min($carbs_percent, 100); ?>%"></div>
                        </div>
                        <span class="percent-text"><?php echo $carbs_percent; ?>% dari kebutuhan harian</span>
                    </div>

                    <div class="nutrition-item">
                        <div class="nutrition-header">
                            <span class="nutrient-name">Lemak</span>
                            <span class="nutrient-value"><?php echo round($menu['lemak'], 2); ?>g</span>
                        </div>
                        <div class="progress-bar">
                            <div class="progress-fill fat-color" style="width: <?php echo min($fat_percent, 100); ?>%"></div>
                        </div>
                        <span class="percent-text"><?php echo $fat_percent; ?>% dari kebutuhan harian</span>
                    </div>
                </div>

                <!-- Mikronutrisi -->
                <div class="nutrition-card">
                    <h3>Nutrisi Lainnya</h3>
                    
                    <div class="nutrition-item">
                        <div class="nutrition-header">
                            <span class="nutrient-name">Energi</span>
                            <span class="nutrient-value"><?php echo round($menu['energi'], 2); ?> kkal</span>
                        </div>
                        <div class="progress-bar">
                            <div class="progress-fill energy-color" style="width: <?php echo min($cal_percent, 100); ?>%"></div>
                        </div>
                        <span class="percent-text"><?php echo $cal_percent; ?>% dari kebutuhan harian</span>
                    </div>

                    <div class="nutrition-item">
                        <div class="nutrition-header">
                            <span class="nutrient-name">Serat</span>
                            <span class="nutrient-value"><?php echo round($menu['serat'], 2); ?>g</span>
                        </div>
                        <div class="progress-bar">
                            <div class="progress-fill fiber-color" style="width: <?php echo min($fiber_percent, 100); ?>%"></div>
                        </div>
                        <span class="percent-text"><?php echo $fiber_percent; ?>% dari kebutuhan harian</span>
                    </div>
                </div>
            </div>
        </section>

        <!-- Nutrition Summary Cards -->
        <section class="summary-section">
            <h2>Ringkasan Nutrisi</h2>
            <div class="summary-cards">
                <div class="summary-card energy">
                    <div class="card-icon">E</div>
                    <div class="card-content">
                        <p class="card-label">Energi</p>
                        <p class="card-value"><?php echo round($menu['energi'], 0); ?> kkal</p>
                    </div>
                </div>

                <div class="summary-card protein">
                    <div class="card-icon">P</div>
                    <div class="card-content">
                        <p class="card-label">Protein</p>
                        <p class="card-value"><?php echo round($menu['protein'], 1); ?>g</p>
                    </div>
                </div>

                <div class="summary-card carbs">
                    <div class="card-icon">C</div>
                    <div class="card-content">
                        <p class="card-label">Karbohidrat</p>
                        <p class="card-value"><?php echo round($menu['karbohidrat'], 1); ?>g</p>
                    </div>
                </div>

                <div class="summary-card fat">
                    <div class="card-icon">L</div>
                    <div class="card-content">
                        <p class="card-label">Lemak</p>
                        <p class="card-value"><?php echo round($menu['lemak'], 1); ?>g</p>
                    </div>
                </div>

                <div class="summary-card fiber">
                    <div class="card-icon">S</div>
                    <div class="card-content">
                        <p class="card-label">Serat</p>
                        <p class="card-value"><?php echo round($menu['serat'], 1); ?>g</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Daily Value Info -->
        <section class="info-section">
            <div class="info-box">
                <h3>Catatan Gizi</h3>
                <ul class="info-list">
                    <li>Kalori: <?php echo round($menu['kalori']); ?> kkal dari kebutuhan harian <?php echo round($daily_calories); ?> kkal</li>
                    <li>Menu ini menyediakan <?php echo $protein_percent; ?>% kebutuhan protein harian</li>
                    <li>Kandungan serat yang sehat: <?php echo round($menu['serat'], 2); ?>g</li>
                    <li>Komposisi nutrisi seimbang untuk pertumbuhan optimal</li>
                </ul>
            </div>
        </section>
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

</body>
</html>
