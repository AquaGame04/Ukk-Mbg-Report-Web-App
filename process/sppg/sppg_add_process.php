<?php
include '../../config/database.php';

if (isset($_POST['submit'])) {
    $id_sppg = mysqli_real_escape_string($conn, $_POST['id_sppg']);
    $nama_tim = mysqli_real_escape_string($conn, $_POST['nama_tim']);
    $jabatan = mysqli_real_escape_string($conn, $_POST['jabatan']);
    $id_sekolah = mysqli_real_escape_string($conn, $_POST['id_sekolah']);
    $ketua = mysqli_real_escape_string($conn, $_POST['ketua_tim']);
    $kontak = mysqli_real_escape_string($conn, $_POST['kontak_tim']);

    $anggota = isset($_POST['anggota_tim']) ? implode(',', $_POST['anggota_tim']) : '';

    $foto_name = $_FILES['foto_tim']['name'];
    $tmp_name = $_FILES['foto_tim']['tmp_name'];
    $new_foto_name = "";

    if(!empty($foto_name)) {
        $new_foto_name = "team_" . time() . "_" . $foto_name;
        move_uploaded_file($tmp_name, "../../assets/uploads/sppg" . $new_foto_name);
    }

    $query = "INSERT INTO sppg (id_sppg, nama_tim, jabatan, id_sekolah, ketua_tim, kontak_tim, anggota_tim, foto_tim) 
              VALUES ('$id_sppg', '$nama_tim', '$jabatan', '$id_sekolah', '$ketua', '$kontak', '$anggota', '$new_foto_name')";

    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Tim SPPG Berhasil Didaftarkan'); window.location='../../pages/sppg/sppg_manages.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>