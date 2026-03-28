<?php
include '../../includes/auth_check.php';
include '../../config/database.php';
Login_Check();
Only_Allow(['Petugas Pengaduan']);

if(isset($_POST['update'])){
    $id = mysqli_real_escape_string($conn, $_POST['id_pengaduan']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);
    $catatan = mysqli_real_escape_string($conn, $_POST['catatan_petugas']);

    $query = "UPDATE pengaduan SET
                status = '$status',
                catatan_petugas = '$catatan'
            WHERE id_pengaduan = '$id'";

    if(mysqli_query($conn, $query)){
        echo "<script>alert('Status pengaduan berhasil di perbarui!'); window.location = '../../pages/petugas/pengaduan/pengaduan_detail.php?id=$id';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>