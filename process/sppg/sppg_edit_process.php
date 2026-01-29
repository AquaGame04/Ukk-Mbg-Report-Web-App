<?php
include '../../config/database.php';

if (isset($_POST['update'])) {
    $id_sppg = mysqli_real_escape_string($conn, $_POST['id_sppg']);
    $nama_tim = mysqli_real_escape_string($conn, $_POST['nama_tim']);
    $jabatan = mysqli_real_escape_string($conn, $_POST['jabatan']);
    $kontak = mysqli_real_escape_string($conn, $_POST['kontak']);
    $id_sekolah = mysqli_real_escape_string($conn, $_POST['id_sekolah']);
    
    // Get current photo
    $query_current = "SELECT foto_tim FROM sppg WHERE id_sppg = '$id_sppg'";
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
                nama_tim = '$nama_tim', 
                jabatan = '$jabatan',
                kontak_tim = '$kontak',
                id_sekolah = '$id_sekolah',
                foto_tim = '$foto_tim'
              WHERE id_sppg = '$id_sppg'";

    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Data Tim SPPG Berhasil Diperbarui'); window.location='../../pages/sppg/sppg_manage.php';</script>";
    } else {
        echo "<script>alert('Gagal memperbarui tim SPPG: " . mysqli_error($conn) . "'); window.location='../../pages/sppg/sppg_edit.php?id=$id_sppg';</script>";
    }
}
?>