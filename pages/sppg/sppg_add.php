<?php
include '../../includes/auth_check.php';
include '../../config/database.php';
Login_Check();
Only_Allow(['Admin']);

$query_sekolah = "SELECT id_sekolah, nama_sekolah FROM sekolah ORDER BY nama_sekolah ASC";
$daftar_sekolah = mysqli_query($conn, $query_sekolah);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Tim SPPG - MBG Report</title>
    <link rel="stylesheet" href="../../assets/css/form_style.css">
</head>
<body>
    <div class="form-container">
        <div class="form-header">
            <h1>Tambah Tim SPPG Baru</h1>
            <p>Masukkan informasi lengkap anggota tim SPPG</p>
        </div>

        <form action="../../process/sppg/sppg_add_process.php" method="POST" enctype="multipart/form-data" class="form-content">
            <div class="form-group">
                <label for="id_sekolah">Sekolah</label>
                <select id="id_sekolah" name="id_sekolah" required>
                    <option value="">-- Pilih Sekolah --</option>
                    <?php while($s = mysqli_fetch_assoc($daftar_sekolah)) : ?>
                        <option value="<?php echo $s['id_sekolah']; ?>"><?php echo $s['nama_sekolah']; ?></option>
                    <?php endwhile; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="nama_tim">Nama Tim</label>
                <input type="text" id="nama_tim" name="nama_tim" placeholder="Masukkan nama lengkap" required>
            </div>

            <div class="form-group">
                <label for="jabatan">Jabatan / Posisi</label>
                <input type="text" id="jabatan" name="jabatan" placeholder="Contoh: Koordinator SPPG, Petugas Gizi, dll" required>
            </div>

            <div class="form-group">
                <label for="kontak">Nomor Kontak</label>
                <input type="text" id="kontak" name="kontak" placeholder="Contoh: 081234567890" required>
            </div>

            <div class="form-group">
                <label for="foto_tim">Foto Tim</label>
                <input type="file" id="foto_tim" name="foto_tim" accept="image/*" required>
                <small>Format: JPG, PNG, GIF (Max 5MB)</small>
            </div>

            <div class="form-actions">
                <button type="submit" name="submit" class="btn-primary">Simpan Tim SPPG</button>
                <a href="sppg_manage.php" class="btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</body>
</html>