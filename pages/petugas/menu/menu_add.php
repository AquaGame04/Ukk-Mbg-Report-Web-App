<?php
include '../../../includes/auth_check.php';
include '../../../config/database.php';
Login_Check();
Only_Allow(['Petugas Gizi']);

$query_sekolah = "SELECT id_sekolah, nama_sekolah FROM sekolah ORDER BY nama_sekolah ASC";
$daftar_sekolah = mysqli_query($conn, $query_sekolah);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Menu - MBG Report</title>
    <link rel="stylesheet" href="../../../assets/css/form_style.css">
    <link rel="stylesheet" href="../../../assets/css/menu_form_style.css">
</head>
<body>
    <div class="form-container">
        <div class="form-header">
            <h1>Input Menu Makan Bergizi</h1>
            <p>Tambahkan menu baru beserta informasi gizi lengkapnya</p>
        </div>

        <form action="../../../process/menu/menu_add_process.php" method="POST" enctype="multipart/form-data" class="form-content">
            <!-- Section 1: Menu Basic Info -->
            <fieldset class="form-section">
                <legend>Informasi Dasar Menu</legend>
                
                <div class="form-group">
                    <label for="id_sekolah">Sekolah Tujuan</label>
                    <select id="id_sekolah" name="id_sekolah" required>
                        <option value="">-- Pilih Sekolah --</option>
                        <?php while($s = mysqli_fetch_assoc($daftar_sekolah)) : ?>
                            <option value="<?php echo $s['id_sekolah']; ?>"><?php echo $s['nama_sekolah']; ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="tanggal">Tanggal Menu</label>
                        <input type="date" id="tanggal" name="tanggal" value="<?php echo date('Y-m-d'); ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="nama_menu">Nama Menu</label>
                        <input type="text" id="nama_menu" name="nama_menu" placeholder="Contoh: Nasi, Ayam Goreng, Sayur Sop" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="foto_menu">Foto Menu</label>
                    <input type="file" id="foto_menu" name="foto_menu" accept="image/*" required>
                    <small>Format: JPG, PNG, GIF (Max 5MB)</small>
                </div>
            </fieldset>

            <!-- Section 2: Nutrition Info -->
            <fieldset class="form-section">
                <legend>Informasi Gizi</legend>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="kalori">Kalori (kkal)</label>
                        <input type="number" id="kalori" name="kalori" min="0" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="energi">Energi (kkal)</label>
                        <input type="number" id="energi" name="energi" step="0.01" min="0" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="protein">Protein (g)</label>
                        <input type="number" id="protein" name="protein" step="0.01" min="0" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="karbohidrat">Karbohidrat (g)</label>
                        <input type="number" id="karbohidrat" name="karbohidrat" step="0.01" min="0" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="lemak">Lemak (g)</label>
                        <input type="number" id="lemak" name="lemak" step="0.01" min="0" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="serat">Serat (g)</label>
                        <input type="number" id="serat" name="serat" step="0.01" min="0" required>
                    </div>
                </div>
            </fieldset>

            <div class="form-actions">
                <button type="submit" name="submit" class="btn-primary">Simpan Menu</button>
                <a href="menu_manage.php" class="btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</body>
</html>