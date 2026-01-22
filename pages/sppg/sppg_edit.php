<?php
include '../../includes/auth_check.php';
include '../../config/database.php';
Login_Check();
Only_Allow(['Admin']);

$id = mysqli_real_escape_string($conn, $_GET['id']);
$query_sppg = mysqli_query($conn, "SELECT * FROM sppg WHERE id_sppg = '$id'");
$sppg = mysqli_fetch_assoc($query_sppg);

// Ambil daftar sekolah untuk dropdown
$daftar_sekolah = mysqli_query($conn, "SELECT id_sekolah, nama_sekolah FROM sekolah");

// Ambil daftar user untuk anggota (Petugas)
$daftar_user = mysqli_query($conn, "SELECT uid, nama FROM users WHERE role != 'Admin'");

// Ubah string anggota_tim dari database menjadi array agar bisa dicek (in_array)
$anggota_sekarang = explode(',', $sppg['anggota_tim']);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <title>Edit TIm SPPG - MBG Report</title>
</head>
<body>
    <h2>Edit Tim SPPG</h2><br>
    <form action="../../process/sppg/sppg_edit_process.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="old_id" value="<?php echo $sppg['id_sppg']; ?>"><br>
        <label for="">ID SPPG:</label><br>
        <input type="text" name="id_sppg" value="<?php echo $sppg['id_sppg']; ?>"><br>
        <label for="">Nama Tim:</label><br>
        <input type="text" name="nama_tim" value="<?php echo $sppg['nama_tim']; ?>"><br>
        <label for="">Jabatan:</label><br>
        <input type="text" name="jabatan" value="<?php echo $sppg['jabatan']; ?>"><br>
        <label for="">Penempatan Sekolah:</label><br>
        <select name="id_sekolah" required>
            <?php while($s = mysqli_fetch_assoc($daftar_sekolah)) : ?>
                <option value="<?php echo $s['id_sekolah'] ?>" <?php if($sppg['id_sekolah'] == $s['id_sekolah']) echo 'selected'; ?>>
                    <?php echo $s['nama_sekolah']; ?>
                </option>
            <?php endwhile; ?>
        </select><br>
        <label for="">Ketua Tim:</label><br>
        <input type="text" name="ketua_tim" value="<?php echo $sppg['ketua_tim']; ?>"><br>
        <label for="">Anggota Tim:</label><br>
        <select name="anggota_tim[]" multiple>
            <?php while ($u = mysqli_fetch_assoc($daftar_user)) : ?>
                <option value="<?php echo $u['uid']; ?>" <?php if(in_array($u['uid'], $anggota_sekarang )) echo 'selected'; ?>>
                    <?php echo $u['nama']; ?>
                </option>
            <?php endwhile; ?>
        </select><br>
        <small>*Tahan Ctrl untuk memilih beberapa anggota</small><br>
        <label for="">Kontak Tim:</label><br>
        <input type="text" name="kontak_tim" value="<?php echo $sppg['kontak_tim']; ?>"><br>
        <label>Foto Tim:</label><br>
        <img src="../../../assets/uploads/<?php echo $sppg['foto_tim']; ?>" width="150" style="display:block; margin: 10px 0;">
        <input type="hidden" name="foto_lama" value="<?php echo $sppg['foto_tim']; ?>">
        <input type="file" name="foto_tim" accept="image/*"><br>
        <button type="submit" name="update">Update</button>
    </form>
    <a href="sppg_manages.php">Batal</a>
</body>
</html>