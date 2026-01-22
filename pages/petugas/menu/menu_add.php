<?php
include '../../../includes/auth_check.php';
include '../../../config/database.php';
Login_Check();
Only_Allow(['Petugas Gizi', 'Admin']);

$query_sekolah = "SELECT id_sekolah, nama_sekolah FROM sekolah";
$daftar_sekolah = mysqli_query($conn, $query_sekolah);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <title>Tambah Menu Gizi</title>
</head>
<body>
    <h2>Input Menu Makan Siang Gratis</h2>
    <form action="../../../process/menu/menu_add_process.php" method="POST" enctype="multipart/form-data">
        <label>Pilih Sekolah:</label><br>
        <select name="id_sekolah" required>
            <option value="">-- Pilih Sekolah Tujuan --</option>
            <?php while($s = mysqli_fetch_assoc($daftar_sekolah)) : ?>
                <option value="<?php echo $s['id_sekolah']; ?>"><?php echo $s['nama_sekolah']; ?></option>
            <?php endwhile; ?>
        </select><br><br>

        <label>Tanggal:</label><br>
        <input type="date" name="tanggal" value="<?php echo date('Y-m-d'); ?>" required><br><br>

        <label>Nama Menu:</label><br>
        <input type="text" name="nama_menu" placeholder="Contoh: Nasi, Ayam Bakar, Sayur Sop" required><br><br>

        <label>Kalori (kkal):</label><br>
        <input type="number" name="kalori" required><br><br>

        <label>Protein (g):</label><br>
        <input type="number" step="0.01" name="protein" required><br><br>

        <label>Karbohidrat (g):</label><br>
        <input type="number" step="0.01" name="karbohidrat" required><br><br>

        <label>Serat (g):</label><br>
        <input type="number" step="0.01" name="serat" required><br><br>

        <label>Energi (kkal/kJ):</label><br>
        <input type="number" step="0.01" name="energi" required><br><br>

        <label>Lemak (g):</label><br>
        <input type="number" step="0.01" name="lemak" required><br><br>

        <label>Foto Menu:</label><br>
        <input type="file" name="foto_menu" accept="image/*" required><br><br>

        <button type="submit" name="submit">Kirim Laporan Menu</button>
    </form>
    <p><a href="menu_manage.php">Batal</a></p>
</body>
</html>