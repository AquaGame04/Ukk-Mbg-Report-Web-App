<?php
include '../../../includes/auth_check.php';
include '../../../config/database.php';
Login_Check();
Only_Allow(['Petugas Pengaduan', 'Admin']);

$id = mysqli_real_escape_string($conn, $_GET['id']);
$query = "SELECT p.*, s.nama_sekolah 
          FROM pengaduan p
          JOIN sekolah s ON p.id_sekolah = s.id_sekolah
          WHERE p.id_pengaduan = '$id'";
$result = mysqli_query($conn, $query);
$data = mysqli_fetch_assoc($result);

if (!$data) {
    echo "<script>alert('Data tidak ditemukan!'); window.location='pengaduan_manage.php';</script>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <title>Detail Pengaduan - MBG Report</title>
</head>
<body>
    <h2>Detail Pengaduan</h2>
    <a href="pengaduan_manage.php">Kembali ke Daftar Pengaduan</a>

    <div style="display: flex;">
        <div style="flex: 1;">
            <h3>Informasi Pelapor</h3>
            <p><strong>Nama: </strong><?php echo $data['nama_pelapor']; ?></p>
            <p><strong>Kontak: </strong><?php echo $data['kontak']; ?></p>
            <p><strong>Sekolah: </strong><?php echo $data['nama_sekolah']; ?></p>
            <p><strong>Tanggal: </strong><?php echo date('d/m/Y H:i', strtotime($data['tanggal'])); ?></p>

            <h3>Isi Laporan</h3>
            <p style="background: #f9f9f9;">
                <?php echo nl2br($data['isi_pengaduan']); ?>
            </p>
            <?php if(!empty($data['foto_bukti'])): ?>
                <h3>Bukti Foto</h3>
                <img src="../../../assets/uploads/menu/<?php echo $data['foto_bukti']; ?>" width="300">
            <?php endif; ?>
        </div>

        <div style="flex: 1;">
            <h3>Tindak Lanjut Petugas</h3>
            <form action="../../../process/pengaduan/pengaduan_update_status_process.php" method="POST">
                <input type="hidden" name="id_pengaduan" value="<?php echo $data['id_pengaduan']; ?>">

                <label for="">Status Pengadian:</label><br>
                <select name="status" id="">
                    <option value="Pending" <?php if($data['status'] == 'Pending') echo 'selected'; ?>>Pending (Menunggu)</option>
                    <option value="Diproses" <?php if($data['status'] == 'Diproses') echo 'selected'; ?>>Diproses</option>
                    <option value="Selesai" <?php if($data['status'] == 'Selesai') echo 'selected'; ?>>Selesai</option>
                </select><br>
                
                <label for="">Catatan Petugas / Respon:</label><br>
                <textarea name="catatan_petugas" rows="4" placeholder="Tuliskan tindakan yang sudah dilakukan atau jawaban untuk pelapor..."><?php echo $data['catatan_petugas']; ?></textarea>
                <br>
                <button type="submit" name="update">Simpan Perubahan</button>
            </form>
        </div>
    </div>
</body>
</html>