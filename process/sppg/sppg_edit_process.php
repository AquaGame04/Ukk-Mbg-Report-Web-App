<?php
include '../../config/database.php';

if (isset($_POST['update'])) {
    $id_sppg_old = mysqli_real_escape_string($conn, $_POST['id_sppg_old']);
    $id_sppg = mysqli_real_escape_string($conn, $_POST['id_sppg']);
    $nama_tim = mysqli_real_escape_string($conn, $_POST['nama_tim']);
    $jabatan = mysqli_real_escape_string($conn, $_POST['jabatan']);
    $ketua_tim = mysqli_real_escape_string($conn, $_POST['ketua_tim']);
    $kontak_tim = mysqli_real_escape_string($conn, $_POST['kontak_tim']);
    $id_sekolah = mysqli_real_escape_string($conn, $_POST['id_sekolah']);
    
    // Check if new id_sppg already exists (excluding current id_sppg_old)
    if ($id_sppg !== $id_sppg_old) {
        $check_id_query = "SELECT id_sppg FROM sppg WHERE id_sppg = '$id_sppg'";
        $check_id_result = mysqli_query($conn, $check_id_query);
        
        if (mysqli_num_rows($check_id_result) > 0) {
            echo "<script>alert('ID Tim SPPG \"$id_sppg\" sudah ada! Gunakan ID yang berbeda.'); window.history.back();</script>";
            exit;
        }
    }
    
    // Check if new tim name already exists in the same school (excluding current tim)
    $check_query = "SELECT id_sppg FROM sppg WHERE nama_tim = '$nama_tim' AND id_sekolah = '$id_sekolah' AND id_sppg != '$id_sppg_old'";
    $check_result = mysqli_query($conn, $check_query);
    
    if (mysqli_num_rows($check_result) > 0) {
        echo "<script>alert('Nama Tim \\\"$nama_tim\\\" sudah ada di sekolah ini! Gunakan nama yang berbeda.'); window.history.back();</script>";
        exit;
    }
    
    // Process anggota_tim array into comma-separated string
    $anggota_tim = '';
    if (!empty($_POST['anggota_tim'])) {
        $anggota_array = $_POST['anggota_tim'];
        $anggota_tim = implode(',', array_map(function($item) use ($conn) {
            return mysqli_real_escape_string($conn, $item);
        }, $anggota_array));
    }
    
    // Get current photo
    $query_current = "SELECT foto_tim FROM sppg WHERE id_sppg = '$id_sppg_old'";
    $result_current = mysqli_query($conn, $query_current);
    $current_data = mysqli_fetch_assoc($result_current);
    $foto_lama = $current_data['foto_tim'];
    
    $foto_tim = $foto_lama;
    
    // Process photo upload
    if (!empty($_FILES['foto_tim']['name'])) {
        $foto_name = time() . "_" . $_FILES['foto_tim']['name'];
        $upload_path = "../../assets/uploads/sppg/" . $foto_name;
        
        if (move_uploaded_file($_FILES['foto_tim']['tmp_name'], $upload_path)) {
            // Delete old photo if exists
            if (!empty($foto_lama) && file_exists("../../assets/uploads/sppg/" . $foto_lama)) {
                unlink("../../assets/uploads/sppg/" . $foto_lama);
            }
            $foto_tim = $foto_name;
        }
    }

    $query = "UPDATE sppg SET 
                id_sppg = '$id_sppg',
                nama_tim = '$nama_tim', 
                jabatan = '$jabatan',
                ketua_tim = '$ketua_tim',
                kontak_tim = '$kontak_tim',
                anggota_tim = '$anggota_tim',
                id_sekolah = '$id_sekolah',
                foto_tim = '$foto_tim'
              WHERE id_sppg = '$id_sppg_old'";

    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Data Tim SPPG Berhasil Diperbarui'); window.location='../../pages/sppg/sppg_manage.php';</script>";
    } else {
        echo "<script>alert('Gagal memperbarui tim SPPG: " . mysqli_error($conn) . "'); window.location='../../pages/sppg/sppg_edit.php?id=$id_sppg_old';</script>";
    }
}
?>