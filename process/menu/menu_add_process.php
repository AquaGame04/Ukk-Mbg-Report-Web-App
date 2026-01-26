<?php
include '../../config/database.php';
session_start();

if (isset($_POST['submit'])) {
    $id_sekolah = $_POST['id_sekolah'];
    $nama_menu = mysqli_real_escape_string($conn, $_POST['nama_menu']);
    $tanggal = $_POST['tanggal'];
    $kalori = $_POST['kalori'];
    $protein = $_POST['protein'];
    $karbo = $_POST['karbohidrat'];
    $lemak = $_POST['lemak'];
    $energi = $_POST['energi']; // New
    $serat = $_POST['serat'];   // New

    // Proses Upload Foto
    $filename = $_FILES['foto_menu']['name'];
    $tmp_name = $_FILES['foto_menu']['tmp_name'];
    $filesize = $_FILES['foto_menu']['size'];
    
    // Berikan nama unik ke file agar tidak bentrok
    $new_filename = time() . "_" . $filename;
    $upload_path = "../../assets/uploads/menu/" . $new_filename;

    if (move_uploaded_file($tmp_name, $upload_path)) {
        // 1. Insert ke menu_harian
        $query_menu = "INSERT INTO menu_harian (nama_menu, foto_url, id_sekolah) VALUES ('$nama_menu', '$new_filename', '$id_sekolah')";
        
        if (mysqli_query($conn, $query_menu)) {
            $id_menu_baru = mysqli_insert_id($conn);

            // 2. Insert ke gizi_menu dengan field lengkap
            $query_gizi = "INSERT INTO gizi_menu (id_menu, kalori, protein, karbohidrat, lemak, energi, serat) 
                           VALUES ('$id_menu_baru', '$kalori', '$protein', '$karbo', '$lemak', '$energi', '$serat')";
            
            if (mysqli_query($conn, $query_gizi)) {
                echo "<script>alert('Menu dan Data Gizi Lengkap Berhasil Disimpan'); window.location='../../pages/petugas/menu/menu_manage.php';</script>";
            }
        }
    } else {
        echo "<script>alert('Gagal Upload Foto'); window.history.back();</script>";
    }
}
?>