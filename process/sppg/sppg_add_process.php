<?php
include '../../config/database.php';

if (isset($_POST['submit'])) {
    $id_sppg = mysqli_real_escape_string($conn, $_POST['id_sppg']);
    $nama_tim = mysqli_real_escape_string($conn, $_POST['nama_tim']);
    $id_sekolah = mysqli_real_escape_string($conn, $_POST['id_sekolah']);
    $ketua = mysqli_real_escape_string($conn, $_POST['ketua_tim']);
    $kontak = mysqli_real_escape_string($conn, $_POST['kontak_tim']);

    $anggota = isset($_POST['anggota_tim']) ? implode(',', $_POST['anggota_tim']) : '';

    $query = "INSERT INTO sppg (id_sppg, nama_tim, id_sekolah, ketua_tim, kontak_tim, anggota_tim) 
              VALUES ('$id_sppg', '$nama_tim', '$id_sekolah', '$ketua', '$kontak', '$anggota')";

    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Tim SPPG Berhasil Didaftarkan'); window.location='../../pages/sppg/sppg_manages.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>