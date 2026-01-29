<?php
include '../../../includes/auth_check.php';
include '../../../config/database.php';
Login_Check();
Only_Allow(['Petugas Gizi', 'Admin']);

$id_menu = $_GET['id'];
$query_menu = "SELECT m.*, g.*, s.id_sekolah, s.nama_sekolah FROM menu_harian m
               LEFT JOIN gizi_menu g ON m.id_menu = g.id_menu
               JOIN sekolah s ON m.id_sekolah = s.id_sekolah
               WHERE m.id_menu = '$id_menu'";
$result_menu = mysqli_query($conn, $query_menu);
$menu = mysqli_fetch_assoc($result_menu);

if (!$menu) {
    header("Location: menu_manage.php");
    exit;
}

$query_sekolah = "SELECT id_sekolah, nama_sekolah FROM sekolah ORDER BY nama_sekolah ASC";
$daftar_sekolah = mysqli_query($conn, $query_sekolah);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Menu - MBG Report</title>
    <link rel="stylesheet" href="../../../assets/css/form_style.css">
    <link rel="stylesheet" href="../../../assets/css/menu_form_style.css">
</head>
<body>
    <div class="form-container">
        <div class="form-header">
            <h1>Edit Menu Makan Bergizi</h1>
            <p>Perbarui informasi menu dan data gizi</p>
        </div>

        <form action="../../../process/menu/menu_edit_process.php" method="POST" enctype="multipart/form-data" class="form-content">
            <input type="hidden" name="id_menu" value="<?php echo $menu['id_menu']; ?>">

            <fieldset class="form-section">
                <legend>Informasi Dasar Menu</legend>
                
                <div class="form-group">
                    <label for="id_sekolah">Sekolah Tujuan</label>
                    <select id="id_sekolah" name="id_sekolah" required>
                        <option value="">-- Pilih Sekolah --</option>
                        <?php mysqli_data_seek($daftar_sekolah, 0); while($s = mysqli_fetch_assoc($daftar_sekolah)) : ?>
                            <option value="<?php echo $s['id_sekolah']; ?>" <?php if($menu['id_sekolah'] == $s['id_sekolah']) echo 'selected'; ?>>
                                <?php echo $s['nama_sekolah']; ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="tanggal">Tanggal Menu</label>
                        <input type="date" id="tanggal" name="tanggal" value="<?php echo $menu['tanggal']; ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="nama_menu">Nama Menu</label>
                        <input type="text" id="nama_menu" name="nama_menu" value="<?php echo $menu['nama_menu']; ?>" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="foto_menu">Foto Menu (Biarkan kosong jika tidak diubah)</label>
                    <input type="file" id="foto_menu" name="foto_menu" accept="image/*">
                    <small>Format: JPG, PNG, GIF (Max 5MB)</small>
                </div>
            </fieldset>

            <fieldset class="form-section">
                <legend>Informasi Gizi</legend>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="kalori">Kalori (kkal)</label>
                        <input type="number" id="kalori" name="kalori" value="<?php echo $menu['kalori'] ?? 0; ?>" min="0" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="energi">Energi (kkal)</label>
                        <input type="number" id="energi" name="energi" step="0.01" value="<?php echo $menu['energi'] ?? 0; ?>" min="0" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="protein">Protein (g)</label>
                        <input type="number" id="protein" name="protein" step="0.01" value="<?php echo $menu['protein'] ?? 0; ?>" min="0" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="karbohidrat">Karbohidrat (g)</label>
                        <input type="number" id="karbohidrat" name="karbohidrat" step="0.01" value="<?php echo $menu['karbohidrat'] ?? 0; ?>" min="0" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="lemak">Lemak (g)</label>
                        <input type="number" id="lemak" name="lemak" step="0.01" value="<?php echo $menu['lemak'] ?? 0; ?>" min="0" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="serat">Serat (g)</label>
                        <input type="number" id="serat" name="serat" step="0.01" value="<?php echo $menu['serat'] ?? 0; ?>" min="0" required>
                    </div>
                </div>
            </fieldset>

            <div class="form-actions">
                <button type="submit" name="update" class="btn-primary">Update Menu</button>
                <a href="menu_manage.php" class="btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</body>
</html>