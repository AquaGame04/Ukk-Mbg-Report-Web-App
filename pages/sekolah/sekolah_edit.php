<?php
include '../../includes/auth_check.php';
include '../../config/database.php';
Login_Check();
Only_Allow(['Admin']);

$id = $_GET['id'];
$query = "SELECT * FROM sekolah WHERE id_sekolah = '$id'";
$result = mysqli_query($conn, $query);
$s = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <title>Edit Sekolah</title>
</head>
<body>
    <h2>Edit Data Sekolah</h2>
    <form action="../../process/sekolah/sekolah_edit_process.php" method="POST">
        <input type="hidden" name="old_id" value="<?php echo $s['id_sekolah']; ?>">
        
        <label>ID Sekolah:</label><br>
        <input type="text" name="id_sekolah" value="<?php echo $s['id_sekolah']; ?>" required><br><br>
        
        <label>Nama Sekolah:</label><br>
        <input type="text" name="nama_sekolah" value="<?php echo $s['nama_sekolah']; ?>" required><br><br>
        
        <label>Alamat:</label><br>
        <textarea name="alamat" required><?php echo $s['alamat']; ?></textarea><br><br>
        
        <label>Kontak:</label><br>
        <input type="text" name="kontak" value="<?php echo $s['kontak']; ?>"><br><br>
        
        <label>Koordinat:</label><br>
        <input type="text" name="koordinat" value="<?php echo $s['koordinat']; ?>"><br><br>
        
        <button type="submit" name="update">Update Sekolah</button>
    </form>
</body>
</html>