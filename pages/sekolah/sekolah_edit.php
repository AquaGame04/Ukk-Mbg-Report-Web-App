<?php
include '../../includes/auth_check.php';
include '../../config/database.php';

Login_Check();
Only_Allow(['Admin']);

// Get school data
$id_sekolah = $_GET['id'];
$query_sekolah = "SELECT * FROM sekolah WHERE id_sekolah = '$id_sekolah'";
$result_sekolah = mysqli_query($conn, $query_sekolah);
$sekolah = mysqli_fetch_assoc($result_sekolah);

// Check if school exists
if (!$sekolah) {
    header("Location: sekolah_manage.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Sekolah - MBG Report</title>
    <link rel="stylesheet" href="../../assets/css/form_style.css">
</head>
<body>
    <div class="form-container">
        <div class="form-header">
            <h1>Edit Data Sekolah</h1>
            <p>Perbarui informasi sekolah</p>
        </div>

        <form action="../../process/sekolah/sekolah_edit_process.php" method="POST" class="form-content">
            <input type="hidden" name="old_id" value="<?php echo $sekolah['id_sekolah']; ?>">

            <div class="form-group">
                <label for="id_sekolah">ID Sekolah</label>
                <input type="text" id="id_sekolah" name="id_sekolah" value="<?php echo $sekolah['id_sekolah']; ?>" required>
                <small>ID unik untuk identitas sekolah</small>
            </div>

            <div class="form-group">
                <label for="nama_sekolah">Nama Sekolah</label>
                <input type="text" id="nama_sekolah" name="nama_sekolah" value="<?php echo $sekolah['nama_sekolah']; ?>" required>
            </div>

            <div class="form-group">
                <label for="alamat">Alamat</label>
                <textarea id="alamat" name="alamat" rows="4" required><?php echo $sekolah['alamat']; ?></textarea>
            </div>

            <div class="form-group">
                <label for="kontak">Nomor Kontak</label>
                <input type="text" id="kontak" name="kontak" value="<?php echo $sekolah['kontak']; ?>" required>
            </div>

            <div class="form-group">
                <label for="koordinat">Koordinat (Opsional)</label>
                <input type="text" id="koordinat" name="koordinat" value="<?php echo $sekolah['koordinat'] ?? ''; ?>" placeholder="Contoh: -6.1754,106.8272">
                <small>Format: latitude,longitude untuk peta Google Maps</small>
            </div>

            <div class="form-actions">
                <button type="submit" name="update" class="btn-primary">Update Sekolah</button>
                <a href="sekolah_manage.php" class="btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</body>
</html>