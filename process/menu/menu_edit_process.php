<?php
include '../../includes/auth_check.php';
include '../../config/database.php';
Login_Check();
Only_Allow(['Petugas Gizi']);

if (isset($_POST['update'])) {
    $id_menu = mysqli_real_escape_string($conn, $_POST['id_menu']);
    $id_sekolah = mysqli_real_escape_string($conn, $_POST['id_sekolah']);
    $nama_menu = mysqli_real_escape_string($conn, $_POST['nama_menu']);
    
    // 1. PERBAIKAN TANGGAL: Ambil data tanggal dari form
    $tanggal = mysqli_real_escape_string($conn, $_POST['tanggal']); 

    // Ambil foto lama untuk cadangan jika tidak ada upload baru
    $foto_lama = $_POST['foto_lama'];

    // Data Gizi
    $energi = $_POST['energi'];
    $kalori = $_POST['kalori'];
    $protein = $_POST['protein'];
    $karbohidrat = $_POST['karbohidrat'];
    $lemak = $_POST['lemak'];
    $serat = $_POST['serat'];

    // 2. PERBAIKAN FOTO: Logika Upload
    // Cek apakah user memilih file baru?
    if (!empty($_FILES['foto_menu']['name'])) {
        $filename = time() . "_" . $_FILES['foto_menu']['name'];
        $tmp_name = $_FILES['foto_menu']['tmp_name'];
        $upload_path = "../../assets/uploads/menu/" . $filename;
        
        // Coba upload
        if (move_uploaded_file($tmp_name, $upload_path)) {
            // Jika upload sukses, hapus foto lama (jika ada filenya)
            if (!empty($foto_lama) && file_exists("../../assets/uploads/menu/" . $foto_lama)) {
                unlink("../../assets/uploads/menu/" . $foto_lama);
            }
            $foto_final = $filename;
        } else {
            // Jika gagal upload, tetap pakai foto lama
            echo "<script>alert('Gagal mengupload foto baru. Menggunakan foto lama.');</script>";
            $foto_final = $foto_lama;
        }
    } else {
        // Jika user tidak memilih foto baru, PASTI pakai foto lama
        $foto_final = $foto_lama;
    }

    // 3. UPDATE SQL: Tambahkan kolom tanggal
    $query_menu = "UPDATE menu_harian SET 
                    tanggal = '$tanggal', 
                    id_sekolah = '$id_sekolah', 
                    nama_menu = '$nama_menu', 
                    foto_url = '$foto_final' 
                   WHERE id_menu = '$id_menu'";

    // Update Tabel Gizi
    $query_gizi = "UPDATE gizi_menu SET 
                    energi = '$energi', 
                    kalori = '$kalori', 
                    protein = '$protein', 
                    karbohidrat = '$karbohidrat', 
                    lemak = '$lemak', 
                    serat = '$serat' 
                   WHERE id_menu = '$id_menu'";

    if (mysqli_query($conn, $query_menu) && mysqli_query($conn, $query_gizi)) {
        echo "<script>alert('Data Berhasil Diperbarui'); window.location='../../pages/petugas/menu/menu_manage.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>