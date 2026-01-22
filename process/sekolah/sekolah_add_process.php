<?php
include '../../config/database.php';

if (isset($_POST['submit'])) {
    $id = mysqli_real_escape_string($conn, $_POST['id_sekolah']);
    $nama = mysqli_real_escape_string($conn, $_POST['nama_sekolah']);
    $alamat = mysqli_real_escape_string($conn, $_POST['alamat']);
    $kontak = mysqli_real_escape_string($conn, $_POST['kontak']);
    $koordinat = mysqli_real_escape_string($conn, $_POST['koordinat']);

    $query = "INSERT INTO sekolah (id_sekolah, nama_sekolah, alamat, kontak, koordinat) 
              VALUES ('$id', '$nama', '$alamat', '$kontak', '$koordinat')";

    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Sekolah Berhasil Ditambahkan'); window.location='../../pages/sekolah/sekolah_manage.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>