<?php
header('Content-Type: application/json');

include '../../config/database.php';
date_default_timezone_set('Asia/Jakarta');

$response = [
    'success' => false,
    'message' => '',
    'id_pengaduan' => ''
];

try {
    if (isset($_POST['kirim_aduan'])) {
        $nama = isset($_POST['nama_pelapor']) ? mysqli_real_escape_string($conn, $_POST['nama_pelapor']) : '';
        $kontak = isset($_POST['kontak']) ? mysqli_real_escape_string($conn, $_POST['kontak']) : '';
        $id_sekolah = isset($_POST['id_sekolah']) ? mysqli_real_escape_string($conn, $_POST['id_sekolah']) : '';
        $isi = isset($_POST['isi_pengaduan']) ? mysqli_real_escape_string($conn, $_POST['isi_pengaduan']) : '';
        
        // Validasi input
        if (empty($nama) || empty($kontak) || empty($id_sekolah) || empty($isi)) {
            $response['message'] = 'Semua field harus diisi!';
            echo json_encode($response);
            exit;
        }
        
        if (strlen($isi) < 10) {
            $response['message'] = 'Isi pengaduan minimal 10 karakter!';
            echo json_encode($response);
            exit;
        }
        
        // Upload Foto Bukti
        $foto_bukti = "";
        if (!empty($_FILES['foto_bukti']['name'])) {
            $allowed_types = array('jpg', 'jpeg', 'png', 'gif');
            $file_type = strtolower(pathinfo($_FILES['foto_bukti']['name'], PATHINFO_EXTENSION));
            
            if (!in_array($file_type, $allowed_types)) {
                $response['message'] = 'Tipe file tidak didukung! Gunakan JPG, PNG, atau GIF.';
                echo json_encode($response);
                exit;
            }
            
            if ($_FILES['foto_bukti']['size'] > 5000000) {
                $response['message'] = 'Ukuran file terlalu besar! Maksimal 5MB.';
                echo json_encode($response);
                exit;
            }
            
            $foto_name = time() . "_" . basename($_FILES['foto_bukti']['name']);
            $upload_dir = "../../assets/uploads/pengaduan/";
            
            // Create directory if it doesn't exist
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0755, true);
            }
            
            if (move_uploaded_file($_FILES['foto_bukti']['tmp_name'], $upload_dir . $foto_name)) {
                $foto_bukti = $foto_name;
            }
        }
        
        // Insert ke database
        $query_aduan = "INSERT INTO pengaduan (nama_pelapor, kontak, id_sekolah, isi_pengaduan, foto_bukti, status, tanggal) 
                        VALUES ('$nama', '$kontak', '$id_sekolah', '$isi', '$foto_bukti', 'Pending', NOW())";
        
        if (mysqli_query($conn, $query_aduan)) {
            // Get the ID of inserted row
            $id_pengaduan = mysqli_insert_id($conn);
            $response['success'] = true;
            $response['message'] = 'Pengaduan berhasil dikirim! Nomor referensi: ' . $id_pengaduan;
            $response['id_pengaduan'] = $id_pengaduan;
        } else {
            $response['message'] = 'Gagal mengirim pengaduan: ' . mysqli_error($conn);
        }
    } else {
        $response['message'] = 'Request tidak valid.';
    }
} catch (Exception $e) {
    $response['message'] = 'Terjadi kesalahan: ' . $e->getMessage();
}

echo json_encode($response);
exit;
?>
