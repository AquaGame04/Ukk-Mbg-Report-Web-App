<?php
include '../../includes/auth_check.php';
include '../../config/database.php';
Login_Check();
Only_Allow(['Admin']);

// ambil nama user berrole selain admin
$query_user = "SELECT uid, nama FROM users WHERE role != 'Admin'";
$daftar_user = mysqli_query($conn, $query_user);

$daftar_sekolah = mysqli_query($conn, "SELECT id_sekolah, nama_sekolah FROM sekolah");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <title>Tambah Tim SPPG - MBG Report</title>
</head>
<body>
    <h2>Daftarkan Tim SPPG Baru</h2>
    <form action="../../process/sppg/sppg_add_process.php" method="POST" enctype="multipart/form-data">
        <label for="">ID SPPG</label><br>
        <input type="text" name="id_sppg" placeholder="Contoh: SPPG-001" required><br>
        <label for="">Nama Tim</label><br>
        <input type="text" name="nama_tim" required><br>
        <label for="">Jabatan</label><br>
        <input type="text" name="jabatan" placeholder="Contoh: Unit Gizi Sekolah" required><br>
        <label for="">Penempatan Sekolah</label><br>
        <select name="id_sekolah" id="" required>
            <option value="">-- Pilih Sekolah--</option>
            <?php while($s = mysqli_fetch_assoc($daftar_sekolah)) : ?>
                <option value="<?php echo $s['id_sekolah']; ?>"><?php echo $s['nama_sekolah']?></option>
            <?php endwhile; ?>
        </select><br>
        <label for="">Ketua Tim</label><br>
        <input type="text" name="ketua_tim"><br>
        <label for="">Anggota Tim (Pilih satu atau lebih)</label><br>
        <select name="anggota_tim[]" multiple>
            <?php while($u = mysqli_fetch_assoc($daftar_user)): ?>
                <option value="<?php echo $u['uid']; ?>"><?php echo $u['nama']; ?></option>
            <?php endwhile; ?>
        </select>
        <small>*Tahan Ctrl untuk memilih lebih dari satu</small><br>
        <label for="">Kontak Tim</label><br>
        <input type="text" name="kontak_tim"><br>
        <label for="">Foto Tim</label><br>
        <input type="file" name="foto_tim" accept="image/*"><br>
        <button type="submit" name="submit">Simpan Tim</button>
    </form>
    <p><a href="sppg_manages.php">Batal</a></p>
</body>
</html>