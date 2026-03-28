<?php
include '../../includes/auth_check.php';
include '../../config/database.php';

Login_Check();
Only_Allow(['Petugas Pengaduan']);

if (!isset($_GET['id']) || empty($_GET['id'])) {
    $_SESSION['message'] = 'ID pengaduan tidak valid!';
    $_SESSION['message_type'] = 'error';
    header('Location: ../../pages/petugas/pengaduan/pengaduan_manage.php');
    exit;
}

$id_pengaduan = mysqli_real_escape_string($conn, $_GET['id']);

// Get pengaduan data to retrieve foto_bukti
$query = "SELECT foto_bukti FROM pengaduan WHERE id_pengaduan = '$id_pengaduan'";
$result = mysqli_query($conn, $query);

if (!$result || mysqli_num_rows($result) == 0) {
    $_SESSION['message'] = 'Data pengaduan tidak ditemukan!';
    $_SESSION['message_type'] = 'error';
    header('Location: ../../pages/petugas/pengaduan/pengaduan_manage.php');
    exit;
}

$row = mysqli_fetch_assoc($result);
$foto_bukti = $row['foto_bukti'];

// Delete pengaduan from database
$delete_query = "DELETE FROM pengaduan WHERE id_pengaduan = '$id_pengaduan'";

if (mysqli_query($conn, $delete_query)) {
    // Delete foto bukti if exists
    if (!empty($foto_bukti)) {
        $foto_path = "../../assets/uploads/pengaduan/" . $foto_bukti;
        if (file_exists($foto_path)) {
            unlink($foto_path);
        }
    }
    
    $_SESSION['message'] = 'Pengaduan berhasil dihapus!';
    $_SESSION['message_type'] = 'success';
} else {
    $_SESSION['message'] = 'Gagal menghapus pengaduan: ' . mysqli_error($conn);
    $_SESSION['message_type'] = 'error';
}

header('Location: ../../pages/petugas/pengaduan/pengaduan_manage.php');
exit;
?>
