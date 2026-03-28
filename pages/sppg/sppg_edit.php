<?php
include '../../includes/auth_check.php';
include '../../config/database.php';

Login_Check();
Only_Allow(['Admin']);

// Get SPPG data
$id_sppg = $_GET['id'];
$query_sppg = "SELECT * FROM sppg WHERE id_sppg = '$id_sppg'";
$result_sppg = mysqli_query($conn, $query_sppg);
$sppg = mysqli_fetch_assoc($result_sppg);

// Check if SPPG exists
if (!$sppg) {
    header("Location: sppg_manage.php");
    exit;
}

// Get schools list
$query_sekolah = "SELECT id_sekolah, nama_sekolah FROM sekolah ORDER BY nama_sekolah ASC";
$daftar_sekolah = mysqli_query($conn, $query_sekolah);

// Get users from database
$query_users = "SELECT uid, nama, role FROM users WHERE role IN ('Petugas Gizi', 'Petugas Pengaduan') ORDER BY nama ASC";
$daftar_users = mysqli_query($conn, $query_users);

// Parse anggota_tim into array
$anggota_selected = !empty($sppg['anggota_tim']) ? explode(',', $sppg['anggota_tim']) : [];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Tim SPPG - MBG Report</title>
    <link rel="stylesheet" href="../../assets/css/form_style.css">
</head>
<body>
    <div class="form-container">
        <div class="form-header">
            <h1>Edit Data Tim SPPG</h1>
            <p>Perbarui informasi anggota tim SPPG</p>
        </div>

        <form action="../../process/sppg/sppg_edit_process.php" method="POST" enctype="multipart/form-data" class="form-content">
            <input type="hidden" name="id_sppg_old" value="<?php echo $sppg['id_sppg']; ?>">

            <div class="form-group">
                <label for="id_sppg">ID Tim SPPG</label>
                <input type="text" id="id_sppg" name="id_sppg" value="<?php echo $sppg['id_sppg']; ?>" placeholder="ID unik untuk tim" maxlength="50" required>
                <small>Gunakan format yang unik dan mudah diingat (maksimal 50 karakter)</small>
            </div>

            <div class="form-group">
                <label for="id_sekolah">Sekolah</label>
                <select id="id_sekolah" name="id_sekolah" required>
                    <option value="">-- Pilih Sekolah --</option>
                    <?php mysqli_data_seek($daftar_sekolah, 0); while($s = mysqli_fetch_assoc($daftar_sekolah)) : ?>
                        <option value="<?php echo $s['id_sekolah']; ?>" <?php if($sppg['id_sekolah'] == $s['id_sekolah']) echo 'selected'; ?>>
                            <?php echo $s['nama_sekolah']; ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="nama_tim">Nama Tim</label>
                <input type="text" id="nama_tim" name="nama_tim" value="<?php echo $sppg['nama_tim']; ?>" required>
            </div>

            <div class="form-group">
                <label for="jabatan">Jabatan / Posisi</label>
                <input type="text" id="jabatan" name="jabatan" value="<?php echo $sppg['jabatan']; ?>" required>
            </div>

            <div class="form-group">
                <label for="ketua_tim">Ketua Tim</label>
                <select id="ketua_tim" name="ketua_tim">
                    <option value="">-- Pilih Ketua Tim --</option>
                    <?php 
                    mysqli_data_seek($daftar_users, 0);
                    while($u = mysqli_fetch_assoc($daftar_users)) : 
                    ?>
                        <option value="<?php echo $u['uid']; ?>" <?php if($sppg['ketua_tim'] == $u['uid']) echo 'selected'; ?>>
                            <?php echo $u['nama']; ?> (<?php echo $u['role']; ?>)
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="kontak_tim">Nomor Kontak</label>
                <input type="text" id="kontak_tim" name="kontak_tim" value="<?php echo $sppg['kontak_tim'] ?? ''; ?>" required>
            </div>

            <div class="form-group">
                <label for="anggota_tim">Anggota Tim (Pilih satu atau lebih)</label>
                <select id="anggota_tim" name="anggota_tim[]" multiple required size="8">
                    <option value="">-- Pilih Anggota Tim --</option>
                    <?php 
                    mysqli_data_seek($daftar_users, 0);
                    while($u = mysqli_fetch_assoc($daftar_users)) : 
                    ?>
                        <option value="<?php echo $u['uid']; ?>" <?php if(in_array($u['uid'], $anggota_selected)) echo 'selected'; ?>>
                            <?php echo $u['nama']; ?> (<?php echo $u['role']; ?>)
                        </option>
                    <?php endwhile; ?>
                </select>
                <small>Gunakan Ctrl+Click (Windows) atau Cmd+Click (Mac) untuk memilih lebih dari satu anggota</small>
            </div>

            <div class="form-group">
                <label for="foto_tim">Foto Tim (Biarkan kosong jika tidak diubah)</label>
                <input type="file" id="foto_tim" name="foto_tim" accept="image/*">
                <small>Format: JPG, PNG, GIF (Max 5MB)</small>
                <?php if(!empty($sppg['foto_tim'])): ?>
                    <div style="margin-top: 10px;">
                        <img src="../../assets/uploads/sppg/<?php echo $sppg['foto_tim']; ?>" alt="Foto Tim" style="width: 100px; height: 100px; object-fit: cover; border-radius: 8px;">
                    </div>
                <?php endif; ?>
            </div>

            <div class="form-actions">
                <button type="submit" name="update" class="btn-primary">Update Tim SPPG</button>
                <a href="sppg_manage.php" class="btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</body>
</html>