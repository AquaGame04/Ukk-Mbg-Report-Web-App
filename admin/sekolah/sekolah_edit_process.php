<?php
include '../../config/database.php';

if (isset($_POST['update'])) {
    $old_id = $_POST['old_id'];
    $id = $_POST['id_sekolah'];
    $nama = $_POST['nama_sekolah'];
    $alamat = $_POST['alamat'];
    $kontak = $_POST['kontak'];
    $koordinat = $_POST['koordinat'];

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