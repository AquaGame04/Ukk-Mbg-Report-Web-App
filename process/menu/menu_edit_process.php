<?php
include '../../config/database.php';

if (isset($_POST['update'])) {
    $id_menu = $_POST['id_menu'];
    $id_sekolah = $_POST['id_sekolah'];
    $nama_menu = mysqli_real_escape_string($conn, $_POST['nama_menu']);
    $foto_lama = $_POST['foto_lama'];

    // Data Gizi
    $energi = $_POST['energi'];
    $kalori = $_POST['kalori'];
    $protein = $_POST['protein'];
    $karbohidrat = $_POST['karbohidrat'];
    $lemak = $_POST['lemak'];
    $serat = $_POST['serat'];

    // Cek apakah ada foto baru
    if ($_FILES['foto_menu']['name'] != "") {
        $filename = time() . "_" . $_FILES['foto_menu']['name'];
        move_uploaded_file($_FILES['foto_menu']['tmp_name'], "../../assets/uploads/menu" . $filename);
        
        // Hapus foto lama dari folder
        if (file_exists("../../assets/uploads/menu" . $foto_lama)) {
            unlink("../../assets/uploads/menu" . $foto_lama);
        }
        $foto_final = $filename;
    } else {
        $foto_final = $foto_lama;
    }

    // Update Tabel Menu
    $query_menu = "UPDATE menu_harian SET 
                   id_sekolah = '$id_sekolah', 
                   nama_menu = '$nama_menu', 
                   foto_url = '$foto_final' 
                   WHERE id_menu = '$id_menu'";

    // Update Tabel Gizi
    $query_gizi = "UPDATE gizi_menu SET 
                   energi = '$energi', kalori = '$kalori', protein = '$protein', 
                   karbohidrat = '$karbohidrat', lemak = '$lemak', serat = '$serat' 
                   WHERE id_menu = '$id_menu'";

    if (mysqli_query($conn, $query_menu) && mysqli_query($conn, $query_gizi)) {
        echo "<script>alert('Data Berhasil Diperbarui'); window.location='../../pages/petugas/menu/menu_manage.php';</script>";
    }
}
?>