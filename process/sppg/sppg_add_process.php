<?php
include '../../config/database.php';

if (isset($_POST['submit'])) {
    $id_sppg = mysqli_real_escape_string($conn, $_POST['id_sppg']);
    $id_sekolah = mysqli_real_escape_string($conn, $_POST['id_sekolah']);
    $nama_tim = mysqli_real_escape_string($conn, $_POST['nama_tim']);
    $jabatan = mysqli_real_escape_string($conn, $_POST['jabatan']);
    $ketua_tim = mysqli_real_escape_string($conn, $_POST['ketua_tim']);
    $kontak_tim = mysqli_real_escape_string($conn, $_POST['kontak_tim']);
    
    // Check if id_sppg already exists
    $check_id_query = "SELECT id_sppg FROM sppg WHERE id_sppg = '$id_sppg'";
    $check_id_result = mysqli_query($conn, $check_id_query);
    
    if (mysqli_num_rows($check_id_result) > 0) {
        echo "<script>alert('ID Tim SPPG \"$id_sppg\" sudah ada! Gunakan ID yang berbeda.'); window.history.back();</script>";
    } else {
        // Check if tim name already exists in the same school
        $check_query = "SELECT id_sppg FROM sppg WHERE nama_tim = '$nama_tim' AND id_sekolah = '$id_sekolah'";
        $check_result = mysqli_query($conn, $check_query);
        
        if (mysqli_num_rows($check_result) > 0) {
            echo "<script>alert('Nama Tim \"$nama_tim\" sudah ada di sekolah ini! Gunakan nama yang berbeda.'); window.history.back();</script>";
        } else {
            // Process anggota_tim array into comma-separated string
            $anggota_tim = '';
            if (!empty($_POST['anggota_tim'])) {
                $anggota_array = $_POST['anggota_tim'];
                $anggota_tim = implode(',', array_map(function($item) use ($conn) {
                    return mysqli_real_escape_string($conn, $item);
                }, $anggota_array));
            }
            
            $foto_tim = "";
            if (!empty($_FILES['foto_tim']['name'])) {
                $foto_name = time() . "_" . $_FILES['foto_tim']['name'];
                $upload_path = "../../assets/uploads/sppg/" . $foto_name;
                
                if (move_uploaded_file($_FILES['foto_tim']['tmp_name'], $upload_path)) {
                    $foto_tim = $foto_name;
                }
            }

            $query = "INSERT INTO sppg (id_sppg, nama_tim, jabatan, ketua_tim, kontak_tim, anggota_tim, foto_tim, id_sekolah) 
                      VALUES ('$id_sppg', '$nama_tim', '$jabatan', '$ketua_tim', '$kontak_tim', '$anggota_tim', '$foto_tim', '$id_sekolah')";
            
            if (mysqli_query($conn, $query)) {
                echo "<script>alert('Tim SPPG Berhasil Ditambahkan'); window.location='../../pages/sppg/sppg_manage.php';</script>";
            } else {
                echo "<script>alert('Gagal menambahkan tim SPPG: " . mysqli_error($conn) . "'); window.location='../../pages/sppg/sppg_add.php';</script>";
            }
        }
    }
}
?>