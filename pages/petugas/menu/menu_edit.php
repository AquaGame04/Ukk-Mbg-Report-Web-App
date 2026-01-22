<?php
include '../../../includes/auth_check.php';
include '../../../config/database.php';
Login_Check();
Only_Allow(['Petugas Gizi', 'Admin']);

$id_menu = mysqli_real_escape_string($conn, $_GET['id']);

// Query JOIN untuk ambil data Menu dan Gizi sekaligus
$query = "SELECT m.*, g.* FROM menu_harian m 
          JOIN gizi_menu g ON m.id_menu = g.id_menu 
          WHERE m.id_menu = '$id_menu'";
$result = mysqli_query($conn, $query);
$data = mysqli_fetch_assoc($result);

// Ambil daftar sekolah untuk dropdown
$daftar_sekolah = mysqli_query($conn, "SELECT id_sekolah, nama_sekolah FROM sekolah");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <title>Edit Menu & Gizi - MBG Report</title>
</head>
<body>
    <h2>Edit Laporan Menu Harian</h2>
    <form action="../../../process/menu/menu_edit_process.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id_menu" value="<?php echo $data['id_menu']; ?>">
        <input type="hidden" name="foto_lama" value="<?php echo $data['foto_url']; ?>">

        <label>Pilih Sekolah:</label><br>
        <select name="id_sekolah" required>
            <?php while($s = mysqli_fetch_assoc($daftar_sekolah)) : ?>
                <option value="<?php echo $s['id_sekolah']; ?>" <?php if($data['id_sekolah'] == $s['id_sekolah']) echo 'selected'; ?>>
                    <?php echo $s['nama_sekolah']; ?>
                </option>
            <?php endwhile; ?>
        </select><br><br>

        <label>Nama Menu:</label><br>
        <input type="text" name="nama_menu" value="<?php echo $data['nama_menu']; ?>" required><br><br>

        <fieldset>
            <legend>Rincian Gizi</legend>
            Energi: <input type="number" step="0.01" name="energi" value="<?php echo $data['energi']; ?>"><br>
            Kalori: <input type="number" name="kalori" value="<?php echo $data['kalori']; ?>"><br>
            Protein: <input type="number" step="0.01" name="protein" value="<?php echo $data['protein']; ?>"><br>
            Karbohidrat: <input type="number" step="0.01" name="karbohidrat" value="<?php echo $data['karbohidrat']; ?>"><br>
            Lemak: <input type="number" step="0.01" name="lemak" value="<?php echo $data['lemak']; ?>"><br>
            Serat: <input type="number" step="0.01" name="serat" value="<?php echo $data['serat']; ?>">
        </fieldset><br>

        <label>Foto Menu (Biarkan kosong jika tidak diubah):</label><br>
        <img src="../../../assets/uploads/<?php echo $data['foto_url']; ?>" width="150" style="display:block; margin: 10px 0;">
        <input type="file" name="foto_menu" accept="image/*"><br><br>

        <button type="submit" name="update">Update Laporan</button>
    </form>
    <a href="menu_manage.php">Batal</a>
</body>
</html>