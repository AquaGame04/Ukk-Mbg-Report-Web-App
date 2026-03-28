<?php
include '../../config/database.php';

if (isset($_POST['update'])) {
    $old_id = $_POST['old_id'];
    $id = $_POST['id_sekolah'];
    $nama = $_POST['nama_sekolah'];
    $alamat = $_POST['alamat'];
    $kontak = $_POST['kontak'];
    $koordinat = $_POST['koordinat'];

    // Check if new ID already exists (excluding current old_id)
    if ($id !== $old_id) {
        $check_query = "SELECT id_sekolah FROM sekolah WHERE id_sekolah = '$id'";
        $check_result = mysqli_query($conn, $check_query);
        
        if (mysqli_num_rows($check_result) > 0) {
            echo "<script>alert('ID Sekolah \"$id\" sudah ada! Gunakan ID yang berbeda.'); window.history.back();</script>";
            exit;
        }
    }

    $query = "UPDATE sekolah SET 
                id_sekolah='$id', 
                nama_sekolah='$nama', 
                alamat='$alamat', 
                kontak='$kontak', 
                koordinat='$koordinat' 
              WHERE id_sekolah='$old_id'";

    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Data Sekolah Berhasil Diperbarui'); window.location='../../pages/sekolah/sekolah_manage.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>