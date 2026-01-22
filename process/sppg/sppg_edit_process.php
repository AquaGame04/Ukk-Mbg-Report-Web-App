<?php
include '../../config/database.php';

if (isset($_POST['update'])) {
    $old_id = mysqli_real_escape_string($conn, $_POST['old_id']);
    $id_sppg = mysqli_real_escape_string($conn, $_POST['id_sppg']);
    $nama_tim = mysqli_real_escape_string($conn, $_POST['nama_tim']);
    $id_sekolah = $_POST['id_sekolah'];
    $ketua = mysqli_real_escape_string($conn, $_POST['ketua_tim']);
    $kontak = mysqli_real_escape_string($conn, $_POST['kontak_tim']);
    
    // Proses array anggota tim menjadi string
    $anggota = isset($_POST['anggota_tim']) ? implode(',', $_POST['anggota_tim']) : '';

    $query = "UPDATE sppg SET 
                id_sppg = '$id_sppg', 
                nama_tim = '$nama_tim', 
                id_sekolah = '$id_sekolah', 
                ketua_tim = '$ketua', 
                kontak_tim = '$kontak',
                anggota_tim = '$anggota'
              WHERE id_sppg = '$old_id'";

    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Data Tim SPPG Berhasil Diperbarui'); window.location='../../pages/sppg/sppg_manages.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>