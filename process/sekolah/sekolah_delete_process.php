<?php
include '../../config/database.php';
include '../../includes/auth_check.php';

// Pastikan hanya Admin yang bisa menghapus
Login_Check();
Only_Allow(['Admin']);

if (isset($_GET['id'])) {
    // Mengambil ID sekolah dari parameter URL
    $id = mysqli_real_escape_string($conn, $_GET['id']);

    // Query untuk menghapus sekolah berdasarkan ID
    $query = "DELETE FROM sekolah WHERE id_sekolah = '$id'";

    if (mysqli_query($conn, $query)) {
        echo "<script>
                alert('Data Sekolah Berhasil Dihapus!'); 
                window.location='../../pages/sekolah/sekolah_manage.php';
              </script>";
    } else {
        // Jika gagal hapus (misal: karena ada data user/menu yang terikat ke sekolah ini)
        echo "<script>
                alert('Gagal menghapus! Data sekolah mungkin sedang digunakan oleh data lain.'); 
                window.location='../../pages/sekolah/sekolah_manage.php';
              </script>";
    }
} else {
    // Jika mencoba akses langsung tanpa ID
    header("Location: ../../pages/sekolah/sekolah_manage.php");
    exit;
}
?>