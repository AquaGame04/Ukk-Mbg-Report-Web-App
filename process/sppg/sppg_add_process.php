<?php
include '../../config/database.php';

if (isset($_POST['submit'])) {
    $id_sekolah = mysqli_real_escape_string($conn, $_POST['id_sekolah']);
    $nama_tim = mysqli_real_escape_string($conn, $_POST['nama_tim']);
    $jabatan = mysqli_real_escape_string($conn, $_POST['jabatan']);
    $kontak = mysqli_real_escape_string($conn, $_POST['kontak']);
    
    $foto_tim = "";
    if (!empty($_FILES['foto_tim']['name'])) {
        $foto_name = time() . "_" . $_FILES['foto_tim']['name'];
        $upload_path = "../../assets/uploads/sppg/" . $foto_name;
        
        if (move_uploaded_file($_FILES['foto_tim']['tmp_name'], $upload_path)) {
            $foto_tim = $foto_name;
        }
    }

    $query = "INSERT INTO sppg (nama_tim, jabatan, kontak_tim, foto_tim, id_sekolah) 
              VALUES ('$nama_tim', '$jabatan', '$kontak', '$foto_tim', '$id_sekolah')";
    
    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Tim SPPG Berhasil Ditambahkan'); window.location='../../pages/sppg/sppg_manage.php';</script>";
    } else {
        echo "<script>alert('Gagal menambahkan tim SPPG: " . mysqli_error($conn) . "'); window.location='../../pages/sppg/sppg_add.php';</script>";
    }
}
?>